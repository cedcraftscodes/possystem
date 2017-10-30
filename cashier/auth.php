<?php
if(session_id())
{
      // session has been started
}
else
{
	session_start();
}
if(!(isset($_SESSION['acc_id'])) || ($_SESSION['acctype'] != "cashier"))
{
	$_SESSION['message'] = "Unauthorized access!";
	header("Location: login.php");
}



if(isset($_SESSION['passchange']) && ($_SESSION['passchange'] == 0))
{
	header("Location: changedefault.php");
}



?>

