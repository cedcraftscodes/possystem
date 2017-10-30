<?php 
if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'addItem':
		addItem();
		break;
		case 'showItem':
		showItem();
		break;
		case 'deleteItem':
		deleteItem();
		break;
		case 'showUpdateItem':
		showUpdateItem();
		break;
		case 'updateItem':
		updateItem();
		break;
		default:
				# code...
		break;
	}
}


function secure($str){
  return strip_tags(trim(htmlspecialchars($str)));
}



function addItem()
{

	include '../config/config.php';

	$stmt = $conn->prepare("INSERT INTO `products`(`Product_name`, `Product_brand`, `Product_quantity`, `Product_price`, `Product_markup_price`, `Product_flooring`, `Product_ceiling`, `Product_unit`, `Product_code`, `Exp_date`, `Product_supplier`, `Product_category`, `created_at`) VALUES 
		(:name, :brand, :quantity, :price, :mark, :floor, :ceiling, :unit, :code, :expdate, :supplier, :category, :dtt)");

	$pname = secure($_POST['pname']);
	$brand = secure($_POST['brand']);
	$quantity = secure($_POST['quantity']);
	$price = secure($_POST['price']);
	$markupprice = secure($_POST['markupprice']);
	$flooring = secure($_POST['flooring']);
	$ceiling = secure($_POST['ceiling']);
	$unit = secure($_POST['unit']);
	$pcode = secure($_POST['pcode']);
	$expdate = secure($_POST['expdate']);
	$supplier = secure($_POST['supplier']);
	$category = secure($_POST['category']);

	$time = time();


	$stmt->bindParam(':name', $pname);
	$stmt->bindParam(':brand', $brand);
	$stmt->bindParam(':quantity', $quantity);
	$stmt->bindParam(':price', $price);
	$stmt->bindParam(':mark', $markupprice);
	$stmt->bindParam(':floor', $flooring);
	$stmt->bindParam(':ceiling', $ceiling);
	$stmt->bindParam(':unit', $unit);
	$stmt->bindParam(':code', $pcode);
	$stmt->bindParam(':expdate', $expdate);
	$stmt->bindParam(':supplier', $supplier);
	$stmt->bindParam(':category', $category);
	$stmt->bindParam(':dtt', $time);
	$stmt->execute();


	showItem();


}


function showItem()
{
	include '../config/config.php';

	$items = $conn->query("SELECT * FROM `products`");

	while($r = $items->fetch()){
		echo "<tr>";
		echo "<td>".$r['Product_code']."</td>";
		echo "<td>".$r['Product_name']."</td>";
		echo "<td>".$r['Product_brand']."</td>";
		echo "<td>".$r['Product_supplier']."</td>";
		echo "<td>".$r['Product_quantity']."</td>";
		echo "<td>".$r['Product_unit']."</td>";
		echo "<td>".$r['Product_price']."</td>";
		$dateadded = date("F j, Y, g:i a", $r["created_at"]);
		echo "<td>".$dateadded."</td>";
		echo '<td><a onclick="updateItem('.$r['id'].')"> <span class="glyphicon glyphicon-pencil"></span></a> | <a onclick="deleteItem('.$r['id'].')"><span class=
		"glyphicon glyphicon-trash"></span></a></td>';

		echo "</tr>";
	}




}

function deleteItem()
{
	include '../config/config.php';
	$id = $_POST['id'];

    // prepare sql and bind parameters
	$stmt = $conn->prepare("DELETE FROM `products` WHERE `id`=:id");
	$stmt->bindParam(':id', $id);
	$stmt->execute();

	showItem();



}

function showUpdateItem()
{
	include '../config/config.php';
	$id = $_POST['id'];

	$stmt = $conn->prepare("SELECT * FROM `products` WHERE `id`=:id");
	$stmt->bindParam(':id',$id);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$id = $row['id'];
	$pname = $row['Product_name'];
	$brand = $row['Product_brand'];
	$quantity = $row['Product_quantity'];
	$price = $row['Product_price'];
	$markupprice = $row['Product_markup_price'];
	$flooring = $row['Product_flooring'];
	$ceiling = $row['Product_ceiling'];
	$unit = $row['Product_unit'];
	$pcode = $row['Product_code'];
	$expdate = $row['Exp_date'];
	$supplier = $row['Product_supplier'];
	$category = $row['Product_category'];

	echo json_encode(array(
		"name" => $pname, 
		"brand" => $brand, 
		"quantity" => $quantity, 
		"price" => $price, 
		"markupprice" => $markupprice,
		"flooring" => $flooring,
		"ceiling" => $ceiling ,
		"unit" => $unit ,
		"code" => $pcode ,
		"expdate" => $expdate ,
		"supplier" => $supplier ,
		"category" => $category ,
		"id" => $id ));

}	

function updateItem()
{
	include '../config/config.php';

	$stmt = $conn->prepare("UPDATE `products` SET `Product_name`=:name,`Product_brand`=:brand,`Product_quantity`=:quantity,`Product_price`=:price,`Product_markup_price`=:mark,`Product_flooring`=:floor,`Product_ceiling`=:ceiling,`Product_unit`=:unit,`Product_code`=:code,`Exp_date`=:expdate,`Product_supplier`=:supplier,`Product_category`=:category WHERE id=:id");

	$id = secure($_POST['u_id']);
	$pname = secure($_POST['u_pname']);
	$brand = secure($_POST['u_brand']);
	$quantity = secure($_POST['u_quantity']);
	$price = secure($_POST['u_price']);
	$markupprice = secure($_POST['u_markupprice']);
	$flooring = secure($_POST['u_flooring']);
	$ceiling = secure($_POST['u_ceiling']);
	$unit = secure($_POST['u_unit']);
	$pcode = secure($_POST['u_pcode']);
	$expdate = secure($_POST['u_expdate']);
	$supplier = secure($_POST['u_supplier']);
	$category = secure($_POST['u_category']);


	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':name', $pname);
	$stmt->bindParam(':brand', $brand);
	$stmt->bindParam(':quantity', $quantity);
	$stmt->bindParam(':price', $price);
	$stmt->bindParam(':mark', $markupprice);
	$stmt->bindParam(':floor', $flooring);
	$stmt->bindParam(':ceiling', $ceiling);
	$stmt->bindParam(':unit', $unit);
	$stmt->bindParam(':code', $pcode);
	$stmt->bindParam(':expdate', $expdate);
	$stmt->bindParam(':supplier', $supplier);
	$stmt->bindParam(':category', $category);

	$stmt->execute();



	showItem();


}

?>