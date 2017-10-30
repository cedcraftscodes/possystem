<?php 


if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'addAdmin':
		addAdmin();
		break;
		case 'showAdmins':
		showAdmins();
		break;
		case 'deleteAdmin':
		deleteAdmin();
		break;
		case 'showUpdateAdmin':
		showUpdateAdmin();
		break;
		case 'updateAdmin':
		updateAdmin();
		break;

		case 'resetPass':
		resetPass();
		break;

		default:
				# code...
		break;
	}
}


function secure($str){
	return strip_tags(trim(htmlspecialchars($str)));
}


function ContainsNumbers($String){
	return preg_match('/\\d/', $String) > 0;
}




function resetPass(){


	include '../config/config.php';
	$id = $_POST['id'];



	//get username from database


	$stmt = $conn->prepare("SELECT user_name FROM `tblusers` WHERE `userid`=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();
	$username = $row['user_name'];
	$password = md5($username);

    // prepare sql and bind parameters
	$stmt = $conn->prepare("UPDATE tblusers set pass_word=:pass, passchange='0' WHERE userid=:id;");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':pass', $password);
	$stmt->execute();



	echo "<tr><script type='text/javascript'>
	$(document).ready(function(){
		$('#msgtitle').text('Success');
		$('#modalmsg').html('Password successfully resetted!');
		$('#msgmodalbtn').text('Close');
		$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
		$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
		$('#msgmodal').modal('show');
	});
</script></tr>";
showAdmins();



}




function addAdmin()
{
	include '../config/config.php';

	/*
		Validations 
	*/
		$errors = array();

		if(strlen($_POST['fname']) == 0){
			array_push($errors, "First Name can not be blank!");
		}else{
			if(ContainsNumbers($_POST['fname'])){
				array_push($errors, "First Name contains number!");
			}
		}


		if(strlen($_POST['lname']) == 0){
			array_push($errors, "Last Name can not be blank!");
		}else{
			if(ContainsNumbers($_POST['lname'])){
				array_push($errors, "Last Name contains number!");
			}
		}


		if(strlen($_POST['mname']) == 0){
			array_push($errors, "Middle Name can not be blank!");
		}else{
			if(ContainsNumbers($_POST['mname'])){
				array_push($errors, "Middle Name contains number!");
			}
		}




		/*
		$stmt = $conn->prepare("SELECT userid FROM tblusers where email=:email AND `deleted`='NO'");
		$stmt->bindParam("email", $_POST['email']) ;
		$stmt->execute();
		$count=$stmt->rowCount();





		if($count != 0){
			array_push($errors, "User with email ".$_POST['email']." already exist!");
		}


		*/


		$fname = secure(ucfirst($_POST['fname']));
		$mname = secure(ucfirst($_POST['mname']));
		$lname = secure(ucfirst($_POST['lname']));

		$gender = secure($_POST['gender']);
		$birthday = secure($_POST['bday']);
		$time = time();



		$number = 0;
		$username = "";
		$exist = true;
		while($exist == true){

			$number = rand(100,1000);
			$username = $fname[0].$mname[0].$lname.$number;


			$stmt = $conn->prepare("SELECT userid FROM tblusers where user_name=:usrn AND `deleted`='NO'");
			$stmt->bindParam("usrn", $username) ;
			$stmt->execute();
			$count=$stmt->rowCount();

			if($count == 0){
				$exist = false;
			}
		}
		$password = md5($username);



		$imgfile = $_FILES['userpic']['name'];
		$tmp_dir = $_FILES['userpic']['tmp_name'];
		$imgsize = $_FILES['userpic']['size'];


		$upload_dir = '../images/dp/';
		$imgext = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));
		$valid = array('jpeg', 'jpg', 'png', 'gif');
		$uploadimg = $username. "_" . rand(1000, 1000000) . "." . $imgext;
		$destination = "";


		if (in_array($imgext, $valid)) {
			if ($imgsize < 5000000) {
				move_uploaded_file($tmp_dir, $upload_dir.$uploadimg);
				$destination = 'images/dp/'.$uploadimg;
			}
			else
			{
				array_push($errors, "Sorry, the file is too large.");
			}
		}
		else
		{
			array_push($errors, "File is not supported.".$imgfile);
		}



		if(count($errors) > 0 )
		{

			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Error');
				$('#modalmsg').html(\"".implode("<br />",$errors)."\");
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
				$('#msgmodal').modal('show');
			});
		</script></tr>";
	}
	else
	{

		$stmt = $conn->prepare("INSERT INTO `tblusers`(`fname`, `mname`, `lname`, `user_name`, `gender`, `birthday`, `pass_word`, `acctype`, `deleted`, `accimg`, `dateadded`, `passchange`) VALUES (:fname, :mname, :lname, :usrn, :gender, :bday, :password , 'cashier', 'NO', :img ,:dtt, '0')");


		$stmt->bindParam(':fname', $fname);
		$stmt->bindParam(':mname', $mname);
		$stmt->bindParam(':lname', $lname);
		$stmt->bindParam(':usrn', $username);
		$stmt->bindParam(':gender', $gender);
		$stmt->bindParam(':bday', $birthday);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':img', $destination);
		$stmt->bindParam(':dtt', $time);
		$stmt->execute();


		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Cashier (".$username.") successfully added!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});
	</script></tr>";
}
showAdmins();
}

function showAdmins()
{
	include '../config/config.php';

	$admins = $conn->query("SELECT * FROM `tblusers` WHERE deleted='NO' AND `acctype`='cashier'");

	while($r = $admins->fetch()){
		echo "<tr>";
		echo "<td>".$r['userid']."</td>";
		echo "<td>".$r['fname']." ".$r['mname']." ".$r['lname']."</td>";
		echo "<td>".$r['gender']."</td>";
		echo "<td>".$r['birthday']."</td>";
		$dateadded = date("F j, Y, g:i a", $r["dateadded"]);
		echo "<td>".$dateadded."</td>";
		echo '<td><a class="btn btn-sm btn-info" onclick="updateAdmin('.$r['userid'].')"> <span class="glyphicon glyphicon-pencil"></span> Edit</a> | <a class="btn btn-sm btn-danger" onclick="deleteAdmin('.$r['userid'].')"><span class=
		"glyphicon glyphicon-trash"></span> Delete</a></td>';
		echo "</tr>";
	}
}


function deleteAdmin()
{
	include '../config/config.php';
	$id = $_POST['id'];

    // prepare sql and bind parameters
	$stmt = $conn->prepare("UPDATE tblusers set deleted='YES' WHERE userid=:id");
	$stmt->bindParam(':id', $id);
	$stmt->execute();



	echo "<tr><script type='text/javascript'>
	$(document).ready(function(){
		$('#msgtitle').text('Success');
		$('#modalmsg').html('Admin successfully deleted!');
		$('#msgmodalbtn').text('Close');
		$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
		$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
		$('#msgmodal').modal('show');
	});
</script></tr>";
showAdmins();
}




function showUpdateAdmin()
{
	include '../config/config.php';
	$id = $_POST['id'];

	$stmt = $conn->prepare("SELECT * FROM `tblusers` WHERE `userid`=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$userid = $row['userid'];
	$fname = $row['fname'];
	$mname = $row['mname'];
	$lname = $row['lname'];
	$username = $row['user_name'];
	$gender = $row['gender'];
	$birthday = $row['birthday'];


	echo json_encode(array(
		"fname" => $fname, 
		"lname" => $lname, 
		"mname" => $mname,
		"username" => $username, 
		"gender" => $gender, 
		"birthday" => $birthday,
		"userid" => $userid ));

}	

function updateAdmin()
{
	include '../config/config.php';

	$stmt = $conn->prepare("UPDATE `tblusers` SET `fname`=:fname,`lname`=:lname, `mname`=:mname,`gender`=:gender,`birthday`=:bday WHERE `userid`=:userid");

	$id = secure($_POST['u_id']);
	$fname = secure($_POST['u_fname']);
	$mname = secure($_POST['u_mname']);
	$lname = secure($_POST['u_lname']);
	$gender = secure($_POST['u_gender']);
	$bday = secure($_POST['u_bday']);

	$errors = array();


	if(strlen($_POST['u_fname']) == 0){
		array_push($errors, "First Name can not be blank!");
	}else{
		if(ContainsNumbers($_POST['u_fname'])){
			array_push($errors, "First Name contains number!");
		}
	}


	if(strlen($_POST['u_lname']) == 0){
		array_push($errors, "Last Name can not be blank!");
	}else{
		if(ContainsNumbers($_POST['u_lname'])){
			array_push($errors, "Last Name contains number!");
		}
	}


	if(strlen($_POST['u_mname']) == 0){
		array_push($errors, "Middle Name can not be blank!");
	}else{
		if(ContainsNumbers($_POST['u_mname'])){
			array_push($errors, "Middle Name contains number!");
		}
	}


	if(count($errors) > 0 )
	{

		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Error');
			$('#modalmsg').html(\"".implode("<br />",$errors)."\");
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
			$('#msgmodal').modal('show');
		});
	</script></tr>";
}
else
{
	$stmt->bindParam(':userid', $id);
	$stmt->bindParam(':fname', $fname);
	$stmt->bindParam(':mname', $mname);
	$stmt->bindParam(':lname', $lname);
	$stmt->bindParam(':gender', $gender);
	$stmt->bindParam(':bday', $bday);
	$stmt->execute();
}

		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Employee successfully updated!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});
		</script></tr>";
showAdmins();
}

?>