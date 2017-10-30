<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';


		$searchResult = $conn->prepare("SELECT
										st.`StockId`,
										pr.Product_name,
										sp.Supplier_name,
										st.`No_Of_Items`,
										st.`SupplierPrice`,
										st.`SellingPrice`,
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
										AND (pr.`Product_name` LIKE :kw) OR (sp.`Supplier_name` LIKE :kw)");
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
					echo "<td>".$r['StockId']."</td>";
					echo "<td>".$r['Product_name']."</td>";
					echo "<td>".$r['Supplier_name']."</td>";

					echo "<td>".$r['SupplierPrice']."</td>";
					echo "<td>".$r['SellingPrice']."</td>";
					echo "<td>".$r['No_Of_Items']."</td>";
					$dateadded = date("F j, Y, g:i a", $r["DateAdded"]);
					echo "<td>".$dateadded."</td>";



					echo "<td>
					<a class='btn btn-sm btn-info' onclick='stockOut(".$r['StockId'].")'> <span class='glyphicon glyphicon-pencil'></span> Stock Out</a> | 
					<a class='btn btn-sm btn-primary' onclick='updateStocks(".$r['StockId'].")'><span class='glyphicon glyphicon-trash'></span> Edit</a>
					<a class='btn btn-sm btn-danger' onclick='removeStock(".$r['StockId'].")'><span class='glyphicon glyphicon-trash'></span> Remove</a>
				</td>";
				echo "</tr>";
			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>