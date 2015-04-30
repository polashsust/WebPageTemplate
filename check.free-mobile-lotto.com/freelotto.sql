/*
Navicat MySQL Data Transfer

Source Server         : live
Source Server Version : 50166
Source Host           : localhost:3306
Source Database       : freelotto

Target Server Type    : MYSQL
Target Server Version : 50166
File Encoding         : 65001

Date: 2013-09-18 17:50:16
*/
CREATE DATABASE IF NOT EXISTS `freelotto` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `freelotto`;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lotto
-- ----------------------------
DROP TABLE IF EXISTS `lotto`;
CREATE TABLE `lotto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) unsigned NOT NULL,
  `uniqueid` char(16) DEFAULT NULL,
  `fortunoruniqueid` char(32) DEFAULT NULL,
  `digit1` int(11) DEFAULT NULL,
  `digit2` int(11) DEFAULT NULL,
  `digit3` int(11) DEFAULT NULL,
  `digit4` int(11) DEFAULT NULL,
  `digit5` int(11) DEFAULT NULL,
  `digit6` int(11) DEFAULT NULL,
  `additionaldigit` int(11) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_id` (`payment_id`),
  CONSTRAINT `lotto_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lotto
-- ----------------------------
INSERT INTO `lotto` VALUES ('1', '1', null, null, null, null, null, null, null, null, null, null, null, '2013-09-18 12:37:06', '2013-09-18 12:37:06');
INSERT INTO `lotto` VALUES ('2', '2', null, null, null, null, null, null, null, null, null, null, null, '2013-09-18 13:09:13', '2013-09-18 13:09:13');
INSERT INTO `lotto` VALUES ('3', '3', null, null, '14', '22', '15', '39', '49', '18', '47', null, null, '2013-09-18 13:22:33', '2013-09-18 13:22:33');
INSERT INTO `lotto` VALUES ('4', '4', null, null, null, null, null, null, null, null, null, null, null, '2013-09-18 13:35:38', '2013-09-18 13:35:38');
INSERT INTO `lotto` VALUES ('5', '5', null, null, '43', '44', '45', '46', '48', '49', '42', null, null, '2013-09-18 14:27:52', '2013-09-18 14:27:52');
INSERT INTO `lotto` VALUES ('6', '6', null, null, '22', '23', '24', '25', '26', '27', '28', null, null, '2013-09-18 14:29:04', '2013-09-18 14:29:04');
INSERT INTO `lotto` VALUES ('7', '7', null, null, '43', '37', '31', '25', '19', '13', '7', null, null, '2013-09-18 14:41:54', '2013-09-18 14:41:54');
INSERT INTO `lotto` VALUES ('8', '8', null, null, '43', '37', '38', '39', '40', '33', '32', null, null, '2013-09-18 15:54:31', '2013-09-18 15:54:31');
INSERT INTO `lotto` VALUES ('9', '9', null, null, '24', '23', '15', '43', '2', '4', '34', null, null, '2013-09-18 16:11:35', '2013-09-18 16:11:35');
INSERT INTO `lotto` VALUES ('10', '10', null, null, '37', '31', '11', '41', '32', '2', '42', null, null, '2013-09-18 16:15:22', '2013-09-18 16:15:22');
INSERT INTO `lotto` VALUES ('11', '11', null, null, '1', '2', '3', '4', '5', '6', '7', null, null, '2013-09-18 16:15:50', '2013-09-18 16:15:50');
INSERT INTO `lotto` VALUES ('12', '12', null, null, '12', '23', '34', '9', '25', '38', '49', null, null, '2013-09-18 16:25:00', '2013-09-18 16:25:00');
INSERT INTO `lotto` VALUES ('13', '13', null, null, '23', '15', '28', '45', '18', '40', '38', null, null, '2013-09-18 16:29:33', '2013-09-18 16:29:33');
INSERT INTO `lotto` VALUES ('14', '14', null, null, '10', '43', '17', '29', '46', '12', '1', null, null, '2013-09-18 16:37:14', '2013-09-18 16:37:14');
INSERT INTO `lotto` VALUES ('15', '15', null, null, '9', '17', '25', '33', '38', '20', '4', null, null, '2013-09-18 16:45:57', '2013-09-18 16:45:57');
INSERT INTO `lotto` VALUES ('16', '16', null, null, '43', '44', '45', '46', '47', '48', '49', null, null, '2013-09-18 17:04:39', '2013-09-18 17:04:39');

-- ----------------------------
-- Table structure for lottoresult
-- ----------------------------
DROP TABLE IF EXISTS `lottoresult`;
CREATE TABLE `lottoresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `number1` int(2) DEFAULT NULL,
  `number2` int(2) DEFAULT NULL,
  `number3` int(2) DEFAULT NULL,
  `number4` int(2) DEFAULT NULL,
  `number5` int(2) DEFAULT NULL,
  `number6` int(2) DEFAULT NULL,
  `number7` int(2) DEFAULT NULL,
  `updatedtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lottoresult
-- ----------------------------
INSERT INTO `lottoresult` VALUES ('1', '2013-09-17', '4', '18', '30', '36', '38', '39', '24', '2013-09-18 17:41:16');

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniquenumber` char(40) NOT NULL,
  `shortnumber` char(14) NOT NULL,
  `descriptor` varchar(196) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `okforlottery` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(45) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment
-- ----------------------------
INSERT INTO `payment` VALUES ('1', 't0gti2agua0clk6p9zvvvu40iitsijt23uahctny', 'QPSM8P5D6KBY', 'QPSM8P5D6KBY freelotto payment', null, '0', '87.139.112.101', '2013-09-18 12:37:06', '2013-09-18 12:37:06');
INSERT INTO `payment` VALUES ('2', 'g0q5g62dr09c8d4twmfrnxzvwezcg7dvrsh9r80f', 'QPBPGRFDSZQM', 'QPBPGRFDSZQM freelotto payment', null, '0', '87.139.112.101', '2013-09-18 13:09:13', '2013-09-18 13:09:13');
INSERT INTO `payment` VALUES ('3', 'dqagjy070so4ap9bxvan5e3uf31ujqkt6gke2zst', 'QPSMPJ524S47', 'QPSMPJ524S47 freelotto payment', null, '0', '87.139.112.101', '2013-09-18 13:22:33', '2013-09-18 13:22:33');
INSERT INTO `payment` VALUES ('4', 'uu7aygrcaljkpd4md5eb6qmi8ez4fixzoxzamje4', 'QPEEFLMTDY42', 'QPEEFLMTDY42 freelotto payment', null, '0', '87.139.112.101', '2013-09-18 13:35:38', '2013-09-18 13:35:38');
INSERT INTO `payment` VALUES ('5', 'nlq4oiaxfvjts4pvbneh5tp0uuarduda4x01l1kp', 'QPBZPRGHBSGJ', 'QPBZPRGHBSGJ freelotto payment', null, '0', '87.139.112.101', '2013-09-18 14:27:52', '2013-09-18 14:27:52');
INSERT INTO `payment` VALUES ('6', 'oihzj14i715tt2vr4bcfi847shmg0hhr0cnguhu1', 'QP9CZN25DHLV', 'QP9CZN25DHLV freelotto payment', null, '0', '87.139.112.101', '2013-09-18 14:29:04', '2013-09-18 14:29:04');
INSERT INTO `payment` VALUES ('7', 'qhd4v8qatt8ivik8206v9l0l3knpopz4rmlrhas5', 'QPN1L3FQTWQM', 'QPN1L3FQTWQM freelotto payment', null, '0', '87.139.112.101', '2013-09-18 14:41:54', '2013-09-18 14:41:54');
INSERT INTO `payment` VALUES ('8', '52vtuaz5wqagz5k3b0f3d8wsirodch6qogfpr7wg', 'QPFXAA27E4RY', 'QPFXAA27E4RY freelotto payment', null, '0', '87.139.112.101', '2013-09-18 15:54:31', '2013-09-18 15:54:31');
INSERT INTO `payment` VALUES ('9', '2ujlb0lli5kcszp5kcsi08ac4r2a7tk7ri2s3uef', 'QPE6ATBWY2BJ', 'QPE6ATBWY2BJ freelotto payment', null, '0', '87.139.26.129', '2013-09-18 16:11:35', '2013-09-18 16:11:35');
INSERT INTO `payment` VALUES ('10', '9hsnd0vwka9tfnymigovx7xote2mdr9pakn3ruhb', 'QPBZJ65M2X6M', 'QPBZJ65M2X6M freelotto payment', null, '0', '87.139.26.129', '2013-09-18 16:15:22', '2013-09-18 16:15:22');
INSERT INTO `payment` VALUES ('11', 'mejsjn9dlvxkjrupnyg7ox839xb6jpylnrnxjozr', 'QPYZ326ZN4JE', 'QPYZ326ZN4JE freelotto payment', null, '0', '87.139.26.129', '2013-09-18 16:15:50', '2013-09-18 16:15:50');
INSERT INTO `payment` VALUES ('12', 'r5zpub7ikegpneh3a1fiib5y2d6trb4rac6nxqhs', 'QPGVJV2XHGTV', 'QPGVJV2XHGTV freelotto payment', null, '0', '87.139.26.129', '2013-09-18 16:25:00', '2013-09-18 16:25:00');
INSERT INTO `payment` VALUES ('13', 'eodpvplj145gbwlfvsstcx7e9g0yivhktcunyvvf', 'QP9VYQVE48RX', 'QP9VYQVE48RX freelotto payment', null, '0', '87.139.26.129', '2013-09-18 16:29:33', '2013-09-18 16:29:33');
INSERT INTO `payment` VALUES ('14', 's4cu6vjyi2da9vsgfr9g0ab387ehql72o5c171br', 'QPFF1A25BG9B', 'QPFF1A25BG9B freelotto payment', null, '0', '87.139.26.129', '2013-09-18 16:37:14', '2013-09-18 16:37:14');
INSERT INTO `payment` VALUES ('15', 'm2icein1hm615ij5wjlfdt2bzi0095osieiirbrc', 'QP3X7CX947EC', 'QP3X7CX947EC freelotto payment', null, '0', '87.139.26.129', '2013-09-18 16:45:57', '2013-09-18 16:45:57');
INSERT INTO `payment` VALUES ('16', 'r9sb3kqcaymwcslt4btsszmrsdf4e8lim4gyc1si', 'QP9FLGV1GA5C', 'QP9FLGV1GA5C freelotto payment', null, '0', '87.139.112.101', '2013-09-18 17:04:39', '2013-09-18 17:04:39');

-- ----------------------------
-- Table structure for paymentcustomer
-- ----------------------------
DROP TABLE IF EXISTS `paymentcustomer`;
CREATE TABLE `paymentcustomer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) unsigned NOT NULL,
  `given` varchar(255) DEFAULT NULL,
  `family` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `emailsent` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_id` (`payment_id`),
  CONSTRAINT `paymentcustomer_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of paymentcustomer
-- ----------------------------
INSERT INTO `paymentcustomer` VALUES ('1', '1', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('2', '2', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('3', '3', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('4', '4', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('5', '5', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('6', '6', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('7', '7', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('8', '8', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('9', '9', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('10', '10', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('11', '11', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('12', '12', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('13', '13', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('14', '14', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('15', '15', null, null, null, null, '0');
INSERT INTO `paymentcustomer` VALUES ('16', '16', null, null, null, null, '0');
