/*
Navicat MySQL Data Transfer

Source Server         : 阿里云
Source Server Version : 50537
Source Host           : 114.215.80.214:3306
Source Database       : mqwork

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2016-08-03 22:35:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mq_vote
-- ----------------------------
DROP TABLE IF EXISTS `mq_vote`;
CREATE TABLE `mq_vote` (
  `vt_id` int(11) NOT NULL AUTO_INCREMENT,
  `vt_title` varchar(40) NOT NULL,
  `vt_ques_answ` text NOT NULL,
  `vt_votes` mediumtext,
  `vt_jianyi` tinytext,
  `vt_status` tinyint(1) NOT NULL DEFAULT '1',
  `vt_right` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为所有用户可看;1为投过票的可看;2为绝对保密',
  `vt_jytext` text,
  `vt_time` datetime DEFAULT NULL,
  PRIMARY KEY (`vt_id`),
  KEY `voteid` (`vt_id`) USING BTREE,
  KEY `vtstatus` (`vt_status`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk COMMENT='投票表';

-- ----------------------------
-- Records of mq_vote
-- ----------------------------
INSERT INTO `mq_vote` VALUES ('5', '您觉得扒扒名企网新版网站怎么样？', '您对扒扒名企网新版的整体感觉怎么样？|很好|不错|一般般吧|不好|太差了==新版的绿色调您觉得协调吗？|很不错|还可以|没什么感觉|换个调吧==您对新版网站的功能板块划分感觉如何？|功能很全|挺不错|还缺少功能==您觉得这个网站的内容对您有吸引力吗？|吸引力很大|还不错|有点吸引力吧|一个怪网站==您会把扒扒名企网加入收藏夹吗？|会加入|不会加入==您注意到首页右上角的扒扒名企网微博了吗？|看见了，很好|没注意|没有看见，没意思==您觉得扒扒名企网的LOGO怎么样？|很别致|看着也挺舒服|不咋的|太次了==您会再次观临扒扒名企网吗？|一定会的|可能|说不定啊|不来了太差了', '2|2|2|2|1|3|2|2|==2|1|1|1|2|2|1|3|整体还是不错的，不过广告有点多==3|2|2|3|2|2|2|2|==1|1|1|1|1|1|1|1|At last, smoeone who comes to the heart of it all==1|1|1|1|1|1|1|1|==2|2|1|2|2|2|2|2|==1|1|1|1|1|1|1|1|qhypaD http://www.FyLitCl7Pf7kjQdDUOLQOuaxTXbj5iNG.com==', '说说您的想法和建议吧！', '0', '1', '整体还是不错的不过广告有点多|2012-08-13 23:34:17||Atlastsmoeonewhocomestotheheartofitall|2012-08-30 00:50:02||qhypaDhttpwwwFyLitCl7Pf7kjQdDUOLQOuaxTXbj5iNGcom|2016-02-10 02:20:51||', '2012-08-11 21:42:11');
