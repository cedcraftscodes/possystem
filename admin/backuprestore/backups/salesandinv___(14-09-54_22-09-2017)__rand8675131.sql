

CREATE TABLE `tblcompanyinfo` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `settingkey` varchar(255) NOT NULL,
  `settingvalue` text NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


INSERT INTO tblcompanyinfo VALUES
("1","name","Giga Ohms"),
("2","receiver","Cedric Coloma"),
("3","street","1578 Chico Street Garcia Subdivision"),
("4","city","+639557050742"),
("5","province","icorrelate@gmail.com"),
("6","zipcode","https://www.facebook.com/itcstuts/"),
("7","phone","https://www.facebook.com/itcstuts/"),
("8","email","icorrelate@gmail.com");




CREATE TABLE `tblcustomer` (
  `CustomerId` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerAddress` varchar(150) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  PRIMARY KEY (`CustomerId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `tbllogins` (
  `LoginID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) NOT NULL,
  `LoginDate` int(11) NOT NULL,
  PRIMARY KEY (`LoginID`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;


INSERT INTO tbllogins VALUES
("1","7","1497702609"),
("2","7","1497702628"),
("3","7","1497703127"),
("4","7","1497704668"),
("5","7","1497764879"),
("6","7","1497945991"),
("7","7","1497946074"),
("8","7","1497946191"),
("9","7","1497946222"),
("10","7","1497946275"),
("11","7","1497950210"),
("12","7","1498388759"),
("13","7","1498388985"),
("14","7","1498389412"),
("15","7","1498561653"),
("16","7","1498561694"),
("17","7","1498569950"),
("18","22","1498894414"),
("19","22","1498894563"),
("20","22","1498986364"),
("21","33","1498986501"),
("22","33","1498986518"),
("23","33","1498986592"),
("24","22","1498987654"),
("25","22","1498989751"),
("26","22","1499002763"),
("27","22","1499493646"),
("28","22","1499493921"),
("29","35","1499496006"),
("30","22","1500178510"),
("31","22","1500179530"),
("32","22","1500184539"),
("33","22","1500185519"),
("34","22","1500188503"),
("35","22","1500188577"),
("36","22","1500190168"),
("37","22","1500265444"),
("38","38","1500269782"),
("39","22","1500269847"),
("40","38","1500270022"),
("41","38","1500272321"),
("42","38","1500275274"),
("43","38","1500790928"),
("44","22","1500791923"),
("45","22","1500883165"),
("46","22","1501404942"),
("47","22","1501408886"),
("48","22","1501411621"),
("49","22","1501413171"),
("50","22","1501413405"),
("51","22","1501414034"),
("52","22","1501414459"),
("53","22","1501415607"),
("54","22","1501417342"),
("55","45","1501418565"),
("56","22","1501419223"),
("57","22","1501571893"),
("58","22","1501832257"),
("59","22","1501833010");




CREATE TABLE `tblproducts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Product_brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Product_quantity` int(11) NOT NULL,
  `Product_price` double(15,4) NOT NULL,
  `Product_markup_price` double(15,4) NOT NULL,
  `Product_flooring` int(11) NOT NULL,
  `Product_ceiling` int(11) NOT NULL,
  `Product_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Exp_date` date NOT NULL,
  `Product_supplier` int(255) NOT NULL,
  `Product_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO tblproducts VALUES
("3","Sample product 1","Cedric","1","500.0000","1231.0000","11","123","pcs","9904034855302","0000-00-00","0","Internal Organ","0000-00-00 00:00:00"),
("4","Sample Product 2","Sonic","5","1200.0000","800.0000","1","1","pcs","1311000004134\n\n","2017-07-19","1","wew","2017-07-16 00:00:00");




CREATE TABLE `tbltransaction` (
  `TransId` int(11) NOT NULL AUTO_INCREMENT,
  `TransUserId` int(11) DEFAULT NULL,
  `TransTotal` double(15,4) DEFAULT NULL,
  `TransChange` double(15,4) DEFAULT NULL,
  `TransCash` double(15,4) DEFAULT NULL,
  `TransDate` int(11) DEFAULT NULL,
  `No_Of_Items` int(11) DEFAULT NULL,
  `CustId` int(11) DEFAULT NULL,
  PRIMARY KEY (`TransId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `tbltransproduct` (
  `TransPid` int(11) NOT NULL AUTO_INCREMENT,
  `TransId` int(11) DEFAULT NULL,
  `TransProdId` int(11) DEFAULT NULL,
  `TransProductPrice` double(15,4) DEFAULT NULL,
  `TransProductQuantity` int(11) DEFAULT NULL,
  `TransProductUnit` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`TransPid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `tblunits` (
  `UnitId` int(11) NOT NULL AUTO_INCREMENT,
  `UnitName` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`UnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `tblusers` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(25) NOT NULL,
  `mname` varchar(25) NOT NULL,
  `lname` varchar(25) NOT NULL,
  `user_name` varchar(55) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `pass_word` varchar(55) NOT NULL,
  `acctype` enum('cashier','admin','','') NOT NULL,
  `deleted` enum('YES','NO','','') NOT NULL,
  `accimg` varchar(255) NOT NULL,
  `dateadded` int(11) NOT NULL,
  `passchange` enum('1','0') NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;


INSERT INTO tblusers VALUES
("22","Cedric","Yatco","Coloma","icorrelate@gmail.com","male","1997-02-12","ed2b1f468c5f915f3f1cf75d7068baae","admin","NO","images/dp/haha@gmail.com_956709.jpg","234235233","1"),
("38","Cedric","Yatco","Cashier","cashier@gmail.com","female","1997-02-12","ed2b1f468c5f915f3f1cf75d7068baae","cashier","YES","images/dp/haha@gmail.com_956709.jpg","234235233","1");


