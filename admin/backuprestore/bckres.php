<?php 
if(session_id()){}else{session_start();}

if(isset($_POST['action']) && !empty($_POST['action']))
{

	$action = $_POST['action'];
	switch ($action) {
		case 'loadbackups':
		loadbackups();
		break;


		case 'showBackupInfo':
		showBackupInfo();
		break;


		case 'restoreact':
		restoreact();
		break;




		case 'startbackup':
		startbackup();
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



function restoreact(){

	$pass = md5(secure($_POST['password']));
	$backupId = secure($_POST['cbobackupVal']);
	$remarks = secure($_POST['remarks']);
	$time = time();

	include '../config/config.php';

	$stmt = $conn->prepare("SELECT * FROM `tblusers` WHERE `userid`=:id");
	$stmt->bindParam(':id',$_SESSION['acc_id']);
	$stmt->execute(); 
	$row = $stmt->fetch();

	$passInDb = $row['pass_word'];


	   //check if password input is the same!
   //Do not proceed if incorrect
	if($passInDb != $pass){

	}
	else
	{

		//Get filename
		$stmt = $conn->prepare("SELECT BackupFile FROM `tblbackups` WHERE `BackupId`=:id");
		$stmt->bindParam(':id',$backupId);
		$stmt->execute(); 
		$row = $stmt->fetch();


		$filenameBb = $row['BackupFile'];


		if(isset($_POST['chkbackup'])){
	   		//BAckup database first if checkbox is ticked 
			$mysqlUserName      = "root";
			$mysqlPassword      = "";
			$mysqlHostName      = "localhost";
			$DbName             = "salesandinv";
			$backup_name        = "mybackup.sql";
			$tables             = "*";


			$filename = Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  array("tblcompanyinfo","tblcustomer","tbllogins", "tblproducts", "tbltransaction", "tbltransproduct", "tblunits", "tblcategories", "tblinventorylogs", "tblpodeliveries", "tblpodel_items", "tblpo_items", "tblproducts", "tblpurchaseorders","tblstockout","tblstocks","tblsuppliers","tblusers", "tblbadorders", "tblrefunds", "tblwrongtries"), $backup_name=false );
			$remarksBck = "Backup before restoring: ".$filename." at ". date("F j, Y, g:i a", $time);


	   		// prepare sql and bind parameters
			$stmt = $conn->prepare("INSERT INTO `tblbackups`( `BackupFile`, `BackupDate`, `UserId`, `Remarks`) 
				VALUES (:fn, :bckdate, :id, :rem)");
			$stmt->bindParam(':id', $_SESSION['acc_id']);
			$stmt->bindParam(':fn', $filename);
			$stmt->bindParam(':bckdate', $time);
			$stmt->bindParam(':rem', $remarksBck);
			$stmt->execute();




		}


		/* Drop the database */
		$mysqli = new mysqli("localhost", "root", "", "salesandinv");
		$mysqli->query('SET foreign_key_checks = 0');
		if ($result = $mysqli->query("SHOW TABLES"))
		{
			while($row = $result->fetch_array(MYSQLI_NUM))
			{
				if($row[0] != "tblbackups" && $row[0] != "tblrestore" && $row[0] != "tblusers"){
					$mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
				}

			}
		}

		$mysqli->query('SET foreign_key_checks = 1');
		$mysqli->close();

		$file = "backups/".$filenameBb; 

		$myfile = fopen($file, "r") or die("Unable to open file!");
		$args =  fread($myfile,filesize($file));
		fclose($myfile);
		$result = mysqli_import_sql( $args, 'localhost',  'root', '', 'salesandinv');


	   		// prepare sql and bind parameters
		$stmt = $conn->prepare("INSERT INTO `tblrestore`(`BackupId`, `RestoreDate`, `UserId`, `Remarks`) VALUES 
			(:bckid, :resdate, :id, :rem)");
		$stmt->bindParam(':id', $_SESSION['acc_id']);
		$stmt->bindParam(':bckid', $backupId);
		$stmt->bindParam(':resdate', $time);
		$stmt->bindParam(':rem', $remarks);
		$stmt->execute();





	}





















	   // import


}



function mysqli_import_sql( $args , $dbhost, $dbuser, $dbpass ,$dbname ) {



     // check mysqli extension installed
	if( ! function_exists('mysqli_connect') ) {
		die(' This scripts need mysql extension to be running properly ! please resolve!!');
	}
	$mysqli = @new mysqli( $dbhost, $dbuser, $dbpass, $dbname );
	if( $mysqli->connect_error ) {
		print_r( $mysqli->connect_error );
		return false;
	}
	$querycount = 11;
	$queryerrors = '';
	$lines = (array) $args;
	if( is_string( $args ) ) {
		$lines =  array( $args ) ;
	}
	if ( ! $lines ) {
		return '' . 'cannot execute ' . $args;
	}
	$scriptfile = false;
	foreach ($lines as $line) {
		$line = trim( $line );
         // if have -- comments add enters
		if (substr( $line, 0, 2 ) == '--') {
			$line = "\n" . $line;
		}
		if (substr( $line, 0, 2 ) != '--') {
			$scriptfile .= ' ' . $line;
			continue;
		}
	}
	$queries = explode( ';', $scriptfile );
	foreach ($queries as $query) {
		$query = trim( $query );
		++$querycount;
		if ( $query == '' ) {
			continue;
		}
		if ( ! $mysqli->query( $query ) ) {
			$queryerrors .= '' . 'Line ' . $querycount . ' - ' . $mysqli->error . '<br>';
			continue;
		}
	}
	if ( $queryerrors ) {
		//return '' . 'There was an error on File: ' . $filename . '<br>' . $queryerrors;
	}

	if( $mysqli && ! $mysqli->error ) {
		@$mysqli->close();
	}   
	return 'complete dumping database !';
}





function Export_Database($host,$user,$pass,$name,  $tables=false, $backup_name=false ){
	$mysqli = new mysqli($host,$user,$pass,$name); 
	$mysqli->select_db($name); 
	$mysqli->query("SET NAMES 'utf8'");

	$queryTables    = $mysqli->query('SHOW TABLES'); 
	while($row = $queryTables->fetch_row()) 
	{ 
		$target_tables[] = $row[0]; 
	}   
	if($tables !== false) 
	{ 
		$target_tables = array_intersect( $target_tables, $tables); 
	}
	foreach($target_tables as $table)
	{
		$result         =   $mysqli->query('SELECT * FROM '.$table);  
		$fields_amount  =   $result->field_count;  
		$rows_num=$mysqli->affected_rows;     
		$res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
		$TableMLine     =   $res->fetch_row();
		$content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

		for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
		{
			while($row = $result->fetch_row())  
                   { //when started (and every after 100 command cycle):
                   	if ($st_counter%100 == 0 || $st_counter == 0 )  
                   	{
                   		$content .= "\nINSERT INTO ".$table." VALUES";
                   	}
                   	$content .= "\n(";
                   	for($j=0; $j<$fields_amount; $j++)  
                   	{ 
                   		$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                   		if (isset($row[$j]))
                   		{
                   			$content .= '"'.$row[$j].'"' ; 
                   		}
                   		else 
                   		{   
                   			$content .= '""';
                   		}     
                   		if ($j<($fields_amount-1))
                   		{
                   			$content.= ',';
                   		}      
                   	}
                   	$content .=")";
                       //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                   	if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                   	{   
                   		$content .= ";";
                   	} 
                   	else 
                   	{
                   		$content .= ",";
                   	} 
                   	$st_counter=$st_counter+1;
                   }
               } $content .="\n\n\n";
           }
           $backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
           //$backup_name = $backup_name ? $backup_name : $name.".sql";
           
           /*
           header('Content-Type: application/octet-stream');   
           header("Content-Transfer-Encoding: Binary"); 
           header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
           echo $content; exit;
   	*/

           $myfile = fopen("backups/".$backup_name, "w") or die("Unable to open file!");
           fwrite($myfile, $content);


           return $backup_name;


       }

       function startbackup(){
       	include '../config/config.php';

       	$mysqlUserName      = "root";
       	$mysqlPassword      = "";
       	$mysqlHostName      = "localhost";
       	$DbName             = "salesandinv";
       	$backup_name        = "mybackup.sql";
       	$tables             = "*";


       	$filename = Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  array("tblcompanyinfo","tblcustomer","tbllogins", "tblproducts", "tbltransaction", "tbltransproduct", "tblunits", "tblcategories", "tblinventorylogs", "tblpodeliveries", "tblpodel_items", "tblpo_items", "tblproducts", "tblpurchaseorders","tblstockout","tblstocks","tblsuppliers","tblusers", "tblbadorders", "tblrefunds", "tblwrongtries"), $backup_name=false );
       	$remarks = secure($_POST['txtremarks']);
       	$time = time();
       	    // prepare sql and bind parameters
       	$stmt = $conn->prepare("INSERT INTO `tblbackups`( `BackupFile`, `BackupDate`, `UserId`, `Remarks`) VALUES (:filename, :bckdate, :id, :remarks)");
       	$stmt->bindParam(':id', $_SESSION['acc_id']);
       	$stmt->bindParam(':filename', $filename);
       	$stmt->bindParam(':bckdate', $time);
       	$stmt->bindParam(':remarks', $remarks);
       	$stmt->execute();
       }



       function loadbackups(){
       	include '../config/config.php';

       	$bcks = $conn->query("SELECT * FROM `tblbackups`");
       	while($r = $bcks->fetch()){
       		echo "<option value='".$r['BackupId']."'>".$r['BackupFile']."</option>";
       	}
       }


       function showBackupInfo()
       {
       	include '../config/config.php';
       	$id = $_POST['id'];

       	$stmt = $conn->prepare("SELECT * FROM `tblbackups` WHERE `BackupId`=:id");
       	$stmt->bindParam(':id',$id);
       	$stmt->execute(); 
       	$row = $stmt->fetch();

       	$name = $row['BackupFile'];
       	$remarks = $row['Remarks'];
       	$date = date("F j, Y, g:i a", $row["BackupDate"]);

       	echo json_encode(array(
       		"name" => $name, 
       		"remarks" => $remarks, 
       		"date" => $date
       		));

       }	



       ?>