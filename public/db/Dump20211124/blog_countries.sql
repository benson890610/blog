-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: blog
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `country_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` char(2) NOT NULL,
  `phone` varchar(10) NOT NULL,
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `countries_code_uk` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Afghanistan','AF','93'),(2,'Aland Islands','AX','358'),(3,'Albania','AL','355'),(4,'Algeria','DZ','213'),(5,'American Samoa','AS','1684'),(6,'Andorra','AD','376'),(7,'Angola','AO','244'),(8,'Anguilla','AI','1264'),(9,'Antarctica','AQ','672'),(10,'Antigua and Barbuda','AG','1268'),(11,'Argentina','AR','54'),(12,'Armenia','AM','374'),(13,'Aruba','AW','297'),(14,'Australia','AU','61'),(15,'Austria','AT','43'),(16,'Azerbaijan','AZ','994'),(17,'Bahamas','BS','1242'),(18,'Bahrain','BH','973'),(19,'Bangladesh','BD','880'),(20,'Barbados','BB','1246'),(21,'Belarus','BY','375'),(22,'Belgium','BE','32'),(23,'Belize','BZ','501'),(24,'Benin','BJ','229'),(25,'Bermuda','BM','1441'),(26,'Bhutan','BT','975'),(27,'Bolivia','BO','591'),(28,'Bonaire, Sint Eustatius and Saba','BQ','599'),(29,'Bosnia and Herzegovina','BA','387'),(30,'Botswana','BW','267'),(31,'Bouvet Island','BV','55'),(32,'Brazil','BR','55'),(33,'British Indian Ocean Territory','IO','246'),(34,'Brunei Darussalam','BN','673'),(35,'Bulgaria','BG','359'),(36,'Burkina Faso','BF','226'),(37,'Burundi','BI','257'),(38,'Cambodia','KH','855'),(39,'Cameroon','CM','237'),(40,'Canada','CA','1'),(41,'Cape Verde','CV','238'),(42,'Cayman Islands','KY','1345'),(43,'Central African Republic','CF','236'),(44,'Chad','TD','235'),(45,'Chile','CL','56'),(46,'China','CN','86'),(47,'Christmas Island','CX','61'),(48,'Cocos (Keeling) Islands','CC','672'),(49,'Colombia','CO','57'),(50,'Comoros','KM','269'),(51,'Congo','CG','242'),(52,'Congo, Democratic Republic of the Congo','CD','242'),(53,'Cook Islands','CK','682'),(54,'Costa Rica','CR','506'),(55,'Cote D\'Ivoire','CI','225'),(56,'Croatia','HR','385'),(57,'Cuba','CU','53'),(58,'Curacao','CW','599'),(59,'Cyprus','CY','357'),(60,'Czech Republic','CZ','420'),(61,'Denmark','DK','45'),(62,'Djibouti','DJ','253'),(63,'Dominica','DM','1767'),(64,'Dominican Republic','DO','1809'),(65,'Ecuador','EC','593'),(66,'Egypt','EG','20'),(67,'El Salvador','SV','503'),(68,'Equatorial Guinea','GQ','240'),(69,'Eritrea','ER','291'),(70,'Estonia','EE','372'),(71,'Ethiopia','ET','251'),(72,'Falkland Islands (Malvinas)','FK','500'),(73,'Faroe Islands','FO','298'),(74,'Fiji','FJ','679'),(75,'Finland','FI','358'),(76,'France','FR','33'),(77,'French Guiana','GF','594'),(78,'French Polynesia','PF','689'),(79,'French Southern Territories','TF','262'),(80,'Gabon','GA','241'),(81,'Gambia','GM','220'),(82,'Georgia','GE','995'),(83,'Germany','DE','49'),(84,'Ghana','GH','233'),(85,'Gibraltar','GI','350'),(86,'Greece','GR','30'),(87,'Greenland','GL','299'),(88,'Grenada','GD','1473'),(89,'Guadeloupe','GP','590'),(90,'Guam','GU','1671'),(91,'Guatemala','GT','502'),(92,'Guernsey','GG','44'),(93,'Guinea','GN','224'),(94,'Guinea-Bissau','GW','245'),(95,'Guyana','GY','592'),(96,'Haiti','HT','509'),(97,'Heard Island and Mcdonald Islands','HM','0'),(98,'Holy See (Vatican City State)','VA','39'),(99,'Honduras','HN','504'),(100,'Hong Kong','HK','852'),(101,'Hungary','HU','36'),(102,'Iceland','IS','354'),(103,'India','IN','91'),(104,'Indonesia','ID','62'),(105,'Iran, Islamic Republic of','IR','98'),(106,'Iraq','IQ','964'),(107,'Ireland','IE','353'),(108,'Isle of Man','IM','44'),(109,'Israel','IL','972'),(110,'Italy','IT','39'),(111,'Jamaica','JM','1876'),(112,'Japan','JP','81'),(113,'Jersey','JE','44'),(114,'Jordan','JO','962'),(115,'Kazakhstan','KZ','7'),(116,'Kenya','KE','254'),(117,'Kiribati','KI','686'),(118,'Korea, Democratic People\'s Republic of','KP','850'),(119,'Korea, Republic of','KR','82'),(120,'Kosovo','XK','381'),(121,'Kuwait','KW','965'),(122,'Kyrgyzstan','KG','996'),(123,'Lao People\'s Democratic Republic','LA','856'),(124,'Latvia','LV','371'),(125,'Lebanon','LB','961'),(126,'Lesotho','LS','266'),(127,'Liberia','LR','231'),(128,'Libyan Arab Jamahiriya','LY','218'),(129,'Liechtenstein','LI','423'),(130,'Lithuania','LT','370'),(131,'Luxembourg','LU','352'),(132,'Macao','MO','853'),(133,'Macedonia, the Former Yugoslav Republic of','MK','389'),(134,'Madagascar','MG','261'),(135,'Malawi','MW','265'),(136,'Malaysia','MY','60'),(137,'Maldives','MV','960'),(138,'Mali','ML','223'),(139,'Malta','MT','356'),(140,'Marshall Islands','MH','692'),(141,'Martinique','MQ','596'),(142,'Mauritania','MR','222'),(143,'Mauritius','MU','230'),(144,'Mayotte','YT','269'),(145,'Mexico','MX','52'),(146,'Micronesia, Federated States of','FM','691'),(147,'Moldova, Republic of','MD','373'),(148,'Monaco','MC','377'),(149,'Mongolia','MN','976'),(150,'Montenegro','ME','382'),(151,'Montserrat','MS','1664'),(152,'Morocco','MA','212'),(153,'Mozambique','MZ','258'),(154,'Myanmar','MM','95'),(155,'Namibia','NA','264'),(156,'Nauru','NR','674'),(157,'Nepal','NP','977'),(158,'Netherlands','NL','31'),(159,'Netherlands Antilles','AN','599'),(160,'New Caledonia','NC','687'),(161,'New Zealand','NZ','64'),(162,'Nicaragua','NI','505'),(163,'Niger','NE','227'),(164,'Nigeria','NG','234'),(165,'Niue','NU','683'),(166,'Norfolk Island','NF','672'),(167,'Northern Mariana Islands','MP','1670'),(168,'Norway','NO','47'),(169,'Oman','OM','968'),(170,'Pakistan','PK','92'),(171,'Palau','PW','680'),(172,'Palestinian Territory, Occupied','PS','970'),(173,'Panama','PA','507'),(174,'Papua New Guinea','PG','675'),(175,'Paraguay','PY','595'),(176,'Peru','PE','51'),(177,'Philippines','PH','63'),(178,'Pitcairn','PN','64'),(179,'Poland','PL','48'),(180,'Portugal','PT','351'),(181,'Puerto Rico','PR','1787'),(182,'Qatar','QA','974'),(183,'Reunion','RE','262'),(184,'Romania','RO','40'),(185,'Russian Federation','RU','70'),(186,'Rwanda','RW','250'),(187,'Saint Barthelemy','BL','590'),(188,'Saint Helena','SH','290'),(189,'Saint Kitts and Nevis','KN','1869'),(190,'Saint Lucia','LC','1758'),(191,'Saint Martin','MF','590'),(192,'Saint Pierre and Miquelon','PM','508'),(193,'Saint Vincent and the Grenadines','VC','1784'),(194,'Samoa','WS','684'),(195,'San Marino','SM','378'),(196,'Sao Tome and Principe','ST','239'),(197,'Saudi Arabia','SA','966'),(198,'Senegal','SN','221'),(199,'Serbia','RS','381'),(200,'Serbia and Montenegro','CS','381'),(201,'Seychelles','SC','248'),(202,'Sierra Leone','SL','232'),(203,'Singapore','SG','65'),(204,'Sint Maarten','SX','1'),(205,'Slovakia','SK','421'),(206,'Slovenia','SI','386'),(207,'Solomon Islands','SB','677'),(208,'Somalia','SO','252'),(209,'South Africa','ZA','27'),(210,'South Georgia and the South Sandwich Islands','GS','500'),(211,'South Sudan','SS','211'),(212,'Spain','ES','34'),(213,'Sri Lanka','LK','94'),(214,'Sudan','SD','249'),(215,'Suriname','SR','597'),(216,'Svalbard and Jan Mayen','SJ','47'),(217,'Swaziland','SZ','268'),(218,'Sweden','SE','46'),(219,'Switzerland','CH','41'),(220,'Syrian Arab Republic','SY','963'),(221,'Taiwan, Province of China','TW','886'),(222,'Tajikistan','TJ','992'),(223,'Tanzania, United Republic of','TZ','255'),(224,'Thailand','TH','66'),(225,'Timor-Leste','TL','670'),(226,'Togo','TG','228'),(227,'Tokelau','TK','690'),(228,'Tonga','TO','676'),(229,'Trinidad and Tobago','TT','1868'),(230,'Tunisia','TN','216'),(231,'Turkey','TR','90'),(232,'Turkmenistan','TM','7370'),(233,'Turks and Caicos Islands','TC','1649'),(234,'Tuvalu','TV','688'),(235,'Uganda','UG','256'),(236,'Ukraine','UA','380'),(237,'United Arab Emirates','AE','971'),(238,'United Kingdom','GB','44'),(239,'United States','US','1'),(240,'United States Minor Outlying Islands','UM','1'),(241,'Uruguay','UY','598'),(242,'Uzbekistan','UZ','998'),(243,'Vanuatu','VU','678'),(244,'Venezuela','VE','58'),(245,'Viet Nam','VN','84'),(246,'Virgin Islands, British','VG','1284'),(247,'Virgin Islands, U.s.','VI','1340'),(248,'Wallis and Futuna','WF','681'),(249,'Western Sahara','EH','212'),(250,'Yemen','YE','967'),(251,'Zambia','ZM','260'),(252,'Zimbabwe','ZW','263');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-24 13:49:19
