/*
Navicat MySQL Data Transfer

Source Server         : 我是新的
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : 361jiaoyu

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-10-17 15:55:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `site_calendar`
-- ----------------------------
DROP TABLE IF EXISTS `site_calendar`;
CREATE TABLE `site_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) DEFAULT NULL,
  `allday` tinyint(1) NOT NULL DEFAULT '0',
  `color` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_calendar
-- ----------------------------
INSERT INTO `site_calendar` VALUES ('1', '的发生', '1476748800', '0', '1', '#06c');
INSERT INTO `site_calendar` VALUES ('2', '发大水发大水', '1476748800', '1476763200', '0', '#f30');
INSERT INTO `site_calendar` VALUES ('3', '发送发的撒的发生', '1476855600', '1476864000', '0', '#360');
INSERT INTO `site_calendar` VALUES ('4', '77777', '1476921600', '1476936000', '0', '#360');
INSERT INTO `site_calendar` VALUES ('5', '发送到', '1476720000', '0', '1', '#360');
INSERT INTO `site_calendar` VALUES ('6', '发大水', '1476720000', '0', '1', '#06c');
INSERT INTO `site_calendar` VALUES ('7', '发生的发生', '1476720000', '0', '1', '#06c');
INSERT INTO `site_calendar` VALUES ('8', '发生的发大水发大水', '1476720000', '0', '1', '#f30');
INSERT INTO `site_calendar` VALUES ('9', '77777', '1474934400', '1474948800', '0', '#06c');
INSERT INTO `site_calendar` VALUES ('10', '法师打发沙发沙发沙发', '1476633600', '0', '1', '#06c');
INSERT INTO `site_calendar` VALUES ('11', '规定是否打算', '1476144000', '1476158400', '0', '#f30');
