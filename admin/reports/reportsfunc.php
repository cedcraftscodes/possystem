<?php 
if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

  $action = $_POST['action'];
  switch ($action) {
   case 'showProduct':
   showProduct();
   break;
   
   case 'showPurchaseOrders':
   showPurchaseOrders();
   break;


   case 'showDeliveries':
   showDeliveries();
   break;

   case 'showTransactions':
   showTransactions();
   break;


   case 'showSalesReport':
   showSalesReport();
   break;

   case 'showRefunds':
   showRefunds();
   break;

   case 'showStockAdjustment':
   showStockAdjustment();
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

function showRefunds(){
 include '../config/config.php';

 $to1 = strtotime(secure($_POST['enddate']));
 $beginOfDay = strtotime("midnight", $to1);
 $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
 $from = strtotime("midnight", (int)$_POST['startdate']);
 $to = $endOfDay;

 $prods = $conn->prepare("
  SELECT
  pr.Product_name, 
  bo.remarks, 
  rf.`amount`, 
  `refunddate`
  FROM
  `tblrefunds` as rf 
  INNER JOIN tblbadorders as bo 
  ON bo.badorder_id = rf.`boid`
  INNER JOIN tblproducts as pr 
  ON pr.id = bo.product_id
  WHERE `refunddate` >= :start AND `refunddate` <= :to");
 $prods->bindValue(":start", $from);
 $prods->bindValue(":to", $to);
 $prods->execute();

 echo 
 "<thead>
 <tr class='headings'>
 <th class='column-title'>Product Name</th>
 <th class='column-title'>Remarks</th>
 <th class='column-title'>Date Refund</th>
 <th class='column-title'>Refund Amount</th>
 </tr>
 </thead>
 <tbody>
 ";

 $counter = 0;
 $total = 0;

 while($r = $prods->fetch()){
  if($counter % 2 == 0){
    echo "<tr class='even pointer'>";
  }else{
    echo "<tr class='odd pointer'>";  
  }
  echo "<td>".$r['Product_name']."</td>";
  echo "<td>".$r['remarks']."</td>";
  $DateDelivered = date("F j, Y", $r["refunddate"]);
  echo "<td>".$DateDelivered."</td>";
  echo "<td>".$r['amount']."</td>";
  echo "</tr>";

  $total+= $r['amount'];
}

echo "<tr>";
echo "<td colspan='1'></td>";
echo "<td colspan='2' align='right' id='total'>Total: </td>";
echo "<td colspan='1' align='right' id='total'>₱ ".number_format($total, 2, '.', ',')."</td>";
echo "</tr>";
echo "</tbody>";
}

function showDeliveries(){
 include '../config/config.php';

 $to1 = strtotime(secure($_POST['enddate']));
 $beginOfDay = strtotime("midnight", $to1);
 $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
 $from = strtotime("midnight", (int)$_POST['startdate']);
 $to = $endOfDay;

 $prods = $conn->prepare("SELECT 
   d.`Pod_id`,
   d.`DeliveryNumber`,
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
   WHERE d.`DateDelivered` >= :start AND d.`DateDelivered` <= :to");
 $prods->bindValue(":start", $from);
 $prods->bindValue(":to", $to);
 $prods->execute();

 echo 
 "<thead>
 <tr class='headings'>
 <th class='column-title'>Delivery #</th>
 <th class='column-title'>Supplier</th>
 <th class='column-title'>Recieved By</th>
 <th class='column-title'>PO Number</th>
 <th class='column-title'>Delivery Date</th>
 </tr>
 </thead>
 <tbody>
 ";

 $counter = 0;

 while($r = $prods->fetch()){
   if($counter % 2 == 0){
    echo "<tr class='even pointer'>";
  }else{
    echo "<tr class='odd pointer'>";	
  }

  echo "<td>".$r['DeliveryNumber']."</td>";
  echo "<td>".$r['Supplier_name']."</td>";
  echo "<td>".$r['Receiver']."</td>";
  echo "<td>".$r['Po_number']."</td>";

  $DateDelivered = date("F j, Y", $r["DateDelivered"]);
  echo "<td>".$DateDelivered."</td>";

  echo "</tr>";
}

echo "</tbody>";


}






function showPurchaseOrders(){
 include '../config/config.php';

 $to1 = strtotime(secure($_POST['enddate']));
 $beginOfDay = strtotime("midnight", $to1);
 $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
 $from = strtotime("midnight", (int)$_POST['startdate']);
 $to = $endOfDay;


 $prods = $conn->prepare("SELECT 
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
   WHERE po.DatePrepared >= :start AND po.DatePrepared <= :to");
 $prods->bindValue(":start", $from);
 $prods->bindValue(":to", $to);
 $prods->execute();

 echo 
 "<thead>
 <tr class='headings'>


 <th class='column-title'>Purchase Order #</th>
 <th class='column-title'>Supplier</th>
 <th class='column-title'>Prepared By</th>
 <th class='column-title'>Checked By</th>
 <th class='column-title'>Expected Delivery</th>
 <th class='column-title'>Date Prepared</th>
 <th class='column-title'>Status</th>
 </tr>
 </thead>
 <tbody>
 ";

 $counter = 0;

 while($r = $prods->fetch()){
   if($counter % 2 == 0){
    echo "<tr class='even pointer'>";
  }else{
    echo "<tr class='odd pointer'>";	
  }

  echo "<td>".$r['Po_number']."</td>";
  echo "<td>".$r['Supplier_name']."</td>";
  echo "<td>".$r['Prepared']."</td>";
  echo "<td>".$r['Checked']."</td>";


  $Exp_DeliveryDate = date("F j, Y", strtotime($r["Exp_DeliveryDate"]));
  echo "<td>".$Exp_DeliveryDate."</td>";

  $DatePrepared = date("F j, Y", $r["DatePrepared"]);
  echo "<td>".$DatePrepared."</td>";

  echo "<td>".$r['Status']."</td>";
  echo "</tr>";
}

echo "</tbody>";


}



function showTransactions(){
 include '../config/config.php';



 $to1 = strtotime(secure($_POST['enddate']));
 $beginOfDay = strtotime("midnight", $to1);
 $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
 $from = strtotime("midnight", (int)$_POST['startdate']);
 $to = $endOfDay;


 $trans = $conn->prepare("SELECT
   `TransNo`,
   `TransDate`,
   `TransTotal`,
   `TransCash`,
   `TransChange`,
   `No_Of_Items`,
   cs.CustomerName,
   concat(us.fname, ' ' , us.mname, ' ', us.lname) as 'Cashier'
   FROM
   `tbltransaction` AS tr
   INNER JOIN tblcustomer AS cs
   ON
   cs.CustomerId = tr.`CustId`
   INNER JOIN tblusers as us 
   ON us.userid = tr.`TransUserId`
   WHERE TransDate >= :start AND TransDate <= :to");
 $trans->bindValue(":start", $from);
 $trans->bindValue(":to", $to);
 $trans->execute();


 echo 
 "<thead>
 <tr class='headings'>
 <th class='column-title'>Transaction #</th>
 <th class='column-title'>Customer Name </th>
 <th class='column-title'>Cashier </th>
 <th class='column-title'>Transaction Date </th>
 <th class='column-title'>No Of Items </th>
 <th class='column-title'>Cash </th>
 <th class='column-title'>Change </th>
 <th class='column-title'>Total </th>
 </th>
 </tr>
 </thead>
 <tbody>";

 $counter = 0;
 $total = 0 ;


 while($r = $trans->fetch()){
   if($counter % 2 == 0){
    echo "<tr class='even pointer'>";
  }else{
    echo "<tr class='odd pointer'>"; 
  }

  echo "<td class=''>".$r['TransNo']."</td>";
  echo "<td class=''>".$r['CustomerName']."</td>";
  echo "<td class=''>".$r['Cashier']."</td>";
  $dateadded = date("F j, Y, g:i a", $r["TransDate"]);
  echo "<td class=''>".$dateadded."</td>";

  echo "<td class=''>".$r['No_Of_Items']."</td>";
  echo "<td class=''>₱ ".$r['TransCash']."</td>";
  echo "<td class=''>₱ ".$r['TransChange']."</td>";
  echo "<td class=''>₱ ".$r['TransTotal']."</td>";
  echo "</tr>";

  $total += $r['TransTotal'];
}



$stmt = $conn->prepare("SELECT SUM(`amount`) as 'Refunds' FROM `tblrefunds` WHERE `refunddate` >= :start AND refunddate <= :to");
$stmt->bindValue(":start", $from);
$stmt->bindValue(":to", $to);
$stmt->execute(); 
$row = $stmt->fetch();


$refunds = secure($row['Refunds']);

$grandtotal = $total - $refunds;


echo "<tr>";
echo "<td colspan='4'></td>";
echo "<td colspan='2' align='right' id='total'>Total: </td>";
echo "<td colspan='2' align='right' id='total'>₱ ".number_format($total , 2, '.', ',')."</td>";
echo "</tr>";



echo "<tr>";
echo "<td colspan='4'></td>";
echo "<td colspan='2' align='right' id='total'>Refunds: </td>";
echo "<td colspan='2' align='right' id='total'>- ₱ ".number_format($refunds, 2, '.', ',')."</td>";
echo "</tr>";


echo "<tr>";
echo "<td colspan='4'></td>";
echo "<td colspan='2' align='right' id='total'>Grand Total: </td>";
echo "<td colspan='2' align='right' id='total'>₱ ".number_format($grandtotal , 2, '.', ',')."</td>";
echo "</tr>";

echo 
"</tbody>";
}



function showSalesReport(){
 include '../config/config.php';




 $to1 = strtotime(secure($_POST['enddate']));
 $beginOfDay = strtotime("midnight", $to1);
 $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
 $from = strtotime("midnight", (int)$_POST['startdate']);
 $to = $endOfDay;






 $trans = $conn->prepare("SELECT
   tr.`TransNo`,
   tr.`TransDate`, 
   (tr.TransTotal / 1.12 * .12) as 'VatTax',
   (tr.TransTotal - (tr.TransTotal / 1.12 * .12)) as 'Vatable',
   tr.TransTotal
   FROM
   `tbltransaction` AS tr
   INNER JOIN tblcustomer AS cs
   ON
   cs.CustomerId = tr.`CustId`
   INNER JOIN tblusers AS us
   ON
   us.userid = tr.`TransUserId`
   WHERE TransDate >= :start AND TransDate <= :to");
 $trans->bindValue(":start", $from);
 $trans->bindValue(":to", $to);
 $trans->execute();

 echo 
 "<thead>
 <tr class='headings'>
 <th class='column-title'>Transaction #</th>
 <th class='column-title'>Transaction Date </th>
 <th class='column-title'>Vat Tax </th>
 <th class='column-title'>Vattable </th>
 <th class='column-title'>Total </th>
 </th>
 </tr>
 </thead>
 <tbody>";

 $counter = 0;
 $total = 0 ;
 $vatable = 0; 
 $vattax = 0;




 while($r = $trans->fetch()){
   if($counter % 2 == 0){
    echo "<tr class='even pointer'>";
  }else{
    echo "<tr class='odd pointer'>";	
  }

  echo "<td class=''>".$r['TransNo']."</td>";
  $dateadded = date("F j, Y, g:i a", $r["TransDate"]);
  echo "<td class=''>".$dateadded."</td>";

  echo "<td class=''>₱".number_format((float)$r['VatTax'], 2, '.', ',')."</td>";
  echo "<td class=''>₱ ".number_format((float)$r['Vatable'], 2, '.', ',')."</td>";
  echo "<td class=''>₱ ".number_format((float)$r['TransTotal'], 2, '.', ',')."</td>";
  echo "</tr>";


  $total += $r['TransTotal'];
  $vatable += $r['Vatable'];
  $vattax += $r['VatTax'];
}

$stmt = $conn->prepare("SELECT SUM(`amount`) as 'Refunds' FROM `tblrefunds` WHERE `refunddate` >= :start AND refunddate <= :to");
$stmt->bindValue(":start", $from);
$stmt->bindValue(":to", $to);
$stmt->execute(); 
$row = $stmt->fetch();

$refunds = secure($row['Refunds']);
$grandtotal = $total - $refunds;




$vattaxmin = ($total - $refunds) / 1.12 * .12;
$vattablemin = $refunds - $vattaxmin;

echo "<tr>";
echo "<td colspan='2' align='right' id='total'>Total: </td>";
echo "<td colspan='1' align='right' id='total'>₱ ".number_format((float)$vattax, 2, '.', ',')."</td>";
echo "<td colspan='1' align='right' id='total'>₱ ".number_format((float)$vatable, 2, '.', ',')."</td>";
echo "<td colspan='1' align='right' id='total'>₱ ".number_format((float)$total, 2, '.', ',')."</td>";
echo "</tr>";

echo "<tr>";
echo "<td colspan='2' align='right' id='total'>Refunds: </td>";
echo "<td colspan='1' align='right' id='total'>-₱ ".number_format((float) $vattaxmin, 2, '.', ',')."</td>";
echo "<td colspan='1' align='right' id='total'>-₱ ".number_format((float)$vattablemin, 2, '.', ',')."</td>";
echo "<td colspan='1' align='right' id='total'>-₱ ".number_format((float)$refunds, 2, '.', ',')."</td>";
echo "</tr>";

echo "<tr>";
echo "<td colspan='2' align='right' id='total'>Grand Total: </td>";
echo "<td colspan='1' align='right' id='total'>₱ ".number_format((float)$vattax - $vattaxmin, 2, '.', ',')."</td>";
echo "<td colspan='1' align='right' id='total'>₱ ".number_format((float)$vatable - $vattablemin, 2, '.', ',')."</td>";
echo "<td colspan='1' align='right' id='total'>₱ ".number_format((float)$total - $refunds, 2, '.', ',')."</td>";
echo "</tr>";



echo 
"</tbody>";
}

function showProduct(){
 include '../config/config.php';

 $stat = $_POST['stat'];
 if($stat == "All"){

  $prods = $conn->prepare("SELECT
   							    *
    FROM
    (
    SELECT
   							        *,
    IF(
    TotalStock > Product_flooring && TotalStock <= Product_ceiling,
    'Normal',
    IF(
    TotalStock < Product_flooring,
    'Critical',
    IF(
    TotalStock > Product_ceiling,
    'Overstocking',
    'Something Else'
    )
    )
    ) AS 'Status'
    FROM
    (
    SELECT
    pr.id,
    pr.Product_code,
    pr.Product_name,
    pr.Product_flooring,
    pr.Product_ceiling,
    sup.Supplier_name,
    SUM(st.No_Of_Items) + SUM(so.Quantity_out) AS TotalStock,
    pr.Product_ceiling - SUM(st.No_Of_Items) + SUM(so.Quantity_out) AS Needed
    FROM
    tblstocks AS st
    LEFT JOIN tblstockout AS so
    ON
    so.StockId = st.StockId
    INNER JOIN tblproducts AS pr
    ON
    pr.id = st.ProductId
    INNER JOIN tblsuppliers AS sup
    ON
    sup.Supplier_id = st.Product_supplier
    WHERE
    st.Deleted = 'NO'
    GROUP BY
    st.ProductId
    ) AS ProductOverView
  ) AS tblme");

}else{

  $prods = $conn->prepare("SELECT
   							    *
    FROM
    (
    SELECT
   							        *,
    IF(
    TotalStock > Product_flooring && TotalStock <= Product_ceiling,
    'Normal',
    IF(
    TotalStock < Product_flooring,
    'Critical',
    IF(
    TotalStock > Product_ceiling,
    'Overstocking',
    'Something Else'
    )
    )
    ) AS 'Status'
    FROM
    (
    SELECT
    pr.id,
    pr.Product_code,
    pr.Product_name,
    pr.Product_flooring,
    pr.Product_ceiling,
    sup.Supplier_name,
    SUM(st.No_Of_Items) + SUM(so.Quantity_out) AS TotalStock,
    pr.Product_ceiling - SUM(st.No_Of_Items) + SUM(so.Quantity_out) AS Needed
    FROM
    tblstocks AS st
    LEFT JOIN tblstockout AS so
    ON
    so.StockId = st.StockId
    INNER JOIN tblproducts AS pr
    ON
    pr.id = st.ProductId
    INNER JOIN tblsuppliers AS sup
    ON
    sup.Supplier_id = st.Product_supplier
    WHERE
    st.Deleted = 'NO'
    GROUP BY
    st.ProductId
    ) AS ProductOverView
    ) AS tblme
    WHERE
    STATUS
    = :stat");
  $prods->bindValue(":stat", $stat);

}

$prods->execute();

echo 
"<thead>
<tr class='headings'>

<th class='column-title'>Product Code</th>
<th class='column-title'>Product Name</th>
<th class='column-title'>Supplier</th>
<th class='column-title'>Flooring</th>
<th class='column-title'>Ceiling</th>
<th class='column-title'>Quantity</th>
<th class='column-title'>Needed</th>

</th>
</tr>
</thead>
<tbody>
";

$counter = 0;

while($r = $prods->fetch()){
 if($counter % 2 == 0){
  echo "<tr class='even pointer'>";
}else{
  echo "<tr class='odd pointer'>";	
}
echo "<td >".$r['Product_code']."</td>";
echo "<td>".$r['Product_name']."</td>";
echo "<td>".$r['Supplier_name']."</td>";
echo "<td>".$r['Product_flooring']."</td>";
echo "<td>".$r['Product_ceiling']."</td>";
echo "<td>".$r['TotalStock']."</td>";
echo "<td>".$r['Needed']."</td>";

echo "</tr>";
}

echo 
"</tbody>";
}



function showStockAdjustment(){

 include '../config/config.php';
 $to1 = strtotime(secure($_POST['enddate']));
 $beginOfDay = strtotime("midnight", $to1);
 $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
 $from = strtotime("midnight", (int)$_POST['startdate']);
 $to = $endOfDay;

/*
 $cats = $conn->prepare("SELECT `CategoryId` , `CategoryName` FROM tblcategories WHERE Deleted='NO'");
 $tcatsrans->bindValue(":start", $from);
 $cats->bindValue(":to", $to);
 $cats->execute();
*/



 $cats = $conn->prepare("SELECT `CategoryId` , `CategoryName` FROM tblcategories WHERE Deleted='NO'");
 $cats->bindValue(":start", $from);
 $cats->bindValue(":to", $to);
 $cats->execute();


 while($r = $cats->fetch()){
  $CategoryName = $r['CategoryName'];
  $CategoryId = $r['CategoryId'];
  $stmt = $conn->prepare("SELECT
    pr.Product_name, 
    ad.`quantity`,
    ad.`remarks`,
    ad.`supplier_price`,
    ad.`markup`,
    ad.`dateadjusted`,
    ad.`Status`
    FROM
    `tbladjustment` as ad
    INNER JOIN tblproducts as pr 
    ON pr.id = ad.`product_id`
    INNER JOIN tblcategories as cat 
    ON cat.CategoryId = pr.Product_category
    WHERE cat.CategoryId = :catid");
  $stmt->bindValue(":catid", $CategoryId);
  $stmt->execute();

  $count = $stmt->rowCount();

  if($count > 0){

    echo "<h4>".$CategoryName."</h4>";
    echo "<table>
    <tr>
    <th>Product Name</th>
    <th>Date</th>
    <th>Remarks</th>
    <th>Supplier Price</th>
    <th>Selling Price</th>
    <th>Quantity</th>
    <th>Total</th>
    </tr>";


    $prods = $conn->prepare("SELECT
      pr.id,
      pr.Product_name, 
      ad.`quantity`,
      ad.`remarks`,
      ad.`supplier_price`,
      ad.`markup`,
      ad.`dateadjusted`,
      ad.`Status`
      FROM
      `tbladjustment` as ad
      INNER JOIN tblproducts as pr 
      ON pr.id = ad.`product_id`
      INNER JOIN tblcategories as cat 
      ON cat.CategoryId = pr.Product_category
      WHERE cat.CategoryId = :catid AND dateadjusted >= :start AND dateadjusted <= :to
      ORDER BY pr.Product_name , `dateadjusted` ASC");
    $prods->bindValue(":catid", $CategoryId);
    $prods->bindValue(":start", $from);
    $prods->bindValue(":to", $to);
    $prods->execute();

    $prev = 0;
    $i = 0; 

    $totalQty = 0;
    $totalPrice = 0;

    while($product = $prods->fetch()){
      $prodid = $product['id'];
      if($i == 0)
        $prev = $prodid;

      if($prev != $prodid){
        if($totalQty < 0 ){
          $style = "style='color:red;'";
        }else{
          $style = "style='color:green;'";
        }
        echo "<tr>
        <td colspan='5' id='total'>Total</td>
        <td ".$style.">".$totalQty."</td>
        <td ".$style.">₱ ".number_format($totalPrice, 2, '.', ',')."</td>
        </tr>";

        $i = 0;
        $totalQty = 0;
        $totalPrice = 0;
      }else{
        $i++;
      }
      echo "<tr>";
      echo "<td>".$product['Product_name']."</td>";
      $dateadded = date("F j, Y, g:i a", $product["dateadjusted"]);
      echo "<td >".$dateadded."</td>";

      echo "<td>".$product['remarks']."</td>";
      echo "<td>".$product['supplier_price']."</td>";

      $selling_price = $product['supplier_price'] + ($product['supplier_price'] * ($product['markup'] / 100));
      echo "<td>".$selling_price."</td>";

      $quantity = $product['quantity'];
      if($product['Status'] == 'Deduction'){
        $quantity *= -1;
        echo "<td> ".$quantity."</td>";
      }else{
        echo "<td>+".$quantity."</td>";
      }


      $total = $product['supplier_price'] * $quantity;
      $totalQty += $quantity;
      $totalPrice += $total;

      echo "<td>". $total."</td>";
      echo "</tr>";
    }


    if($totalQty < 0 ){
      $style = "style='color:red;'";
    }else{
      $style = "style='color:green;'";
    }
    echo "<tr>
    <td colspan='5' id='total'>Total</td>
    <td ".$style.">".$totalQty."</td>
    <td ".$style.">₱ ".number_format($totalPrice, 2, '.', ',')."</td>
    </tr>";

    $totalQty = 0;
    $totalPrice = 0;



    echo "</table>";
    echo "<hr>";
    
  }


}

}


?>