<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';


		$searchResult = $conn->prepare("SELECT pr.`id`, pr.`Product_name`, pr.`Product_brand`, pr.`Product_flooring`, pr.`Product_ceiling`, pr.`Product_code`, u.`UnitName`, ct.`CategoryName`, pr.`Product_Description` , pr.`MarkupPercentage`
		FROM `tblproducts` AS pr 
		INNER JOIN tblunits AS u ON u.UnitId = pr.`Product_unit` 
		INNER JOIN tblcategories AS ct ON ct.`CategoryId` = pr.`Product_category` 
		WHERE pr.`Deleted` = 'NO' AND (pr.`Product_code` LIKE :kw) OR (pr.`Product_name` LIKE :kw)
		");
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
				echo "<td>".$r['Product_code']."</td>";
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

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>