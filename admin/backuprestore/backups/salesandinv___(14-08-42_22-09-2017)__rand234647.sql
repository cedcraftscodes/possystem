

CREATE TABLE `tblbadorders` (
  `badorder_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `dateadded` int(11) NOT NULL,
  `Status` varchar(120) NOT NULL,
  `Deleted` enum('NO','YES') NOT NULL,
  PRIMARY KEY (`badorder_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `tblcategories` (
  `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(255) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;






CREATE TABLE `tblcompanyinfo` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `settingkey` varchar(255) NOT NULL,
  `settingvalue` text NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;






CREATE TABLE `tblcustomer` (
  `CustomerId` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerAddress` varchar(150) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  PRIMARY KEY (`CustomerId`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;






CREATE TABLE `tblinventorylogs` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `stockid` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `userid` int(11) NOT NULL,
  `LogDate` int(11) NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;






CREATE TABLE `tbllogins` (
  `LoginID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) NOT NULL,
  `LoginDate` int(11) NOT NULL,
  PRIMARY KEY (`LoginID`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=latin1;


INSERT INTO tbllogins VALUES
("185","22","1506060356");




CREATE TABLE `tblpo_items` (
  `Poitem_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_id` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity_Requested` int(11) DEFAULT NULL,
  PRIMARY KEY (`Poitem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;






CREATE TABLE `tblpodel_items` (
  `del_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `Pod_id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `SupplierPrice` double DEFAULT NULL,
  `Quantity_Delivered` int(11) DEFAULT NULL,
  PRIMARY KEY (`del_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;






CREATE TABLE `tblpodeliveries` (
  `Pod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_id` int(11) DEFAULT NULL,
  `ReceivedBy_id` int(11) DEFAULT NULL,
  `DeliveryNumber` varchar(255) NOT NULL,
  `DateDelivered` int(11) DEFAULT NULL,
  PRIMARY KEY (`Pod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;






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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;






CREATE TABLE `tblstockout` (
  `StockOutId` int(11) NOT NULL AUTO_INCREMENT,
  `StockId` int(11) DEFAULT NULL,
  `Quantity_out` int(11) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  `Deleted` enum('NO','YES') NOT NULL,
  PRIMARY KEY (`StockOutId`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;






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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;






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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;






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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;






CREATE TABLE `tbltransproduct` (
  `TransPid` int(11) NOT NULL AUTO_INCREMENT,
  `TransId` int(11) DEFAULT NULL,
  `TransProdId` int(11) DEFAULT NULL,
  `TransSupplier` int(11) NOT NULL,
  `TransProductPrice` double(15,2) DEFAULT NULL,
  `TransProductQuantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`TransPid`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;






CREATE TABLE `tblunits` (
  `UnitId` int(11) NOT NULL AUTO_INCREMENT,
  `UnitName` varchar(55) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`UnitId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;






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
("38","Cedric","Yatco","Cashier","cashier@gmail.com","female","1997-02-12","ed2b1f468c5f915f3f1cf75d7068baae","cashier","NO","images/dp/haha@gmail.com_956709.jpg","234235233","1");


