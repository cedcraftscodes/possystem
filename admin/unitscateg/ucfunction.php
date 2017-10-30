<?php 


if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'addCategory':
		addCategory();
		break;
		case 'showCategories':
		showCategories();
		break;
		case 'deleteCategory':
		deleteCategory();
		break;
		case 'showUpdateCategory':
		showUpdateCategory();
		break;
		case 'updateCategory':
		updateCategory();
		break;


		//=============================================================

		case 'addUnit':
		addUnit();
		break;
		case 'showUnits':
		showUnits();
		break;
		case 'deleteUnit':
		deleteUnit();
		break;
		case 'showUpdateUnit':
		showUpdateUnit();
		break;
		case 'updateUnit':
		updateUnit();
		break;




		default:
				# code...
		break;
	}
}


function secure($str){
	return strip_tags(trim(htmlspecialchars($str)));
}


function ContainsNumbers($String){
	return preg_match('/\\d/', $String) > 0;
}



function addCategory()
{
	include '../config/config.php';

	/*
		Validations 
	*/
		$errors = array();

		$cname = secure(ucfirst($_POST['cname']));

		$stmt = $conn->prepare("SELECT `CategoryId` FROM `tblcategories` WHERE `CategoryName`=:cate AND `Deleted`='NO'");
		$stmt->bindParam(':cate',$cname);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count >= 1){
			array_push($errors, "Category name already exists!");
		}


		if(count($errors) > 0 )
		{

			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Error');
				$('#modalmsg').html(\"".implode("<br />",$errors)."\");
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
				$('#msgmodal').modal('show');
			});
		</script></tr>";
	}
	else
	{

		$stmt = $conn->prepare("INSERT INTO `tblcategories`( `CategoryName`, `Deleted`) VALUES (:cname , 'NO')");


		$stmt->bindParam(':cname', $cname);
		$stmt->execute();


		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Category successfully added!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});
	</script></tr>";
}
showCategories();
}






function showCategories()
{
	include '../config/config.php';

	$admins = $conn->query("SELECT `CategoryId`, `CategoryName` FROM `tblcategories` WHERE `Deleted`='NO'");

	while($r = $admins->fetch()){
		echo "<tr>";
		echo "<td>".$r['CategoryId']."</td>";
		echo "<td>".$r['CategoryName']."</td>";

		echo '<td><a class="btn btn-sm btn-info" onclick="updateCategory('.$r['CategoryId'].')"> <span class="glyphicon glyphicon-pencil"></span> Edit</a> | <a class="btn btn-sm btn-danger" onclick="deleteCategory('.$r['CategoryId'].')"><span class=
		"glyphicon glyphicon-trash"></span> Delete</a></td>';
		echo "</tr>";
	}
}

function deleteCategory()
{
	include '../config/config.php';
	$id = $_POST['id'];


$stmt = $conn->prepare("SELECT * FROM `tblstocks` WHERE `ProductId`=:id and Deleted='NO'");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();
	$count = $stmt->rowCount();
	if($count >= 1){
			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Error');
				$('#modalmsg').html('Category can not be deleted, there are still products with category selected!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
				$('#msgmodal').modal('show');
			});
		</script></tr>";
	}else{







    // prepare sql and bind parameters
	$stmt = $conn->prepare("UPDATE tblcategories set Deleted='YES' WHERE CategoryId=:id");
	$stmt->bindParam(':id', $id);
	$stmt->execute();



	echo "<tr><script type='text/javascript'>
	$(document).ready(function(){
		$('#msgtitle').text('Success');
		$('#modalmsg').html('Category successfully deleted!');
		$('#msgmodalbtn').text('Close');
		$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
		$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
		$('#msgmodal').modal('show');
	});
</script></tr>";

}

showCategories();



}

function showUpdateCategory()
{
	include '../config/config.php';
	$id = $_POST['id'];
	$stmt = $conn->prepare("SELECT `CategoryName` FROM `tblcategories` WHERE `CategoryId`=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$cname = secure($row['CategoryName']);

	echo json_encode(array(
		"id" => $id, 
		"cname" => $cname));

}	






function updateCategory()
{
	include '../config/config.php';

	$stmt = $conn->prepare("UPDATE `tblcategories` SET `CategoryName`=:cname WHERE `CategoryId`=:id");


	$id = secure($_POST['u_id']);
	$cname = secure($_POST['u_cname']);



	$errors = array();



	if(count($errors) > 0 )
	{

		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Error');
			$('#modalmsg').html(\"".implode("<br />",$errors)."\");
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
			$('#msgmodal').modal('show');
		});</script></tr>";
	}
	else
	{
		$stmt->bindParam(':cname', $cname);

		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	showCategories();
}


//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=




function addUnit()
{
	include '../config/config.php';

	/*
		Validations 
	*/
		$errors = array();

		$uname = secure(ucfirst($_POST['uname']));
		$stmt = $conn->prepare("SELECT `UnitId` FROM `tblunits` WHERE `UnitName`=:cate and `Deleted`='NO'");
		$stmt->bindParam(':cate',$uname);
		$stmt->execute(); 
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count >= 1){
			array_push($errors, "Unit already exists!");
		}




		if(count($errors) > 0 )
		{

			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Error');
				$('#modalmsg').html(\"".implode("<br />",$errors)."\");
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
				$('#msgmodal').modal('show');
			});
		</script></tr>";
	}
	else
	{

		$stmt = $conn->prepare("INSERT INTO `tblunits`(`UnitName`, `Deleted`) VALUES (:uname, 'NO')");
		$stmt->bindParam(':uname', $uname);
		$stmt->execute();


		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Unit successfully added!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});
	</script></tr>";
}
showUnits();
}



function showUnits()
{
	include '../config/config.php';

	$admins = $conn->query("SELECT `UnitId`, `UnitName` FROM `tblunits` WHERE `Deleted`='NO'");

	while($r = $admins->fetch()){
		echo "<tr>";
		echo "<td>".$r['UnitId']."</td>";
		echo "<td>".$r['UnitName']."</td>";

		echo '<td><a class="btn btn-sm btn-info" onclick="updateUnit('.$r['UnitId'].')"> <span class="glyphicon glyphicon-pencil"></span> Edit</a> | <a class="btn btn-sm btn-danger" onclick="deleteUnit('.$r['UnitId'].')"><span class=
		"glyphicon glyphicon-trash"></span> Delete</a></td>';
		echo "</tr>";
	}
}

function deleteUnit()
{
	include '../config/config.php';
	$id = $_POST['id'];


	$stmt = $conn->prepare("SELECT `id` FROM `tblproducts` WHERE `Product_unit`=:id AND `Deleted`='NO'");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();
	$count = $stmt->rowCount();

	if($count >= 1){
			echo "<tr><script type='text/javascript'>
				$(document).ready(function(){
					$('#msgtitle').text('Success');
					$('#modalmsg').html('Unit can not be deleted, there are product(s) using this unit!');
					$('#msgmodalbtn').text('Close');
					$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
					$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
					$('#msgmodal').modal('show');
				});
			</script></tr>";
	}else{

		    // prepare sql and bind parameters
	$stmt = $conn->prepare("UPDATE tblunits set Deleted='YES' WHERE UnitId=:id");
	$stmt->bindParam(':id', $id);
	$stmt->execute();



	echo "<tr><script type='text/javascript'>
	$(document).ready(function(){
		$('#msgtitle').text('Success');
		$('#modalmsg').html('Unit successfully deleted!');
		$('#msgmodalbtn').text('Close');
		$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
		$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
		$('#msgmodal').modal('show');
	});
</script></tr>";

	
	}


showUnits();



}

function showUpdateUnit()
{
	include '../config/config.php';
	$id = $_POST['id'];

	$stmt = $conn->prepare("SELECT  `UnitName` FROM `tblunits` WHERE `UnitId`=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$uname = secure($row['UnitName']);

	echo json_encode(array(
		"id" => $id, 
		"uname" => $uname ));
}	




function updateUnit()
{
	include '../config/config.php';

	$stmt = $conn->prepare("UPDATE `tblunits` SET `UnitName`=:uname WHERE `UnitId`=:id");


	$id = secure($_POST['u_uid']);
	$uname = secure($_POST['u_uname']);

	$errors = array();



	if(count($errors) > 0 )
	{

		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Error');
			$('#modalmsg').html(\"".implode("<br />",$errors)."\");
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
			$('#msgmodal').modal('show');
		});</script></tr>";
	}
	else
	{
		$stmt->bindParam(':uname', $uname);

		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	showUnits();
}




?>