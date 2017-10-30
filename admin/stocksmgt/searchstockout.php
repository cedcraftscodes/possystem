<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';


		$searchResult = $conn->prepare("SELECT
		so.`StockOutId`,
		so.`StockId`,
		pr.Product_name,
		sp.Supplier_name,
		st.SellingPrice, 
		so.`Quantity_out`
		FROM
		`tblstockout` as so
		INNER JOIN tblstocks as st 
		ON st.StockId = so.`StockId`
		INNER JOIN tblproducts as pr
		ON pr.id = st.ProductId
		INNER JOIN tblsuppliers as sp 
		ON sp.Supplier_id = st.Product_supplier
		WHERE pr.`Deleted` = 'NO' AND  (pr.`Product_name` LIKE :kw)

		");
		$searchResult->bindValue(":kw", '%'.$keyword.'%');
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
		echo "<td>".$r['StockOutId']."</td>";
		echo "<td>".$r['StockId']."</td>";
		echo "<td>".$r['Product_name']."</td>";
		echo "<td>".$r['Supplier_name']."</td>";
		echo "<td>₱ ".number_format($r['SellingPrice'], 2, '.', '')."</td>";
		echo "<td>".$r['Quantity_out']."</td>";

		echo "<td>
		<a class='btn btn-sm btn-info' onclick='stockIn(".$r['StockOutId'].")'> <span class='glyphicon glyphicon-pencil'></span> Stock In</a>
	</td>";
	echo "</tr>";


			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>