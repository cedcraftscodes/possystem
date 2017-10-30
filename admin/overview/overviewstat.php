<?php


if (session_id()) {
} else {
    session_start();
}

if (isset($_POST['action']) && !empty($_POST['action'])) {
    
    $action = $_POST['action'];
    switch ($action) {
        
        case 'topTransactionToday':
            topTransactionToday();
        break;
        case 'topProductsToday':
            topProductsToday();
        break;
        case 'showOverviewStatusToday':
            showOverviewStatusToday();
        break;        

        case 'topTransactionAllTime':
            topTransactionAllTime();
        break;
        case 'topProductsAllTime':
            topProductsAllTime();
        break;
        case 'showOverviewStatusAllTime':
            showOverviewStatusAllTime();
        break;   




        default:
            # code...
            break;
    }
}


function secure($str)
{
    return strip_tags(trim(htmlspecialchars($str)));
}

function ContainsNumbers($String)
{
    return preg_match('/\\d/', $String) > 0;
}

function topTransactionToday()
{
    include '../config/config.php';
    
    $time = time();
   	$beginOfDay = strtotime("midnight", $time);
	$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

    $toptr = $conn->prepare("
							SELECT
							    `TransNo`,
							    cs.CustomerName,
							    tr.`TransTotal`,
							    CONCAT(us.fname, ' ', us.lname) AS 'Cashier',
							    tr.`TransDate`
							FROM
							    `tbltransaction` AS tr
							INNER JOIN tblcustomer AS cs
							ON
							    cs.CustomerId = tr.`CustId`
							INNER JOIN tblusers AS us
							
							ON
							    us.userid = tr.`TransUserId`
							WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to
							ORDER BY
							    tr.`TransTotal`
							DESC
							LIMIT 5");

   	$toptr->bindValue(":start",	$beginOfDay);
   	$toptr->bindValue(":to", $endOfDay);
   	$toptr->execute();

	$counter = 0;
	$rank = 1;


	while($r = $toptr->fetch()){
		if($counter % 2 == 0){
			echo "<tr class='even pointer'>";
		}else{
			echo "<tr class='odd pointer'>";	
		}
        echo "<td class=''>".$rank."</td>";
        echo "<td class=''>".$r['TransNo']."</td>";
        echo "<td class=''>".$r['CustomerName']."</td>";
        echo "<td class=''>".$r['Cashier']."</td>";
        echo "<td class=''>₱ ".number_format($r['TransTotal'], 2,".",",")."</td>";
        $dateadded = date("F j, Y, g:i a", $r["TransDate"]);
        echo "<td class=''>".$dateadded."</td>";
        echo "</tr>";

        $counter++;
        $rank++;
	}
	echo 
	"</tbody>";
}



function topProductsToday()
{
    include '../config/config.php';
    $time = time();
   	$beginOfDay = strtotime("midnight", $time);
	$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;


    $topr = $conn->prepare("SELECT 
							pr.Product_name,
							SUM(tp.TransProductPrice * tp.TransProductQuantity) as 'SalesAmount',
							SUM(tp.TransProductQuantity) as 'SalesCount',
							cat.CategoryName
							FROM `tbltransaction` as tr 
							INNER JOIN tbltransproduct as tp
							ON tp.TransId = tr.`TransId`
							INNER join tblproducts as pr 
							ON pr.id = tp.TransProdId
							INNER join tblcategories as cat 
							ON cat.CategoryId = pr.Product_category
							WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to
							GROUP  BY pr.id
							ORDER BY SalesAmount DESC

							LIMIT 5");
    $topr->bindValue(":start",	$beginOfDay);
   	$topr->bindValue(":to", $endOfDay);
   	$topr->execute();

    while ($r = $topr->fetch()) {
    	$prodName = $r["Product_name"];
    	$sales = $r["SalesAmount"];
    	$category = $r["CategoryName"];
    	$salecount = $r["SalesCount"];

        echo "<li class='media event'>
              <a class='pull-left border-aero profile_thumb'>
                <i class='fa fa-shopping-basket aero'></i>
              </a>
              <div class='media-body'>
                <a class='title' >".$prodName."</a>
                <p><strong>".number_format($sales, 2,".",",").". </strong> ".$category."</p>
                <p> <small>".$salecount." Sales Today</small>
                </p>
              </div>
            </li>";
    }
}


function showOverviewStatusToday()
{
    include '../config/config.php';
    $time = time();
   	$beginOfDay = strtotime("midnight", $time);
	$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
	

    $stmt = $conn->prepare("SELECT SUM(`TransProductQuantity`) as 'ProdCount' FROM tbltransproduct as tpr 
		INNER JOIN tbltransaction as tr 
		ON tr.TransId = tpr.TransId
		WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $pc  = $row['ProdCount'];



    $stmt = $conn->prepare("SELECT SUM(`TransTotal`) as 'TotalSales' FROM `tbltransaction` as tr
		WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $ts  = $row['TotalSales'];



	$stmt = $conn->prepare("SELECT COUNT(`Transid`) as 'TransactionCount' FROM `tbltransaction` as tr
		WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $tcount  = $row['TransactionCount'];

   	
   	$stmt = $conn->prepare("SELECT COUNT(`CustomerId`) as 'CustomerCount' FROM `tblcustomer` as tr
		WHERE DateAdded >= :start AND DateAdded <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $ccount  = $row['CustomerCount'];

    $stmt = $conn->prepare("SELECT COUNT(`Pod_id`) as 'DeliveryCount' FROM `tblpodeliveries` 
		WHERE `DateDelivered` >= :start AND `DateDelivered` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $dcount  = $row['DeliveryCount'];

	$stmt = $conn->prepare("SELECT SUM(`Quantity_Delivered`) as 'TPD' FROM `tblpodel_items` as ppod 
		INNER JOIN tblpodeliveries as pod 
		ON pod.Pod_id = ppod.`Pod_id`
		WHERE pod.`DateDelivered` >= :start AND pod.`DateDelivered` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $tpd  = $row['TPD'];

    
    echo json_encode(array(
        "ProdCount" => (int) $pc,
        "TotalSales" => number_format($ts, 2, '.', ''),
        "TransactionCount" => (int) $tcount,
        "CustomerCount" => (int)$ccount,
        "DeliveryCount" => (int)$dcount,
        "ProductsDelivered" => (int)$tpd,
    ));
}







function topTransactionAllTime()
{
    include '../config/config.php';
    
    $time = time();
    $beginOfDay = 0;
    $endOfDay   = $time;

    $toptr = $conn->prepare("
                            SELECT
                                `TransNo`,
                                cs.CustomerName,
                                tr.`TransTotal`,
                                CONCAT(us.fname, ' ', us.lname) AS 'Cashier',
                                tr.`TransDate`
                            FROM
                                `tbltransaction` AS tr
                            INNER JOIN tblcustomer AS cs
                            ON
                                cs.CustomerId = tr.`CustId`
                            INNER JOIN tblusers AS us
                            
                            ON
                                us.userid = tr.`TransUserId`
                            WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to
                            ORDER BY
                                tr.`TransTotal`
                            DESC
                            LIMIT 5");

    $toptr->bindValue(":start", $beginOfDay);
    $toptr->bindValue(":to", $endOfDay);
    $toptr->execute();

    $counter = 0;
    $rank = 1;


    while($r = $toptr->fetch()){
        if($counter % 2 == 0){
            echo "<tr class='even pointer'>";
        }else{
            echo "<tr class='odd pointer'>";    
        }
        echo "<td class=''>".$rank."</td>";
        echo "<td class=''>".$r['TransNo']."</td>";
        echo "<td class=''>".$r['CustomerName']."</td>";
        echo "<td class=''>".$r['Cashier']."</td>";
        echo "<td class=''>₱ ".number_format($r['TransTotal'], 2, '.', ',')."</td>";
        $dateadded = date("F j, Y, g:i a", $r["TransDate"]);
        echo "<td class=''>".$dateadded."</td>";
        echo "</tr>";

        $counter++;
        $rank++;
    }
    echo 
    "</tbody>";
}





function topProductsAllTime()
{
    include '../config/config.php';
    $time = time();
    $beginOfDay = 0;
    $endOfDay   = time();


    $topr = $conn->prepare("SELECT 
                            pr.Product_name,
                            SUM(tp.TransProductPrice * tp.TransProductQuantity) as 'SalesAmount',
                            SUM(tp.TransProductQuantity) as 'SalesCount',
                            cat.CategoryName
                            FROM `tbltransaction` as tr 
                            INNER JOIN tbltransproduct as tp
                            ON tp.TransId = tr.`TransId`
                            INNER join tblproducts as pr 
                            ON pr.id = tp.TransProdId
                            INNER join tblcategories as cat 
                            ON cat.CategoryId = pr.Product_category
                            WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to
                            GROUP  BY pr.id
                            ORDER BY SalesAmount DESC

                            LIMIT 5");
    $topr->bindValue(":start",  $beginOfDay);
    $topr->bindValue(":to", $endOfDay);
    $topr->execute();

    while ($r = $topr->fetch()) {
        $prodName = $r["Product_name"];
        $sales = $r["SalesAmount"];
        $category = $r["CategoryName"];
        $salecount = $r["SalesCount"];

        echo "<li class='media event'>
              <a class='pull-left border-aero profile_thumb'>
                <i class='fa fa-shopping-basket aero'></i>
              </a>
              <div class='media-body'>
                <a class='title' >".$prodName."</a>
                <p><strong>".number_format($sales, 2,".",",").". </strong> ".$category."</p>
                <p> <small>".$salecount." Sales All Time</small>
                </p>
              </div>
            </li>";
    }
}


function showOverviewStatusAllTime()
{
    include '../config/config.php';
    $time = time();
    $beginOfDay = 0;
    $endOfDay   = time();
    

    $stmt = $conn->prepare("SELECT SUM(`TransProductQuantity`) as 'ProdCount' FROM tbltransproduct as tpr 
        INNER JOIN tbltransaction as tr 
        ON tr.TransId = tpr.TransId
        WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $pc  = $row['ProdCount'];



    $stmt = $conn->prepare("SELECT SUM(`TransTotal`) as 'TotalSales' FROM `tbltransaction` as tr
        WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $ts  = $row['TotalSales'];



    $stmt = $conn->prepare("SELECT COUNT(`Transid`) as 'TransactionCount' FROM `tbltransaction` as tr
        WHERE tr.`TransDate` >= :start AND tr.`TransDate` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $tcount  = $row['TransactionCount'];

    
    $stmt = $conn->prepare("SELECT COUNT(`CustomerId`) as 'CustomerCount' FROM `tblcustomer` as tr
        WHERE DateAdded >= :start AND DateAdded <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $ccount  = $row['CustomerCount'];

    $stmt = $conn->prepare("SELECT COUNT(`Pod_id`) as 'DeliveryCount' FROM `tblpodeliveries` 
        WHERE `DateDelivered` >= :start AND `DateDelivered` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $dcount  = $row['DeliveryCount'];

    $stmt = $conn->prepare("SELECT SUM(`Quantity_Delivered`) as 'TPD' FROM `tblpodel_items` as ppod 
        INNER JOIN tblpodeliveries as pod 
        ON pod.Pod_id = ppod.`Pod_id`
        WHERE pod.`DateDelivered` >= :start AND pod.`DateDelivered` <= :to");
    $stmt->bindParam(':start', $beginOfDay, PDO::PARAM_INT);
    $stmt->bindParam(':to', $endOfDay, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $tpd  = $row['TPD'];

    
    echo json_encode(array(
        "ProdCount" => (int) $pc,
        "TotalSales" => number_format($ts, 2, '.', ''),
        "TransactionCount" => (int) $tcount,
        "CustomerCount" => (int)$ccount,
        "DeliveryCount" => (int)$dcount,
        "ProductsDelivered" => (int)$tpd,
    ));
}




?>