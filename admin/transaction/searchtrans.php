<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';
		$searchResult = $conn->prepare("SELECT
			`TransId`,
			`TransNo`,
			`TransDate`,
			`No_Of_Items`,
			cs.CustomerName
			FROM
			`tbltransaction` as tr 
			INNER JOIN tblcustomer AS cs
			ON
			cs.CustomerId = tr.`CustId`
			WHERE `TransNo` LIKE :kw");
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
			echo "<td>".$r['TransNo']."</td>";
			echo "<td>".$r['CustomerName']."</td>";
			$dateadded = date("F j, Y, g:i a", $r["TransDate"]);
			echo "<td>".$dateadded."</td>";
			echo "<td>".$r['No_Of_Items']."</td>";
			echo "<td><a class='btn btn-sm btn-info' onclick='printReceipt(".$r['TransId'].")'> <span class='glyphicon glyphicon-pencil'></span> Print</a> </td>";
			echo "</tr>";
			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>