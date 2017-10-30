<?php 


if(session_id()){}else{session_start();}



if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'loadSuppliers':
		loadSuppliers();
		break;



		case 'loadAdmins':
		loadAdmins();
		break;


		case 'loadProductsToOrder':
		loadProductsToOrder();
		break;


		case 'preparePo':
		preparePo();
		break;

		case 'showPurchaseOrders':
		showPurchaseOrders();
		break;


		case 'printslip':
		printslip();
		break;



		default:
		break;
	}
}


function secure($str){
	return strip_tags(trim(htmlspecialchars($str)));
}


function ContainsNumbers($String){
	return preg_match('/\\d/', $String) > 0;
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




function printslip(){
	$id = $_POST['id'];

	$settings = getSettings(array('name', 'street', 'city', 'province', 'zipcode', 'phone', 'email'));


	$compinfo = array(
		"compname" => $settings['name'],  
		"street" => $settings['street'],
		"city" => $settings['city'], 
		"province" => $settings['province'], 
		"zipcode" => $settings['zipcode'],
		"phone" => $settings['phone'],
		"email" => $settings['email'] );


	//change and total
	include '../config/config.php';


	$stmt = $conn->prepare("SELECT 
							sp.Supplier_name, 
							sp.Supplier_co_name, 
							CONCAT(sp.Supplier_street, ' ', sp.Supplier_city, ' ', sp.Supplier_province, ' ', sp.Supplier_zipcode) as 'Address', 
							sp.Supplier_contact, 
							po.Po_number, 
							po.Exp_DeliveryDate, 
							po.DatePrepared

							FROM tblsuppliers as sp 
							INNER JOIN tblpurchaseorders as po 
							ON po.Supplier_id = sp.Supplier_id
							WHERE po.Po_id =:poid
							");

	$stmt->bindParam(':poid',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$Supplier_name = secure($row['Supplier_name']);
	$Supplier_co_name = secure($row['Supplier_co_name']);
	$Address = secure($row['Address']);
	$Supplier_contact = secure($row['Supplier_contact']);

	$Po_number = secure($row['Po_number']);
	$Exp_DeliveryDate = secure($row['Exp_DeliveryDate']);
	$DatePrepared =  date("F j, Y, g:i a", $row["DatePrepared"]);




	echo "<center><strong>".$compinfo['compname']."</strong> </center>
	<center>".$compinfo['street'] . " ".$compinfo['city']." ".$compinfo['province']."</center>
	<center>".$compinfo['email']."</center>
	<center> <strong>Purchase Order #: ".$Po_number."</strong> </center>
	<center>".$DatePrepared."</center>

	<table style='width:100%; margin-top: 20px; ' >
		<tr>
			<th align='left'>Product</th> 
			<th align='left'>Qty</th>
		</tr>";


		$stmt = $conn->prepare("SELECT
			    pr.Product_name, 
			    `Quantity_Requested`
			FROM
			    `tblpo_items` AS poi
			INNER JOIN tblproducts as pr 
			ON pr.id = poi.`ProductId`
			WhERE `Po_id` =:poid");


		if ($stmt->execute(array(':poid' => $id))) {

			while ($r = $stmt->fetch()) {
				echo "<tr>";
				echo "<td>".$r['Product_name']."</td>";
				echo "<td>".$r['Quantity_Requested']."</td>";
				echo "</tr>";
			}

		}






		echo "</table>

		<hr style='height:1px;border:none;color:#333;background-color:#333;' />


		<hr style='height:1px;border:none;color:#333;background-color:#333;' />

		<table style='' width:100%; margin-top: 20px;'align='center'>
			  <tr>
			    <td><strong>Expected Delivery: </strong></td>
			    <td>".$Exp_DeliveryDate."</td>
			  </tr>

			  <tr>
			    <td><strong>Supplier Name: </strong></td>
			    <td>".$Supplier_name."</td>
			  </tr>
			  <tr>
			    <td><strong>Supplier Receiver: </strong></td>
			    <td>".$Supplier_co_name."</td>
			  </tr>
			    <tr>
			    <td><strong>Supplier Address: </strong></td>
			    <td>".$Address."</td>
			  </tr>

			    <tr>
			    <td><strong>Supplier Contact: </strong></td>
			    <td>".$Supplier_contact."</td>
			  </tr>

		</table>
		<hr style='height:1px;border:none;color:#333;background-color:#333;'' />";


}

function showPurchaseOrders(){
	include '../config/config.php';

	$prod = $conn->query("SELECT 
		po.Po_id, 
		po.`Po_number`, 
		sp.Supplier_name,
		(SELECT CONCAT(us.fname, ' ', us.lname)  FROM tblusers as us  WHERE userid=po.`PreparedBy_id`) as 'Prepared',
		(SELECT CONCAT(us.fname, ' ', us.lname)  FROM tblusers as us  WHERE userid=po.`Checked_By`) as 'Checked',
		po.Exp_DeliveryDate,
		po.Status,
		po.DatePrepared
		FROM tblpurchaseorders as po
		INNER JOIN tblsuppliers as sp 
		ON sp.Supplier_id = po.Supplier_id");

	while($r = $prod->fetch()){
		echo "<tr>";
		echo "<td>".$r['Po_number']."</td>";
		echo "<td>".$r['Supplier_name']."</td>";
		echo "<td>".$r['Prepared']."</td>";
		echo "<td>".$r['Checked']."</td>";

		//echo "<td>".$r['Exp_DeliveryDate']."</td>";
		$Exp_DeliveryDate = date("F j, Y", strtotime($r["Exp_DeliveryDate"]));
		echo "<td>".$Exp_DeliveryDate."</td>";

		$DatePrepared = date("F j, Y", $r["DatePrepared"]);
		echo "<td>".$DatePrepared."</td>";

		echo "<td>".$r['Status']."</td>";
		if($r['Status'] == "Pending"){
		echo "<td><a class='btn btn-sm btn-info' href='deliverproducts.php?poid=".$r['Po_id']."'> <span class='glyphicon glyphicon-pencil'></span> Deliver</a><a class='btn btn-sm btn-info' onclick='printslip(".$r['Po_id'].")''> <span class='fa fa-print'></span> Print Slip</a>";
		}
		else
		{
		echo "<td><a class='btn btn-sm btn-info' disabled='true'> <span class='glyphicon glyphicon-pencil'></span> Deliver</a><a class='btn btn-sm btn-info' onclick='printslip(".$r['Po_id'].")'> <span class='fa fa-print'></span> Print Slip</a>";
		}
		echo "</tr>";
	}
}
function preparePo(){

	$poNumber = $_POST['ponumber'];
	$deliverydate = $_POST['deldate'];
	$supplierId = $_POST['sup_id'];
	$preparedBy = $_SESSION['acc_id'];
	$checkedBy = $_POST['cboadmins'];
	$checkedByPass = md5($_POST['password']);
	$time = time();

	$quantities = $_POST['quantities'];
	$sumOfQuantities = 0;
	foreach ($quantities as $key => $value) {
		$sumOfQuantities += $value;
	}

	if($sumOfQuantities == 0){
		echo json_encode(array(
			"message" => 'Please input atleast 1 product quantity to order!', 
			"success" => false
			));
	}else{
		include '../config/config.php';
		$stmt = $conn->prepare("SELECT `pass_word` FROM tblusers WHERE userid=:id");
		$stmt->bindParam(':id',$checkedBy);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$passindb = $row['pass_word'];



		if($passindb == $checkedByPass){

			
			$stmt = $conn->prepare("INSERT INTO `tblpurchaseorders`(`Po_number`, `PreparedBy_id`, `Checked_By`, `DatePrepared`, 
				`Exp_DeliveryDate`, `Supplier_id`, `Status`, `deleted`) VALUES (:num, :pb, :cb, :dp ,:dt, :sid, 'Pending', 'NO')");
			$stmt->bindParam(':num',$poNumber);
			$stmt->bindParam(':pb',$preparedBy);
			$stmt->bindParam(':dp',$time);
			$stmt->bindParam(':cb',$checkedBy);
			$stmt->bindParam(':dt',$deliverydate);
			$stmt->bindParam(':sid',$supplierId);
			$stmt->execute(); 

			$poid = $conn->lastInsertId();




			foreach ($_SESSION["currPo"] as $r) {
				$request = $quantities[$r['id']];
				if($request == 0 )
					continue;

				$stmt = $conn->prepare("INSERT INTO `tblpo_items`(`Po_id`, `ProductId`, `Quantity_Requested`) VALUES (:pd, :pr, :qr)");
				$stmt->bindParam(':pd',$poid);
				$stmt->bindParam(':pr',$r['id']);
				$stmt->bindParam(':qr',$request);
				$stmt->execute(); 
			}

			echo json_encode(array(
				"message" => 'Purchase Order Prepared!', 
				"success" => true
				));

		}
		else
		{
			echo json_encode(array(
				"message" => 'Checker Password Mismatch!', 
				"success" => false
				));
		}

	}





}

function loadSuppliers(){
	include '../config/config.php';

	$bcks = $conn->query("SELECT * FROM `tblsuppliers` WHERE `Deleted`='NO'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['Supplier_id']."'>".$r['Supplier_name']."</option>";
	}
}




function loadAdmins(){
	include '../config/config.php';

	$bcks = $conn->query("SELECT Concat(`fname`,' ', `mname`, ' ', `lname`) as Fullname, `userid` FROM `tblusers` WHERE `deleted`='NO' AND `acctype`='admin'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['userid']."'>".$r['Fullname']."</option>";
	}
}



function loadProductsToOrder(){
	$id = $_POST['id'];
	include "../config/config.php";



	$sth = $conn->prepare("SELECT
					    *
					FROM
					    (
					    SELECT
					        *,
					        IF(
					            TotalStock > Product_flooring && TotalStock <= Product_ceiling,
					            'Normal',
					            IF(
					                TotalStock < Product_flooring,
					                'Critical',
					                IF(
					                    TotalStock > Product_ceiling,
					                    'Overstocking',
					                    'Something Else'
					                )
					            )
					        ) AS 'Status'
					    FROM
					        (
					        SELECT
					    pr.id,
					    pr.Product_code,
					    pr.Product_name,
					    pr.Product_flooring,
					    pr.Product_ceiling,
					    sup.Supplier_name,
					    sup.Supplier_id,
					    (
					    SELECT
					        SUM(tblstocks.No_Of_Items) + COALESCE(
					            SUM(tblstockout.Quantity_out),
					            0
					        )
					    FROM
					        tblstocks
					    LEFT JOIN tblstockout ON tblstocks.StockId = tblstockout.StockId
					    WHERE
					        tblstocks.ProductId = pr.id AND tblstocks.Deleted = 'NO'
					    GROUP BY
					        pr.id
					) AS TotalStock,
					pr.Product_ceiling -(
					    (
					    SELECT
					        SUM(tblstocks.No_Of_Items) + COALESCE(
					            SUM(tblstockout.Quantity_out),
					            0
					        )
					    FROM
					        tblstocks
					    LEFT JOIN tblstockout ON tblstocks.StockId = tblstockout.StockId
					    WHERE
					        tblstocks.ProductId = pr.id AND tblstocks.Deleted = 'NO'
					    GROUP BY
					        pr.id
					)
					) AS Needed
					FROM
					    tblstocks AS st
					LEFT JOIN tblstockout AS so
					ON
					    so.StockId = st.StockId
					INNER JOIN tblproducts AS pr
					ON
					    pr.id = st.ProductId
					INNER JOIN tblsuppliers AS sup
					ON
					    sup.Supplier_id = st.Product_supplier
					WHERE
					    st.Deleted = 'NO'
					GROUP BY
					    st.ProductId,
					    sup.Supplier_id
					    ) AS ProductOverView
					) AS Stalier
					WHERE
					    Supplier_id = :id AND Stalier.Status = 'Critical'");
	$sth->bindParam(":id", $id );
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	$_SESSION["currPo"] = $result;



	showCurrentPo();
}

function showCurrentPo(){
	$step = 0;
	foreach ($_SESSION["currPo"] as $r) {
		$min = (int)$r['Product_flooring'] - (int)$r['TotalStock'];

		echo "<tr>";
		echo "<td>".($step + 1)."</td>";
		echo "<td>".$r['Product_name']."</td>";
		echo "<td>".$r['Supplier_name']."</td>";
		echo "<td><input type='Number' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='quantities[".$r['id']."]' placeholder=0 value=0 required='' max='".$r['Needed']."'>"."</td>";
		echo "<td>Min: 0 - Max: ". $r['Needed']."</td>";
		echo "<td>".$min."</td>";
	echo "</tr>";
	$step++;
	}
}
?>