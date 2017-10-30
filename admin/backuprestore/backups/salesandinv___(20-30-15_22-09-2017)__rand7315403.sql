

CREATE TABLE `tblbadorders` (
  `badorder_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `preparedby` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier_price` double(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `dateadded` int(11) NOT NULL,
  `Status` varchar(120) NOT NULL,
  PRIMARY KEY (`badorder_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO tblbadorders VALUES
("1","2","22","4","120.00","0","Cracked PVC Pipe","1506080512","Completed"),
("2","1","22","1","180.00","0","","1506081776","Completed");




CREATE TABLE `tblcategories` (
  `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(255) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


INSERT INTO tblcategories VALUES
("1","Lightings","NO"),
("2","Plumbing","NO"),
("3","Tools","NO");




CREATE TABLE `tblcompanyinfo` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `settingkey` varchar(255) NOT NULL,
  `settingvalue` text NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


INSERT INTO tblcompanyinfo VALUES
("1","name","Chukuloo"),
("2","receiver","Cedric Coloma"),
("3","street","1578 Chico Street Garcia Subdivision"),
("4","city","Binan"),
("5","province","Laguna"),
("6","zipcode","4024"),
("7","phone","09184481097"),
("8","email","icorrelate@gmail.com"),
("9","voidcode","244161004191");




CREATE TABLE `tblcustomer` (
  `CustomerId` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerAddress` varchar(150) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  PRIMARY KEY (`CustomerId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO tblcustomer VALUES
("1","Chloe Reyes","Zapote Road","1506081186"),
("2","Cedric Coloma","Not Set","1506081524");




CREATE TABLE `tblinventorylogs` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `stockid` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `userid` int(11) NOT NULL,
  `LogDate` int(11) NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


INSERT INTO tblinventorylogs VALUES
("1","1","50","Stock Out","Product Stock Out","22","1506079549"),
("2","1","39","Stock Out","Product Stock Out","22","1506079845"),
("3","1","10","Stock Out","Product Stock Out","22","1506080802"),
("4","1","10","Stock Out","Product Stock Out","22","1506080802"),
("5","1","10","Sales","Stocks Outside Diminished #1506080629","22","1506081186"),
("6","1","1","Sales","Stocks Outside Diminished #1506081186","22","1506081524"),
("7","1","5","Sales","Stocks Outside Diminished #","22","1506081776");




CREATE TABLE `tbllogins` (
  `LoginID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) NOT NULL,
  `LoginDate` int(11) NOT NULL,
  PRIMARY KEY (`LoginID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


INSERT INTO tbllogins VALUES
("1","22","1506073396"),
("2","22","1506074178"),
("3","22","1506078473"),
("4","22","1506078522"),
("5","52","1506078592"),
("6","22","1506082104"),
("7","52","1506082249"),
("8","53","1506082609"),
("9","22","1506082774");




CREATE TABLE `tblpo_items` (
  `Poitem_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_id` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity_Requested` int(11) DEFAULT NULL,
  PRIMARY KEY (`Poitem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO tblpo_items VALUES
("1","1","2","30"),
("2","2","2","30");




CREATE TABLE `tblpodel_items` (
  `del_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `Pod_id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `SupplierPrice` double DEFAULT NULL,
  `Quantity_Delivered` int(11) DEFAULT NULL,
  PRIMARY KEY (`del_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO tblpodel_items VALUES
("1","2","2","120","5"),
("2","3","2","120","25");




CREATE TABLE `tblpodeliveries` (
  `Pod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_id` int(11) DEFAULT NULL,
  `ReceivedBy_id` int(11) DEFAULT NULL,
  `DeliveryNumber` varchar(255) NOT NULL,
  `DateDelivered` int(11) DEFAULT NULL,
  PRIMARY KEY (`Pod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


INSERT INTO tblpodeliveries VALUES
("1","2","22","100456","1506080261"),
("2","1","22","100526","1506080362"),
("3","1","22","100457","1506080409");




CREATE TABLE `tblproducts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Product_brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Product_flooring` int(11) NOT NULL,
  `Product_ceiling` int(11) NOT NULL,
  `Product_unit` int(11) NOT NULL,
  `Product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Product_category` int(11) NOT NULL,
  `Product_Description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `Deleted` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO tblproducts VALUES
("1","Flourescent Bulbs","Omni","30","150","1","8850007011149","1","12 Watts Magic Bulb","1506079013","NO"),
("2","PVC Pipe","Sun Shop","50","225","1","2016-00099","2","Transparent PVC Pipe","1506079173","NO"),
("3","Screwdriver Set","Phillips","30","120","1","10000127491","3","31 in 1 Professional Screwdrivers Kit","1506079368","NO");




CREATE TABLE `tblpurchaseorders` (
  `Po_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_number` varchar(255) NOT NULL,
  `Supplier_id` int(11) NOT NULL,
  `PreparedBy_id` int(11) DEFAULT NULL,
  `Checked_By` int(11) NOT NULL,
  `Exp_DeliveryDate` varchar(255) NOT NULL,
  `DatePrepared` int(11) DEFAULT NULL,
  `Status` varchar(255) NOT NULL,
  `deleted` enum('NO','YES') NOT NULL,
  PRIMARY KEY (`Po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO tblpurchaseorders VALUES
("1","1506079879","4","22","52","2017-09-27","1506080089","Completed","NO"),
("2","1506079879","4","22","52","2017-09-27","1506080104","Pending","NO");




CREATE TABLE `tblrefunds` (
  `refundid` int(11) NOT NULL AUTO_INCREMENT,
  `boid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `refunddate` int(11) NOT NULL,
  PRIMARY KEY (`refundid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `tblstockout` (
  `StockOutId` int(11) NOT NULL AUTO_INCREMENT,
  `StockId` int(11) DEFAULT NULL,
  `Quantity_out` int(11) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  `Deleted` enum('NO','YES') NOT NULL,
  PRIMARY KEY (`StockOutId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO tblstockout VALUES
("2","1","4","1506080802","NO");




CREATE TABLE `tblstocks` (
  `StockId` int(11) NOT NULL AUTO_INCREMENT,
  `ProductId` int(11) DEFAULT NULL,
  `No_Of_Items` int(11) DEFAULT NULL,
  `SellingPrice` double DEFAULT NULL,
  `Product_supplier` int(11) NOT NULL,
  `SupplierPrice` double NOT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  `Deleted` enum('NO','YES') NOT NULL,
  PRIMARY KEY (`StockId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


INSERT INTO tblstocks VALUES
("1","1","70","230","1","180","1506079498","NO"),
("2","2","5","0","4","0","1506079679","NO"),
("3","2","5","0","4","120","1506080362","NO"),
("4","2","15","0","4","120","1506080409","NO"),
("5","2","5","230","4","120","1506080535","NO"),
("6","2","5","230","4","120","1506080590","NO"),
("7","1","5","230","1","180","1506081798","NO");




CREATE TABLE `tblsuppliers` (
  `Supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `Supplier_name` varchar(150) DEFAULT NULL,
  `Supplier_co_name` varchar(150) DEFAULT NULL,
  `Supplier_street` varchar(150) DEFAULT NULL,
  `Supplier_city` varchar(150) DEFAULT NULL,
  `Supplier_province` varchar(150) DEFAULT NULL,
  `Supplier_zipcode` varchar(150) DEFAULT NULL,
  `Supplier_contact` varchar(150) DEFAULT NULL,
  `Supplier_email` varchar(55) NOT NULL,
  `AddedBy` int(11) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`Supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


INSERT INTO tblsuppliers VALUES
("1","ABC Electronics","Gigaohms Electronic Center","1578 Chico Street Garcia Subdivision","Santa Rosa","Laguna","4026","09357190233","abcelectronics@gmail.com","22","1506076666","NO"),
("2","Hextech","Gigaohms Electronic Center","1241 Narra Street Garlic Subdivision","Santa Rosa","Laguna","4026","09348104136","hextech@rocketmail.com","22","1506076888","NO"),
("3","Clockworks","Gigaohms Electronic Center","1337 Bark Street Doge Subdivision","Santa Rosa","Laguna","4026","09165133116","clockworkES@gmail.com","22","1506077023","NO"),
("4","Steel Trade","Gigaohms Electronic Center","1998 Jackie Street Chan Subdivision","Santa Rosa","Laguna","4026","09357190238","SteelTrade1@yahoo.com","22","1506077219","NO"),
("5","KYS Signage","Gigaohms Electronic Center","1215 Wanda Street Pass Subdivision","Binan","Laguna","4024","09346190336","KYSsign@gmail.com","22","1506077280","NO");




CREATE TABLE `tbltransaction` (
  `TransId` int(11) NOT NULL AUTO_INCREMENT,
  `TransUserId` int(11) DEFAULT NULL,
  `TransNo` varchar(255) NOT NULL,
  `TransTotal` double(15,2) DEFAULT NULL,
  `TransChange` double(15,2) DEFAULT NULL,
  `TransCash` double(15,2) DEFAULT NULL,
  `TransDate` int(11) DEFAULT NULL,
  `No_Of_Items` int(11) DEFAULT NULL,
  `CustId` int(11) DEFAULT NULL,
  `TransDiscount` double(15,2) NOT NULL,
  PRIMARY KEY (`TransId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO tbltransaction VALUES
("1","22","1506080629","2250.00","0.00","2250.00","1506081186","10","1","50.00"),
("2","22","1506081186","230.00","270.00","500.00","1506081524","1","2","0.00");




CREATE TABLE `tbltransproduct` (
  `TransPid` int(11) NOT NULL AUTO_INCREMENT,
  `TransId` int(11) DEFAULT NULL,
  `TransProdId` int(11) DEFAULT NULL,
  `TransSupplier` int(11) NOT NULL,
  `TransSupplierPrice` double(15,2) NOT NULL,
  `TransProductPrice` double(15,2) DEFAULT NULL,
  `TransProductQuantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`TransPid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


INSERT INTO tbltransproduct VALUES
("1","1","1","1","180.00","230.00","10"),
("2","2","1","1","180.00","230.00","1");




CREATE TABLE `tblunits` (
  `UnitId` int(11) NOT NULL AUTO_INCREMENT,
  `UnitName` varchar(55) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`UnitId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


INSERT INTO tblunits VALUES
("1","PCS","NO");




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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;


INSERT INTO tblusers VALUES
("22","Nielsen Charles","Marinas","Boo","icorrelate@gmail.com","male","1997-02-12","f5bb0c8de146c67b44babbf4e6584cc0","admin","NO","images/dp/haha@gmail.com_956709.jpg","234235233","1"),
("52","Emerald","Servas","De Paz","ESDe Paz807","female","1998-09-07","f5bb0c8de146c67b44babbf4e6584cc0","admin","NO","images/dp/ESDe Paz807_346723.jpg","1506078538","1"),
("53","Kaloy","Arceo","Marinas","KAMarinas779","male","1998-05-18","f07365b601f93103bf6b6be8bb59812a","cashier","NO","images/dp/KAMarinas779_258097.jpg","1506082406","1");




CREATE TABLE `tblwrongtries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


INSERT INTO tblwrongtries VALUES
("1","1506082714","cashier");


