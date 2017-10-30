

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
("1","11","2","5","100.00","3","","1506152655","Pending"),
("2","1","2","6","100.00","-10","Has cracks","1506152712","Completed");




CREATE TABLE `tblcategories` (
  `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(255) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


INSERT INTO tblcategories VALUES
("1","Lightings","NO"),
("2","Plumbing","NO"),
("3","Tools","NO"),
("4","Audio Products","NO"),
("5","Batteries","NO"),
("6","Capacitors","NO"),
("7","Cords","NO"),
("8","Aluminum","NO"),
("9","Tool bOX","YES");




CREATE TABLE `tblcompanyinfo` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `settingkey` varchar(255) NOT NULL,
  `settingvalue` text NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


INSERT INTO tblcompanyinfo VALUES
("1","name","Nyan Cat"),
("2","receiver","Cedric Coloma"),
("3","street","1578 Chico Street Garcia Subdivision"),
("4","city","Binan"),
("5","province","Laguna"),
("6","zipcode","4024"),
("7","phone","09184481097"),
("8","email","icorrelate@gmail.com"),
("9","voidcode","9904034855302");




CREATE TABLE `tblcustomer` (
  `CustomerId` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerAddress` varchar(150) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  PRIMARY KEY (`CustomerId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


INSERT INTO tblcustomer VALUES
("1","Not Set","Not Set","1506136719"),
("2","Concepcion","Sta. Rosa","1506139706"),
("3","Not Set","Not Set","1506143099"),
("4","Not Set","Not Set","1506150260"),
("5","Not Set","Not Set","1506150633");




CREATE TABLE `tblinventorylogs` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `stockid` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `userid` int(11) NOT NULL,
  `LogDate` int(11) NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;


INSERT INTO tblinventorylogs VALUES
("1","4","10","Stock Out","Product Stock Out","22","1506136257"),
("2","3","15","Stock Out","Product Stock Out","22","1506136266"),
("3","1","10","Stock Out","Product Stock Out","22","1506136289"),
("4","2","26","Stock Out","Product Stock Out","22","1506136301"),
("5","1","3","Sales","Stocks Outside Diminished #1506135493","22","1506136719"),
("6","2","5","Sales","Stocks Outside Diminished #1506135493","22","1506136719"),
("7","4","8","Sales","Stocks Outside Diminished #1506135493","22","1506136719"),
("8","1","5","Sales","Stocks Outside Diminished #1506138879","2","1506139706"),
("9","4","2","Depleted","Stocks Outside Depleted","2","1506139706"),
("10","4","55","Stock Out","Product Stock Out","2","1506140670"),
("11","1","1","Sales","Stocks Outside Diminished #1506142592","3","1506143099"),
("12","4","50","Stock Out","Product Stock Out","2","1506144901"),
("13","4","1","Sales","Stocks Outside Diminished #1506149166","6","1506150260"),
("14","4","49","Depleted","Stocks Outside Depleted","6","1506150633"),
("15","11","20","Stock Out","Product Stock Out","2","1506151829"),
("16","10","50","Stock Out","Product Stock Out","2","1506152182"),
("17","4","5","Stock Out","Product Stock Out","2","1506152629"),
("18","4","3","Sales","Stocks Outside Diminished #","2","1506152655");




CREATE TABLE `tbllogins` (
  `LoginID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) NOT NULL,
  `LoginDate` int(11) NOT NULL,
  PRIMARY KEY (`LoginID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;


INSERT INTO tbllogins VALUES
("1","2","1506135841"),
("2","3","1506135998"),
("3","3","1506136032"),
("4","2","1506136096"),
("5","3","1506137234"),
("6","2","1506138797"),
("7","3","1506138879"),
("8","2","1506139519"),
("9","2","1506139841"),
("10","2","1506142360"),
("11","2","1506142538"),
("12","3","1506142570"),
("13","3","1506142903"),
("14","2","1506143954"),
("15","5","1506144168"),
("16","3","1506144478"),
("17","2","1506145142"),
("18","2","1506147362"),
("19","2","1506148536"),
("20","5","1506148667"),
("21","6","1506148867"),
("22","2","1506149003"),
("23","2","1506149068"),
("24","2","1506149145"),
("25","6","1506149165");




CREATE TABLE `tblpo_items` (
  `Poitem_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_id` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity_Requested` int(11) DEFAULT NULL,
  PRIMARY KEY (`Poitem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


INSERT INTO tblpo_items VALUES
("1","1","2","30"),
("2","2","1","1"),
("3","3","6","50"),
("4","4","7","70");




CREATE TABLE `tblpodel_items` (
  `del_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `Pod_id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `SupplierPrice` double DEFAULT NULL,
  `Quantity_Delivered` int(11) DEFAULT NULL,
  PRIMARY KEY (`del_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


INSERT INTO tblpodel_items VALUES
("1","1","2","200","30"),
("2","2","1","100","1"),
("3","3","6","550","50"),
("4","4","7","150","50"),
("5","5","7","200","20");




CREATE TABLE `tblpodeliveries` (
  `Pod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_id` int(11) DEFAULT NULL,
  `ReceivedBy_id` int(11) DEFAULT NULL,
  `DeliveryNumber` varchar(255) NOT NULL,
  `DateDelivered` int(11) DEFAULT NULL,
  PRIMARY KEY (`Pod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


INSERT INTO tblpodeliveries VALUES
("1","1","2","DHHDFJ","1506140910"),
("2","2","2","Del. 13-13","1506140980"),
("3","3","2","Del. 13-13","1506141818"),
("4","4","2","DELN12124","1506151612"),
("5","4","2","DEL639142","1506151780");




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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO tblproducts VALUES
("1","Flourescent Bulbs","Omni","30","150","1","10000127491","1","12 Watts Magic Bulb","1506079013","NO"),
("2","PVC Pipe","Sun Shop","50","225","1","2016-00099","2","Transparent PVC Pipe","1506079173","NO"),
("3","Screwdriver Set","Phillips","30","120","1","10000127491","3","31 in 1 Professional Screwdrivers Kit","1506079368","NO"),
("4","Aluminium Electrolytic Capacitor","KEMET","50","150","1","200000000","6","4700μF 250 V dc 66mm Can - Screw Terminals, Radial ALS30 Series","1506100234","YES"),
("5","Aluminium Electrolytic Capacitor","KEMET","50","150","1","2017001201","6","4700μF 250 V dc 66mm Can - Screw Terminals, Radial ALS30 Series","1506100513","NO"),
("6","Aluminium Electrolytic Capacitor a","Nichicon","50","150","1","7372574920","6","","1506100898","NO"),
("7","9V Battery","Energizer","70","230","1","7372574900","5","Energizer Industrial Energizer Alkaline 9V Battery PP3","1506100989","NO"),
("8","AA Batteries","Duracell","60","210","1","7372574901","5","Duracell Alkaline AA Battery","1506101329","NO"),
("9","AAA Batteries","Duracell","65","220","1","7372574902","5","Duracell ULTRA Power Alkaline AAA Battery","1506101438","NO"),
("10","AAAA Battery","Duracell","70","230","1","7372574903","5","Energizer 1.5V Alkaline AAAA Battery","1506101520","NO"),
("11","Alkaline Batteries","Cegasa","80","260","1","7372574904","5","Cegasa RSPCD1702 3V 100000mAh Air Alkaline Battery","1506101615","NO"),
("12","C Batteries","Energizer","85","280","1","7372574905","5","Energizer Industrial Alkaline C Battery","1506101700","NO"),
("13","Coin Button Battery","RS Pro","70","240","1","7372574906","5","RS Pro LR44 1.5V Alkaline Coin Button Battery","1506101793","NO"),
("14","D Battery","Energizer","70","210","1","7372574907","5","Energizer Industrial Alkaline D Battery","1506102039","NO"),
("15","Lantern Battery","Eveready","40","180","1","7372574908","5","Eveready 996 6V, 11Ah Alkaline Lantern Battery","1506102119","NO"),
("16","N Battery","Duracell","70","230","1","7372574909","5","Duracell 1.5V Alkaline N Battery","1506102272","NO"),
("17","LED Car Bulb","Osram","90","340","1","7372574910","1","LED Car Bulb 26.8 mm Amber 12 V 60 mA 10mm 30 lm","1506102797","NO"),
("18","UTP Cords","BELDEN","35","80","2","7372574914","7","CAT5E","1506102902","NO"),
("19","Floodlight","Crompton","40","190","1","7372574911","1","Crompton Lighting HID Floodlight 70 W","1506102958","NO"),
("20","LED Desk Lamp","RS Pro","30","170","1","7372574912","1","RS Pro LED Desk Lamp, 6 W, Adjustable Arm, Black, 230 V, Lamp Included","1506103025","NO"),
("21","Halogen Lamp","Osram","70","280","1","7372574913","1","60 W H4 White Car Halogen Lamp, 12 V, 160h","1506103119","NO"),
("22","Jack AUX Auxiliary Cord","OEM","50","80","1","7372574915","7","3.5mm male to male flat noodle AUX stereo audio cable","1506103133","NO"),
("23","Black Light","Philips","60","260","1","7372574916","1","Philips Lighting 6 W 370 nm UV Black Light G5, length 226.3 mm, Dia. 16 mm, 44 V, 3000h","1506103223","NO"),
("24","Aluminum Steel Sheets","Cegasa","30","170","1","7372574917","1","Aluminum Steel Sheets 0.5mm","1506136799","NO"),
("25","LED Light","Phillips","60","270","1","4806517040395","1","Blue LED Light","1506140103","NO"),
("26","UV Light","Phillips","55","265","1","4800523443416","1","Green UV Light","1506140171","NO"),
("27","Black Light","Phillips","35","185","1","729461168158","1","5cm Black Light","1506140236","NO"),
("28","Aluminum Steel Bar","Cegasa","30","160","1","2000000057408","8","20mm Thick Aluminum Steel Bar","1506140534","NO"),
("29","UV Lights 2","Phillips","25","140","1","4800216121041","1","10w UV Lights","1506140756","NO"),
("30","Capacitor","Phillips","25","140","1","4800016083778","6","12mm capacitor","1506140831","NO");




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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


INSERT INTO tblpurchaseorders VALUES
("1","1506140856","2","2","2","2017-12-01","1506140888","Completed","NO"),
("2","1506140936","1","2","2","2017-12-31","1506140954","Completed","NO"),
("3","1506141764","4","2","2","2017-09-26","1506141794","Completed","NO"),
("4","1506151475","5","2","2","2017-09-29","1506151489","Completed","NO");




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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


INSERT INTO tblstockout VALUES
("9","4","2","1506152629","NO");




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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;


INSERT INTO tblstocks VALUES
("1","1","11","150","1","100","1506135697","YES"),
("2","2","30","250","2","200","1506135726","YES"),
("3","6","25","650","4","550","1506135885","YES"),
("4","11","0","110","5","100","1506136238","NO"),
("5","2","30","250","2","200","1506140910","NO"),
("6","1","1","150","1","100","1506140980","NO"),
("7","6","50","650","4","550","1506141818","YES"),
("8","1","30","150","6","100","1506149401","NO"),
("9","7","5","300","5","150","1506150976","NO"),
("10","7","50","300","5","150","1506151612","YES"),
("11","7","20","300","5","200","1506151780","YES"),
("12","1","10","250","6","100","1506152727","YES"),
("13","1","10","250","6","100","1506152736","YES"),
("14","1","10","250","6","100","1506152736","YES");




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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;


INSERT INTO tblsuppliers VALUES
("1","ABC Electronics","Gigaohms Electronic Center","1578 Chico Street Garcia Subdivision","Santa Rosa","Laguna","4026","09357190233","abcelectronics@gmail.com","22","1506076666","NO"),
("2","Hextech","Gigaohms Electronic Center","1241 Narra Street Garlic Subdivision","Santa Rosa","Laguna","4026","09348104136","hextech@rocketmail.com","22","1506076888","NO"),
("3","Clockworks","Gigaohms Electronic Center","1337 Bark Street Doge Subdivision","Santa Rosa","Laguna","4026","09165133116","clockworkES@gmail.com","22","1506077023","NO"),
("4","Steel Trade","Gigaohms Electronic Center","1998 Jackie Street Chan Subdivision","Santa Rosa","Laguna","4026","09357190238","SteelTrade1@yahoo.com","22","1506077219","NO"),
("5","KYS Signage","Gigaohms Electronic Center","1215 Wanda Street Pass Subdivision","Binan","Laguna","4024","09346190336","KYSsign@gmail.com","22","1506077280","NO"),
("6","ABC Corp","Cedroc","ghg","jhgjh","gjhg","4024","09184481097","meme@gmail.com","2","1506149196","NO");




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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


INSERT INTO tbltransaction VALUES
("2","2","1506138879","920.00","80.00","1000.00","1506139706","7","2","50.00"),
("3","3","1506142592","150.00","850.00","1000.00","1506143099","1","3","0.00"),
("4","6","1506149166","60.00","440.00","500.00","1506150260","1","4","50.00"),
("5","6","1506150261","5390.00","610.00","6000.00","1506150633","49","5","0.00");




CREATE TABLE `tbltransproduct` (
  `TransPid` int(11) NOT NULL AUTO_INCREMENT,
  `TransId` int(11) DEFAULT NULL,
  `TransProdId` int(11) DEFAULT NULL,
  `TransSupplier` int(11) NOT NULL,
  `TransSupplierPrice` double(15,2) NOT NULL,
  `TransProductPrice` double(15,2) DEFAULT NULL,
  `TransProductQuantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`TransPid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


INSERT INTO tbltransproduct VALUES
("6","2","1","1","100.00","150.00","5"),
("7","2","11","5","100.00","110.00","2"),
("8","3","1","1","100.00","150.00","1"),
("9","4","11","5","100.00","110.00","1"),
("10","5","11","5","100.00","110.00","49");




CREATE TABLE `tblunits` (
  `UnitId` int(11) NOT NULL AUTO_INCREMENT,
  `UnitName` varchar(55) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`UnitId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


INSERT INTO tblunits VALUES
("1","PCS","NO"),
("2","Yards","NO"),
("3","Meter","YES");




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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;


INSERT INTO tblusers VALUES
("2","Kim","Santos","Gatdula","KSGatdula417","male","1969-09-03","f5bb0c8de146c67b44babbf4e6584cc0","admin","NO","images/dp/KSGatdula417_79016.jpg","1506135795","1"),
("3","Chloe","Espiritu","Reyes","CEReyes929","female","1995-09-01","f5bb0c8de146c67b44babbf4e6584cc0","cashier","YES","images/dp/CEReyes929_902350.jpg","1506135926","1"),
("4","Nielsen","Marinas","Bool","NMBool714","male","1970-08-03","79a362eb49170f28bf15b7fce027effd","cashier","YES","images/dp/NMBool714_415868.jpg","1506139575","0"),
("5","Cedric","Don","Coloma","NMBool576","male","1998-05-18","0796c3bcb85ee7778b3f14e11df4d48f","cashier","NO","images/dp/NMBool576_844852.jpg","1506144134","1"),
("6","Keith","Servas","Depaz","KSDepaz264","female","1998-09-13","f5bb0c8de146c67b44babbf4e6584cc0","cashier","NO","images/dp/KSDepaz264_331876.png","1506148825","1");




CREATE TABLE `tblwrongtries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


INSERT INTO tblwrongtries VALUES
("1","1506148933","cashier");


