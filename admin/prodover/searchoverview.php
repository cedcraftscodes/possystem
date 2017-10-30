<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';


		$searchResult = $conn->prepare("SELECT
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
						    st.ProductId,
						    sup.Supplier_id
						) AS ProductOverView
						WHERE (`Product_code` LIKE :kw) OR (`Product_name` LIKE :kw)");
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				if($r['Status'] == 'Critical'){
					echo "<tr class='danger'>";
				}else if ($r['Status'] == 'Overstocking'){
					echo "<tr class='warning'>";
				}else{
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

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>