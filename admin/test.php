<?php
	if(isset($_POST['names'])){
		print_r($_POST['names']);
	}

	$products = array(
			array('id' => 5,'name' =>"Siga" ), 
			array('id' => 6,'name' => "Boy Bayang" ),
			array('id' => 7,'name' => "Nic Naks" ),
			array('id' => 22,'name' => "Piatos" ),
			array('id' => 57,'name' => "Karaoke" )
			);
	?>

	

<form action="test.php" method="POST">
	<?php for($i = 0; $i < count($products); $i++){ ?>
	<label><?php echo $products[$i]["name"]; ?></label><br>
	<input type="type" name="names[<?php echo $products[$i]["id"]; ?>]" id="1" placeholder="quantity"><br><br>

	<?php }?>
	<input type="submit" name="">
</form>