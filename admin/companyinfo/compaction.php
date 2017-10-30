<?php
if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'showcompinfo':
		showcompinfo();
		break;


		case 'updatecompanyinfo':
		updatecompanyinfo();
		break;


		default:
				# code...
		break;
	}
}




function showcompinfo(){

	$settings = getSettings(array('name', 'receiver', 'street', 'city', 'province', 'zipcode', 'phone', 'email', 'voidcode', 'tin'));

	echo json_encode(array(
		"compname" => $settings['name'], 
		"receiver" => $settings['receiver'], 
		"street" => $settings['street'],
		"city" => $settings['city'], 
		"province" => $settings['province'], 
		"zipcode" => $settings['zipcode'],
		"phone" => $settings['phone'],
		"email" => $settings['email'], 
		"voidcode" =>  $settings['voidcode'],
		"tin" =>  $settings['tin']));
}


function secure($str){
	return strip_tags(trim(htmlspecialchars($str)));
}


function updatecompanyinfo(){

	$name = $_POST['comname'];
	$receiver = $_POST['comprec'];
	$street = $_POST['street'];
	$city = $_POST['city'];
	$province = $_POST['province'];
	$zipcode = $_POST['zipcode'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];

	$voidcode = $_POST['voidcode'];
	$tin = $_POST['tin'];
	require '../config/config.php';


	$sql = "UPDATE `tblcompanyinfo` SET `settingvalue`=:name WHERE `settingkey`='name';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:receiver WHERE `settingkey`='receiver';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:street WHERE `settingkey`='street';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:city WHERE `settingkey`='city';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:province WHERE `settingkey`='province';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:zipcode WHERE `settingkey`='zipcode';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:phone WHERE `settingkey`='phone';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:email WHERE `settingkey`='email';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:vcode WHERE `settingkey`='voidcode';";
	$sql .= "UPDATE `tblcompanyinfo` SET `settingvalue`=:tin WHERE `settingkey`='tin';";



	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':name', $name);
	$stmt->bindParam(':receiver', $receiver);
	$stmt->bindParam(':street', $street);
	$stmt->bindParam(':city', $city);
	$stmt->bindParam(':province', $province);
	$stmt->bindParam(':zipcode', $zipcode);
	$stmt->bindParam(':phone', $phone);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':vcode', $voidcode);
	$stmt->bindParam(':tin', $tin);


	$stmt->execute();


}

function getSettings(array $keys){
	include '../config/config.php';

	$in = "";
	foreach ($keys as $i => $item)
	{
		$key = ":id".$i;
		$in .= "$key,";
		$in_params[$key] = $item;
	}
	$in = rtrim($in,","); 
	$sql = "SELECT * FROM tblcompanyinfo WHERE  settingkey IN ($in)";
	$stmt = $conn->prepare($sql);
	$stmt->execute($in_params);

	$settings_array = array();
	while($row = $stmt->fetch()){
		$settings_array[$row['settingkey']] = $row['settingvalue'];
	}
	return $settings_array;

}





?>