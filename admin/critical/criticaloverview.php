<?php


if (session_id()) {
} else {
	session_start();
}

if (isset($_POST['action']) && !empty($_POST['action'])) {

	$action = $_POST['action'];
	switch ($action) {

		case 'showOverView':
		showOverView();
		break;

		case 'loadSuppliers':
		loadSuppliers();
		break;


		case 'loadPoInfo':
		loadPoInfo();
		break;

		case 'preparePo':
		preparePo();
		break;


		default:
            # code...
		break;
	}
}

function secure($str)
{
	return strip_tags(trim(htmlspecialchars($str)));
}

function ContainsNumbers($String)
{
	return preg_match('/\\d/', $String) > 0;
}



function loadPoInfo(){
	include '../config/config.php';

	$pid = $_POST['id'];
	$stmt = $conn->prepare("SELECT
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
		cat.CategoryName,
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
		INNER JOIN tblcategories AS cat
		ON
		cat.CategoryId = pr.Product_category
		WHERE
		st.Deleted = 'NO' and id =:id
		GROUP BY
		st.ProductId
		) AS ProductOverView");
	$stmt->bindParam(':id', $pid, PDO::PARAM_INT);

	$stmt->execute();
	$row = $stmt->fetch();

	$product_name  = $row['Product_name'];
	$qtyonstock  = $row['TotalStock'];
	$max  = $row['Needed'];
	$removetocrit = (int)$row['Product_flooring'] - (int)$row['TotalStock'];
	$range = "Min: 0 - Max: ". $row['Needed'];

	$time = time();



/*
        $('#po_product_name').text(result.product_name);
        $('#po_ponumber').text(result.ponum);

        $('#po_quantity_on_stock').text(result.qtyonstock);
        $('#po_qtyrange').text(result.qtyrange);
        $('#po_removetocrit').text(result.removetocrit);
        $('#po_prepared').text(result.prepared);

*/


        /* Fetch the username of currently logged in user*/
        $stmt = $conn->prepare("SELECT
        	CONCAT(fname, ' ', mname, ' ', lname) as 'Prepared'
        	FROM
        	`tblusers`
        	WHERE
        	`userid`=:uid");
        $stmt->bindParam(':uid', $_SESSION['acc_id'], PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $prepared  = $row['Prepared'];

        echo json_encode(array(
        	"product_name" => $product_name,
        	"ponum" => $time, 
        	"qtyonstock" => $qtyonstock, 
        	"qtyrange" => $range, 
        	"removetocrit" => $removetocrit, 
        	"prepared" => $prepared,
        	"needed" => $max
        	));
    }



    function loadSuppliers(){
    	include '../config/config.php';

    	$pid = $_POST['pid'];

    	$bcks = $conn->prepare("SELECT DISTINCT(sup.Supplier_name) as 'Suppliers', sup.Supplier_id
    		FROM tblstocks as st 
    		INNER JOIN tblsuppliers as sup 
    		ON sup.Supplier_id = st.Product_supplier
    		WHERE st.ProductId = :id");

    	$bcks->bindParam(":id", $pid);
    	$bcks->execute();

    	while($r = $bcks->fetch()){
    		echo "<option value='".$r['Supplier_id']."'>".$r['Suppliers']."</option>";
    	}
    }





    function preparePo(){

    	$poNumber = $_POST['ponum'];
    	$deliverydate = $_POST['deldate'];
    	$supplierId = $_POST['cbosuppliers'];
    	$preparedBy = $_SESSION['acc_id'];
    	$checkedBy = $_POST['cboadmins'];
    	$checkedByPass = md5($_POST['password']);
    	$productid = $_POST['pid'];

    	$time = time();

    	$quantity = $_POST['po_quantityin'];


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


    		$stmt = $conn->prepare("INSERT INTO `tblpo_items`(`Po_id`, `ProductId`, `Quantity_Requested`) VALUES (:pd, :pr, :qr)");
    		$stmt->bindParam(':pd',$poid);
    		$stmt->bindParam(':pr',$productid);
    		$stmt->bindParam(':qr',$quantity);
    		$stmt->execute(); 

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


    function showOverView()
    {
    	include '../config/config.php';

    	$prod = $conn->query("SELECT
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
    		cat.CategoryName,
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
    		INNER JOIN tblcategories AS cat
    		ON
    		cat.CategoryId = pr.Product_category
    		WHERE
    		st.Deleted = 'NO'
    		GROUP BY
    		st.ProductId
    		) AS ProductOverView
    		ORDER BY CASE WHEN
    		STATUS
    		= 'Critical' THEN 1 WHEN
    		STATUS
    		= 'Overstocking' THEN 2 WHEN
    		STATUS
    		= 'Normal' THEN 3 ELSE 4
    		END ASC");


    	while ($r = $prod->fetch()) {
    		if ($r['Status'] == 'Critical') {
    			echo "<tr class='danger' onclick='preparePo(".$r['id'].")'>";
    			echo "<td >" . $r['Product_code'] . "</td>";
    			echo "<td>" . $r['Product_name'] . "</td>";
    			echo "<td>" . $r['CategoryName'] . "</td>";
    			echo "<td>" . $r['Product_flooring'] . "</td>";
    			echo "<td>" . $r['Product_ceiling'] . "</td>";
    			echo "<td>" . $r['TotalStock'] . " " . $r['UnitName'] . "</td>";
    			echo "<td>" . $r['Needed'] . "</td>";
    			echo "<td>" . $r['Status'] . "</td>";
    			echo "</tr>";
    		}
    	}
    }

    ?>