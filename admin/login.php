
<?php
if(session_id()){}else{
  session_start();
  if(!isset($_SESSION['trialsadmin'])){
    $_SESSION['trialsadmin'] = 0;

  }
}

require 'config/config.php';
function secure($str){
  return strip_tags(trim($str));
}

if(isset($_POST['submit']) && isset($_POST['uname']) && isset($_POST['pass']))
{

  $uname = secure($_POST['uname']);
  $pass = md5(secure($_POST['pass']));

  $type = "admin";

  $stmt = $conn->prepare("SELECT `id`, `time` FROM `tblwrongtries` WHERE `type` ='admin' ORDER BY `id` DESC");
  $stmt->execute();
  $stmt->setFetchMode(PDO::FETCH_ASSOC); 
  $ct=$stmt->rowCount();
  $data=$stmt->fetch();
  $lastfailedlogin = (int)$data['time'];

  $currtime = time();
  $timedelay = 180;


  if($currtime >= $lastfailedlogin  && $currtime <= ($lastfailedlogin + $timedelay)){
    $_SESSION['message'] = "You can login after ".abs(( $currtime - ($lastfailedlogin + $timedelay))) . " seconds!";
  }
  else
  {
  $stmt = $conn->prepare("SELECT userid , passchange FROM tblusers WHERE user_name=:uname and pass_word=:pass and acctype=:type AND DELETED='NO'");
  $stmt->bindParam("uname", $uname) ;
  $stmt->bindParam("pass", $pass);
  $stmt->bindParam("type", $type) ;
  $stmt->execute();


  $stmt->setFetchMode(PDO::FETCH_ASSOC); 
  $count=$stmt->rowCount();
  $data=$stmt->fetch();

  if($count)
  {
    $_SESSION['acc_id'] = $data['userid'];
    $_SESSION['acctype'] = $type;
    $_SESSION['passchange'] = $data['passchange'];

    $stmt = $conn->prepare("INSERT INTO `tbllogins`(`AccountID`, `LoginDate`) VALUES (:acc, :date)");
    $date = time();
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':acc', $_SESSION['acc_id']);
    $stmt->execute();
    header('Location: index.php');
  }
  else
  {
    $_SESSION['trialsadmin']++;
    $_SESSION['message'] = "Username / Password mismatch! <br> Incorrect Trials: ".$_SESSION['trialsadmin'];
  }

  if($_SESSION['trialsadmin']  == 3){
    $time = time();
    $stmt = $conn->prepare("INSERT INTO `tblwrongtries`(`time`, `type`) VALUES (:ti, 'admin')");
    $stmt->bindParam("ti", $time);
    $stmt->execute();



    $stmt = $conn->prepare("SELECT `id`, `time` FROM `tblwrongtries` ORDER BY `id` DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    $ct=$stmt->rowCount();
    $data=$stmt->fetch();
    $lastfailedlogin = (int)$data['time'];


    $currtime = time();

    $_SESSION['message'] = "You can login after ".abs(( $currtime - ($lastfailedlogin + $timedelay))) . " seconds!";
    $_SESSION['trialsadmin'] = 0;          
  }

  }



}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Sales and Inventory System</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">

  <style type="text/css">
    @CHARSET "UTF-8";
/*
over-ride "Weak" message, show font in dark grey
*/

.progress-bar {
  color: #333;
} 

* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  outline: none;
}

.form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  @include box-sizing(border-box);

  &:focus {
    z-index: 2;
  }
}

body {
  background: url("images/media.jpg") no-repeat center center fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  overflow-x: hidden;
}

.login-form {
  margin-top: 60px;
}

form[role=login] {
  color: #5d5d5d;
  background: #f2f2f2;
  padding: 26px;
  border-radius: 10px;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
}
form[role=login] img {
  display: block;
  margin: 0 auto;
  margin-bottom: 35px;
}
form[role=login] input,
form[role=login] button {
  font-size: 18px;
  margin: 16px 0;
}
form[role=login] > div {
  text-align: center;
}

.form-links {
  text-align: center;
  margin-top: 1em;
  margin-bottom: 50px;
}
.form-links a {
  color: #fff;
}

</style>

</head>

<body >
  <div class="container">
    <div class="row" id="pwd-container">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <section class="login-form">
          <form method="post" action="login.php" role="login">
            <div>
              <h3><i class="fa fa-shopping-cart"></i> GigaOhms Electronic Store</h3>
              <br>
            </div>
            <p>Input your username and password!</p>

            <div>
              <input type="text" class="form-control" placeholder="Username" name="uname" required="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" name="pass"/>
            </div>

            <p style="color: red;"><?php if(isset($_SESSION['message'])) {echo $_SESSION['message']; $_SESSION['message'] = "";}?></p>
            <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Login</button>
            <a href="../cashier/login.php">Not an admin? Login as a Cashier!</a>

          </form>


          <div class="form-links">
            <a href="#"><p>© 2017 All Rights Reserved.</p></a>
          </div>
        </section>  
      </div>
      <div class="col-md-4"></div>
    </div>
  </div>
</body>
</html>
