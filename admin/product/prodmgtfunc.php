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


		case 'loadProducts':
		loadProducts();
		break;


		case 'addProduct':
		addProduct();
		break;

		case 'addStockProduct':
		addStockProduct();
		break;

		case 'deleteProduct':
		deleteProduct();
		break;


		case 'showUpdateProduct':
		showUpdateProduct();
		break;

		case 'updateProduct':
		updateProduct();
		break;

		case 'showUnitAutoComplete':
		showUnitAutoComplete();
		break;


		case 'showCategoryAutoComplete':
		showCategoryAutoComplete();
		break;

		case 'showExistingProduct':
		showExistingProduct();
		break;


		case 'showExistingSupplier':
		showExistingSupplier();
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



function showUnitAutoComplete()
{
	include '../config/config.php';


	$stmt = $conn->prepare("SELECT  `UnitName` FROM `tblunits` ");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$units = $stmt->fetchAll(PDO::FETCH_COLUMN);

	echo json_encode($units);

}	


function showCategoryAutoComplete()
{
	include '../config/config.php';
	$stmt = $conn->prepare("SELECT `CategoryName` FROM tblcategories");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$units = $stmt->fetchAll(PDO::FETCH_COLUMN);
	echo json_encode($units);
}	







function loadSuppliers(){
	include '../config/config.php';

	$bcks = $conn->query("SELECT * FROM `tblsuppliers` WHERE `Deleted`='NO'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['Supplier_id']."'>".$r['Supplier_name']."</option>";
	}
}



function loadUnit(){
	include '../config/config.php';

	$bcks = $conn->query("SELECT * FROM `tblunits` WHERE `Deleted`='NO'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['UnitId']."'>".$r['UnitName']."</option>";
	}
}


function loadCategories(){
	include '../config/config.php';

	$bcks = $conn->query("SELECT * FROM `tblcategories` WHERE `Deleted`='NO'");
	while($r = $bcks->fetch()){
		echo "<option value='".$r['CategoryId']."'>".$r['CategoryName']."</option>";
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

function loadProducts()
{
	require '..\barcodegen/BarcodeBase.php';
	require '..\barcodegen/Code39.php';
	$bcode = array();
	$bcode['c39']	= array('name' => 'Code39', 'obj' => new emberlabs\Barcode\Code39());
	function bcode_error($m)
	{
		echo "<div class='error'>{$m}</div>";
	}


	include '../config/config.php';

	$prod = $conn->query("SELECT pr.`id`, pr.`Product_name`, pr.`Product_brand`, pr.`Product_flooring`, pr.`Product_ceiling`, pr.`Product_code`, u.`UnitName`, ct.`CategoryName`, pr.`Product_Description`, pr.`MarkupPercentage` 
		FROM `tblproducts` AS pr 
		INNER JOIN tblunits AS u ON u.UnitId = pr.`Product_unit` 
		INNER JOIN tblcategories AS ct ON ct.`CategoryId` = pr.`Product_category` 
		WHERE pr.`Deleted` = 'NO' ORDER BY pr.`id` DESC");

	while($r = $prod->fetch()){
		echo "<tr>";


		echo "<td>";
		foreach($bcode as $k => $value)
		{
			try
			{
				$bcode[$k]['obj']->setData($r['Product_code']);
				$bcode[$k]['obj']->setDimensions(250, 75);
				$bcode[$k]['obj']->draw();
				$b64 = $bcode[$k]['obj']->base64();

				echo "<figure><img src='data:image/png;base64,$b64' /><figcaption class='caption'> ".$r['Product_code']." </figcaption>";
			}
			catch (Exception $e)
			{
				bcode_error($e->getMessage());
			}
		}
		echo "</td>";
		echo "<td>".$r['Product_name']."</td>";
		echo "<td>".$r['Product_brand']."</td>";
		echo "<td>".$r['Product_Description']."</td>";
		echo "<td>".$r['Product_flooring']."</td>";
		echo "<td>".$r['Product_ceiling']."</td>";
		echo "<td>".$r['UnitName']."</td>";
		echo "<td>".$r['MarkupPercentage']."</td>";
		echo '<td><a class="btn btn-sm btn-info" onclick="updateProduct('.$r['id'].')"> <span class="glyphicon glyphicon-pencil"></span> Edit</a> | <a class="btn btn-sm btn-danger" onclick="deleteProduct('.$r['id'].')"><span class=
		"glyphicon glyphicon-trash"></span> Delete</a></td>';
		echo "</tr>";
	}
}



function showUpdateProduct()
{
	include '../config/config.php';
	$id = $_POST['id'];
	$stmt = $conn->prepare("SELECT pr.`id`, pr.`Product_name`, pr.`Product_brand`, pr.`Product_flooring`, pr.`Product_ceiling`, 
		pr.`Product_code`,pr.`Product_unit` , pr.`Product_category`,  pr.`Product_Description`, pr.`MarkupPercentage` FROM `tblproducts` AS pr   WHERE pr.`Deleted` = 'NO' AND pr.`id`=:id");

	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$code = secure($row['Product_code']);
	$pname = secure($row['Product_name']);
	$pbrand = secure($row['Product_brand']);
	$desc = secure($row['Product_Description']);
	$flooring = secure($row['Product_flooring']);
	$ceiling = secure($row['Product_ceiling']);
	$unitname = secure($row['Product_unit']);
	$cat = secure($row['Product_category']);
	$markup = secure($row['MarkupPercentage']);


	echo json_encode(array(
		"pcode" => $code, 
		"pname" => $pname, 
		"pbrand" => $pbrand,
		"desc" => $desc, 
		"flooring" => $flooring,
		"ceiling" => $ceiling, 
		"unitname" => $unitname , 
		"cat" => $cat, 
		"markup" => $markup));

}	



function showExistingProduct()
{
	include '../config/config.php';
	$product_name = $_POST['pname'];
	$stmt = $conn->prepare("SELECT pr.`id`, pr.`Product_name`, pr.`Product_brand`, pr.`Product_flooring`, pr.`Product_ceiling`, 
		pr.`Product_code`,u.`UnitName` , cat.`CategoryName`,  pr.`Product_Description`, pr.`MarkupPercentage` FROM `tblproducts` AS pr INNER JOIN tblcategories as cat ON cat.`CategoryId` = pr.`Product_category` INNER JOIN tblunits as u on u.`UnitId` = pr.`Product_unit` WHERE pr.`Deleted` = 'NO' AND pr.`Product_name`=:pname");

	$stmt->bindParam(':pname',$product_name);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$code = secure($row['Product_code']);
	$pname = secure($row['Product_name']);
	$pbrand = secure($row['Product_brand']);
	$desc = secure($row['Product_Description']);
	$flooring = secure($row['Product_flooring']);
	$ceiling = secure($row['Product_ceiling']);
	$unitname = secure($row['UnitName']);
	$cat = secure($row['CategoryName']);
	$markup = secure($row['MarkupPercentage']);


	echo json_encode(array(
		"pcode" => $code, 
		"pname" => $pname, 
		"pbrand" => $pbrand,
		"desc" => $desc, 
		"flooring" => $flooring,
		"ceiling" => $ceiling, 
		"unitname" => $unitname , 
		"cat" => $cat, 
		"markup" => $markup));

}	


function showExistingSupplier()
{
	include '../config/config.php';
	$supplier_name = $_POST['sname'];

	$stmt = $conn->prepare("SELECT * FROM `tblsuppliers` WHERE `Supplier_name`=:sname");
	$stmt->bindParam(':sname',$supplier_name);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$sid = secure($row['Supplier_id']);
	$sname = secure($row['Supplier_name']);
	$sconame = secure($row['Supplier_co_name']);
	$st = secure($row['Supplier_street']);
	$ct = secure($row['Supplier_city']);
	$pv = secure($row['Supplier_province']);
	$zc = secure($row['Supplier_zipcode']);
	$cont = secure($row['Supplier_contact']);
	$email = secure($row['Supplier_email']);



	echo json_encode(array(
		"id" => $sid, 
		"sname" => $sname, 
		"rname" => $sconame,
		"street" => $st, 
		"city" => $ct, 
		"province" => $pv,
		"zipcode" => $zc, 
		"contact" => $cont, 
		"email" => $email));
}	



function addStockProduct()
{
	include '../config/config.php';


	//Products
	$pname = secure($_POST['us_pname']);
	$brand = secure($_POST['us_brand']);
	$desc = secure($_POST['us_desc']);
	$flooring = secure($_POST['us_flooring']);
	$ceiling = secure($_POST['us_ceiling']);
	$pcode = secure($_POST['us_pcode']);
	$markup = secure($_POST['us_markuppercent']);

	//Supplier
	if(!isset($_POST['chkuseold'])){
		$sname = secure($_POST['us_sname']);
		$sconame = secure($_POST['us_rname']);
		$st = secure($_POST['us_street']);
		$ct = secure($_POST['us_city']);
		$pv = secure($_POST['us_province']);
		$zc = secure($_POST['us_zipcode']);
		$cont = secure($_POST['us_contactnumber']);
		$email = secure($_POST['us_email']);

	}

	//Unit and category
	$unit = secure($_POST['us_unit']);
	$category = secure($_POST['us_category']);

	//Supplier price and Quantity
	$supplier_price = secure($_POST['us_supplierprice']);
	$quantity = secure($_POST['us_stockqty']);

	$time = time();

	$errors = array();



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
		$unitId = 0 ;
		$stmt = $conn->prepare("SELECT `UnitId` FROM `tblunits` WHERE `UnitName`=:cate and `Deleted`='NO' LIMIT 1");
		$stmt->bindParam(':cate',$unit);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if($count >= 1){
			$unitId = $row['UnitId'];
		}
		else
		{
			$stmt = $conn->prepare("INSERT INTO `tblunits`(`UnitName`, `Deleted`) VALUES (:uname, 'NO')");
			$stmt->bindParam(':uname', $unit);
			$stmt->execute();
			$unitId = $conn->lastInsertId();
		}



		$catId = 0 ;
		$stmt = $conn->prepare("SELECT `CategoryId`, `CategoryName`, `Deleted` FROM `tblcategories` WHERE `CategoryName`=:cate AND `Deleted`='NO'");
		$stmt->bindParam(':cate',$category);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if($count >= 1){
			$catId = $row['CategoryId'];
		}
		else
		{
			$stmt = $conn->prepare("INSERT INTO `tblcategories`( `CategoryName`, `Deleted`) VALUES (:cat, 'NO')");
			$stmt->bindParam(':cat', $category);
			$stmt->execute();
			$catId = $conn->lastInsertId();
		}


		$prodId = 0 ;
		$stmt = $conn->prepare("SELECT `id` FROM `tblproducts` WHERE `Product_name`=:pname LIMIT 1");
		$stmt->bindParam(':pname',$pname);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if($count >= 1){
			$prodId = $row['id'];


			$stmt = $conn->prepare("SELECT * from tblproducts where `Product_code`=:bcode AND `Deleted`='NO' AND `id` <> :id");
			$stmt->bindParam(':bcode',$pcode);
			$stmt->bindParam(':id',$prodId);			
			$stmt->execute(); 
			$row = $stmt->fetch();
			$count = $stmt->rowCount();

			if($count >= 1){
				echo "<tr><script type='text/javascript'>
				$(document).ready(function(){
					$('#msgtitle').text('Error');
					$('#modalmsg').html('Product Code already exist!');
					$('#msgmodalbtn').text('Close');
					$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
					$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
					$('#msgmodal').modal('show');
				});
				</script></tr>";
				loadProducts();
				return;
			}





			$stmt = $conn->prepare("UPDATE `tblproducts` SET `Product_name`=:name,`Product_brand`=:brand,`Product_flooring`=:floor,`Product_ceiling`=:ceil,`Product_unit`=:unit,`Product_code`=:code, `Product_category`=:cat,`Product_Description`=:desc, `MarkupPercentage`=:mk WHERE `id`=:id");

			$stmt->bindParam(':name', $pname);
			$stmt->bindParam(':brand', $brand);
			$stmt->bindParam(':floor', $flooring);
			$stmt->bindParam(':ceil', $ceiling);
			$stmt->bindParam(':unit', $unitId);
			$stmt->bindParam(':code', $pcode);
			$stmt->bindParam(':cat', $catId);
			$stmt->bindParam(':desc', $desc);
			$stmt->bindParam(':id', $prodId);
			$stmt->bindParam(':mk', $markup);
			$stmt->execute();

		}
		else
		{
			$stmt = $conn->prepare("INSERT INTO `tblproducts`(`Product_name`, `Product_brand`, `Product_flooring`, `Product_ceiling`, `Product_unit`, `Product_code`, `Product_category`, `Product_Description`, `created_at`, `MarkupPercentage`, `Deleted`) VALUES (:pname, :brand, :floor, :ceil,  :unit, :pcode, :cat,   :des , :dat, :mark,'NO')");
			$stmt->bindParam(':pname', $pname);
			$stmt->bindParam(':brand', $brand);
			$stmt->bindParam(':floor', $flooring);
			$stmt->bindParam(':ceil', $ceiling);
			$stmt->bindParam(':pcode', $pcode);
			$stmt->bindParam(':unit', $unitId);
			$stmt->bindParam(':cat', $catId);
			$stmt->bindParam(':des', $desc);
			$stmt->bindParam(':dat', $time);
			$stmt->bindParam(':mark', $markup);
			$stmt->execute();
			$prodId = $conn->lastInsertId();
		}



	//Get combobox
		$supId = 0 ;
		if(isset($_POST['chkuseold'])){	
			$supplierId = secure($_POST['us_suppliername']);
			$supId  = $supplierId;
		}else{

			$stmt = $conn->prepare("SELECT `Supplier_id` FROM `tblsuppliers` WHERE `Supplier_name`=:sname LIMIT 1");
			$stmt->bindParam(':sname',$sname);
			$stmt->execute(); 
			$row = $stmt->fetch();
			$count = $stmt->rowCount();

			if($count >= 1){
				$supId = $row['Supplier_id'];
			}
			else
			{
				$stmt = $conn->prepare("INSERT INTO `tblsuppliers`(`Supplier_name`, `Supplier_co_name`, `Supplier_street`, `Supplier_city`, `Supplier_province`, `Supplier_zipcode`, `Supplier_contact`, `Supplier_email`, `AddedBy`, `DateAdded`, `Deleted`) VALUES
					(:sname, :coname, :st, :ct, :pv, :zc, :cont, :email, :Add, :dat , 'NO')");

				$stmt->bindParam(':sname', $sname);
				$stmt->bindParam(':coname', $sconame);
				$stmt->bindParam(':st', $st);
				$stmt->bindParam(':ct', $ct);
				$stmt->bindParam(':pv', $pv);
				$stmt->bindParam(':zc', $zc);
				$stmt->bindParam(':cont', $cont);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':Add', $_SESSION['acc_id']);
				$stmt->bindParam(':dat', $time);
				$stmt->execute();

				$supId = $conn->lastInsertId();
			}

		}



		//get the quantity of the product



		$stmt = $conn->prepare("SELECT
								    *
								FROM
								    (
								    SELECT
								        pr.id,
								        pr.Product_ceiling,
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
								            tblstocks.ProductId = pr.id
								        GROUP BY
								            pr.id
								    ) AS TotalStock
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
								INNER JOIN tblcategories AS cat
								ON
								    cat.CategoryId = pr.Product_category
								WHERE
								    st.Deleted = 'NO'
								GROUP BY
								    st.ProductId,
								    sup.Supplier_id
								) AS ProductOverView
								WHERE id = :id");
		$stmt->bindParam(':id',$prodId);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$totalstock = (int)secure($row['TotalStock']);

		$stmt = $conn->prepare("SELECT Product_ceiling FROM tblproducts WHERE id=:id");
		$stmt->bindParam(':id',$prodId);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$ceil = (int)secure($row['Product_ceiling']);

		if(($totalstock + $quantity) > $ceil){
			echo "<tr><script type='text/javascript'>
				$(document).ready(function(){
					$('#msgtitle').text('Error');
					$('#modalmsg').html('Unable to add new stock, Ceiling is reached!".$ceil."');
					$('#msgmodalbtn').text('Close');
					$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
					$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
					$('#msgmodal').modal('show');
				});
				</script></tr>";
				loadProducts();
				return;
		}else{

		}




		$stmt = $conn->prepare("INSERT INTO `tblstocks`(`ProductId`, `No_Of_Items`, `Product_supplier`, `SupplierPrice`, `DateAdded`, `Deleted`) VALUES (:pid, :qty, :sup, :supp, :dt, 'NO')");
		$stmt->bindParam(':pid', $prodId);
		$stmt->bindParam(':qty', $quantity);
		$stmt->bindParam(':sup', $supId);
		$stmt->bindParam(':supp', $supplier_price);
		$stmt->bindParam(':dt', $time);

		$stmt->execute();

		/*

		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Product successfully to Stocks!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});
		</script></tr>";


		*/

		


	}
	loadProducts();


}




function addProduct()
{
	include '../config/config.php';

	$pname = secure($_POST['pname']);
	$brand = secure($_POST['brand']);
	$desc = secure($_POST['desc']);
	$flooring = secure($_POST['flooring']);
	$ceiling = secure($_POST['ceiling']);
	$cbounit = secure($_POST['cbounit']);
	$cbocategory = secure($_POST['cbocategory']);
	$pcode = secure($_POST['pcode']);
	$markup = secure($_POST['markuppercent']);
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



		if(strlen($_POST['pname']) == 0){
			array_push($errors, "Product name can not be blank!");
		}

		if(strlen($_POST['pcode']) == 0){
			array_push($errors, "Product code can not be blank!");
		}

		if($ceiling <= $flooring){
			array_push($errors, "Ceiling must be greater than the flooring!");
		}
		

		$stmt = $conn->prepare("SELECT * from tblproducts where `Product_code`=:bcode AND `Deleted`='NO'");
		$stmt->bindParam(':bcode',$pcode);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$count = $stmt->rowCount();


		if($count >= 1){
			array_push($errors, "Product with barcode inputted already exists!");
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


			$stmt = $conn->prepare("INSERT INTO `tblproducts`(`Product_name`, `Product_brand`, `Product_flooring`, `Product_ceiling`, `Product_unit`, `Product_code`, `Product_category`, `Product_Description`, `created_at`, `MarkupPercentage`, `Deleted`) VALUES (:pname, :brand, :floor, :ceil,  :unit, :pcode, :cat,   :des , :dat, :mark,'NO')");

			$stmt->bindParam(':pname', $pname);
			$stmt->bindParam(':brand', $brand);
			$stmt->bindParam(':floor', $flooring);
			$stmt->bindParam(':ceil', $ceiling);
			$stmt->bindParam(':pcode', $pcode);
			$stmt->bindParam(':unit', $cbounit);
			$stmt->bindParam(':cat', $cbocategory);
			$stmt->bindParam(':des', $desc);
			$stmt->bindParam(':dat', $time);
			$stmt->bindParam(':mark', $markup);
			$stmt->execute();

			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Success');
				$('#modalmsg').html('Product successfully added!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
				$('#msgmodal').modal('show');
			});
			</script></tr>";



		}
		loadProducts();


	}



	function updateProduct(){
		include '../config/config.php';

		$stmt = $conn->prepare("UPDATE `tblproducts` SET `Product_name`=:name,`Product_brand`=:brand,`Product_flooring`=:floor,`Product_ceiling`=:ceil,`Product_unit`=:unit,`Product_code`=:code, `Product_category`=:cat,`Product_Description`=:desc, `MarkupPercentage`=:mk WHERE `id`=:id");

		$id = secure($_POST['u_id']);
		$pname = secure($_POST['u_pname']);
		$brand = secure($_POST['u_brand']);
		$desc = secure($_POST['u_desc']);
		$floor = secure($_POST['u_flooring']);
		$ceil = secure($_POST['u_ceiling']);
		$unit = secure($_POST['u_cbounit']);
		$category = secure($_POST['u_cbocategory']);
		$code = secure($_POST['u_pcode']);
		$markup = secure($_POST['u_markuppercent']);

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
		$stmt->bindParam(':name', $pname);
		$stmt->bindParam(':brand', $brand);
		$stmt->bindParam(':floor', $floor);
		$stmt->bindParam(':ceil', $ceil);
		$stmt->bindParam(':unit', $unit);
		$stmt->bindParam(':code', $code);
		$stmt->bindParam(':cat', $category);
		$stmt->bindParam(':desc', $desc);
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':mk', $markup);
		$stmt->execute();

	}



	echo "<tr><script type='text/javascript'>
	$(document).ready(function(){
		$('#msgtitle').text('Success');
		$('#modalmsg').html('Product successfully updated!');
		$('#msgmodalbtn').text('Close');
		$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
		$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
		$('#msgmodal').modal('show');
	});
	</script></tr>";


	loadProducts();




}


?>