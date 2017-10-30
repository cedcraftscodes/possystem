<?php
require __DIR__.'\barcodegen/BarcodeBase.php';
require __DIR__.'\barcodegen/Code39.php';
$bcode = array();
$bcode['c39']	= array('name' => 'Code39', 'obj' => new emberlabs\Barcode\Code39());
function bcode_error($m)
{
	echo "<div class='error'>{$m}</div>";
}
function bcode_img64($b64str)
{
	echo "<figure><img src='data:image/png;base64,$b64str' /><figcaption class='caption'> ".$_POST['encode']." </figcaption>";
}
?>
<html>
<head>

<title>Barcode Generato</title>

<style type="text/css">
	.error, .success {
		margin: 20px 0 20px 0;
		font-weight: bold;
		padding: 15px;
		color: #FFF;
	}


	.error {
		background-color: #A00;
	}
	.success {
		background-color: #0A0;
	}
	figure {
    display: inline-block;
    margin: 20px; /* adjust as needed */
}
figure img {
    vertical-align: top;
}
figure figcaption {
    text-align: center;
    background-color: black;
}



</style>

</head>
<body>

<form action="bcodesample.php" method="post">

 Data to encode: <input type="text" name="encode" value="<?php if(isset($_POST['encode'])) echo htmlspecialchars($_POST['encode']); ?>" /><br />
<input type="submit" value="Encode" name="submit" />

</form>

<?php 
if (isset($_POST['submit'])) {
?>

<?php
	foreach($bcode as $k => $value)
	{
		try
		{
			$bcode[$k]['obj']->setData($_POST['encode']);
			$bcode[$k]['obj']->setDimensions(300, 150);
			$bcode[$k]['obj']->draw();
			$b64 = $bcode[$k]['obj']->base64();
			bcode_img64($b64);
		}
		catch (Exception $e)
		{
			bcode_error($e->getMessage());
		}
	}
?>

<?php } ?>

</body>
</html>