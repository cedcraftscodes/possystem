<?php
if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'showUserinfo':
		showUserinfo();
		break;


		case 'updateUserInfo':
		updateUserInfo();
		break;

		case 'changePassword':
		changePassword();
		break;


		case 'showLoginHistory':
		showLoginHistory();
		break;

		default:
				# code...
		break;
	}
}



function showUserinfo(){

	include '../config/config.php';
	;

	$stmt = $conn->prepare("SELECT * FROM `tblusers` WHERE `userid`=:id");
	$stmt->bindParam(':id',$_SESSION['acc_id']);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$userid = $row['userid'];
	$fname = $row['fname'];
	$mname = $row['mname'];
	$lname = $row['lname'];
	$gender = $row['gender'];
	$birthday = $row['birthday'];


	echo json_encode(array(
		"fname" => $fname, 
		"lname" => $lname, 
		"mname" => $mname,
		"gender" => $gender, 
		"birthday" => $birthday,
		"userid" => $userid ));

}

function secure($str){
	return strip_tags(trim(htmlspecialchars($str)));
}
function ContainsNumbers($String){
	return preg_match('/\\d/', $String) > 0;
}


function updateUserInfo(){

	include '../config/config.php';

	$stmt = $conn->prepare("UPDATE `tblusers` SET `fname`=:fname,`lname`=:lname, `mname`=:mname,`gender`=:gender,`birthday`=:bday WHERE `userid`=:userid");

	$id = secure($_SESSION['acc_id']);
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

		echo "<script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Error');
			$('#modalmsg').html(\"".implode("<br />",$errors)."\");
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
			$('#msgmodal').modal('show');
		});</script>";
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


		echo "<script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success!');
			$('#modalmsg').text('Personal Information Successfully edited!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});</script>";

	}


}




function changePassword(){
	$id = secure($_SESSION['acc_id']);
	$currpass = secure($_POST['currpass']);


	$newpass = secure($_POST['newpass']);
	$cpass = secure($_POST['cpass']);


	include '../config/config.php';;
	$stmt = $conn->prepare("SELECT pass_word FROM `tblusers` WHERE `userid`=:id");
	$stmt->bindParam(':id',$_SESSION['acc_id']);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$currpassdb = $row['pass_word'];
	$currpasshashed = md5($currpass);



	$errors = array();



	if($currpassdb != $currpasshashed){
		array_push($errors, "Password does not match!");
	}

	if($newpass != $cpass){
		array_push($errors, "Please retype new password!");
	}



	if(count($errors) > 0 )
	{
		echo "<script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Error');
			$('#modalmsg').html(\"".implode("<br />",$errors)."\");
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
			$('#msgmodal').modal('show');
		});</script>";
	}
	else
	{

		$stmt = $conn->prepare("UPDATE `tblusers` SET`pass_word`=:pass WHERE `userid`=:userid");
		$id = $_SESSION['acc_id'];
		$password = md5($newpass);
		$time = time();


		$stmt->bindParam(':pass', $password);
		$stmt->bindParam(':userid', $id);

		$stmt->execute();

		echo "<script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Password successfully changed!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});</script>";
	}
}

function showLoginHistory(){
	include '../config/config.php';

	$logs = $conn->query("SELECT `LoginID` , `LoginDate` FROM tbllogins WHERE `AccountID`=".$_SESSION['acc_id']." ORDER BY `LoginID` DESC");

	while($r = $logs->fetch()){
		echo "<tr>";
		echo "<td>".$r['LoginID']."</td>";
		$dateadded = date("F j, Y, g:i a", $r["LoginDate"]);
		echo "<td>".$dateadded."</td>";
		echo "</tr>";
	}
}



?>