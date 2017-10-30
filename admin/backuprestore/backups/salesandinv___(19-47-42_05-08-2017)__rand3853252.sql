

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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;


INSERT INTO tblusers VALUES
("22","Cedric","Yatco","Coloma","icorrelate@gmail.com","male","1997-02-12","ed2b1f468c5f915f3f1cf75d7068baae","admin","NO","images/dp/asdas@gmail.com_516963.jpg","234235233","1"),
("38","Cedric","Yatco","Cashier Acc","cashier@gmail.com","female","1997-02-12","ed2b1f468c5f915f3f1cf75d7068baae","cashier","NO","images/dp/asdas@gmail.com_516963.jpg","234235233","0"),
("42","Cedric","Yatco","Coloma","CYColoma764","female","1997-12-02","564a2cbca9975837aa0b32d98335b80a","cashier","NO","images/dp/CYColoma764_843584.png","1501408602","0"),
("43","Cedric","Yatco","Coloma","CYColoma194","male","1997-12-02","a70fafcc6f12a97f56e8a2419e146fae","cashier","YES","images/dp/CYColoma194_109636.png","1501408907","0"),
("44","Cedric","Yatco","Coloma","CYColoma457","male","1997-12-02","7a9f2045d9bc28de8633f94e56784664","cashier","NO","images/dp/CYColoma457_481724.png","1501410455","0"),
("45","Cedric","Yatco","Coloma","CYColoma543","male","1234-12-12","ed2b1f468c5f915f3f1cf75d7068baae","cashier","NO","images/dp/CYColoma543_678674.png","1501410621","1");


