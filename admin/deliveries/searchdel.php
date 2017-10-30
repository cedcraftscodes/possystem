<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';

		$searchResult = $conn->prepare("SELECT 
							d.`Pod_id`,
							sup.Supplier_name,
							CONCAT(us.fname, ' ', us.lname) as 'Receiver',
							po.Po_number,
							d.`DateDelivered`
							FROM `tblpodeliveries` as d
							INNER JOIN tblpurchaseorders as po 
							ON po.Po_id = d.`Po_id`
							INNER JOIN tblsuppliers as sup 
							ON po.Supplier_id = sup.Supplier_id
							INNER JOIN tblusers as us 
							on us.userid = d.`ReceivedBy_id`
							WHERE (po.`Po_number` LIKE :kw) OR (sup.`Supplier_name` LIKE :kw)");

		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
				echo "<td>".$r['Pod_id']."</td>";
				echo "<td>".$r['Supplier_name']."</td>";
				echo "<td>".$r['Receiver']."</td>";
				echo "<td>".$r['Po_number']."</td>";

				$DateDelivered = date("F j, Y", $r["DateDelivered"]);
				echo "<td>".$DateDelivered."</td>";

				echo "<td><a class='btn btn-sm btn-info' onclick='viewDelivery(".$r['Pod_id'].")'> <span class='glyphicon glyphicon-pencil'></span> View</a>";
				echo "</tr>";
			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>