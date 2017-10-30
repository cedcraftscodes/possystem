<?php 


if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {


		case 'deleteStock':
		deleteStock();
		break;

		case 'showStocks':
		showStocks();
		break;


		case 'showStockOutProduct':
		showStockOutProduct();
		break;


		case 'stockOut':
		stockOut();
		break;


		

		case 'showStockOut':
		showStockOut();
		break;

		case 'showStockInProduct':
		showStockInProduct();
		break;
		case 'stockIn':
		stockIn();
		break;

		case 'loadSuppliers':
		loadSuppliers();
		break;

		case 'loadProducts':
		loadProducts();
		break;


		case 'addStock':
		addStock();
		break;

		case 'showUpdateStocks':
		showUpdateStocks();
		break;


		case 'updateStock':
		updateStock();
		break;


		case 'showMarkupPercent':
		showMarkupPercent();
		break;


		case 'computeSellingPrice':
		computeSellingPrice();
		break;

		case 'showAccountsComplete':
		showAccountsComplete();
		break;
		


		default:
				# code...
		break;
	}
}

function secure($str){
	return strip_tags(trim(htmlspecialchars($str)));
}


function ContainsNumbers($String){
	return preg_match('/\\d/', $String) > 0;
}

function computeSellingPrice(){
	include '../config/config.php';
	$id = $_POST['pid'];
	$supplierprice = (float)$_POST['supplier_price'];


	$stmt = $conn->prepare("SELECT MarkupPercentage FROM tblproducts WHERE id=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$markup = $row['MarkupPercentage'] / 100;

	$SellingPrice = ($supplierprice + ($supplierprice * $markup));

	echo json_encode(array(
		"sellingprice" => $SellingPrice
	));
}



function showMarkupPercent(){
	include '../config/config.php';
	$id = $_POST['pid'];
	$stmt = $conn->prepare("SELECT MarkupPercentage FROM tblproducts WHERE id=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$markup = $row['MarkupPercentage'];


	echo json_encode(array(
		"markup" => $markup
	));
}





function showAccountsComplete()
{
	include '../config/config.php';
	$stmt = $conn->prepare("SELECT CONCAT(`fname`, ' ', `lname`) as 'Accounts' FROM `tblusers`");
	$stmt->execute(); 
	$units = $stmt->fetchAll(PDO::FETCH_COLUMN);
	echo json_encode($units);
}	




function updateStock(){
	include '../config/config.php';
	$suId = secure($_POST['su_id']);
	$su_quantity = secure($_POST['su_quantity']);
	$remarks = secure($_POST['su_remarks']);
	$liable = secure($_POST['su_liable']);

	$remarks.= " by: ".$liable;




	/*
		Validations 
	*/
		$errors = array();

		/*

		if(strlen($_POST['fname']) == 0){
			array_push($errors, "First Name can not be blank!");
		}else{
			if(ContainsNumbers($_POST['fname'])){
				array_push($errors, "First Name contains number!");
			}
		}
		*/




		//get the ceiling of the product;

		$stmt = $conn->prepare("SELECT pr.`Product_ceiling` FROM `tblproducts` as pr 
			INNER JOIN tblstocks as st
			ON st.`ProductId` = pr.`id`
			WHERE st.`StockId`=:id AND st.`Deleted`='NO'");
		$stmt->bindParam(':id',$suId);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$ceiling = secure($row['Product_ceiling']);
		if($su_quantity > $ceiling){
			array_push($errors, "Ceiling is reached!");
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



		///get supplier price , stock quantity


			$stmt = $conn->prepare("SELECT 
				pr.`id`,
				st.`SupplierPrice`,
				pr.`MarkupPercentage`,
				st.`SupplierPrice` + (st.`SupplierPrice` * (pr.MarkupPercentage / 100)) as `SellingPrice`, 
				st.`No_Of_Items`
				FROM `tblproducts` as pr 
				INNER JOIN tblstocks as st
				ON st.`ProductId` = pr.`id`
				WHERE st.`StockId`=:id AND st.`Deleted`='NO'");
			$stmt->bindParam(':id',$suId);
			$stmt->execute(); 
			$row = $stmt->fetch();


			$sellingprice = secure($row['SellingPrice']);
			$markup = secure($row['MarkupPercentage']);
			$quantityInDb = secure($row['No_Of_Items']);
			$pid = secure($row['id']);
			$supplierp = secure($row['SupplierPrice']);
			$time = time();
			

			$qantityadj = 0;
			if($su_quantity < $quantityInDb){
				$qantityadj = $quantityInDb - $su_quantity;
			//deduction

				$stmt = $conn->prepare("INSERT INTO `tbladjustment`( `product_id`, `quantity`, `remarks`, `supplier_price`, `markup`, `dateadjusted`, `Status`) VALUES (:pid, :qty, :rem, :sprice, :mark, :da, 'Deduction')");
				$stmt->bindParam(':pid', $pid);
				$stmt->bindParam(':sprice', $supplierp);
				$stmt->bindParam(':qty', $qantityadj);
				$stmt->bindParam(':rem', $remarks);
				$stmt->bindParam(':mark', $markup);
				$stmt->bindParam(':da', $time);
				$stmt->execute();


			}else if ($su_quantity > $quantityInDb){
				$qantityadj = $su_quantity - $quantityInDb;
			//addition
				$stmt = $conn->prepare("INSERT INTO `tbladjustment`( `product_id`, `quantity`, `remarks`, `supplier_price`, `markup`, `dateadjusted`, `Status`) VALUES (:pid, :qty, :rem, :sprice, :mark, :da, 'Addition')");
				$stmt->bindParam(':pid', $pid);
				$stmt->bindParam(':sprice', $supplierp);
				$stmt->bindParam(':qty', $qantityadj);
				$stmt->bindParam(':rem', $remarks);
				$stmt->bindParam(':mark', $markup);
				$stmt->bindParam(':da', $time);
				$stmt->execute();
			}

			$stmt = $conn->prepare("UPDATE `tblstocks` SET `No_Of_Items`=:supp WHERE `StockId`=:id");
			$suId = secure($_POST['su_id']);
			$su_quantity = secure($_POST['su_quantity']);
			$stmt->bindParam(':supp', $su_quantity);
			$stmt->bindParam(':id', $suId);
			$stmt->execute();

			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Success');
				$('#modalmsg').html('Stock successfully updated!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
				$('#msgmodal').modal('show');
			});
			</script></tr>";
		}
		showStocks();

	}
	function showUpdateStocks()
	{
		include '../config/config.php';
		$id = $_POST['id'];

		$stmt = $conn->prepare("SELECT
			st.`StockId`,
			pr.Product_name,
			sp.Supplier_name,
			st.`No_Of_Items`,
			st.`SupplierPrice`,
			st.`DateAdded`
			FROM
			`tblstocks` AS st
			INNER JOIN tblproducts AS pr
			ON
			pr.id = st.`ProductId`
			INNER JOIN tblsuppliers AS sp
			ON
			sp.Supplier_id = st.Product_supplier
			WHERE st.`Deleted`='NO' AND st.`StockId`=:id");
		$stmt->bindParam(':id',$id);
		$stmt->execute(); 
		$row = $stmt->fetch();

		$suProductName = $row['Product_name'];
		$suSupplier = $row['Supplier_name'];
		$suSupPrice = $row['SupplierPrice'];
		$su_quantity = $row['No_Of_Items'];

		echo json_encode(array(
			"suProductName" => $suProductName, 
			"suSupplier" => $suSupplier, 
			"suSupPrice" => number_format($suSupPrice, 2,".",","),
			"su_quantity" => $su_quantity
		));

	}	





	function showStocks()
	{
		include '../config/config.php';

		$stocks = $conn->query("SELECT
			st.`StockId`,
			pr.id,
			pr.Product_name,
			sp.Supplier_name,
			st.`No_Of_Items`,
			st.`SupplierPrice`,
			(st.`SupplierPrice` + (st.`SupplierPrice` * (pr.MarkupPercentage / 100))) as `SellingPrice`,
			st.`DateAdded`
			FROM
			`tblstocks` AS st
			INNER JOIN tblproducts AS pr
			ON
			pr.id = st.`ProductId`
			INNER JOIN tblsuppliers AS sp
			ON
			sp.Supplier_id = st.Product_supplier
			WHERE st.`Deleted`='NO'
			ORDER BY st.`StockId` DESC");


		while($r = $stocks->fetch()){
			echo "<tr>";
			echo "<td>".$r['StockId']."</td>";
			echo "<td>".$r['Product_name']."</td>";
			echo "<td>".$r['Supplier_name']."</td>";

			echo "<td>₱ ".number_format($r['SupplierPrice'], 2,".",",")."</td>";
			echo "<td>₱ ".number_format($r['SellingPrice'], 2,".",",")."</td>";
			echo "<td>".$r['No_Of_Items']."</td>";
			$dateadded = date("F j, Y, g:i a", $r["DateAdded"]);
			echo "<td>".$dateadded."</td>";

			echo "<td>";

			$stmt1 = $conn->prepare("SELECT * FROM `tblstocks` WHERE `ProductId`=:pid and Deleted ='NO' AND `DateAdded` < (SELECT `DateAdded` FROM tblstocks WHERE StockId=:stid) AND No_Of_Items > 0");
			$stmt1->bindParam(':stid', $r['StockId']);
			$stmt1->bindParam(':pid',$r['id']);
			$stmt1->execute(); 
			$row1 = $stmt1->fetch();
			$count = $stmt1->rowCount();


			if($count >= 1 || $r['No_Of_Items'] == 0){
				echo "<a class='btn btn-sm btn-info' disabled=''> <span class='glyphicon glyphicon-pencil'></span> Stock Out</a>";
			}else{

				echo "<a class='btn btn-sm btn-info' onclick='stockOut(".$r['StockId'].")'> <span class='glyphicon glyphicon-pencil'></span> Stock Out</a>";
			}





			echo "<a class='btn btn-sm btn-primary' onclick='updateStocks(".$r['StockId'].")'><span class='glyphicon glyphicon-trash'></span> Edit</a>";



		//echo "<a class='btn btn-sm btn-danger' onclick='removeStock(".$r['StockId'].")'><span class='glyphicon glyphicon-trash'></span> Remove</a>";


			echo "</td>";
			echo "</tr>";
		}
	}



	function addStock()
	{
		include '../config/config.php';
		$pid = secure($_POST['cboproducts']);
		$qty = secure($_POST['stockqty']);
		$sup = secure($_POST['cbosupplier']);
		$supp = secure($_POST['supplierprice']);
		$time = time();

	/*
		Validations 
	*/
		$errors = array();

		/*

		if(strlen($_POST['fname']) == 0){
			array_push($errors, "First Name can not be blank!");
		}else{
			if(ContainsNumbers($_POST['fname'])){
				array_push($errors, "First Name contains number!");
			}
		}
		*/

		//get the ceiling of the product;

		$stmt = $conn->prepare("SELECT `Product_ceiling` FROM `tblproducts` WHERE `id`=:id");
		$stmt->bindParam(':id',$pid);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$ceiling = secure($row['Product_ceiling']);
		if($qty > $ceiling){
			array_push($errors, "You are adding too much stock. Ceiling is reached!");
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


			$stmt = $conn->prepare("INSERT INTO `tblstocks`(`ProductId`, `No_Of_Items`, `Product_supplier`, `SupplierPrice`, `DateAdded`, `Deleted`) VALUES (:pid, :qty, :sup, :supp, :dt, 'NO')");
			$stmt->bindParam(':pid', $pid);
			$stmt->bindParam(':qty', $qty);
			$stmt->bindParam(':sup', $sup);
			$stmt->bindParam(':supp', $supp);
			$stmt->bindParam(':dt', $time);

			$stmt->execute();
			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Success');
				$('#modalmsg').html('Stock successfully added!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
				$('#msgmodal').modal('show');
			});
			</script></tr>";



		}
		showStocks();


	}




	function deleteStock()
	{


		include '../config/config.php';
		$stockId = $_POST['id'];

	//check if there is stock outside 

		$stmt = $conn->prepare("SELECT * FROM `tblstockout` WHERE `StockId`=? AND `Deleted`='NO'");
		$stmt->bindParam(1, $stockId, PDO::PARAM_INT);
		$stmt->execute();
		$qrow = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!$qrow)
		{
    // prepare sql and bind parameters
			$stmt = $conn->prepare("UPDATE tblstocks set Deleted='YES' WHERE `StockId`=:id");
			$stmt->bindParam(':id', $stockId);
			$stmt->execute();

			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Success');
				$('#modalmsg').html('Stocks successfully removed!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
				$('#msgmodal').modal('show');
			});
			</script></tr>";

		}
		else
		{
			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Error');
				$('#modalmsg').html('There are still stocks outside! Please remove it first!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-primary pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
				$('#msgmodal').modal('show');
			});
			</script></tr>";

		}
		showStocks();

	}

	function showStockOutProduct()
	{
		include '../config/config.php';
		$id = $_POST['id'];

		$stmt = $conn->prepare("SELECT
			st.`StockId`,
			pr.Product_name,
			st.`No_Of_Items`,
			st.`SupplierPrice`,
			(st.`SupplierPrice` + (st.`SupplierPrice` * (pr.MarkupPercentage / 100))) as `SellingPrice`,
			st.`DateAdded`
			FROM
			`tblstocks` AS st
			INNER JOIN tblproducts AS pr
			ON
			pr.id = st.`ProductId`
			WHERE st.`StockId`=:id
			");




		$stmt->bindParam(':id',$id);
		$stmt->execute(); 
		$row = $stmt->fetch();

		$soId = secure($row['StockId']);
		$soProductName = secure($row['Product_name']);
		$soQuantity = secure($row['No_Of_Items']);
		$soProductPrice = secure($row['SellingPrice']);

		echo json_encode(array(
			"soId" => $soId, 
			"soProductName" => $soProductName, 
			"soQuantity" => $soQuantity, 
			"soProductPrice" => number_format($soProductPrice, 2,".",",")));

	}	

	function stockOut()
	{
		include '../config/config.php';

		$errors = array();

		$id = $_POST['u_sid'];
		$stmt = $conn->prepare("SELECT
			st.`StockId`,
			st.`No_Of_Items`,
			st.`ProductId`,
			(st.`SupplierPrice` + (st.`SupplierPrice` * (pr.MarkupPercentage / 100))) as `SellingPrice`
			FROM
			`tblstocks` AS st
			INNER JOIN tblproducts AS pr
			ON
			pr.id = st.`ProductId`
			WHERE st.`StockId`=:id");
		$stmt->bindParam(':id',$id);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$soId = secure($row['StockId']);


		$quantityInDb = secure($row['No_Of_Items']);
		$selling = secure($row['SellingPrice']);







	//Check if the Quantity in database is greater than how much you want to stock out
		$quantity = secure($_POST['u_quantity']);
		if($quantity > $quantityInDb){
			array_push($errors, "You are stocking out too much!");
		}

	//check mo sa stock out if meron ng naka labas na stock na merong product na ganun 
		$productId = secure($row['ProductId']);
		$stmt = $conn->prepare('SELECT so.`StockOutId`, so.`StockId`, st.ProductId FROM `tblstockout` as so INNER JOIN tblstocks as st ON st.StockId = so.`StockId` WHERE st.ProductId=? AND st.`StockId` <> ?');
		$stmt->bindParam(1, $productId, PDO::PARAM_INT);
		$stmt->bindParam(2, $soId, PDO::PARAM_INT);
		$stmt->execute();
		$prodCount = $stmt->rowCount();

		if($prodCount == 1){
			array_push($errors, "You can not stock out same product with different stock id.");
		}





	/*

	ALERT ALERT ALERT ==== NO VALIDATION
	if(strlen($_POST['u_fname']) == 0){
		array_push($errors, "First Name can not be blank!");
	}else{
		if(ContainsNumbers($_POST['u_fname'])){
			array_push($errors, "First Name contains number!");
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
		});</script></tr>";
	}
	else
	{

		$time = time();


		$stmt = $conn->prepare('SELECT * FROM tblstockout WHERE StockId=?');
		$stmt->bindParam(1, $soId, PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(! $row)
		{
			//Nothing Found
			$stmt = $conn->prepare("INSERT INTO `tblstockout`(`StockId`, `Quantity_out`, `DateAdded`) VALUES (:sid, :quan, :dt)");
			$stmt->bindParam(':sid', $soId);
			$stmt->bindParam(':quan', $quantity);
			$stmt->bindParam(':dt', $time);
			$stmt->execute();

		}
		else
		{
			//Found
			$stmt = $conn->prepare("UPDATE `tblstockout` SET `Quantity_out`= `Quantity_out` + :add WHERE `StockId`=:sid");
			$stmt->bindParam(':sid', $soId);
			$stmt->bindParam(':add', $quantity, PDO::PARAM_INT);
			$stmt->execute();
		}


		//Diminish quantity in tblstocks with quantity of stocks removed
		$stmt = $conn->prepare("UPDATE `tblstocks` SET `No_Of_Items`= `No_Of_Items` - :dim WHERE `StockId`=:sid");
		$stmt->bindParam(':sid', $soId);
		$stmt->bindParam(':dim', $quantity, PDO::PARAM_INT);
		$stmt->execute();


		//Insert to inventory logs
		$stmt = $conn->prepare("INSERT INTO `tblinventorylogs`( `stockid`, `quantity`, `action`, `remarks`, `userid`, `LogDate`) VALUES (:sid, :dim, 'Stock Out', 'Product Stock Out', :uid, :logdate)");
		$stmt->bindParam(':sid', $soId);
		$stmt->bindParam(':dim', $quantity, PDO::PARAM_INT);
		$stmt->bindParam(':uid', $_SESSION['acc_id']);
		$stmt->bindParam(':logdate', $time);
		$stmt->execute();

		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Stock successfully stock out!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});
		</script></tr>";




	//Algorithm
	/*
	stock id does not exist in tbl stock out
	add it on tbl stock out

	else if

	Stock id exist
	Update stock out quantity with stock id of x

	*/

}
showStocks();
}



function loadSuppliers(){
	include '../config/config.php';

	$bcks = $conn->query("SELECT * FROM `tblsuppliers` WHERE `Deleted`='NO'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['Supplier_id']."'>".$r['Supplier_name']."</option>";
	}
}

function loadProducts(){
	include '../config/config.php';

	$bcks = $conn->query("SELECT * FROM `tblproducts` WHERE `Deleted`='NO'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['id']."'>".$r['Product_name']."</option>";
	}
}








//===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///////////////////////////////////////////===========================///


function showStockOut()
{
	include '../config/config.php';

	$stocks = $conn->query("SELECT
		so.`StockOutId`,
		so.`StockId`,
		pr.Product_name,
		sp.Supplier_name,
		(st.`SupplierPrice` + (st.`SupplierPrice` * (pr.MarkupPercentage / 100))) as `SellingPrice`,
		so.`Quantity_out`
		FROM
		`tblstockout` as so
		INNER JOIN tblstocks as st 
		ON st.StockId = so.`StockId`
		INNER JOIN tblproducts as pr
		ON pr.id = st.ProductId
		INNER JOIN tblsuppliers as sp 
		ON sp.Supplier_id = st.Product_supplier
		ORDER BY so.`StockOutId` DESC");

	while($r = $stocks->fetch()){
		echo "<tr>";
		echo "<td>".$r['StockOutId']."</td>";
		echo "<td>".$r['StockId']."</td>";
		echo "<td>".$r['Product_name']."</td>";
		echo "<td>".$r['Supplier_name']."</td>";
		echo "<td>₱ ".number_format($r['SellingPrice'], 2, '.', ',')."</td>";
		echo "<td>".$r['Quantity_out']."</td>";

		echo "<td>
		<a class='btn btn-sm btn-info' onclick='stockIn(".$r['StockOutId'].")'> <span class='glyphicon glyphicon-pencil'></span> Stock In</a>
		</td>";
		echo "</tr>";
	}
}





function showStockInProduct()
{
	include '../config/config.php';
	$id = $_POST['id'];

	$stmt = $conn->prepare("SELECT
		so.`StockId`, 
		so.`Quantity_out`, 
		pr.Product_name
		FROM
		`tblstockout` AS so
		INNER JOIN tblstocks as st 
		on st.StockId = so.`StockId`
		INNER JOIN tblproducts as pr 
		on pr.id = st.ProductId
		WHERE so.`StockOutId`=:id");


	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$siId = secure($row['StockId']);
	$siProductName = secure($row['Product_name']);
	$siQuantity = secure($row['Quantity_out']);



	echo json_encode(array(
		"siId" => $siId, 
		"siProductName" => $siProductName, 
		"siQuantity" => $siQuantity));

}	
function stockIn(){

	include '../config/config.php';


	$errors = array();

	$id = $_POST['u_sid'];




	$stmt = $conn->prepare("SELECT
		so.`StockId`, 
		so.`Quantity_out`, 
		pr.Product_name
		FROM
		`tblstockout` AS so
		INNER JOIN tblstocks as st 
		on st.StockId = so.`StockId`
		INNER JOIN tblproducts as pr 
		on pr.id = st.ProductId
		WHERE so.`StockOutId`=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();


	$StockId = secure($row['StockId']);
	$QuantityInDb = secure($row['Quantity_out']);



	$quantity = secure($_POST['u_quantity']);

	if($quantity > $QuantityInDb){
		array_push($errors, "You are stocking in too much!");
	}





	/*

	
	Validations 
	1. quantity is greater than that on stock out 


	--> Get Stockout count
	--> Get Stock Id


	*/



	/*

	ALERT ALERT ALERT ==== NO VALIDATION
	if(strlen($_POST['u_fname']) == 0){
		array_push($errors, "First Name can not be blank!");
	}else{
		if(ContainsNumbers($_POST['u_fname'])){
			array_push($errors, "First Name contains number!");
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
		});</script></tr>";
	}
	else
	{

		$time = time();





		/*
			if(quantity == quantity in db ,)
				Update table stocks, *Delete
				add quantity where stock id = -->1
			else if(Quantity is less than){
				
				Diminish stocks in stock out ->>stockout
				Update table stocks, add quantity here stock id = -->1
			}


			//Diminish quantity in tblstocks with quantity of stocks removed
			$stmt = $conn->prepare("UPDATE `tblstocks` SET `No_Of_Items`= `No_Of_Items` - :dim WHERE `StockId`=:sid");
			$stmt->bindParam(':sid', $soId);
			$stmt->bindParam(':dim', $quantity, PDO::PARAM_INT);
			$stmt->execute();



	

$StockId


		*/


if($quantity == $QuantityInDb){
	$stmt = $conn->prepare("DELETE FROM `tblstockout` WHERE `StockOutId`=:id; 
		UPDATE `tblstocks` SET `No_Of_Items`=`No_Of_Items` + :toAdd WHERE `StockId`=:sid");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':sid', $StockId);
	$stmt->bindParam(':toAdd', $quantity, PDO::PARAM_INT);
	$stmt->execute();
}else if($quantity < $QuantityInDb){

	$stmt = $conn->prepare("UPDATE `tblstockout` SET `Quantity_out`=`Quantity_out` - :toIn WHERE `StockOutId`=:id; 
		UPDATE `tblstocks` SET `No_Of_Items`=`No_Of_Items` + :toAdd WHERE `StockId`=:sid");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':sid', $StockId);
	$stmt->bindParam(':toIn', $quantity, PDO::PARAM_INT);
	$stmt->bindParam(':toAdd', $quantity, PDO::PARAM_INT);
	$stmt->execute();
}


echo "<tr><script type='text/javascript'>
$(document).ready(function(){
	$('#msgtitle').text('Success');
	$('#modalmsg').html('Stock successfully stock in!');
	$('#msgmodalbtn').text('Close');
	$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
	$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
	$('#msgmodal').modal('show');
});
</script></tr>";


}


showStockOut();
}



?>