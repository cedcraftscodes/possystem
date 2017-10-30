<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include 'conn.php';


		$searchResult = $conn->prepare("SELECT * FROM items WHERE (`name` LIKE :kw) OR (`description` LIKE :kw)");
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
				echo "<td>".$r['ItemID']."</td>";
				echo "<td>".$r['name']."</td>";
				echo "<td>".$r['description']."</td>";
				echo "<td>".$r['brand']."</td>";
				echo "<td>".$r['price']."</td>";
				echo "<td>".$r['quantity']."</td>";
				$dateadded = date("F j, Y, g:i a", $r["dateadded"]);
				echo "<td>".$dateadded."</td>";
				echo '<td><a onclick="updateItem('.$r['ItemID'].')"> <span class="glyphicon glyphicon-pencil"></span></a>|<a onclick="deleteItem('.$r['ItemID'].')"><span class=
				"glyphicon glyphicon-trash"></span></a></td>';

				echo "</tr>";
			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>