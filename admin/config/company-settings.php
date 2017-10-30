<?php 

function getSettings(array $keys){
	include 'config.php';

	$in = "";
	foreach ($keys as $i => $item)
	{
	    $key = ":id".$i;
	    $in .= "$key,";
	    $in_params[$key] = $item;
	}
	$in = rtrim($in,","); 
	$sql = "SELECT * FROM tblsettings WHERE  settingkey IN ($in)";
	$stmt = $conn->prepare($sql);
	$stmt->execute($in_params);

	$settings_array = array();
	while($row = $stmt->fetch()){
		$settings_array[$row['settingkey']] = $row['settingvalue'];
	}
	return $settings_array;

}



?>

