-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: wish
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(32) NOT NULL,
  `password` varchar(70) NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `openid` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','c4ca4238a0b923820dcc509a6f75849b','罗嗣卿',1,'2015214310','oAS95weWTdF9T1g6OqOAUm0WQHPI');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wish`
--

DROP TABLE IF EXISTS `wish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` int(10) unsigned NOT NULL,
  `content` varchar(255) NOT NULL,
  `img` varchar(100) NOT NULL,
  `guy` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `deadline` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `angel_id` int(10) unsigned NOT NULL DEFAULT '0',
  `angel_guy` varchar(10) NOT NULL DEFAULT '',
  `angel_phone` varchar(15) NOT NULL DEFAULT '',
  `cancel_reason` varchar(255) NOT NULL DEFAULT '',
  `cancel_time` int(11) NOT NULL DEFAULT '0',
  `done` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wish`
--

LOCK TABLES `wish` WRITE;
/*!40000 ALTER TABLE `wish` DISABLE KEYS */;
INSERT INTO `wish` VALUES (1,1,'测试','','罗嗣卿','18888888888',1999222222,1333333333,0,'','','123',1513498901,0),(2,1,'哇哇哇哇谁帮我取个快递呀','','罗斯情','18888888888',1999999999,1999999999,1,'谷田','19999999999','',0,0),(3,1,'哇哇哇哇谁帮我取个快递呀','https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=1876329048,621353300&fm=58&bpow=900&bpoh=589','罗斯情','18888888888',1999999999,1999999999,1,'谷田','19999999999','',0,0),(4,1,'哇哇哇哇谁帮我取个快递呀','https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=1876329048,621353300&fm=58&bpow=900&bpoh=589','罗斯情','18888888888',1999999999,1999999999,0,'','','123123',1513499050,0),(5,1,'哇哇哇哇谁帮我取个快递呀','https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=1876329048,621353300&fm=58&bpow=900&bpoh=589','罗斯情','18888888888',1999999999,1999999999,2015214288,'hujialin','110','',0,0),(6,1,'哇哇哇哇谁帮我取个快递呀','https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=1876329048,621353300&fm=58&bpow=900&bpoh=589','罗斯情','18888888888',1999999999,1999999999,1,'谷田1','19999999999','',0,1),(7,1,'admin','','罗斯情','18846938586',1513594980,1513506186,2015214288,'hujailin','123','',0,0),(8,1,'123','','罗嗣卿','2015214310',1513592580,1513506198,0,'','','3434',1513514397,0),(9,1,'lalalala','http://wish.nefuer.net/Uploads/2017-12-17/5a3663138f7a2.png','罗嗣卿','2015214310',1513600080,1513513748,0,'','','123',1513513904,0),(10,1,'23','http://wish.nefuer.net/Uploads/2017-12-17/5a36636721ad5.png','罗嗣卿','2015214310',1513600200,1513513835,2015214310,'谷田','18846938586','',0,0),(11,1,'hjlhlh','','罗嗣卿','2015214310',1513600800,1513514414,2016214157,'王诚','18845127116','',0,0),(12,1,'哈哈哈','','罗嗣卿','2015214310',1513603140,1513516764,2015224196,'刘晓蕊','22222222222','',0,0),(13,1,'哈哈哈','http://wish.nefuer.net/Uploads/2017-12-17/5a36778477df5.jpg','罗嗣卿','2015214310',1513605360,1513518984,2015214177,'ggg','fgg','',0,0),(14,1,'233','http://wish.jblog.info/Uploads/2017-12-17/5a3677ea12234.jpg','罗嗣卿','2015214310',1513605420,1513519085,0,'','','',0,0),(15,1,'拿东西','http://wish.jblog.info/Uploads/2017-12-18/5a371f1fd0022.jpg','罗嗣卿','2015214310',1513651860,1513561907,2015214310,'米粒','5454545454','',0,0),(16,1,'f发货','','罗嗣卿','2015214310',1513737720,1513565013,1000002214,'张锡英','13100969429','',0,0),(17,1,'要查看作业','','罗嗣卿','2015214310',1513653240,1513566898,1000002214,'张锡英','13100969429','',0,0),(18,1,'约车去火车站','http://wish.jblog.info/Uploads/2017-12-18/5a3786e74017c.jpg','罗嗣卿','2015214310',1513761240,1513588487,0,'','','',0,0),(19,1,'123123','','罗嗣卿','2015214310',1514379900,1514293541,0,'','','',0,0),(20,1,'测试测试测试','','罗嗣卿','2015214310',1521879420,1521706673,0,'','','',0,0),(21,1,'谁能帮我买个西瓜','http://wish.jblog.info/Uploads/2018-03-31/5abf22da61e4b.jpg','罗嗣卿','2015214310',1522573860,1522475766,0,'','','',0,0);
/*!40000 ALTER TABLE `wish` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-31 14:37:31
