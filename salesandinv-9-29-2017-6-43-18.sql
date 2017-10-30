-- MySQL dump 10.16  Distrib 10.1.25-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: salesandinv
-- ------------------------------------------------------
-- Server version	10.1.25-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbladjustment`
--

DROP TABLE IF EXISTS `tbladjustment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbladjustment` (
  `adjid` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` text COLLATE utf8_bin NOT NULL,
  `supplier_price` int(11) NOT NULL,
  `markup` int(11) NOT NULL,
  `dateadjusted` int(11) NOT NULL,
  `Status` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`adjid`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbladjustment`
--

LOCK TABLES `tbladjustment` WRITE;
/*!40000 ALTER TABLE `tbladjustment` DISABLE KEYS */;
INSERT INTO `tbladjustment` VALUES (3,1,3,'Defective Product',200,19,1506583073,'Deduction'),(4,1,3,'Defective Product',200,19,1506583082,'Deduction'),(5,19,20,'Defect',1000,10,1506583126,'Deduction'),(6,1,3,'Defective Product',200,19,1506583198,'Deduction'),(7,1,3,'Product Replaced',200,19,1506584015,'Deduction'),(8,8,5,'Product Lost',0,0,1506591510,'Deduction'),(9,19,5,'Product Lost',1000,10,1506591557,'Deduction'),(10,19,5,'Product Found',1000,10,1506591585,'Addition'),(11,19,20,'Product Replaced',1000,10,1506602496,'Addition'),(12,19,15,'Product Replaced',1000,10,1506602502,'Addition'),(13,19,15,'Product Replaced',1000,10,1506602502,'Addition');
/*!40000 ALTER TABLE `tbladjustment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbackups`
--

DROP TABLE IF EXISTS `tblbackups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblbackups` (
  `BackupId` int(11) NOT NULL AUTO_INCREMENT,
  `BackupFile` varchar(255) DEFAULT NULL,
  `BackupDate` int(11) DEFAULT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`BackupId`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbackups`
--

LOCK TABLES `tblbackups` WRITE;
/*!40000 ALTER TABLE `tblbackups` DISABLE KEYS */;
INSERT INTO `tblbackups` VALUES (30,'salesandinv___(14-34-31_22-09-2017)__rand7533773.sql',1506062071,22,'I just want to backup'),(31,'salesandinv___(14-45-23_22-09-2017)__rand9080336.sql',1506062723,22,'Backup before restoring: salesandinv___(14-45-23_22-09-2017)__rand9080336.sql at September 22, 2017, 2:45 pm'),(32,'salesandinv___(17-09-50_22-09-2017)__rand11054824.sql',1506071390,22,'Test Backup'),(33,'salesandinv___(17-10-11_22-09-2017)__rand4489814.sql',1506071411,22,'Backup before restoring: salesandinv___(17-10-11_22-09-2017)__rand4489814.sql at September 22, 2017, 5:10 pm'),(34,'salesandinv___(20-29-17_22-09-2017)__rand10561117.sql',1506083357,22,'Before deleting stock.'),(35,'salesandinv___(20-30-15_22-09-2017)__rand7315403.sql',1506083415,22,'Before deleting Stock in and Stock out.'),(36,'salesandinv___(20-32-42_22-09-2017)__rand5486383.sql',1506083562,22,'Backup before restoring: salesandinv___(20-32-42_22-09-2017)__rand5486383.sql at September 22, 2017, 8:32 pm');
/*!40000 ALTER TABLE `tblbackups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbadorders`
--

DROP TABLE IF EXISTS `tblbadorders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbadorders`
--

LOCK TABLES `tblbadorders` WRITE;
/*!40000 ALTER TABLE `tblbadorders` DISABLE KEYS */;
INSERT INTO `tblbadorders` VALUES (1,2,22,4,120.00,0,'Cracked PVC Pipe',1506080512,'Completed'),(2,1,22,1,180.00,0,'',1506081776,'Completed'),(3,5,22,1,100.00,1,'Defective',1506501336,'Pending'),(4,1,22,1,200.00,3,'',1506581772,'Pending'),(5,19,22,6,1000.00,0,'Defective Items',1506582108,'Completed'),(6,1,22,1,200.00,3,'Defective Product',1506582820,'Pending'),(7,1,22,1,200.00,0,'Defective Product',1506583073,'Completed'),(8,1,22,1,200.00,0,'Defective Product',1506583082,'Completed'),(9,19,22,6,1000.00,-10,'Defect',1506583126,'Pending'),(10,1,22,1,200.00,0,'Defective Product',1506583198,'Completed');
/*!40000 ALTER TABLE `tblbadorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcategories`
--

DROP TABLE IF EXISTS `tblcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcategories` (
  `CategoryId` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(255) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcategories`
--

LOCK TABLES `tblcategories` WRITE;
/*!40000 ALTER TABLE `tblcategories` DISABLE KEYS */;
INSERT INTO `tblcategories` VALUES (1,'Lightings','NO'),(2,'Plumbing','NO'),(3,'Tools','NO'),(4,'Audio Products','NO'),(5,'Batteries','NO'),(6,'Capacitors','NO'),(7,'Cords','NO'),(8,'BOloww','NO'),(9,'Marata','NO');
/*!40000 ALTER TABLE `tblcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcompanyinfo`
--

DROP TABLE IF EXISTS `tblcompanyinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcompanyinfo` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `settingkey` varchar(255) NOT NULL,
  `settingvalue` text NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcompanyinfo`
--

LOCK TABLES `tblcompanyinfo` WRITE;
/*!40000 ALTER TABLE `tblcompanyinfo` DISABLE KEYS */;
INSERT INTO `tblcompanyinfo` VALUES (1,'name','Giga Ohms'),(2,'receiver','Nick Catimbang'),(3,'street','Km. 36 National Highway Bgy. Platero'),(4,'city',' BiÃ±an City'),(5,'province','Laguna'),(6,'zipcode','4024'),(7,'phone','09228335230'),(8,'email','icorrelate@gmail.com'),(9,'voidcode','244161004191');
/*!40000 ALTER TABLE `tblcompanyinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcustomer`
--

DROP TABLE IF EXISTS `tblcustomer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcustomer` (
  `CustomerId` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerName` varchar(150) DEFAULT NULL,
  `CustomerAddress` varchar(150) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  PRIMARY KEY (`CustomerId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcustomer`
--

LOCK TABLES `tblcustomer` WRITE;
/*!40000 ALTER TABLE `tblcustomer` DISABLE KEYS */;
INSERT INTO `tblcustomer` VALUES (1,'Chloe Reyes','Zapote Road',1506081186),(2,'Cedric Coloma','Not Set',1506081524),(3,'Cedric Coloma','123 Binan Laguna',1506234020),(4,'Cedric Coloma','Binan Laguna',1506247366);
/*!40000 ALTER TABLE `tblcustomer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblinventorylogs`
--

DROP TABLE IF EXISTS `tblinventorylogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblinventorylogs` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `stockid` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `userid` int(11) NOT NULL,
  `LogDate` int(11) NOT NULL,
  PRIMARY KEY (`logid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblinventorylogs`
--

LOCK TABLES `tblinventorylogs` WRITE;
/*!40000 ALTER TABLE `tblinventorylogs` DISABLE KEYS */;
INSERT INTO `tblinventorylogs` VALUES (1,1,'50','Stock Out','Product Stock Out',22,1506079549),(2,1,'39','Stock Out','Product Stock Out',22,1506079845),(3,1,'10','Stock Out','Product Stock Out',22,1506080802),(4,1,'10','Stock Out','Product Stock Out',22,1506080802),(5,1,'10','Sales','Stocks Outside Diminished #1506080629',22,1506081186),(6,1,'1','Sales','Stocks Outside Diminished #1506081186',22,1506081524),(7,1,'5','Sales','Stocks Outside Diminished #',22,1506081776),(8,4,'10','Stock Out','Product Stock Out',22,1506098290),(9,4,'5','Stock Out','Product Stock Out',22,1506098336),(10,4,'10','Stock Out','Product Stock Out',22,1506098572),(11,4,'8','Stock Out','Product Stock Out',22,1506098827),(12,8,'5','Stock Out','Product Stock Out',22,1506100691),(13,8,'10','Stock Out','Product Stock Out',22,1506100706),(14,9,'4','Stock Out','Product Stock Out',22,1506100763),(15,9,'20','Stock Out','Product Stock Out',22,1506126493),(16,9,'1','Sales','Stocks Outside Diminished #1506233940',22,1506234020),(17,12,'5','Stock Out','Product Stock Out',22,1506245326),(18,12,'50','Stock Out','Product Stock Out',22,1506247200),(19,12,'4','Sales','Stocks Outside Diminished #1506234643',22,1506247366),(20,9,'20','Stock Out','Product Stock Out',22,1506514905),(21,9,'20','Stock Out','Product Stock Out',22,1506514941),(22,9,'20','Stock Out','Product Stock Out',22,1506514970),(23,12,'3','Sales','Stocks Outside Diminished #',22,1506582820),(24,12,'3','Sales','Stocks Outside Diminished #',22,1506583073),(25,13,'25','Stock Out','Product Stock Out',22,1506591286);
/*!40000 ALTER TABLE `tblinventorylogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbllogins`
--

DROP TABLE IF EXISTS `tbllogins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbllogins` (
  `LoginID` int(11) NOT NULL AUTO_INCREMENT,
  `AccountID` int(11) NOT NULL,
  `LoginDate` int(11) NOT NULL,
  PRIMARY KEY (`LoginID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbllogins`
--

LOCK TABLES `tbllogins` WRITE;
/*!40000 ALTER TABLE `tbllogins` DISABLE KEYS */;
INSERT INTO `tbllogins` VALUES (1,22,1506073396),(2,22,1506074178),(3,22,1506078473),(4,22,1506078522),(5,52,1506078592),(6,22,1506082104),(7,52,1506082249),(8,53,1506082609),(9,22,1506082774),(10,22,1506084550),(11,22,1506086468),(12,53,1506086499),(13,22,1506086623),(14,53,1506095116),(15,53,1506095136),(16,22,1506095420),(17,22,1506095488),(18,22,1506095496),(19,22,1506095632),(20,22,1506095637),(21,22,1506097274),(22,22,1506126410),(23,22,1506126543),(24,22,1506221925),(25,53,1506234643),(26,22,1506234714),(27,22,1506244303),(28,22,1506300884),(29,22,1506302767),(30,22,1506494035),(31,22,1506495353),(32,22,1506506975),(33,22,1506580771),(34,22,1506581132),(35,22,1506581327);
/*!40000 ALTER TABLE `tbllogins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpo_items`
--

DROP TABLE IF EXISTS `tblpo_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpo_items` (
  `Poitem_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_id` int(11) DEFAULT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `Quantity_Requested` int(11) DEFAULT NULL,
  PRIMARY KEY (`Poitem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpo_items`
--

LOCK TABLES `tblpo_items` WRITE;
/*!40000 ALTER TABLE `tblpo_items` DISABLE KEYS */;
INSERT INTO `tblpo_items` VALUES (18,18,1,50);
/*!40000 ALTER TABLE `tblpo_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpodel_items`
--

DROP TABLE IF EXISTS `tblpodel_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpodel_items` (
  `del_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `Pod_id` int(11) NOT NULL,
  `ProductId` int(11) DEFAULT NULL,
  `SupplierPrice` double DEFAULT NULL,
  `Quantity_Delivered` int(11) DEFAULT NULL,
  PRIMARY KEY (`del_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpodel_items`
--

LOCK TABLES `tblpodel_items` WRITE;
/*!40000 ALTER TABLE `tblpodel_items` DISABLE KEYS */;
INSERT INTO `tblpodel_items` VALUES (1,2,2,120,5),(2,3,2,120,25),(3,5,1,200,5);
/*!40000 ALTER TABLE `tblpodel_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpodeliveries`
--

DROP TABLE IF EXISTS `tblpodeliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpodeliveries` (
  `Pod_id` int(11) NOT NULL AUTO_INCREMENT,
  `Po_id` int(11) DEFAULT NULL,
  `ReceivedBy_id` int(11) DEFAULT NULL,
  `DeliveryNumber` varchar(255) NOT NULL,
  `DateDelivered` int(11) DEFAULT NULL,
  PRIMARY KEY (`Pod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpodeliveries`
--

LOCK TABLES `tblpodeliveries` WRITE;
/*!40000 ALTER TABLE `tblpodeliveries` DISABLE KEYS */;
INSERT INTO `tblpodeliveries` VALUES (1,2,22,'100456',1506080261),(2,1,22,'100526',1506080362),(3,1,22,'100457',1506080409),(4,5,22,'sasas',1506098499),(5,18,22,'DEL151',1506240321);
/*!40000 ALTER TABLE `tblpodeliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblproducts`
--

DROP TABLE IF EXISTS `tblproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `MarkupPercentage` int(11) NOT NULL,
  `Deleted` enum('YES','NO') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblproducts`
--

LOCK TABLES `tblproducts` WRITE;
/*!40000 ALTER TABLE `tblproducts` DISABLE KEYS */;
INSERT INTO `tblproducts` VALUES (1,'Flourescent Bulbs','Omni',30,150,1,'112345',1,'12 Watts Magic Bulb',1506079013,19,'NO'),(2,'PVC Pipe','Sun Shop',50,225,1,'2016-00099',2,'Transparent PVC Pipe',1506079173,0,'NO'),(3,'Screwdriver Set','Phillips',30,120,1,'10000127491',3,'31 in 1 Professional Screwdrivers Kit',1506079368,0,'NO'),(4,'Aluminium Electrolytic Capacitor','KEMET',50,150,1,'200000000',6,'4700μF 250 V dc 66mm Can - Screw Terminals, Radial ALS30 Series',1506100234,0,'YES'),(5,'Aluminium Electrolytic Capacitor','KEMET',50,150,1,'2017001201',6,'4700μF 250 V dc 66mm Can - Screw Terminals, Radial ALS30 Series',1506100513,0,'NO'),(6,'Aluminium Electrolytic Capacitor','Nichicon',50,150,1,'2017001202',6,'4700μF 16 V dc 16mm Through Hole PS Series Lifetime 3000h +105°C',1506100898,0,'NO'),(7,'9V Battery','Energizer',70,230,1,'7372574900',5,'Energizer Industrial Energizer Alkaline 9V Battery PP3',1506100989,0,'NO'),(8,'AA Batteries','Duracell',60,210,1,'7372574901',5,'Duracell Alkaline AA Battery',1506101329,0,'NO'),(9,'AAA Batteries','Duracell',65,220,1,'7372574902',5,'Duracell ULTRA Power Alkaline AAA Battery',1506101438,0,'NO'),(10,'AAAA Battery','Duracell',70,230,1,'7372574903',5,'Energizer 1.5V Alkaline AAAA Battery',1506101520,0,'NO'),(11,'Alkaline Batteries','Cegasa',80,260,1,'7372574904',5,'Cegasa RSPCD1702 3V 100000mAh Air Alkaline Battery',1506101615,0,'NO'),(12,'C Batteries','Energizer',85,280,1,'7372574905',5,'Energizer Industrial Alkaline C Battery',1506101700,0,'NO'),(13,'Coin Button Battery','RS Pro',70,240,1,'7372574906',5,'RS Pro LR44 1.5V Alkaline Coin Button Battery',1506101793,0,'NO'),(14,'D Battery','Energizer',70,210,1,'7372574907',5,'Energizer Industrial Alkaline D Battery',1506102039,0,'NO'),(15,'Lantern Battery','Eveready',40,180,1,'7372574908',5,'Eveready 996 6V, 11Ah Alkaline Lantern Battery',1506102119,0,'NO'),(16,'N Battery','Duracell',70,230,1,'7372574909',5,'Duracell 1.5V Alkaline N Battery',1506102272,0,'NO'),(17,'LED Car Bulb','Osram',90,340,1,'7372574910',1,'LED Car Bulb 26.8 mm Amber 12 V 60 mA 10mm 30 lm',1506102797,0,'NO'),(18,'UTP Cords','BELDEN',35,80,2,'7372574914',7,'CAT5E',1506102902,0,'NO'),(19,'FloodLight','Cromptons',40,190,1,'7372574911',1,'Crompton Lighting HID Floodlight 70 W',1506102958,10,'NO'),(20,'LED Desk Lamp','RS Pro',30,170,1,'7372574912',1,'RS Pro LED Desk Lamp, 6 W, Adjustable Arm, Black, 230 V, Lamp Included',1506103025,0,'NO'),(21,'Halogen Lamp','Osram',70,280,1,'7372574913',1,'60 W H4 White Car Halogen Lamp, 12 V, 160h',1506103119,0,'NO'),(22,'Jack AUX Auxiliary Cord','OEM',50,80,1,'7372574915',7,'3.5mm male to male flat noodle AUX stereo audio cable',1506103133,0,'NO'),(23,'Black Light','Philips',60,260,1,'7372574916',1,'Philips Lighting 6 W 370 nm UV Black Light G5, length 226.3 mm, Dia. 16 mm, 44 V, 3000h',1506103223,0,'NO'),(24,'sdafasd','fasdf',11,123,2,'125125',3,'fas',1506246592,15,'NO'),(25,'A4 Battery','Marko',12,200,2,'2512525152',5,'Leiva',1506498046,15,'NO'),(26,'Serla','mervi',15,166,7,'2525552',9,'Lakso',1506498218,12,'NO');
/*!40000 ALTER TABLE `tblproducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpurchaseorders`
--

DROP TABLE IF EXISTS `tblpurchaseorders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpurchaseorders`
--

LOCK TABLES `tblpurchaseorders` WRITE;
/*!40000 ALTER TABLE `tblpurchaseorders` DISABLE KEYS */;
INSERT INTO `tblpurchaseorders` VALUES (18,'1506232980',1,22,22,'2017-09-30',1506232987,'Pending','NO');
/*!40000 ALTER TABLE `tblpurchaseorders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblrefunds`
--

DROP TABLE IF EXISTS `tblrefunds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblrefunds` (
  `refundid` int(11) NOT NULL AUTO_INCREMENT,
  `boid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `refunddate` int(11) NOT NULL,
  PRIMARY KEY (`refundid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblrefunds`
--

LOCK TABLES `tblrefunds` WRITE;
/*!40000 ALTER TABLE `tblrefunds` DISABLE KEYS */;
INSERT INTO `tblrefunds` VALUES (1,3,120,1506501336),(2,4,714,1506581772),(3,8,714,1506583082),(4,10,714,1506583198);
/*!40000 ALTER TABLE `tblrefunds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblrestore`
--

DROP TABLE IF EXISTS `tblrestore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblrestore` (
  `RestoreId` int(11) NOT NULL AUTO_INCREMENT,
  `BackupId` int(11) DEFAULT NULL,
  `RestoreDate` int(11) DEFAULT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`RestoreId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblrestore`
--

LOCK TABLES `tblrestore` WRITE;
/*!40000 ALTER TABLE `tblrestore` DISABLE KEYS */;
INSERT INTO `tblrestore` VALUES (2,30,1506062723,22,''),(3,30,1506071411,22,''),(4,35,1506083562,22,'I made mistakes in deleting each stock 1 by 1.');
/*!40000 ALTER TABLE `tblrestore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblstockout`
--

DROP TABLE IF EXISTS `tblstockout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblstockout` (
  `StockOutId` int(11) NOT NULL AUTO_INCREMENT,
  `StockId` int(11) DEFAULT NULL,
  `Quantity_out` int(11) DEFAULT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  `Deleted` enum('NO','YES') NOT NULL,
  PRIMARY KEY (`StockOutId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstockout`
--

LOCK TABLES `tblstockout` WRITE;
/*!40000 ALTER TABLE `tblstockout` DISABLE KEYS */;
INSERT INTO `tblstockout` VALUES (9,12,40,1506247200,'NO'),(11,9,20,1506514970,'NO');
/*!40000 ALTER TABLE `tblstockout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblstocks`
--

DROP TABLE IF EXISTS `tblstocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblstocks` (
  `StockId` int(11) NOT NULL AUTO_INCREMENT,
  `ProductId` int(11) DEFAULT NULL,
  `No_Of_Items` int(11) DEFAULT NULL,
  `Product_supplier` int(11) NOT NULL,
  `SupplierPrice` double NOT NULL,
  `DateAdded` int(11) DEFAULT NULL,
  `Deleted` enum('NO','YES') NOT NULL,
  PRIMARY KEY (`StockId`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblstocks`
--

LOCK TABLES `tblstocks` WRITE;
/*!40000 ALTER TABLE `tblstocks` DISABLE KEYS */;
INSERT INTO `tblstocks` VALUES (1,1,74,1,180,1506079498,'YES'),(2,2,5,4,0,1506079679,'YES'),(3,2,5,4,120,1506080362,'YES'),(4,2,15,4,120,1506080409,'YES'),(5,2,5,4,120,1506080535,'YES'),(6,2,5,4,120,1506080590,'YES'),(7,1,5,1,180,1506081798,'YES'),(8,1,40,1,100,1506100682,'YES'),(9,5,19,1,100,1506100759,'NO'),(10,1,5,1,200,1506222850,'NO'),(11,5,5,2,100,1506225648,'NO'),(12,1,10,1,200,1506240321,'NO'),(13,8,25,1,0,1506252608,'NO'),(14,13,20,1,0,1506252747,'NO'),(15,2,10,1,0,1506252850,'YES'),(16,3,10,1,150,1506252872,'NO'),(17,NULL,NULL,1,100,1506496416,'NO'),(18,NULL,NULL,1,125,1506496607,'NO'),(19,19,110,6,1000,1506498407,'NO'),(20,19,50,1,100,1506498807,'NO'),(21,1,3,1,200,1506583969,'NO'),(22,1,3,1,200,1506584015,'NO'),(23,19,20,6,1000,1506602496,'NO'),(24,19,15,6,1000,1506602502,'NO'),(25,19,15,6,1000,1506602502,'NO');
/*!40000 ALTER TABLE `tblstocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsuppliers`
--

DROP TABLE IF EXISTS `tblsuppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsuppliers`
--

LOCK TABLES `tblsuppliers` WRITE;
/*!40000 ALTER TABLE `tblsuppliers` DISABLE KEYS */;
INSERT INTO `tblsuppliers` VALUES (1,'ABC Electronics','Gigaohms Electronic Center','1578 Chico Street Garcia Subdivision','Santa Rosa','Laguna','4026','09357190233','abcelectronics@gmail.com',22,1506076666,'NO'),(2,'Hextech','Gigaohms Electronic Center','1241 Narra Street Garlic Subdivision','Santa Rosa','Laguna','4026','09348104136','hextech@rocketmail.com',22,1506076888,'NO'),(3,'Clockworks','Gigaohms Electronic Center','1337 Bark Street Doge Subdivision','Santa Rosa','Laguna','4026','09165133116','clockworkES@gmail.com',22,1506077023,'NO'),(4,'Steel Trade','Gigaohms Electronic Center','1998 Jackie Street Chan Subdivision','Santa Rosa','Laguna','4026','09357190238','SteelTrade1@yahoo.com',22,1506077219,'NO'),(5,'KYS Signage','Gigaohms Electronic Center','1215 Wanda Street Pass Subdivision','Binan','Laguna','4024','09346190336','KYSsign@gmail.com',22,1506077280,'NO'),(6,'Looe','Loee Merklo','1257 Pyon yang','Popo','Loko','1234','09876574856','meme@gmail.com',22,1506498290,'NO');
/*!40000 ALTER TABLE `tblsuppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbltransaction`
--

DROP TABLE IF EXISTS `tbltransaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `ORNo` int(11) NOT NULL,
  PRIMARY KEY (`TransId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltransaction`
--

LOCK TABLES `tbltransaction` WRITE;
/*!40000 ALTER TABLE `tbltransaction` DISABLE KEYS */;
INSERT INTO `tbltransaction` VALUES (1,22,'1506080629',2250.00,0.00,2250.00,1506081186,10,1,50.00,0),(2,22,'1506081186',230.00,270.00,500.00,1506081524,1,2,0.00,0),(3,22,'1506233940',120.00,80.00,200.00,1506234020,1,3,0.00,3),(4,22,'1506234643',952.00,48.00,1000.00,1506247366,4,4,0.00,4);
/*!40000 ALTER TABLE `tbltransaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbltransproduct`
--

DROP TABLE IF EXISTS `tbltransproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbltransproduct` (
  `TransPid` int(11) NOT NULL AUTO_INCREMENT,
  `TransId` int(11) DEFAULT NULL,
  `TransProdId` int(11) DEFAULT NULL,
  `TransSupplier` int(11) NOT NULL,
  `TransSupplierPrice` double(15,2) NOT NULL,
  `TransProductPrice` double(15,2) DEFAULT NULL,
  `TransProductQuantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`TransPid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbltransproduct`
--

LOCK TABLES `tbltransproduct` WRITE;
/*!40000 ALTER TABLE `tbltransproduct` DISABLE KEYS */;
INSERT INTO `tbltransproduct` VALUES (1,1,1,1,180.00,230.00,10),(2,2,1,1,180.00,230.00,1),(3,3,5,1,100.00,120.00,1),(4,4,1,1,200.00,238.00,4);
/*!40000 ALTER TABLE `tbltransproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblunits`
--

DROP TABLE IF EXISTS `tblunits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblunits` (
  `UnitId` int(11) NOT NULL AUTO_INCREMENT,
  `UnitName` varchar(55) DEFAULT NULL,
  `Deleted` enum('YES','NO') NOT NULL,
  PRIMARY KEY (`UnitId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblunits`
--

LOCK TABLES `tblunits` WRITE;
/*!40000 ALTER TABLE `tblunits` DISABLE KEYS */;
INSERT INTO `tblunits` VALUES (1,'PCS','NO'),(2,'Yards','NO'),(4,'FloodLight','NO'),(5,'FloodLight','NO'),(6,'HAHAHA','NO'),(7,'Harata','NO');
/*!40000 ALTER TABLE `tblunits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblusers`
--

DROP TABLE IF EXISTS `tblusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblusers`
--

LOCK TABLES `tblusers` WRITE;
/*!40000 ALTER TABLE `tblusers` DISABLE KEYS */;
INSERT INTO `tblusers` VALUES (22,'Nielsen Charles','Marinas','Bool','icorrelate@gmail.com','male','1997-02-12','f5bb0c8de146c67b44babbf4e6584cc0','admin','NO','images/dp/haha@gmail.com_956709.jpg',234235233,'1'),(52,'Emerald','Servas','De Paz','ESDe Paz807','female','1998-09-07','f5bb0c8de146c67b44babbf4e6584cc0','admin','NO','images/dp/ESDe Paz807_346723.jpg',1506078538,'1'),(53,'Kaloy','Arceo','Marinas','KAMarinas779','male','1998-05-18','f5bb0c8de146c67b44babbf4e6584cc0','cashier','NO','images/dp/KAMarinas779_258097.jpg',1506082406,'1');
/*!40000 ALTER TABLE `tblusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblwrongtries`
--

DROP TABLE IF EXISTS `tblwrongtries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblwrongtries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblwrongtries`
--

LOCK TABLES `tblwrongtries` WRITE;
/*!40000 ALTER TABLE `tblwrongtries` DISABLE KEYS */;
INSERT INTO `tblwrongtries` VALUES (1,1506082714,'cashier'),(2,1506086282,'cashier');
/*!40000 ALTER TABLE `tblwrongtries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-29  6:43:21
