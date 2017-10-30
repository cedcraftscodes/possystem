<?php
if(isset($_GET["query"]))
{

	$keyword = htmlspecialchars($_GET["query"], ENT_QUOTES, 'UTF-8');

	if(strlen($keyword) < 3){
		echo "<p> Minimum of 3 characters required!</p>";
	}else{
		include '../config/config.php';

		$searchResult = $conn->prepare("SELECT * FROM tblusers WHERE (`fname` LIKE :kw) OR (`mname` LIKE :kw) OR (`lname` LIKE :kw) AND `deleted`='NO'");
		$searchResult->bindValue(":kw", '%'.$keyword.'%') ;
		$searchResult->execute();
		$count=$searchResult->rowCount();

		if($count != 0){
			while($r = $searchResult->fetch()){
				echo "<tr>";
				echo "<td>".$r['userid']."</td>";
				echo "<td>".$r['fname']." ".$r['mname']." ".$r['lname']."</td>";

				echo "<td>".$r['email']."</td>";
				echo "<td>".$r['gender']."</td>";
				echo "<td>".$r['birthday']."</td>";
				$dateadded = date("F j, Y, g:i a", $r["dateadded"]);
				echo "<td>".$dateadded."</td>";
				echo '<td><a class="btn btn-sm btn-info" onclick="updateAdmin('.$r['userid'].')"> <span class="glyphicon glyphicon-pencil"></span> Edit</a> | <a class="btn btn-sm btn-danger" onclick="deleteAdmin('.$r['userid'].')"><span class=
				"glyphicon glyphicon-trash"></span> Delete</a></td>';
				echo "</tr>";
			}

		}else{
			echo "<p>No results found! </p>";
		}

	}

}


?>