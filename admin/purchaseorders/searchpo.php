<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';


		$searchResult = $conn->prepare("SELECT 
			po.Po_id, 
			po.`Po_number`, 
			sp.Supplier_name,
			(SELECT CONCAT(us.fname, ' ', us.lname)  FROM tblusers as us  WHERE userid=po.`PreparedBy_id`) as 'Prepared',
			(SELECT CONCAT(us.fname, ' ', us.lname)  FROM tblusers as us  WHERE userid=po.`Checked_By`) as 'Checked',
			po.Exp_DeliveryDate,
			po.Status,
			po.DatePrepared
			FROM tblpurchaseorders as po
			INNER JOIN tblsuppliers as sp 
			ON sp.Supplier_id = po.Supplier_id
			WHERE (`Po_number` LIKE :kw) OR (`Supplier_name` LIKE :kw) AND po.`deleted`='NO'");

		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
				echo "<td>".$r['Po_number']."</td>";
				echo "<td>".$r['Supplier_name']."</td>";
				echo "<td>".$r['Prepared']."</td>";
				echo "<td>".$r['Checked']."</td>";

		//echo "<td>".$r['Exp_DeliveryDate']."</td>";
				$Exp_DeliveryDate = date("F j, Y", strtotime($r["Exp_DeliveryDate"]));
				echo "<td>".$Exp_DeliveryDate."</td>";
				
				$DatePrepared = date("F j, Y", $r["DatePrepared"]);
				echo "<td>".$DatePrepared."</td>";

				echo "<td>".$r['Status']."</td>";
				if($r['Status'] == "Pending"){
					echo "<td><a class='btn btn-sm btn-info' href='deliverproducts.php?poid=".$r['Po_id']."'> <span class='glyphicon glyphicon-pencil'></span> Deliver</a><a class='btn btn-sm btn-info' onclick='printslip(".$r['Po_id'].")''> <span class='fa fa-print'></span> Print Slip</a>";
				}
				else
				{
					echo "<td><a class='btn btn-sm btn-info' disabled='true'> <span class='glyphicon glyphicon-pencil'></span> Deliver</a><a class='btn btn-sm btn-info' onclick='printslip(".$r['Po_id'].")'> <span class='fa fa-print'></span> Print Slip</a>";
				}
				echo "</tr>";
			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>