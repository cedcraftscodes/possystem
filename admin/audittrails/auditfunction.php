<?php 


if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'showTransactions':
		showTransactions();
		break;
		
		case 'showLoginHistory':
		showLoginHistory();
		break;


		case 'showRestoreHistory':
		showRestoreHistory();
		break;



		case 'showBackupHistory':
		showBackupHistory();
		break;

		case 'showPurchaseOrders':
		showPurchaseOrders();
		break;

		case 'showBadOrders':
		showBadOrders();
		break;


		

		case 'showInventoryLogs':
			showInventoryLogs();
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








function showInventoryLogs(){
include '../config/config.php';

	$pos = $conn->query("SELECT
						    `logid`,
						    pr.Product_name,
						    `quantity`,
						    `action`,
						    `remarks`,
						    CONCAT(us.fname, ' ', us.lname) as 'PreparedBy',
						    `LogDate`
						FROM
						    `tblinventorylogs` as il 
						INNER join tblstocks as st 
						ON st.StockId = il.`stockid`
						INNER JOIN tblproducts as pr 
						on pr.id = st.StockId
						INNER join tblusers as us 
						ON us.userid = il.`userid`");
	echo 
	"<thead>
		<tr class='headings'>
			<th class='column-title'>LogId</th>
			<th class='column-title'>Product_name </th>
			<th class='column-title'>Quantity </th>
			<th class='column-title'>Action </th>
			<th class='column-title'>Remarks</th>
			<th class='column-title'>Prepared By</th>
			<th class='column-title'>Log Date</th>
			</th>
		</tr>
	</thead>
	<tbody>
	";

	$counter = 0;

	while($r = $pos->fetch()){
		if($counter % 2 == 0){
			echo "<tr class='even pointer'>";
		}else{
			echo "<tr class='odd pointer'>";	
		}
        echo "<td class=''>".$r['logid']."</td>";
        echo "<td class=''>".$r['Product_name']."</td>";
        echo "<td class=''>".$r['quantity']."</td>";
        echo "<td class=''>".$r['action']."</td>";

        echo "<td class=''>".$r['remarks']."</td>";
        echo "<td class=''>".$r['PreparedBy']."</td>";
        $dateadded = date("F j, Y, g:i a", $r["LogDate"]);
        echo "<td class=''>".$dateadded."</td>";
        echo "</tr>";
	}
	echo 
	"</tbody>";
}


function showBadOrders(){
include '../config/config.php';

	$pos = $conn->query("SELECT
		`badorder_id`,
		pr.Product_name,
		sup.Supplier_name,
		`supplier_price`,
		`quantity`,
		`remarks`,
		bo.`dateadded`,
		`Status`, 
		CONCAT(us.fname, ' ', us.lname) as 'PreparedBy'
		FROM
		`tblbadorders` as bo 
		INNER JOIN tblproducts as pr 
		ON bo.`product_id` = pr.id
		INNER JOIN tblsuppliers as sup 
		ON sup.Supplier_id = bo.`supplier_id`
		INNER JOIN tblusers as us 
		ON us.userid = bo.`preparedby`
		ORDER BY `badorder_id` DESC");
	echo 
	"<thead>
		<tr class='headings'>
			<th class='column-title'>BO ID</th>
			<th class='column-title'>Supplier Name </th>
			<th class='column-title'>Product Name </th>
			<th class='column-title'>Remarks </th>
			<th class='column-title'>Prepared By</th>
			<th class='column-title'>Date Prepared </th>
			</th>
		</tr>
	</thead>
	<tbody>
	";

	$counter = 0;

	while($r = $pos->fetch()){
		if($counter % 2 == 0){
			echo "<tr class='even pointer'>";
		}else{
			echo "<tr class='odd pointer'>";	
		}
        echo "<td class=''>".$r['badorder_id']."</td>";
        echo "<td class=''>".$r['Supplier_name']."</td>";
        echo "<td class=''>".$r['Product_name']."</td>";
        echo "<td class=''>".$r['remarks']."</td>";

        echo "<td class=''>".$r['PreparedBy']."</td>";
        $dateadded = date("F j, Y, g:i a", $r["dateadded"]);
        echo "<td class=''>".$dateadded."</td>";
        echo "</tr>";
	}
	echo 
	"</tbody>";
}


function showPurchaseOrders(){
include '../config/config.php';

	$pos = $conn->query("SELECT
						    `Po_number`, 
						    sup.Supplier_name,
						    (SELECT CONCAT(tblusers.fname, ' ', tblusers.lname) FROM tblusers WHERE tblusers.userid = po.`PreparedBy_id`) as 'PreparedBy',
						    (SELECT CONCAT(tblusers.fname, ' ', tblusers.lname) FROM tblusers WHERE tblusers.userid = po.`Checked_By`) as 'CheckedBy', 
						    DatePrepared,
						    `Status`
						    
						FROM
						    `tblpurchaseorders`as po 
						INNER JOIN tblsuppliers as sup 
						ON sup.Supplier_id = po.`Supplier_id`");
	echo 
	"<thead>
		<tr class='headings'>
			<th class='column-title'>PO Number</th>
			<th class='column-title'>Supplier Name </th>
			<th class='column-title'>Prepared By </th>
			<th class='column-title'>Checked By </th>
			<th class='column-title'>Date Prepared </th>
			<th class='column-title'>Status </th>
			</th>
		</tr>
	</thead>
	<tbody>
	";

	$counter = 0;

	while($r = $pos->fetch()){
		if($counter % 2 == 0){
			echo "<tr class='even pointer'>";
		}else{
			echo "<tr class='odd pointer'>";	
		}
        echo "<td class=''>".$r['Po_number']."</td>";
        echo "<td class=''>".$r['Supplier_name']."</td>";
        echo "<td class=''>".$r['PreparedBy']."</td>";
        echo "<td class=''>".$r['CheckedBy']."</td>";

        $dateadded = date("F j, Y, g:i a", $r["DatePrepared"]);
        echo "<td class=''>".$dateadded."</td>";
        echo "<td class=''>".$r['Status']."</td>";
        echo "</tr>";
	}
	echo 
	"</tbody>";
}


function showBackupHistory(){
include '../config/config.php';

	$trans = $conn->query("SELECT bc.`BackupId`,  bc.`BackupDate`, bc.`Remarks` , CONCAT(us.fname, ' ', us.lname) as 'AccountName'
							FROM `tblbackups` as bc
							INNER JOIN tblusers as us 
							on us.userid = bc.`UserId`
							ORDER BY `BackupId` DESC");
	echo 
	"<thead>
		<tr class='headings'>
			<th class='column-title'>Backup ID</th>
			<th class='column-title'>Account Name </th>
			<th class='column-title'>Backup Remark </th>
			<th class='column-title'>Backup Date </th>
			</th>
		</tr>
	</thead>
	<tbody>
	";

	$counter = 0;

	while($r = $trans->fetch()){
		if($counter % 2 == 0){
			echo "<tr class='even pointer'>";
		}else{
			echo "<tr class='odd pointer'>";	
		}

        echo "<td class=''>".$r['BackupId']."</td>";
        echo "<td class=''>".$r['AccountName']."</td>";
        echo "<td class=''>".$r['Remarks']."</td>";
        $dateadded = date("F j, Y, g:i a", $r["BackupDate"]);
        echo "<td class=''>".$dateadded."</td>";
        echo "</tr>";
	}
	echo "</tbody>";
}


function showRestoreHistory(){
include '../config/config.php';

	$rest = $conn->query("SELECT rs.`RestoreId`, rs.`RestoreDate` , rs.`Remarks`, CONCAT(us.`fname`, ' ', us.`lname`) as 'UserAccount', bc.`Remarks` as 'BcRemarks'
	FROM `tblrestore` as rs 
	INNER JOIN tblbackups as bc 
	on bc.BackupId = rs.`BackupId`
	INNER JOIN tblusers as us 
	on us.userid = rs.`UserId`
		ORDER BY rs.`RestoreId` DESC");

	
	echo 
	"<thead>
		<tr class='headings'>
			<th class='column-title'>Restore ID</th>
			<th class='column-title'>Account Name </th>
			<th class='column-title'>Backup Remark </th>
			<th class='column-title'>Restore Remarks </th>
			<th class='column-title'>Restore Date </th>
			</th>
		</tr>
	</thead>
	<tbody>
	";
	
	$counter = 0;

	while($r = $rest->fetch()){
		if($counter % 2 == 0){
			echo "<tr class='even pointer'>";
		}else{
			echo "<tr class='odd pointer'>";	
		}

        echo "<td class=''>".$r['RestoreId']."</td>";
        echo "<td class=''>".$r['UserAccount']."</td>";
        echo "<td class=''>".$r['BcRemarks']."</td>";
		echo "<td class=''>".$r['Remarks']."</td>";

        $dateadded = date("F j, Y, g:i a", $r["RestoreDate"]);

        echo "<td class=''>".$dateadded."</td>";
        echo "</tr>";
	}


	echo 
	"</tbody>";
}



function showLoginHistory(){
include '../config/config.php';

	$trans = $conn->query("SELECT lg.`LoginID`, 
		CONCAT(us.fname, ' ', us.mname, ' ', us.lname) as 'AccountName', 
		lg.`LoginDate` 
		FROM `tbllogins` as lg
		INNER JOIN tblusers as us 
		ON us.userid = lg.`AccountID`
		ORDER BY lg.`LoginID` DESC");


	echo 
	"<thead>
		<tr class='headings'>
			<th class='column-title'>Login ID</th>
			<th class='column-title'>Account Holder </th>
			<th class='column-title'>Login Date </th>
			</th>
		</tr>
	</thead>
	<tbody>
	";

	$counter = 0;

	while($r = $trans->fetch()){
		if($counter % 2 == 0){
			echo "<tr class='even pointer'>";
		}else{
			echo "<tr class='odd pointer'>";	
		}

        echo "<td class=''>".$r['LoginID']."</td>";
        echo "<td class=''>".$r['AccountName']."</td>";
        $dateadded = date("F j, Y, g:i a", $r["LoginDate"]);

        echo "<td class=''>".$dateadded."</td>";
        echo "</tr>";
	}


	echo 
	"</tbody>";




}

function showTransactions()
{
	include '../config/config.php';

	$trans = $conn->query("SELECT tr.`TransId`, 
		cs.CustomerName, 
		tr.`TransTotal`, 
		tr.`No_Of_Items`, 
		CONCAT(us.fname, ' ', us.lname) as 'Cashier', 
		tr.`TransDate` 
		FROM `tbltransaction` as tr 
		INNER JOIN tblcustomer as cs
		ON cs.CustomerId = tr.`CustId`
		INNER JOIN tblusers as us 
		ON us.userid = tr.`TransUserId`");


	echo 
	"<thead>
		<tr class='headings'>
			<th class='column-title'>Transaction ID </th>
			<th class='column-title'>Customer Name </th>
			<th class='column-title'>Total </th>
			<th class='column-title'>No of Items </th>
			<th class='column-title'>Cashier </th>
			<th class='column-title'>Transaction Date </th>
			</th>
		</tr>
	</thead>
	<tbody>
	";

	$counter = 0;

	while($r = $trans->fetch()){
		if($counter % 2 == 0){
			echo "<tr class='even pointer'>";
		}else{
			echo "<tr class='odd pointer'>";	
		}

        echo "<td class=''>".$r['TransId']."</td>";
        echo "<td class=''>".$r['CustomerName']."</td>";
        echo "<td class=''>₱ ".number_format($r['TransTotal'], 2, '.', ',')."</td>";
        echo "<td class=''>".$r['No_Of_Items']."</td>";
        echo "<td class=''>".$r['Cashier']."</td>";

        $dateadded = date("F j, Y, g:i a", $r["TransDate"]);

        echo "<td class=''>".$dateadded."</td>";
        echo "</tr>";
	}


	echo 
	"</tbody>";


}


?>