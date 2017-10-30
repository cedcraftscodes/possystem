<?php 


if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'loadSuppliers':
		loadSuppliers();
		break;

		case 'loadUnit':
		loadUnit();
		break;

		case 'loadCategories':
		loadCategories();
		break;


		case 'loadBadOrders':
		loadBadOrders();
		break;


		case 'loadProductsToCbo':
		loadProductsToCbo();
		break;

		case 'showreplaceinfo':
		showreplaceinfo();
		break;


		case 'checkForReplacement':
		checkForReplacement();
		break;

		case 'returnprodcust':
		returnprodcust();
		break;

		case 'showownertosupplier':
		showownertosupplier();
		break;

		case 'loadStockidToCbo':
		loadStockidToCbo();
		break;


		case 'returnownertosup':
		returnownertosup();
		break;


		case 'addProduct':
		addProduct();
		break;


		case 'deleteProduct':
		deleteProduct();
		break;


		case 'showUpdateBadOrders':
		showUpdateBadOrders();
		break;

		case 'replaceboproduct':
		replaceboproduct();
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

function loadStockidToCbo(){
	include '../config/config.php';
	$bcks = $conn->query("SELECT
		`StockId`
		FROM
		`tblstocks`
		WHERE
		`No_Of_Items` >=1 AND Deleted='NO'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['StockId']."'>".$r['StockId']."</option>";
	}
}

function loadProductsToCbo(){
	include '../config/config.php';
	$transno = $_POST['tid'];	
	$bcks = $conn->prepare("SELECT
		pr.Product_name, 
		pr.id
		FROM
		`tbltransproduct` as tp
		INNER JOIN tblproducts as pr 
		ON pr.id = tp.`TransProdId`
		INNER JOIN tbltransaction as tr
		ON tr.TransId = tp.`TransId`
		WHERE `TransNo` = ?");

	$bcks->execute(array($transno));

	while($r = $bcks->fetch()){
		echo "<option value='".$r['id']."'>".$r['Product_name']."</option>";
	}
}

function deleteProduct()
{
	include '../config/config.php';
	$id = $_POST['id'];




	$stmt = $conn->prepare("SELECT * FROM `tblproducts` WHERE `Product_category`=:id and Deleted='NO'");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();
	$count = $stmt->rowCount();
	if($count >= 1){
		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Error');
			$('#modalmsg').html('Product can not be deleted, there are still products on stocks!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
			$('#msgmodal').modal('show');
		});
		</script></tr>";
	}else{
    // prepare sql and bind parameters
		$stmt = $conn->prepare("UPDATE tblproducts set Deleted='YES' WHERE `id`=:id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();

		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Product successfully deleted!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});
		</script></tr>";
	}



	loadProducts();
}




function loadBadOrders()
{
	include '../config/config.php';

	$prod = $conn->query("SELECT
		`badorder_id`,
		pr.Product_name,
		sup.Supplier_name,
		`supplier_price`,
		`quantity`,
		`remarks`,
		bo.`dateadded`,
		`Status`, 
		CONCAT(us.fname, ' ', us.lname) as 'PreparedBy'
		FROM
		`tblbadorders` as bo 
		INNER JOIN tblproducts as pr 
		ON bo.`product_id` = pr.id
		INNER JOIN tblsuppliers as sup 
		ON sup.Supplier_id = bo.`supplier_id`
		INNER JOIN tblusers as us 
		ON us.userid = bo.`preparedby`
		WHERE `status`='Pending'
		");
	while($r = $prod->fetch()){
		echo "<tr>";
		echo "<td>".$r['badorder_id']."</td>";
		echo "<td>".$r['Product_name']."</td>";
		echo "<td>".$r['Supplier_name']."</td>";
		echo "<td>".$r['supplier_price']."</td>";
		echo "<td>".$r['quantity']."</td>";
		echo "<td>".($r['quantity'] * $r['supplier_price'])."</td>";
		echo "<td>".$r['remarks']."</td>";
		echo "<td>".$r['PreparedBy']."</td>";
		$dateadded = date("F j, Y, g:i a", $r["dateadded"]);
		echo "<td>".$dateadded."</td>";
		echo '<td><a class="btn btn-sm btn-info" onclick="replaceproduct('.$r['badorder_id'].')"> <span class="glyphicon glyphicon-pencil"></span> Replace</a> | 
		</td>';
		echo "</tr>";
	}
}





function checkForReplacement()
{
	include '../config/config.php';
	$transid = $_POST['tid'];
	$pid = $_POST['pid'];
	$quantity = $_POST['qty'];



	$stmt = $conn->prepare("SELECT
		`TransSupplier`,
		tp.`TransProductPrice`
		FROM
		`tbltransproduct` as tp
		INNER join tblsuppliers as sup 
		ON sup.Supplier_id = tp.`TransSupplier`
		INNER JOIN tbltransaction as ts 
		ON ts.TransId = tp.`TransId`
		WHERE ts.TransNo = :tid AND tp.`TransProdId` = :pid
		");


	$stmt->bindParam(':pid',$pid);
	$stmt->bindParam(':tid',$transid);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$sid = secure($row['TransSupplier']);
	$selling = secure($row['TransProductPrice']);


	$stmt = $conn->prepare("SELECT
		`StockOutId`,
		pr.Product_name
		FROM
		`tblstockout` AS so
		INNER JOIN tblstocks AS st
		ON
		st.StockId = so.`StockId`
		INNER JOIN tblproducts AS pr
		ON
		pr.id = st.ProductId
		WHERE
		so.`Quantity_out` >= :qty 
		AND st.Product_supplier = :sup 
		AND pr.id =:pid 
		AND (st.`SupplierPrice` + (st.`SupplierPrice` * (pr.MarkupPercentage / 100)))=:sell");

	$stmt->bindParam(':qty',$quantity);
	$stmt->bindParam(':sup',$sid);	
	$stmt->bindParam(':pid',$pid);
	$stmt->bindParam(':sell',$selling);

	$stmt->execute(); 
	$row = $stmt->fetch();
	$count = $stmt->rowCount();

	$soid = secure($row['StockOutId']);
	$prodname = secure($row['Product_name']);


	if($count == 1){

		echo json_encode(array(
			"hasReplacement" => true, 
			"soid" => $soid, 
			"prodname" => $prodname
		));
	}else if($count == 0){
		echo json_encode(array(
			"hasReplacement" => false
		));
	}





}	






function showownertosupplier(){
	include '../config/config.php';
	$stockid = $_POST['stockid'];
	$stmt = $conn->prepare("SELECT
		pr.Product_name, 
		sp.Supplier_name, 
		st.`SupplierPrice`, 
		st.`No_Of_Items`

		FROM
		`tblstocks` as st 
		INNER JOIN tblproducts as pr 
		ON pr.id = st.`ProductId`
		INNER JOIN tblsuppliers as sp 
		ON sp.Supplier_id = st.`Product_supplier`
		WHERE `StockId`=:id");

	$stmt->bindParam(':id',$stockid);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$Product_name = secure($row['Product_name']);
	$Supplier_name = secure($row['Supplier_name']);
	$SupplierPrice = secure($row['SupplierPrice']);
	$No_Of_Items = secure($row['No_Of_Items']);


	echo json_encode(array(
		"Product_name" => $Product_name, 
		"Supplier_name" => $Supplier_name, 
		"SupplierPrice" => $SupplierPrice, 
		"No_Of_Items" => $No_Of_Items, 
	));
}

function showreplaceinfo()
{
	include '../config/config.php';
	$transid = $_POST['tid'];
	$pid = $_POST['pid'];
	$stmt = $conn->prepare("SELECT
		sup.Supplier_name, 
		tp.`TransSupplierPrice`, 
		tp.`TransProductPrice`, 
		tp.`TransProductQuantity`
		FROM
		`tbltransproduct` as tp
		INNER join tblsuppliers as sup 
		ON sup.Supplier_id = tp.`TransSupplier`
		INNER JOIN tbltransaction as ts 
		ON ts.TransId = tp.`TransId`
		WHERE ts.TransNo = :tid AND tp.`TransProdId` = :pid");


	$stmt->bindParam(':pid',$pid);
	$stmt->bindParam(':tid',$transid);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$supname = secure($row['Supplier_name']);
	$supprice = secure($row['TransSupplierPrice']);
	$selling = secure($row['TransProductPrice']);
	$quantity = secure($row['TransProductQuantity']);


	echo json_encode(array(
		"supname" => $supname, 
		"supprice" => $supprice, 
		"selling" => $selling, 
		"quantity" => $quantity, 
	));

}	



function showUpdateBadOrders()
{
	include '../config/config.php';
	$bid = $_POST['bid'];
	$stmt = $conn->prepare("SELECT
		bo.`badorder_id`, 
		pr.Product_name, 
		sup.Supplier_name,
		bo.`supplier_price`,
		bo.`quantity`,
		CONCAT(us.fname, ' ', us.lname) as 'Prepared',
		bo.`remarks`
		FROM
		`tblbadorders` as bo 
		INNER JOIN tblproducts as pr 
		ON pr.id = bo.`product_id`
		INNER JOIN tblusers as us 
		ON us.userid = bo.`preparedby`

		INNER JOIN tblsuppliers as sup 
		ON sup.Supplier_id = bo.`supplier_id`
		WHERE bo.`badorder_id` = :bid");

	$stmt->bindParam(':bid',$bid);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$bid = secure($row['badorder_id']);
	$Product_name = secure($row['Product_name']);
	$Supplier_name = secure($row['Supplier_name']);
	$supplier_price = secure($row['supplier_price']);
	$quantity = secure($row['quantity']);
	$Prepared = secure($row['Prepared']);
	$remarks = secure($row['remarks']);

	echo json_encode(array(
		"bid" => $bid, 
		"Product_name" => $Product_name, 
		"Supplier_name" => $Supplier_name,
		"supplier_price" => $supplier_price, 
		"quantity" => $quantity,
		"Prepared" => $Prepared, 
		"remarks" => $remarks));





}	

function returnownertosup(){

	include '../config/config.php';

	// `product_id`, `preparedby`, `supplier_id`, `supplier_price`, `quantity`, `remarks`, `dateadded`, `Status`
	$time = time();
	$stid = secure($_POST['cbostockid']);
	$quantity = secure($_POST['quantity_sup']);
	$remarks = secure($_POST['remarks_sup']);
	$pass = secure(md5($_POST['password_sup']));

	/*
		Validations 
	*/

		$errors = array();
		//Wrong password
		$stmt = $conn->prepare("SELECT `pass_word` FROM tblusers WHERE userid=:id");
		$stmt->bindParam(':id',$_SESSION['acc_id']);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$passindb = $row['pass_word'];

		if($passindb != $pass){
			array_push($errors, "Password mismatch!");
		}


		if(count($errors) > 0 )
		{

			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Error');
				$('#modalmsg').html(\"".implode("<br />",$errors)."\");
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
				$('#msgmodal').modal('show');
			});
			</script></tr>";
		}
		else
		{

		//reduce stock
			$stmt = $conn->prepare("UPDATE tblstocks SET `No_Of_Items` = No_Of_Items - :dim WHERE `StockId` =:sid");
			$stmt->bindParam(':sid',$stid);
			$stmt->bindParam(':dim', $quantity, PDO::PARAM_INT);
			$stmt->execute(); 

			$stmt = $conn->prepare("SELECT `ProductId`, `SupplierPrice`, `Product_supplier` ,`MarkupPercentage` FROM tblstocks as st  INNER JOIN tblproducts as pr ON pr.`id` = st.`ProductId` WHERE `StockId`=:sid");

			$row = $stmt->fetch();
			$stmt->bindParam(':sid',$stid);
			$stmt->execute(); 
			$row = $stmt->fetch();

			$pid = secure($row['ProductId']);
			$sid = secure($row['Product_supplier']);
			$supprice = secure($row['SupplierPrice']);
			$markup = secure($row['MarkupPercentage']);

			$status = "Pending";
			//insert into bad orders
			$stmt = $conn->prepare("INSERT INTO `tblbadorders`(`product_id`, `preparedby`, `supplier_id`, `supplier_price`, `quantity`, `remarks`, `dateadded`, `Status`) VALUES (:pid, :pb, :sup, :sprice, :qty, :rem, :dat, :stat)");
			$stmt->bindParam(':pid', $pid);
			$stmt->bindParam(':sup', $sid);
			$stmt->bindParam(':sprice', $supprice);


			$stmt->bindParam(':pb', $_SESSION['acc_id']);
			$stmt->bindParam(':qty', $quantity);
			$stmt->bindParam(':rem', $remarks);
			$stmt->bindParam(':dat', $time);
			$stmt->bindParam(':stat', $status);
			$stmt->execute();


		//insert into table adjustments



			$stmt = $conn->prepare("INSERT INTO `tbladjustment`( `product_id`, `quantity`, `remarks`, `supplier_price`, `markup`, `dateadjusted`, `Status`) VALUES (:pid, :qty, :rem, :sprice, :mark, :da, 'Deduction')");
			$stmt->bindParam(':pid', $pid);
			$stmt->bindParam(':sprice', $supprice);
			$stmt->bindParam(':qty', $quantity);
			$stmt->bindParam(':rem', $remarks);
			$stmt->bindParam(':mark', $markup);
			$stmt->bindParam(':da', $time);
			$stmt->execute();






			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Success');
				$('#modalmsg').html('Bad Order successfully added!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
				$('#msgmodal').modal('show');
			});
			</script></tr>";



		}
		loadBadOrders();

	}

	function returnprodcust()
	{
		include '../config/config.php';

	// `product_id`, `preparedby`, `supplier_id`, `supplier_price`, `quantity`, `remarks`, `dateadded`, `Status`

		$pid = secure($_POST['cboprodcust']);
		$transid = secure($_POST['tnum']);


		$stmt = $conn->prepare("SELECT
			`TransSupplier`,
			tp.`TransSupplierPrice`,
			TransProductPrice
			FROM
			`tbltransproduct` as tp
			INNER join tblsuppliers as sup 
			ON sup.Supplier_id = tp.`TransSupplier`
			INNER JOIN tbltransaction as ts 
			ON ts.TransId = tp.`TransId`
			WHERE ts.TransNo = :tid AND tp.`TransProdId` = :pid
			");

		$row = $stmt->fetch();
		$stmt->bindParam(':pid',$pid);
		$stmt->bindParam(':tid',$transid);
		$stmt->execute(); 
		$row = $stmt->fetch();

		$selling = secure($row['TransProductPrice']);


		$sid = secure($row['TransSupplier']);
		$supprice = secure($row['TransSupplierPrice']);

		$accid = $_SESSION['acc_id'];
		$pass = secure(md5($_POST['cust_pass']));
		$quantity = secure($_POST['cust_quantity']);
		$remarks = secure($_POST['cust_remarks']);
		$time = time();
		$status = "Pending";
		$soid = 0;
		$prodname = "";





	/*
		Validations 
	*/

		$errors = array();
		//Wrong password
		$stmt = $conn->prepare("SELECT `pass_word` FROM tblusers WHERE userid=:id");
		$stmt->bindParam(':id',$accid);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$passindb = $row['pass_word'];

		if($passindb != $pass){
			array_push($errors, "Password mismatch!");
		}


		$refund_replace = $_POST['refund_replace'];  
		if ($refund_replace == "replace") {          
				    //no replacement
			$stmt = $conn->prepare("SELECT
				`StockOutId`,
				pr.Product_name
				FROM
				`tblstockout` AS so
				INNER JOIN tblstocks AS st
				ON
				st.StockId = so.`StockId`
				INNER JOIN tblproducts AS pr
				ON
				pr.id = st.ProductId
				WHERE
				so.`Quantity_out` >= :qty 
				AND st.Product_supplier = :sup 
				AND pr.id =:pid 
				AND (st.`SupplierPrice` + (st.`SupplierPrice` * (pr.MarkupPercentage / 100))) =:sell");

			$stmt->bindParam(':qty',$quantity);
			$stmt->bindParam(':sup',$sid);	
			$stmt->bindParam(':pid',$pid);
			$stmt->bindParam(':sell',$selling);

			$stmt->execute(); 

			$row = $stmt->fetch();
			$count = $stmt->rowCount();

			$soid = secure($row['StockOutId']);
			$prodname = secure($row['Product_name']);


			if($count == 0){
				array_push($errors, "Product has no replacement!");
			}   
		}


		

		if(count($errors) > 0 )
		{

			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Error');
				$('#modalmsg').html(\"".implode("<br />",$errors)."\");
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
				$('#msgmodal').modal('show');
			});
			</script></tr>";
		}
		else
		{
			if ($refund_replace == "replace") {     
			//check stock in stockout
			//if stock quantity is == , diminish and delete
			//if
			//reduce stocks in stockout
			//insert into bad orders


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
				$stmt->bindParam(':id',$pid);
				$stmt->execute(); 
				$row = $stmt->fetch();

				$stockID = $row['StockId'];
				$SoID = $row['StockOutId'];
				$quantityout = $row['Quantity_out'];


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
					$rem = "Stocks Outside Diminished #";

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
				$status = "Pending";
				$stmt = $conn->prepare("INSERT INTO `tblbadorders`(`product_id`, `preparedby`, `supplier_id`, `supplier_price`, `quantity`, `remarks`, `dateadded`, `Status`) VALUES (:pid, :pb, :sup, :sprice, :qty, :rem, :dat, :stat)");
				$stmt->bindParam(':pid', $pid);
				$stmt->bindParam(':pb', $accid);
				$stmt->bindParam(':sup', $sid);
				$stmt->bindParam(':sprice', $supprice);
				$stmt->bindParam(':qty', $quantity);
				$stmt->bindParam(':rem', $remarks);
				$stmt->bindParam(':dat', $time);
				$stmt->bindParam(':stat', $status);
				$stmt->execute();

				$bid = $conn->lastInsertId();


			}
			else if ($refund_replace == "refund")
			{

				$status = "Pending";
			//insert into bad orders
				$stmt = $conn->prepare("INSERT INTO `tblbadorders`(`product_id`, `preparedby`, `supplier_id`, `supplier_price`, `quantity`, `remarks`, `dateadded`, `Status`) VALUES (:pid, :pb, :sup, :sprice, :qty, :rem, :dat, :stat)");
				$stmt->bindParam(':pid', $pid);
				$stmt->bindParam(':pb', $accid);
				$stmt->bindParam(':sup', $sid);
				$stmt->bindParam(':sprice', $supprice);
				$stmt->bindParam(':qty', $quantity);
				$stmt->bindParam(':rem', $remarks);
				$stmt->bindParam(':dat', $time);
				$stmt->bindParam(':stat', $status);
				$stmt->execute();
				$bid = $conn->lastInsertId();

				$amount = $quantity * $selling;

			//insert into tblrefunds
				$stmt = $conn->prepare("INSERT INTO `tblrefunds`(`boid`, `amount`, `refunddate`) VALUES (:boid, :amount, :dat)");
				$stmt->bindParam(':boid', $bid);
				$stmt->bindParam(':amount', $amount);
				$stmt->bindParam(':dat', $time);
				$stmt->execute();
			}


			$stmt = $conn->prepare("SELECT
				pr.`MarkupPercentage`
				FROM`tblproducts`  as pr
				WHERE pr.`id` = :id");
			$stmt->bindParam(':id',$pid);
			$stmt->execute(); 
			$row = $stmt->fetch();

			$markup = $row['MarkupPercentage'];


			$stmt = $conn->prepare("INSERT INTO `tbladjustment`( `product_id`, `quantity`, `remarks`, `supplier_price`, `markup`, `dateadjusted`, `Status`) VALUES (:pid, :qty, :rem, :sprice, :mark, :da, 'Deduction')");
			$stmt->bindParam(':pid', $pid);
			$stmt->bindParam(':sprice', $supprice);
			$stmt->bindParam(':qty', $quantity);
			$stmt->bindParam(':rem', $remarks);
			$stmt->bindParam(':mark', $markup);
			$stmt->bindParam(':da', $time);
			$stmt->execute();


			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Success');
				$('#modalmsg').html('Bad Order successfully added!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
				$('#msgmodal').modal('show');
			});
			</script></tr>";



		}
		loadBadOrders();


	}



	function replaceboproduct(){
		include '../config/config.php';
		$time = time();
		$quantity = secure($_POST['replace_quantityin']);
		$bid = secure($_POST['u_bid']);
		$errors = array();

	/*
	if(strlen($_POST['u_mname']) == 0){
		array_push($errors, "Middle Name can not be blank!");
	}else{
		if(ContainsNumbers($_POST['u_mname'])){
			array_push($errors, "Middle Name contains number!");
		}
	}
	*/

	if(count($errors) > 0 )
	{

		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Error');
			$('#modalmsg').html(\"".implode("<br />",$errors)."\");
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
			$('#msgmodal').modal('show');
		});
		</script></tr>";
	}
	else
	{
	//diminish quantity in bad orders 
		$stmt = $conn->prepare("UPDATE tblbadorders SET `quantity` = `quantity` - :dim WHERE `badorder_id`=:bid");
		$stmt->bindParam(':bid', $bid);
		$stmt->bindParam(':dim', $quantity, PDO::PARAM_INT);
		$stmt->execute();


		//get quantity ni bad order

		$stmt = $conn->prepare("SELECT
			`quantity`
			FROM
			`tblbadorders`
			WHERE
			`badorder_id` =:bid");
		$stmt->bindParam(':bid',$bid);
		$stmt->execute(); 
		$row = $stmt->fetch();

		$qtyindb = secure((int)$row['quantity']);


		if($qtyindb == 0){
		//quantity is 0 , then update the status to Completed	
			$stmt = $conn->prepare("UPDATE tblbadorders SET `Status`='Completed' WHERE `badorder_id`=:bid");
			$stmt->bindParam(':bid', $bid);
			$stmt->execute();

		}



		$stmt = $conn->prepare("SELECT
			bo.`product_id`, 
			bo.`supplier_price`, 
			bo.`supplier_id`
			FROM
			`tblbadorders` as bo 
			WHERE `badorder_id` = :bid");
		$stmt->bindParam(':bid',$bid);
		$stmt->execute(); 
		$row = $stmt->fetch();


		$pid = secure($row['product_id']);
		$supplierp = secure($row['supplier_price']);
		$suppid = secure($row['supplier_id']);

		$sellingp = 0 ;
		$stmt = $conn->prepare("SELECT MarkupPercentage FROM tblproducts as pr WHERE pr.id=:pid");
		$stmt->bindParam(':pid',$pid);
		$stmt->execute(); 

		$row = $stmt->fetch();
		$markup= secure($row['MarkupPercentage']);
		$sellingp = ($supplierp + ($supplierp * ($markup / 100))) ;



	//add new stocks
		$stmt = $conn->prepare("INSERT INTO `tblstocks`(`ProductId`, `No_Of_Items`, `Product_supplier`, `SupplierPrice`, `DateAdded`, `Deleted`) VALUES (:pid, :qty , :sup, :supprice, :dt, 'NO')");
		$stmt->bindParam(':pid', $pid);
		$stmt->bindParam(':qty', $quantity);
		$stmt->bindParam(':sup', $suppid);
		$stmt->bindParam(':supprice', $supplierp);
		$stmt->bindParam(':dt', $time);
		$stmt->execute();


		$remarks = "Product Replaced";
		$stmt = $conn->prepare("INSERT INTO `tbladjustment`( `product_id`, `quantity`, `remarks`, `supplier_price`, `markup`, `dateadjusted`, `Status`) VALUES (:pid, :qty, :rem, :sprice, :mark, :da, 'Addition')");
		$stmt->bindParam(':pid', $pid);
		$stmt->bindParam(':sprice', $supplierp);
		$stmt->bindParam(':qty', $quantity);
		$stmt->bindParam(':rem', $remarks);
		$stmt->bindParam(':mark', $markup);
		$stmt->bindParam(':da', $time);
		$stmt->execute();
	}



	echo "<tr><script type='text/javascript'>
	$(document).ready(function(){
		$('#msgtitle').text('Success');
		$('#modalmsg').html('Product successfully replaced!');
		$('#msgmodalbtn').text('Close');
		$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
		$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
		$('#msgmodal').modal('show');
	});
	</script></tr>";


	loadBadOrders();




}


?>