<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';


		$searchResult = $conn->prepare("SELECT * FROM `tblsuppliers` WHERE (`Supplier_name` LIKE :kw) OR (`Supplier_co_name` LIKE :kw) AND `Deleted`='NO'");
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
				echo "<td>".$r['Supplier_id']."</td>";
				echo "<td>".$r['Supplier_name']."</td>";
				echo "<td>".$r['Supplier_co_name']."</td>";
				echo "<td>".$r['Supplier_street'].' '.$r['Supplier_city'].' '.$r['Supplier_Province'].' '.$r['Supplier_zipcode']."</td>";
				echo "<td>".$r['Supplier_contact']."</td>";
				echo "<td>".$r['Supplier_email']."</td>";
				$dateadded = date("F j, Y, g:i a", $r["DateAdded"]);
				echo "<td>".$dateadded."</td>";
				echo '<td><a class="btn btn-sm btn-info" onclick="updateAdmin('.$r['Supplier_id'].')"> <span class="glyphicon glyphicon-pencil"></span> Edit</a> | <a class="btn btn-sm btn-danger" onclick="deleteAdmin('.$r['Supplier_id'].')"><span class=
				"glyphicon glyphicon-trash"></span> Delete</a></td>';
				echo "</tr>";
			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>