<?php 


if(session_id()){}else{session_start();}



if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {

		case 'showDeliveries':
		showDeliveries();
		break;

		case 'deliverProducts':
		deliverProducts();
		break;


		default:
		break;
	}
}


function secure($str){
	return strip_tags(trim(htmlspecialchars($str)));
}


function ContainsNumbers($String){
	return preg_match('/\\d/', $String) > 0;
}



function deliverProducts(){
	$quantities = $_POST['quantities'];
	$prices = $_POST['prices'];
	$poid = $_POST['poid'];
	$delnum = $_POST['delnum'];
	

	$totalqty = 0;


	foreach ($quantities as $id => $qty) 
	{
		$totalqty+=(int)$qty;
	}

	if($totalqty > 0){
		$time = time();

		include '../config/config.php';
		$stmt = $conn->prepare("INSERT INTO `tblpodeliveries`(`Po_id`, `ReceivedBy_id`, `DeliveryNumber`,`DateDelivered`) VALUES (:poid, :rb, :del, :dd)");
		$stmt->bindParam(':poid',$poid);
		$stmt->bindParam(':dd',$time);
		$stmt->bindParam(':del',$delnum);
		$stmt->bindParam(':rb',$_SESSION['acc_id']);
		$stmt->execute(); 
		$delid = $conn->lastInsertId();


		foreach ($quantities as $id => $qty) {
			$pid = $id;
			$quantity = (int)$qty;
			$price = (double)$prices[$id];

			if($quantity == 0)
				continue;

			$stmt = $conn->prepare("INSERT INTO `tblpodel_items`( `Pod_id`, `ProductId`, `SupplierPrice`, `Quantity_Delivered`) VALUES
				(:podid, :pid, :supprice, :quan)");
			$stmt->bindParam(':podid',$delid);
			$stmt->bindParam(':pid',$pid);
			$stmt->bindParam(':supprice', $price);
			$stmt->bindParam(':quan',$quantity);
			$stmt->execute(); 


			
			// +=====================+ Fix it Here ///////////////
			$stmt = $conn->prepare("INSERT INTO `tblstocks`(`ProductId`, `No_Of_Items`, `SellingPrice`, `Product_supplier`, `SupplierPrice`, `DateAdded`, `Deleted`) 
				SELECT :pid, 
				:qty, 
				(SELECT `SellingPrice` FROM `tblstocks` WHERE `ProductId`=:pid AND `Deleted`='NO' ORDER BY `StockId` DESC LIMIT 1),
				(SELECT `Supplier_id` FROM `tblpurchaseorders` WHERE `Po_id`=:id), 
				:sel,
				:dt, 'NO'");
			$stmt->bindParam(':id',$poid);
			$stmt->bindParam(':pid',$pid);
			$stmt->bindParam(':qty',$quantity);
			$stmt->bindParam(':sel', $price);
			$stmt->bindParam(':dt',$time);
			$stmt->execute();


			
		}

		$stmt = $conn->prepare("SELECT
			pr.id,
			pr.Product_name,
			poi.`Quantity_Requested`,
			(
			SELECT
			SUM(`Quantity_Delivered`)
			FROM
			tblpodel_items AS podi
			WHERE
			`ProductId` = poi.`ProductId` AND pod.Po_id = :pid
			) AS Delivered,
			(
			SELECT
			st.`SupplierPrice`
			FROM
			tblstocks AS st
			WHERE
			st.ProductId = poi.`ProductId`
			ORDER BY
			st.StockId
			DESC
			LIMIT 1
			) AS 'LatestPrice'
			FROM
			`tblpo_items` AS poi
			LEFT JOIN tblpodeliveries AS pod
			ON
			pod.Po_id = poi.`Po_id`
			INNER JOIN tblproducts AS pr
			ON
			pr.id = poi.`ProductId`
			WHERE
			poi.`Po_id` = :pid
			GROUP BY
			pr.id,
			poi.`Po_id`
			ORDER BY Delivered");


		$isCompleted = true;

		if ($stmt->execute(array(':pid' => $poid))) {

			while ($r = $stmt->fetch()) {
				$delivered = (int)$r['Delivered'];
				$requested = (int)$r['Quantity_Requested'];
				if($requested != $delivered){
					$isCompleted = false;
				}
			}
		}

		if($isCompleted){
	    // prepare sql and bind parameters
			$stmt = $conn->prepare("UPDATE tblpurchaseorders set Status='Completed' WHERE Po_id=:id");
			$stmt->bindParam(':id', $poid);
			$stmt->execute();
		}

		echo json_encode(array(
			"message" => 'Delivery Success!', 
			"success" => true
			));

	}else{

		echo json_encode(array(
			"message" => 'Deliver atleast one product!', 
			"success" => false
			));
	}

	}



	function showDeliveries(){
		include '../config/config.php';

		$prod = $conn->query("SELECT 
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
			ORDER BY d.`Pod_id` DESC
			");

		while($r = $prod->fetch()){
			echo "<tr>";
			echo "<td>".$r['Pod_id']."</td>";
			echo "<td>".$r['Supplier_name']."</td>";
			echo "<td>".$r['Receiver']."</td>";
			echo "<td>".$r['Po_number']."</td>";

			$DateDelivered = date("F j, Y", $r["DateDelivered"]);
			echo "<td>".$DateDelivered."</td>";

			echo "<td><a class='btn btn-sm btn-info' href='viewdelivery.php?id=".$r['Pod_id']."''> <span class='glyphicon glyphicon-pencil'></span> View</a>";
			echo "</tr>";
		}
	}


?>