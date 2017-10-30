<?php


if(session_id()){

	if(!isset($_SESSION['orders'])){
		$_SESSION['orders'] = array();
	}

	if(!isset($_SESSION['transid'])){
		$_SESSION['transid'] = time();
	}


}else{session_start();


	if(!isset($_SESSION['orders'])){
		$_SESSION['orders'] = array();
	}

	if(!isset($_SESSION['transid'])){
		$_SESSION['transid'] = time();
	}

}


if(isset($_POST['action']) && !empty($_POST['action']))
{
	$action = $_POST['action'];
	switch ($action) {
		case 'addbcode':
		addbcode();
		break;

		case 'loadOrders';
		loadOrders();
		break;


		case 'setQuantity';
		setQuantity();
		break;

		case 'showUpdateQuantity';
		showUpdateQuantity();
		break;


		case 'deleteOrder';
		removeOrder();
		break;

		case 'loadTransInfo';
		loadTransInfo();
		break;

		case 'voidTransaction';
		voidTransaction();
		break;

		case 'settleTransaction';
		settleTransaction();
		break;


		case 'pricecheck';
		pricecheck();
		break;

		case 'getVoidCode';
		getVoidCode();
		break;

		case 'loadAdmins';
		loadAdmins();
		break;


		default:
				# code...
		break;
	}
}

function loadAdmins(){
	include 'config/config.php';
	$bcks = $conn->query("SELECT Concat(`fname`,' ', `mname`, ' ', `lname`) as Fullname, `userid` FROM `tblusers` WHERE `deleted`='NO' AND `acctype`='admin'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['userid']."'>".$r['Fullname']."</option>";
	}
}

function pricecheck(){
	$bcode = $_POST['pricechk-bcode'];
	$product = getProductInfo($bcode);

	if($product['exists']){ 
		$price = $product['price'];
		$pname = $product['pname'];
		$qout = $product['qout'];
		
		echo json_encode(array( 
			"success" => true,
			"pname" => $pname,
			"qout" => $qout,
			"price" => number_format($price, 2, '.', ',')
			));
	}else{
		echo json_encode(array(
			"message" => 'Product not found!', 
			"success" => false
			));
	}
}

function settleTransaction()
{
	//insert to customer table
	include 'config/config.php';
	$time = time();
	$payment = $_POST['cashtendered'];
	$customername = ($_POST['customername'] == '') ? 'Not Set': $_POST['customername'];
	$custaddress = ($_POST['custaddress'] == '') ? 'Not Set': $_POST['custaddress'];
	$total = 0;
	$discount = 0;	


	$NoOfItems = 0;
	for($i = 0; $i < sizeof($_SESSION['orders']) ; $i++){		
		$quantity = $_SESSION['orders'][$i][1];
		$barcode = $_SESSION['orders'][$i][0];
		$NoOfItems += $quantity;
		$curr = getProductInfo($barcode);
		$total += $curr["price"] * $quantity;
	}


	if(isset($_POST['chkmngdiscount'])){	


		$managerid = $_POST['cboadmins'];
		$password = md5($_POST['mngpass']);
		$discount = $_POST['discount'];

		$stmt = $conn->prepare("SELECT `pass_word` FROM tblusers WHERE userid=:id");
		$stmt->bindParam(':id', $managerid);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$passindb = $row['pass_word'];

		if($password == $passindb){

			if($discount > $total){
					echo json_encode(array(
					"message" => 'Discount can not be greater than the total!', 
					"success" => false
					));
					return;
			}else{
				$total -= $discount;
			}
		}
		else
		{
			echo json_encode(array(
			"message" => 'Manager Password incorrect!', 
			"success" => false
			));
			return;
		}
	}

	if($NoOfItems == 0){
			echo json_encode(array(
			"message" => 'Orders can not be empty!', 
			"success" => false
			));
			return;
	}


	$transprint = 0;
	if($payment < $total){
		echo json_encode(array(
			"message" => 'Payment Failed. Please pay the total amount!', 
			"success" => false
			));
	}else{
		$change = $payment - $total;


		$stmt = $conn->prepare("SELECT COUNT(`TransId`) as 'LastOr' FROM tbltransaction");
		$stmt->execute(); 
		$row = $stmt->fetch();
		$orno = (int)$row['LastOr'] + 1;


		$dateadded = date("Ymd000", $time);
		$orno = $dateadded.$orno;
		
		
		$stmt = $conn->prepare("INSERT INTO `tblcustomer`(`CustomerName`, `CustomerAddress`, `DateAdded`) VALUES (:cname, :cadd, :da)");
		$stmt->bindParam(':cname',$customername);
		$stmt->bindParam(':cadd',$custaddress);
		$stmt->bindParam(':da', $time);
		$stmt->execute(); 
		$custid = $conn->lastInsertId();

		$stmt = $conn->prepare("INSERT INTO `tbltransaction`(`TransUserId`, `TransNo`, `TransTotal`, `TransChange`, `TransCash`, `TransDate`, `No_Of_Items`, `CustId`, `TransDiscount`, `ORNo`) VALUES (:uid, :transno, :total, :change, :cash , :dt, :no, :cust, :disc, :orno)");
		$stmt->bindParam(':uid',$_SESSION['acc_id']);
		$stmt->bindParam(':transno',$_SESSION['transid']);
		$stmt->bindParam(':total', $total);
		$stmt->bindParam(':change',$change);
		$stmt->bindParam(':cash',$payment);
		$stmt->bindParam(':dt',$time);
		$stmt->bindParam(':no',$NoOfItems);
		$stmt->bindParam(':cust',$custid);
		$stmt->bindParam(':disc',$discount);
		$stmt->bindParam(':orno',$orno);
		$stmt->execute(); 
		$tid = $conn->lastInsertId();
		$transprint = $tid;

		for($i = 0; $i < sizeof($_SESSION['orders']) ; $i++){	
			if($_SESSION['orders'][$i][0] != ""){


				$barcode = $_SESSION['orders'][$i][0];
				$curr = getProductInfo($barcode);

				$quantity = $_SESSION['orders'][$i][1];
				$currpid = $curr["prodid"];
				$price = $curr["price"];
				$ssupid = $curr["supid"];
				
				$supprice = $curr["supprice"];
				
				$stmt = $conn->prepare("INSERT INTO `tbltransproduct`(`TransId`, `TransProdId`, `TransProductPrice`, `TransProductQuantity`,`TransSupplier`, `TransSupplierPrice`) VALUES (:tid, :tpid, :tpp, :tqty, :suplier, :supprice)");
				$stmt->bindParam(':tid',$tid);
				$stmt->bindParam(':tpid',$currpid);
				$stmt->bindParam(':tpp', $price);
				$stmt->bindParam(':tqty', $quantity);
				$stmt->bindParam(':suplier', $ssupid);
				$stmt->bindParam(':supprice', $supprice);
				$stmt->execute(); 

				//--kunin ren si stock out id 
				//--kunin mo yung # of Stock sa stock out table;
				$stmt = $conn->prepare("SELECT
										    `StockOutId`, 
										    so.`Quantity_out`,
										    st.`StockId`
										FROM
										    `tblstockout` AS so
										INNER JOIN tblstocks as st 
										ON st.StockId = so.`StockId`
										INNER join tblproducts as pr 
										ON pr.id = st.ProductId 
										WHERE pr.`id` = :id");
				$stmt->bindParam(':id',$currpid);
				$stmt->execute(); 
				$row = $stmt->fetch();
				$SoID = $row['StockOutId'];
				$stockID = $row['StockId'];

				$quantityout  = $row['Quantity_out'];

				//if(naubos si stock sa stock out table (equal si $quantity kay stock na nasa stock out))
				if($quantity == $quantityout){
					//>burahin mo sa stock out table
					$stmt = $conn->prepare("DELETE FROM `tblstockout` WHERE `StockOutId`=:id");
					$stmt->bindParam(':id',$SoID);
					$stmt->execute(); 


					$act = "Depleted";
					$rem = "Stocks Outside Depleted";
					//>mag add ka sa table logs na na deplete na yung stock 
					$stmt = $conn->prepare("INSERT INTO `tblinventorylogs`(`stockid`, `quantity`, `action`, `remarks`,`userid` ,`LogDate`) VALUES (:id, :qty, :act, :rem, :ui, :dt)");
					$stmt->bindParam(':id',$stockID);
					$stmt->bindParam(':qty',$quantity);
					$stmt->bindParam(':act', $act);
					$stmt->bindParam(':rem', $rem);
					$stmt->bindParam(':ui', $_SESSION['acc_id']);
					$stmt->bindParam(':dt',$time);
					$stmt->execute(); 


				}else if($quantityout > $quantity){	//else if nabawasan lang naman 
					//>minus lang quantity; 
					$stmt = $conn->prepare("UPDATE tblstockout SET `Quantity_out` = Quantity_out - :dim WHERE `StockOutId`=:id");
					$stmt->bindParam(':dim', $quantity, PDO::PARAM_INT);
					$stmt->bindParam(':id',$SoID);
					$stmt->execute(); 

					
					$act = "Sales";
					$rem = "Stocks Outside Diminished #".$_SESSION['transid'];

					//>mag add ka sa table logs na nagdiminish ng stock
					$stmt = $conn->prepare("INSERT INTO `tblinventorylogs`(`stockid`, `quantity`, `action`, `remarks`,`userid`, `LogDate`) VALUES (:id, :qty, :act, :rem, :ui, :dt)");
					$stmt->bindParam(':id',$stockID);
					$stmt->bindParam(':qty',$quantity);
					$stmt->bindParam(':act', $act);
					$stmt->bindParam(':rem',$rem);
					$stmt->bindParam(':ui', $_SESSION['acc_id']);
					$stmt->bindParam(':dt',$time);
					$stmt->execute(); 
				} 

			/*

			Add code to update stocks in stockout

			$stmt = $conn->prepare("INSERT INTO `tbltransproduct`(`TransId`, `TransProdId`, `TransProductPrice`, `TransProductQuantity`) VALUES (:tid, :tpid, :tpp, :tqty)");
			$stmt->bindParam(':tid',$tid);
			$stmt->bindParam(':tpid',$currpid);
			$stmt->bindParam(':tpp', $price);
			$stmt->bindParam(':tqty', $quantity);
			$stmt->execute(); 
			*/
		}


	}

	unset($_SESSION['transid']);
	unset($_SESSION['orders']);
	$_SESSION['orders'] = array();
	$_SESSION['transid'] = time();

	echo json_encode(array(
		"message" => 'Payment Success!', 
		"success" => true,
		"transid" => $transprint
		));
}
}


function getVoidCode(){
	$settings = getSettings(array('voidcode'));
	echo json_encode(array("voidcode" => $settings['voidcode']));
}
function voidTransaction(){
	//unset($_SESSION['transid']);
	//unset($_SESSION['orders']);



	$_SESSION['orders'] = array();
	$_SESSION['transid'] = time();


	//insert to void transaction

}
/*
total # of items
Vat
Subtotal

*/




function getSettings(array $keys){
	include 'config/config.php';

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




function loadTransInfo(){
	include 'config/config.php';
	$NoOfItems = 0;
	$total = 0;
	for($i = 0; $i < sizeof($_SESSION['orders']) ; $i++){		
		$quantity = $_SESSION['orders'][$i][1];
		$barcode = $_SESSION['orders'][$i][0];
		$NoOfItems += $quantity;
		$curr = getProductInfo($barcode);

		$total += $curr["price"] * $quantity;
	}

	$vattax = $total / 1.12 * .12;
	$vatable = $total - $vattax;
	$transid = $_SESSION['transid'];

	$time = time();

	$stmt = $conn->prepare("SELECT COUNT(`TransId`) as 'LastOr' FROM tbltransaction");
		$stmt->execute(); 
		$row = $stmt->fetch();
		$orno = (int)$row['LastOr'] + 1;

		$orno = secure(str_pad($orno, 2, '0', STR_PAD_LEFT));



		$dateadded = date("Ymd000", $time);
		$orno = $dateadded.$orno;







	echo json_encode(array(
		'InvoiceNo' => $orno,
		'NoOfItems' => $NoOfItems, 
		'Total'=> number_format($total, 2, '.', ''), 
		'VatTax'=> number_format($vattax, 2, '.', ''), 
		'Vatable' => number_format($vatable, 2, '.', ''), 
		));



/*

	echo json_encode(array(
		'InvoiceNo' => $transid,
		'NoOfItems' => $NoOfItems, 
		'Total'=> number_format($total, 2, '.', ''), 
		'VatTax'=> number_format($vattax, 2, '.', ''), 
		'Vatable' => number_format($vatable, 2, '.', ''), 
		));


		*/
}

function removeOrder(){
	$id = $_POST['id'];

	$_SESSION['orders'][$id][0] = "";
	$_SESSION['orders'][$id][1] = 0;





	//array_splice($_SESSION['orders'], $id, 1);
	//unset($_SESSION['orders'][$id][0]);
	//$_SESSION['orders'] = array_values($_SESSION['orders']);
	loadOrders();
}


function showUpdateQuantity(){
	$id = $_POST['id'];
	$currProd = getProductInfo($id);

	$indexInOrder = 0;
	for($i = 0; $i < sizeof($_SESSION['orders']) ; $i++){
		if($_SESSION['orders'][$i][0] == $id)	{
			$indexInOrder = $i;
		}
	}

	include 'config/config.php';
	$stmt = $conn->prepare("SELECT `Quantity_out`
		FROM tblstockout as so 
		INNER JOIN tblstocks as st 
		ON st.StockId = so.StockId
		INNER join tblproducts as pr 
		ON pr.id = st.ProductId
		WHERE pr.Product_code=:bcode");
	$stmt->bindParam(':bcode',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();


	$qty = array('quantity' =>  $_SESSION['orders'][$indexInOrder][1], 'qout' => (int)$row['Quantity_out']);

	echo json_encode(array_merge($currProd , $qty));
}




function addbcode(){
	$barcode = $_POST['bcode'];
	$product = getProductInfo($barcode);

	if($product['exists']){ 
		$existInOrder = false;
		$indexInOrder = 0;
		for($i = 0; $i < sizeof($_SESSION['orders']) ; $i++){
			if($_SESSION['orders'][$i][0] == $barcode)	{
				$indexInOrder = $i;
				$existInOrder = true;
			}
		}

		if($existInOrder){
			include 'config/config.php';
			$stmt = $conn->prepare("SELECT `Quantity_out`
				FROM tblstockout as so 
				INNER JOIN tblstocks as st 
				ON st.StockId = so.StockId
				INNER join tblproducts as pr 
				ON pr.id = st.ProductId
				WHERE pr.Product_code=:bcode");
			$stmt->bindParam(':bcode',$barcode);
			$stmt->execute(); 
			$row = $stmt->fetch();

			if($row['Quantity_out'] <= $_SESSION['orders'][$indexInOrder][1]){
				echo "<tr><script type='text/javascript'>
				$(document).ready(function(){
					$('#msgtitle').text('Error');
					$('#modalmsg').html('You have reached the limit!');
					$('#msgmodalbtn').text('Close');
					$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
					$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
					$('#msgmodal').modal('show');
				});
			</script></tr>";
		}else{
			$_SESSION['orders'][$indexInOrder][1]++;
		}
	}else{
		array_push($_SESSION['orders'], array($barcode, 1));
	}
}else{
	echo "<tr><script type='text/javascript'>
	$(document).ready(function(){
		$('#msgtitle').text('Error');
		$('#modalmsg').html('Product not Found in the database!');
		$('#msgmodalbtn').text('Close');
		$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
		$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
		$('#msgmodal').modal('show');
	});
</script></tr>";
}

loadOrders();
}


function setQuantity(){
	$barcode = $_POST['barcode'];
	$quantity = $_POST['quantity'];


	$indexInOrder = 0;
	for($i = 0; $i < sizeof($_SESSION['orders']) ; $i++){
		if($_SESSION['orders'][$i][0] != ""){
			if($_SESSION['orders'][$i][0] == $barcode)	{
				$indexInOrder = $i;
			}
		}
	}
	$_SESSION['orders'][$indexInOrder][1] = $quantity;
	loadOrders();
}


function loadOrders(){
	for($i = 0; $i < sizeof($_SESSION['orders']) ; $i++){
		if($_SESSION['orders'][$i][0] != ""){
			$currProduct = getProductInfo($_SESSION['orders'][$i][0]);
			$bcode = $_SESSION['orders'][$i][0];
			$pname = $currProduct["pname"];
			$price = $currProduct["price"];
			$quantity = $_SESSION['orders'][$i][1];
			echo "<tr>".
			"<td><button type='button' class='btn btn-sm btn-danger' onclick='deleteOrder($i)' aria-label='Close'>&times</button></td>".
			"<td>".$bcode."</td>".
			"<td >".$pname."</td>".
			"<td class='text-center'>₱ ".number_format($price, 2, '.', ',')."</td>".
			"<td class='text-center'>
			<a onclick=\"updateQuantity('$bcode')\">$quantity</a>

		</td>".
		"<td class='text-right'>₱ ". number_format(($quantity * $price), 2, '.', ',')."</td>".
		"</tr>";

	}

}
}

function voidOrders(){
	$_SESSION['orders'] = null;

}
function getProductInfo($barcode){
	include 'config/config.php';
	$stmt = $conn->prepare("SELECT
		pr.Product_name, (st.`SupplierPrice` + (st.`SupplierPrice` * (pr.MarkupPercentage / 100))) as `SellingPrice`, pr.id, st.Product_supplier, st.SupplierPrice, so.Quantity_out
		FROM
		`tblstockout` AS so
		INNER JOIN tblstocks AS st
		ON
		st.StockId = so.`StockId`
		INNER JOIN tblproducts as pr 
		ON st.ProductId = pr.id
		WHERE pr.Product_code =:bcode");
	$stmt->bindParam(':bcode',$barcode);
	$stmt->execute(); 
	$row = $stmt->fetch();
	$count = $stmt->rowCount();
	$pname = $row['Product_name'];
	$price = $row['SellingPrice'];
	$pid = $row['id'];
	$supid = $row['Product_supplier'];
	$supprice = $row['SupplierPrice'];
	$qout = $row['Quantity_out'];

	$exist = ($count == 1) ? 1 : 0;
	return array(
		"prodid" => $pid,
		"pname" => $pname, 
		"price" => $price,
		"supid" => $supid,
		"supprice" => $supprice,
		"qout" => $qout,
		"exists" => $exist);
} 

function secure($str){
	return strip_tags(trim(htmlspecialchars($str)));
}


function ContainsNumbers($String){
	return preg_match('/\\d/', $String) > 0;
}


?>

	