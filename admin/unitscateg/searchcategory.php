<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';

		$searchResult = $conn->prepare("SELECT * FROM tblcategories WHERE (`CategoryName` LIKE :kw) AND `Deleted`='NO'");
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
				echo "<td>".$r['CategoryId']."</td>";
				echo "<td>".$r['CategoryName']."</td>";

				echo '<td><a class="btn btn-sm btn-info" onclick="updateCategory('.$r['CategoryId'].')"> <span class="glyphicon glyphicon-pencil"></span> Edit</a> | <a class="btn btn-sm btn-danger" onclick="deleteCategory('.$r['CategoryId'].')"><span class=
				"glyphicon glyphicon-trash"></span> Delete</a></td>';
				echo "</tr>";
			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>