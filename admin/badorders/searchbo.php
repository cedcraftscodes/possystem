<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';


		$searchResult = $conn->prepare("SELECT
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
										WHERE pr.`Deleted` = 'NO' AND `status`='Pending' OR (pr.`Product_name` LIKE :kw) OR (sup.`Supplier_name` LIKE :kw)");
		
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
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

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>