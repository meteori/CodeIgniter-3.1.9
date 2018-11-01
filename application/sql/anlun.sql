/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 100132
 Source Host           : localhost:3306
 Source Schema         : anlun

 Target Server Type    : MySQL
 Target Server Version : 100132
 File Encoding         : 65001

 Date: 28/10/2018 21:23:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for order_wx
-- ----------------------------
DROP TABLE IF EXISTS `order_wx`;
CREATE TABLE `order_wx` (
  `openid` varchar(255) DEFAULT NULL,
  `crsNo` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=armscii8;

-- ----------------------------
-- Table structure for start_machine
-- ----------------------------
DROP TABLE IF EXISTS `start_machine`;
CREATE TABLE `start_machine` (
  `wx_username` varchar(0) NOT NULL,
  `start_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

SET FOREIGN_KEY_CHECKS = 1;
