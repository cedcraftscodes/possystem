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
		
		
		case 'showOverViewStatus':
		showOverViewStatus();
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
		tblstocks.ProductId = pr.id
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
		tblstocks.ProductId = pr.id
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
		INNER JOIN tblcategories as cat 
		on cat.CategoryId = pr.Product_category
		WHERE
		st.Deleted = 'NO'
		GROUP BY
		st.ProductId,
		sup.Supplier_id
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
			echo "<tr class='danger'>";
		} else if ($r['Status'] == 'Overstocking') {
			echo "<tr class='warning'>";
		} else {
			echo "<tr class='success'>";
		}
		
		
		
		echo "<td >" . $r['Product_code'] . "</td>";
		echo "<td>" . $r['Product_name'] . "</td>";
		echo "<td>" . $r['CategoryName'] . "</td>";
		echo "<td>" . $r['Supplier_name'] . "</td>";
		echo "<td>" . $r['Product_flooring'] . "</td>";
		echo "<td>" . $r['Product_ceiling'] . "</td>";
		echo "<td>" . $r['TotalStock'] . " " . $r['UnitName'] . "</td>";
		echo "<td>" . $r['Needed'] . "</td>";
		echo "<td>" . $r['Status'] . "</td>";
		echo "</tr>";
	}
}



function showOverviewStatus()
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
		tblstocks.ProductId = pr.id
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
		tblstocks.ProductId = pr.id
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
		INNER JOIN tblcategories as cat 
		on cat.CategoryId = pr.Product_category
		WHERE
		st.Deleted = 'NO'
		GROUP BY
		st.ProductId,
		sup.Supplier_id
		) AS ProductOverView
		ORDER BY CASE WHEN
		STATUS
		= 'Critical' THEN 1 WHEN
		STATUS
		= 'Overstocking' THEN 2 WHEN
		STATUS
		= 'Normal' THEN 3 ELSE 4
		END ASC");
	
	
	$productCount     = 0;
	$critical         = 0;
	$overStockProduct = 0;
	
	
	$totalPrice = 0;
	
	$qtyOnStockIn    = 0;
	$qtyOnStockOut   = 0;
	$totalQtyOfStock = 0;
	
	while ($r = $prod->fetch()) {
		if ($r['Status'] == 'Critical') {
			$critical++;
		} else if ($r['Status'] == 'Overstocking') {
			$overStockProduct++;
		}
		
		$productCount++;
	}
	
	
	
	
	
	
	$stmt = $conn->prepare("SELECT SUM(`No_Of_Items`) as 'QtyIn' FROM `tblstocks`");
	$stmt->execute();
	$row          = $stmt->fetch();
	$qtyOnStockIn = $row['QtyIn'];
	
	$stmt = $conn->prepare("SELECT SUM(`Quantity_out`) as 'QtyOut' FROM `tblstockout`");
	$stmt->execute();
	$row           = $stmt->fetch();
	$qtyOnStockOut = $row['QtyOut'];
	
	
	$totalQtyOfStock = $qtyOnStockIn + $qtyOnStockOut;
	
	
	$clp  = ($productCount != 0 ? ($critical / $productCount * 100) : 0);
	$qtyp = ($productCount != 0 ? ($qtyOnStockIn / $totalQtyOfStock * 100) : 0);
	$osp  = ($productCount != 0 ? ($overStockProduct / $productCount * 100) : 0);
	$qop  = ($productCount != 0 ? ($qtyOnStockOut / $totalQtyOfStock * 100) : 0);
	
	echo json_encode(array(
		"NoOfProduct" => (int) $productCount,
		"OverStocked" => (int) $overStockProduct,
		"OverStockedPercent" => $osp,
		"CriticalLevel" => (int) $critical,
		"CriticalLevelPercent" => $clp,
		"QtyIn" => (int) $qtyOnStockIn,
		"QtyInPercent" => $qtyp,
		"QtyOut" => (int) $qtyOnStockOut,
		"QtyOutPercent" => $qop
	));
}









?>