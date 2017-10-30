<?php


if(session_id()){}else{session_start();}


if(isset($_POST['action']) && !empty($_POST['action']))
{
	$action = $_POST['action'];
	switch ($action) {
		case 'loadtransactions':
		loadtransactions();
		break;

		case 'printReceipt':
		printReceipt();
		break;




		default:
				# code...
		break;
	}
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

function printReceipt(){
	$id = $_POST['id'];

	

	$settings = getSettings(array('name', 'receiver', 'street', 'city', 'province', 'zipcode', 'phone', 'email', 'tin'));


	$compinfo = array(
		"compname" => $settings['name'], 
		"receiver" => $settings['receiver'], 
		"street" => $settings['street'],
		"city" => $settings['city'], 
		"province" => $settings['province'], 
		"zipcode" => $settings['zipcode'],
		"phone" => $settings['phone'],
		"email" => $settings['email'],
		"tin" => $settings['tin']  );

	//get Info


	//get products

	//Vat tax


	//change and total
	include '../config/config.php';

	$stmt = $conn->prepare("SELECT
		`TransNo`,
		`TransTotal`,
		`TransChange`,
		`TransCash`,
		`TransDate`,
		`TransDiscount`,
		cs.CustomerName,
		cs.CustomerAddress,
		Concat(us.fname , ' ', us.mname, ' ' , us.lname) as `Cashier`, 
		`ORNo`
		FROM
		`tbltransaction` as tr
		INNER JOIN tblusers as us 
		on us.userid = tr.`TransUserId` 

		INNER join tblcustomer as cs 
		ON cs.CustomerId = tr.`CustId`
		WHERE tr.TransId = :tid");

	$stmt->bindParam(':tid',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$TransNo = secure($row['TransNo']);
	$TransTotal = secure($row['TransTotal']);
	$TransChange = secure($row['TransChange']);
	$TransCash = secure($row['TransCash']);
	$TransDate = date("F j, Y, g:i a", secure($row['TransDate']));	
	$CustomerName = secure($row['CustomerName']);
	$CustomerAddress = secure($row['CustomerAddress']);
	$Cashier = secure($row['Cashier']);
	$Discount = secure($row['TransDiscount']);
	$vattax = $TransTotal  / 1.12 * .12;
	$vattable = $TransTotal - $vattax;

	$orno = secure(str_pad($row['ORNo'], 5, '0', STR_PAD_LEFT));

	echo "<center><strong>".$compinfo['compname']."</strong> </center>
	<center>".$compinfo['street'] . " ".$compinfo['city']." ".$compinfo['province']."</center>
	<center>".$compinfo['email']."</center>
	<center> <strong>Official Receipt #:  ".$orno."</strong> </center>
	<center> <strong>TIN #:  ".$compinfo['tin']."</strong> </center>
	<center>".$TransDate."</center>

	<table style='width:100%; margin-top: 20px; ' >
		<tr>
			<th align='left'>Product</th> 
			<th align='left'>Qty</th>
			<th align='left'>Price</th> 
			<th align='left'>Total</th>
		</tr>";

		$stmt = $conn->prepare("SELECT
			pr.Product_name,
			`TransProductPrice`,
			`TransProductQuantity`
			FROM
			`tbltransproduct` AS tp
			INNER JOIN tblproducts as pr 
			on pr.id = tp.`TransProdId`
			WHERE TransId =:tid;");


		if ($stmt->execute(array(':tid' => $id))) {

			while ($r = $stmt->fetch()) {
				echo "<tr>";
				echo "<td>".$r['Product_name']."</td>";
				echo "<td>".$r['TransProductQuantity']."</td>";
				echo "<td>₱ ".$r['TransProductPrice']."</td>";
				echo "<td>₱ ".number_format(($r['TransProductPrice'] * $r['TransProductQuantity']), 2, '.', ',')."</td>";
				echo "</tr>";
			}

		}



		echo "</table>

		<hr style='height:1px;border:none;color:#333;background-color:#333;' />

		<table style='width:100%; margin-top: 20px;' align='center'>
			<tr>
				<td>VaT Tax</td>
				<td>₱ ".number_format($vattax, 2, '.', ',')."</td>
			</tr>
			<tr>
				<td>Vatable</td>
				<td>₱ ".number_format($vattable, 2, '.', ',')."</td>
			</tr>


			<tr>
				<td>Discount</td>
				<td>₱ ".number_format($Discount, 2, '.', ',')."</td>
			</tr>

			<tr>
				<td><strong>Grand Total</strong></td>
				<td><strong>₱ ".number_format($TransTotal, 2, '.', ',')."</strong></td>
			</tr>

			<tr>
				<td>Cash</td>
				<td>₱ ".number_format($TransCash, 2, '.', ',')."</td>
			</tr>
			
			<tr>
				<td>Change</td>
				<td>₱ ".number_format($TransChange, 2, '.', ',')."</td>
			</tr>

		</table>

		<hr style='height:1px;border:none;color:#333;background-color:#333;' />

		<table style='' width:100%; margin-top: 20px;'align='center'>
			<tr>
				<td><strong>Cashier Name: </strong></td>
				<td>".$Cashier."</td>
			</tr>
			<tr>
				<td><strong>Customer Name: </strong></td>
				<td>".$CustomerName."</td>
			</tr>
			<tr>
				<td><strong>Customer Address: </strong></td>
				<td>".$CustomerAddress."</td>

			</tr>
		</table>
		<hr style='height:1px;border:none;color:#333;background-color:#333;'' />
		<center> <strong>Transaction #: ".$TransNo."</strong> </center>
		<center><strong>Thank you! Come Again!</strong></center>";

		
	}
	function loadtransactions()
	{
		include '../config/config.php';

		$prod = $conn->query("SELECT
			`TransId`,
			`TransNo`,
			`TransDate`,
			`No_Of_Items`,
			cs.CustomerName
			FROM
			`tbltransaction` as tr 
			INNER JOIN tblcustomer AS cs
			ON
			cs.CustomerId =tr.`CustId`
			ORDER BY tr.TransId DESC");

		while($r = $prod->fetch()){
			echo "<tr>";
			echo "<td>".$r['TransNo']."</td>";
			echo "<td>".$r['CustomerName']."</td>";
			$dateadded = date("F j, Y, g:i a", $r["TransDate"]);
			echo "<td>".$dateadded."</td>";
			echo "<td>".$r['No_Of_Items']."</td>";
			echo "<td><a class='btn btn-sm btn-info' onclick='printReceipt(".$r['TransId'].")'> <span class='glyphicon glyphicon-pencil'></span> Print</a> </td>";
			echo "</tr>";
		}
	}





	function secure($str){
		return strip_tags(trim(htmlspecialchars($str)));
	}


	function ContainsNumbers($String){
		return preg_match('/\\d/', $String) > 0;
	}
	?>