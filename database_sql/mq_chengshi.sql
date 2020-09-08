/*
Navicat MySQL Data Transfer

Source Server         : 阿里Mysql
Source Server Version : 50537
Source Host           : 114.215.80.214:3306
Source Database       : mqwork

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2020-09-08 20:22:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mq_chengshi
-- ----------------------------
DROP TABLE IF EXISTS `mq_chengshi`;
CREATE TABLE `mq_chengshi` (
  `cs_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `cs_name` varchar(20) NOT NULL DEFAULT '',
  `cs_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cs_upid` int(8) unsigned NOT NULL DEFAULT '0',
  `cs_key` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`cs_id`),
  KEY `upid` (`cs_upid`)
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=gbk COMMENT='城市表';

-- ----------------------------
-- Records of mq_chengshi
-- ----------------------------
INSERT INTO `mq_chengshi` VALUES ('1', '北京市', '1', '0', '2');
INSERT INTO `mq_chengshi` VALUES ('2', '天津市', '1', '0', '4');
INSERT INTO `mq_chengshi` VALUES ('3', '河北省', '1', '0', '19');
INSERT INTO `mq_chengshi` VALUES ('4', '山西省', '1', '0', '20');
INSERT INTO `mq_chengshi` VALUES ('5', '内蒙古省', '1', '0', '32');
INSERT INTO `mq_chengshi` VALUES ('6', '辽宁省', '1', '0', '34');
INSERT INTO `mq_chengshi` VALUES ('7', '吉林省', '1', '0', '33');
INSERT INTO `mq_chengshi` VALUES ('8', '黑龙江省', '1', '0', '35');
INSERT INTO `mq_chengshi` VALUES ('9', '上海市', '1', '0', '3');
INSERT INTO `mq_chengshi` VALUES ('10', '江苏省', '1', '0', '7');
INSERT INTO `mq_chengshi` VALUES ('11', '浙江省', '1', '0', '9');
INSERT INTO `mq_chengshi` VALUES ('12', '安徽省', '1', '0', '31');
INSERT INTO `mq_chengshi` VALUES ('13', '福建省', '1', '0', '14');
INSERT INTO `mq_chengshi` VALUES ('14', '江西省', '1', '0', '15');
INSERT INTO `mq_chengshi` VALUES ('15', '山东省', '1', '0', '8');
INSERT INTO `mq_chengshi` VALUES ('16', '河南省', '1', '0', '18');
INSERT INTO `mq_chengshi` VALUES ('17', '湖北省', '1', '0', '17');
INSERT INTO `mq_chengshi` VALUES ('18', '湖南省', '1', '0', '16');
INSERT INTO `mq_chengshi` VALUES ('19', '广东省', '1', '0', '6');
INSERT INTO `mq_chengshi` VALUES ('20', '广西省', '1', '0', '29');
INSERT INTO `mq_chengshi` VALUES ('21', '海南省', '1', '0', '30');
INSERT INTO `mq_chengshi` VALUES ('22', '重庆市', '1', '0', '5');
INSERT INTO `mq_chengshi` VALUES ('23', '四川省', '1', '0', '10');
INSERT INTO `mq_chengshi` VALUES ('24', '贵州省', '1', '0', '28');
INSERT INTO `mq_chengshi` VALUES ('25', '云南省', '1', '0', '27');
INSERT INTO `mq_chengshi` VALUES ('26', '西藏省', '1', '0', '26');
INSERT INTO `mq_chengshi` VALUES ('27', '陕西省', '1', '0', '21');
INSERT INTO `mq_chengshi` VALUES ('28', '甘肃省', '1', '0', '22');
INSERT INTO `mq_chengshi` VALUES ('29', '青海省', '1', '0', '24');
INSERT INTO `mq_chengshi` VALUES ('30', '宁夏省', '1', '0', '23');
INSERT INTO `mq_chengshi` VALUES ('31', '新疆省', '1', '0', '25');
INSERT INTO `mq_chengshi` VALUES ('32', '台湾省', '1', '0', '13');
INSERT INTO `mq_chengshi` VALUES ('33', '香港', '1', '0', '11');
INSERT INTO `mq_chengshi` VALUES ('34', '澳门', '1', '0', '12');
INSERT INTO `mq_chengshi` VALUES ('35', '海外', '1', '0', '36');
INSERT INTO `mq_chengshi` VALUES ('36', '天津', '2', '2', null);
INSERT INTO `mq_chengshi` VALUES ('37', '美国', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('38', '加拿大', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('39', '澳大利亚', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('40', '新西兰', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('41', '英国', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('42', '法国', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('43', '德国', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('44', '捷克', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('45', '荷兰', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('46', '瑞士', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('47', '希腊', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('48', '挪威', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('49', '瑞典', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('50', '丹麦', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('51', '芬兰', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('52', '爱尔兰', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('53', '奥地利', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('54', '意大利', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('55', '乌克兰', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('56', '俄罗斯', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('57', '西班牙', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('58', '韩国', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('59', '新加坡', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('60', '马来西亚', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('61', '印度', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('62', '泰国', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('63', '日本', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('64', '巴西', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('65', '阿根廷', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('66', '南非', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('67', '埃及', '2', '35', null);
INSERT INTO `mq_chengshi` VALUES ('68', '北京', '2', '1', '1');
INSERT INTO `mq_chengshi` VALUES ('69', '威海', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('70', '潍坊', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('71', '厦门', '2', '13', '1');
INSERT INTO `mq_chengshi` VALUES ('72', '西宁', '2', '29', null);
INSERT INTO `mq_chengshi` VALUES ('73', '郑州', '2', '16', '1');
INSERT INTO `mq_chengshi` VALUES ('74', '盐城', '2', '10', null);
INSERT INTO `mq_chengshi` VALUES ('75', '徐州', '2', '10', null);
INSERT INTO `mq_chengshi` VALUES ('76', '新乡', '2', '16', null);
INSERT INTO `mq_chengshi` VALUES ('77', '成都', '2', '23', '1');
INSERT INTO `mq_chengshi` VALUES ('78', '扬州', '2', '10', null);
INSERT INTO `mq_chengshi` VALUES ('79', '宜宾', '2', '23', null);
INSERT INTO `mq_chengshi` VALUES ('80', '宜昌', '2', '17', null);
INSERT INTO `mq_chengshi` VALUES ('81', '枣庄', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('82', '中山', '2', '19', '1');
INSERT INTO `mq_chengshi` VALUES ('83', '淄博', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('84', '常州', '2', '10', null);
INSERT INTO `mq_chengshi` VALUES ('85', '珠海', '2', '19', null);
INSERT INTO `mq_chengshi` VALUES ('86', '长沙', '2', '18', '1');
INSERT INTO `mq_chengshi` VALUES ('87', '呼和浩特', '2', '5', '1');
INSERT INTO `mq_chengshi` VALUES ('88', '昆明', '2', '25', '1');
INSERT INTO `mq_chengshi` VALUES ('89', '长治', '2', '4', null);
INSERT INTO `mq_chengshi` VALUES ('90', '宁波', '2', '11', '1');
INSERT INTO `mq_chengshi` VALUES ('91', '内江', '2', '25', null);
INSERT INTO `mq_chengshi` VALUES ('92', '南通', '2', '10', null);
INSERT INTO `mq_chengshi` VALUES ('93', '南宁', '2', '20', '1');
INSERT INTO `mq_chengshi` VALUES ('94', '绍兴', '2', '11', null);
INSERT INTO `mq_chengshi` VALUES ('95', '唐山', '2', '3', '1');
INSERT INTO `mq_chengshi` VALUES ('96', '乌鲁木齐', '2', '31', '1');
INSERT INTO `mq_chengshi` VALUES ('97', '海门', '2', '10', null);
INSERT INTO `mq_chengshi` VALUES ('98', '长春', '2', '7', '1');
INSERT INTO `mq_chengshi` VALUES ('99', '龙口', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('100', '芜湖', '2', '12', null);
INSERT INTO `mq_chengshi` VALUES ('101', '鞍山', '2', '6', '0');
INSERT INTO `mq_chengshi` VALUES ('102', '常熟', '2', '10', null);
INSERT INTO `mq_chengshi` VALUES ('103', '南京', '2', '10', '1');
INSERT INTO `mq_chengshi` VALUES ('104', '铁岭', '2', '6', null);
INSERT INTO `mq_chengshi` VALUES ('105', '昆山', '2', '10', null);
INSERT INTO `mq_chengshi` VALUES ('106', '南昌', '2', '14', '1');
INSERT INTO `mq_chengshi` VALUES ('107', '滨州', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('108', '本溪', '2', '6', null);
INSERT INTO `mq_chengshi` VALUES ('109', '东营', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('110', '东莞', '2', '19', '1');
INSERT INTO `mq_chengshi` VALUES ('111', '哈尔滨', '2', '8', '1');
INSERT INTO `mq_chengshi` VALUES ('112', '广州', '2', '19', '1');
INSERT INTO `mq_chengshi` VALUES ('113', '安阳', '2', '16', null);
INSERT INTO `mq_chengshi` VALUES ('114', '佛山', '2', '19', '1');
INSERT INTO `mq_chengshi` VALUES ('115', '合肥', '2', '12', '1');
INSERT INTO `mq_chengshi` VALUES ('116', '杭州', '2', '11', '1');
INSERT INTO `mq_chengshi` VALUES ('117', '邯郸', '2', '3', '0');
INSERT INTO `mq_chengshi` VALUES ('118', '深圳', '2', '19', '1');
INSERT INTO `mq_chengshi` VALUES ('119', '保定', '2', '3', '0');
INSERT INTO `mq_chengshi` VALUES ('120', '苏州', '2', '10', '1');
INSERT INTO `mq_chengshi` VALUES ('121', '沈阳', '2', '6', '1');
INSERT INTO `mq_chengshi` VALUES ('122', '武汉', '2', '17', '1');
INSERT INTO `mq_chengshi` VALUES ('123', '济南', '2', '15', '1');
INSERT INTO `mq_chengshi` VALUES ('124', '惠州', '2', '19', null);
INSERT INTO `mq_chengshi` VALUES ('125', '包头', '2', '5', null);
INSERT INTO `mq_chengshi` VALUES ('126', '洛阳', '2', '16', null);
INSERT INTO `mq_chengshi` VALUES ('127', '柳州', '2', '20', null);
INSERT INTO `mq_chengshi` VALUES ('128', '临沂', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('129', '兰州', '2', '28', '1');
INSERT INTO `mq_chengshi` VALUES ('130', '衢州', '2', '11', null);
INSERT INTO `mq_chengshi` VALUES ('131', '齐齐哈尔', '2', '8', null);
INSERT INTO `mq_chengshi` VALUES ('132', '青岛', '2', '15', '1');
INSERT INTO `mq_chengshi` VALUES ('133', '大连', '2', '6', '1');
INSERT INTO `mq_chengshi` VALUES ('134', '商丘', '2', '16', null);
INSERT INTO `mq_chengshi` VALUES ('135', '日照', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('136', '石家庄', '2', '3', '1');
INSERT INTO `mq_chengshi` VALUES ('137', '太原', '2', '4', '1');
INSERT INTO `mq_chengshi` VALUES ('138', '泰安', '2', '15', null);
INSERT INTO `mq_chengshi` VALUES ('139', '无锡', '2', '10', '1');
INSERT INTO `mq_chengshi` VALUES ('140', '温州', '2', '11', '1');
INSERT INTO `mq_chengshi` VALUES ('141', '西安', '2', '27', '1');
INSERT INTO `mq_chengshi` VALUES ('142', '贵阳', '2', '24', '1');
INSERT INTO `mq_chengshi` VALUES ('143', '绵阳', '2', '23', null);
INSERT INTO `mq_chengshi` VALUES ('147', '澳门', '2', '34', '1');
INSERT INTO `mq_chengshi` VALUES ('146', '香港', '2', '33', '1');
INSERT INTO `mq_chengshi` VALUES ('144', '上海', '2', '9', '1');
INSERT INTO `mq_chengshi` VALUES ('145', '台北', '2', '32', '1');
INSERT INTO `mq_chengshi` VALUES ('148', '重庆', '2', '22', '1');
INSERT INTO `mq_chengshi` VALUES ('149', '海口', '2', '21', '1');
INSERT INTO `mq_chengshi` VALUES ('150', '拉萨', '2', '26', '1');
INSERT INTO `mq_chengshi` VALUES ('151', '银川', '2', '30', '1');
INSERT INTO `mq_chengshi` VALUES ('152', '九江', '2', '14', '0');
INSERT INTO `mq_chengshi` VALUES ('156', '余姚', '2', '11', '0');
INSERT INTO `mq_chengshi` VALUES ('157', '泰州', '2', '10', '0');
INSERT INTO `mq_chengshi` VALUES ('158', '漯河', '2', '16', '0');
INSERT INTO `mq_chengshi` VALUES ('159', '玉林', '2', '20', '0');
INSERT INTO `mq_chengshi` VALUES ('160', '福州', '2', '13', '1');
INSERT INTO `mq_chengshi` VALUES ('161', '邹城', '2', '15', '0');
INSERT INTO `mq_chengshi` VALUES ('162', '攀枝花', '2', '23', '0');
INSERT INTO `mq_chengshi` VALUES ('163', '贵溪', '2', '14', '0');
INSERT INTO `mq_chengshi` VALUES ('164', '淮北', '2', '12', '0');
INSERT INTO `mq_chengshi` VALUES ('165', '铜陵', '2', '12', '0');
INSERT INTO `mq_chengshi` VALUES ('166', '江门', '2', '19', '0');
INSERT INTO `mq_chengshi` VALUES ('167', '金昌', '2', '28', '0');
INSERT INTO `mq_chengshi` VALUES ('168', '嘉峪关', '2', '28', '0');
INSERT INTO `mq_chengshi` VALUES ('169', '伊春', '2', '5', '0');
INSERT INTO `mq_chengshi` VALUES ('170', '大同', '2', '4', '0');
INSERT INTO `mq_chengshi` VALUES ('171', '黄石', '2', '17', '0');
INSERT INTO `mq_chengshi` VALUES ('172', '新余', '2', '14', '0');
INSERT INTO `mq_chengshi` VALUES ('173', '韩城', '2', '27', '0');
INSERT INTO `mq_chengshi` VALUES ('174', '刑台', '2', '3', '0');
INSERT INTO `mq_chengshi` VALUES ('175', '新泰', '2', '15', '0');
INSERT INTO `mq_chengshi` VALUES ('176', '张家港', '2', '10', '0');
INSERT INTO `mq_chengshi` VALUES ('177', '宿州', '2', '12', '0');
INSERT INTO `mq_chengshi` VALUES ('178', '江阴', '2', '10', '0');
INSERT INTO `mq_chengshi` VALUES ('179', '廊坊', '2', '3', '0');
INSERT INTO `mq_chengshi` VALUES ('180', '招远', '2', '15', '0');
