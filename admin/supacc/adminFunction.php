<?php 


if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'addAdmin':
		addAdmin();
		break;
		case 'showAdmins':
		showAdmins();
		break;
		case 'deleteAdmin':
		deleteAdmin();
		break;
		case 'showUpdateAdmin':
		showUpdateAdmin();
		break;
		case 'updateAdmin':
		updateAdmin();
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

function addAdmin()
{
	include '../config/config.php';

	/*
		Validations 
	*/
		$errors = array();

		/*

		if(strlen($_POST['fname']) == 0){
			array_push($errors, "First Name can not be blank!");
		}else{
			if(ContainsNumbers($_POST['fname'])){
				array_push($errors, "First Name contains number!");
			}
		}
		*/

		
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


		$stmt = $conn->prepare("INSERT INTO `tblsuppliers`(`Supplier_name`, `Supplier_co_name`, `Supplier_street`, `Supplier_city`, `Supplier_province`, `Supplier_zipcode`, `Supplier_contact`, `Supplier_email`, `AddedBy`, `DateAdded`, `Deleted`) VALUES 
			(:sname, :coname, :st, :ct, :pv, :zc, :cont, :email, :Add, :dat , 'NO')");

		$sname = secure($_POST['sname']);
		$sconame = secure($_POST['rname']);
		$st = secure($_POST['street']);
		$ct = secure($_POST['city']);
		$pv = secure($_POST['province']);
		$zc = secure($_POST['zipcode']);
		$cont = secure($_POST['contactnumber']);
		$email = secure($_POST['email']);
		$time = time();



		$stmt->bindParam(':sname', $sname);
		$stmt->bindParam(':coname', $sconame);
		$stmt->bindParam(':st', $st);
		$stmt->bindParam(':ct', $ct);
		$stmt->bindParam(':pv', $pv);
		$stmt->bindParam(':zc', $zc);
		$stmt->bindParam(':cont', $cont);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':Add', $_SESSION['acc_id']);
		$stmt->bindParam(':dat', $time);

		$stmt->execute();


		echo "<tr><script type='text/javascript'>
		$(document).ready(function(){
			$('#msgtitle').text('Success');
			$('#modalmsg').html('Supplier successfully added!');
			$('#msgmodalbtn').text('Close');
			$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
			$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
			$('#msgmodal').modal('show');
		});
	</script></tr>";



}
showAdmins();


}




function showAdmins()
{
	include '../config/config.php';

	$admins = $conn->query("SELECT * FROM `tblsuppliers` WHERE `Deleted`='NO'");

	while($r = $admins->fetch()){
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
}

function deleteAdmin()
{
	include '../config/config.php';
	$id = $_POST['id'];

	$stmt = $conn->prepare("SELECT * FROM `tblstocks` WHERE `Product_supplier`=:id and Deleted='NO'");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();
	$count = $stmt->rowCount();

	if($count >= 1){
			echo "<tr><script type='text/javascript'>
			$(document).ready(function(){
				$('#msgtitle').text('Error');
				$('#modalmsg').html('Supplier can not be deleted, there are still stocks with supplier selected!');
				$('#msgmodalbtn').text('Close');
				$('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
				$('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
				$('#msgmodal').modal('show');
			});
		</script></tr>";
	}else{

    // prepare sql and bind parameters
	$stmt = $conn->prepare("UPDATE tblsuppliers set Deleted='YES' WHERE Supplier_id=:id");
	$stmt->bindParam(':id', $id);
	$stmt->execute();


	echo "<tr><script type='text/javascript'>
	$(document).ready(function(){
		$('#msgtitle').text('Success');
		$('#modalmsg').html('Supplier successfully deleted!');
		$('#msgmodalbtn').text('Close');
		$('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
		$('#msgmodalheader').attr('class', 'modal-header modal-header-success');
		$('#msgmodal').modal('show');
	});
	</script></tr>";

	}
	

showAdmins();
}

function showUpdateAdmin()
{
	include '../config/config.php';
	$id = $_POST['id'];

	$stmt = $conn->prepare("SELECT * FROM `tblsuppliers` WHERE `Supplier_id`=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$sid = secure($row['Supplier_id']);
	$sname = secure($row['Supplier_name']);
	$sconame = secure($row['Supplier_co_name']);
	$st = secure($row['Supplier_street']);
	$ct = secure($row['Supplier_city']);
	$pv = secure($row['Supplier_province']);
	$zc = secure($row['Supplier_zipcode']);
	$cont = secure($row['Supplier_contact']);
	$email = secure($row['Supplier_email']);



	echo json_encode(array(
		"id" => $sid, 
		"sname" => $sname, 
		"rname" => $sconame,
		"street" => $st, 
		"city" => $ct, 
		"province" => $pv,
		"zipcode" => $zc, 
		"contact" => $cont, 
		"email" => $email));

}	






function updateAdmin()
{
	include '../config/config.php';

	$stmt = $conn->prepare("UPDATE `tblsuppliers` SET `Supplier_name`=:sname,`Supplier_co_name`=:rname,`Supplier_street`=:street,`Supplier_city`=:city,`Supplier_province`=:prov,`Supplier_zipcode`=:zcode,`Supplier_contact`=:cont,`Supplier_email`=:email WHERE `Supplier_id`=:id");


	$sid = secure($_POST['u_id']);
	$sname = secure($_POST['u_sname']);
	$sconame = secure($_POST['u_rname']);
	$st = secure($_POST['u_street']);
	$ct = secure($_POST['u_city']);
	$pv = secure($_POST['u_province']);
	$zc = secure($_POST['u_zipcode']);
	$cont = secure($_POST['u_contactnumber']);
	$email = secure($_POST['u_email']);


	$errors = array();


	/*

	ALERT ALERT ALERT ==== NO VALIDATION
	if(strlen($_POST['u_fname']) == 0){
		array_push($errors, "First Name can not be blank!");
	}else{
		if(ContainsNumbers($_POST['u_fname'])){
			array_push($errors, "First Name contains number!");
		}
	}


	*/



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


		$stmt->bindParam(':sname', $sname);
		$stmt->bindParam(':rname', $sconame);
		$stmt->bindParam(':street', $st);
		$stmt->bindParam(':city', $ct);
		$stmt->bindParam(':prov', $pv);
		$stmt->bindParam(':zcode', $zc);
		$stmt->bindParam(':cont', $cont);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':id', $sid);
		$stmt->execute();




	}



	showAdmins();


}

?>