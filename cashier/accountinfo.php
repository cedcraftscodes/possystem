<?php
	include_once 'config/config.php';
	$id = $_SESSION['acc_id'];

	$stmt = $conn->prepare("SELECT * FROM `tblusers` WHERE `userid`=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$_SESSION['fname'] = $row['fname'];
	$_SESSION['mname'] = $row['mname'];
	$_SESSION['lname'] = $row['lname'];
	$_SESSION['fullname'] = $_SESSION['fname']." ".$_SESSION['mname']." ".$_SESSION['lname'];
	
	$_SESSION['dp'] = $row['accimg'];

	$_SESSION['gender'] = ucfirst($row['gender']);
	$_SESSION['acctypeTemp'] = ucfirst($row['acctype']);



?>


