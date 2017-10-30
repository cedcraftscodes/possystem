<?php 
if(session_id()){}else{session_start();}
if(!(isset($_SESSION['acc_id'])) || ($_SESSION['acctype'] != "cashier"))
{
  $_SESSION['message'] = "Unauthorized access!";
  header("Location: login.php");
}




require 'config/config.php';
function secure($str){
  return strip_tags(trim($str));
}

if(isset($_POST['submit']) && isset($_POST['oldpass']) && isset($_POST['newpass']) && isset($_POST['cpass']))
{

  $opass = secure($_POST['oldpass']);
  $npass = secure($_POST['newpass']);
  $cpass = secure($_POST['cpass']);




  $stmt = $conn->prepare("SELECT pass_word  FROM tblusers WHERE userid=:id");
  $stmt->bindParam("id", $_SESSION['acc_id']) ;
  $stmt->execute();
  $data=$stmt->fetch();



  if(md5($opass) != $data['pass_word']){
    $_SESSION['message'] = "Old Password do not match!";
  }else if($npass != $cpass){
    $_SESSION['message'] = "Retype your new password!";
  }else{
    $npass = md5($npass);
    $_SESSION['passchange'] = '1';

    $stmt = $conn->prepare("UPDATE tblusers set pass_word=:pass, passchange='1' WHERE userid=:id");
    $date = time();

    $stmt->bindParam(':pass', $npass);
    $stmt->bindParam(':id', $_SESSION['acc_id']);
    $stmt->execute();
    header('Location: index.php');
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

  <title>Change Default Password</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

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

<body>

  <div class="container">

    <div class="row" id="pwd-container">
      <div class="col-md-4"></div>

      <div class="col-md-4">
        <section class="login-form">
          <form method="post" action="changedefault.php" role="login">
            <div>
              <h3><i class="fa fa-shopping-cart"></i> GigaOhms Electronic Store</h3>
              <br>
            </div>

            <p>Before you proceed, please change your default password!</p>
            <input type="password" name="oldpass" placeholder="old password" required pattern=".{8,}" required title="Minimum 8 characters required" class="form-control" placeholder="Password" class="form-control input-lg" />
            <input type="password" name="newpass" placeholder="new password" required pattern=".{8,}" required title="Minimum 8 characters required" class="form-control" placeholder="Password" class="form-control input-lg" />
            <input type="password" name="cpass" placeholder="confirm new password" required="" pattern=".{8,}" required title="Minimum 8 characters required" class="form-control" placeholder="Password" class="form-control input-lg"  />

            <p style="color: red;"><?php if(isset($_SESSION['message'])) {echo $_SESSION['message']; $_SESSION['message'] = "";}?></p>


            <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Change Default Password</button>
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


