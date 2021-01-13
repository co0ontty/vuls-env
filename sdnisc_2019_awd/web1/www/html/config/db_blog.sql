/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : db_blog

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-02-07 20:30:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章的id',
  `a_title` char(255) DEFAULT NULL COMMENT '文章的中文标题',
  `a_begin_text` char(255) DEFAULT NULL COMMENT '文章的简介',
  `a_text` text COMMENT '文章的内容',
  `a_adddate` char(255) DEFAULT NULL,
  `a_adduser` char(255) DEFAULT NULL COMMENT '文章发布作者',
  `a_p_type` tinyint(4) DEFAULT NULL COMMENT '文章的类型',
  `a_type` char(255) DEFAULT NULL COMMENT '文章的分类表示',
  `a_comment` int(11) DEFAULT '0' COMMENT '文章评论',
  `a_photo` char(255) DEFAULT NULL,
  `a_state` tinyint(4) DEFAULT NULL,
  `a_visit` int(11) DEFAULT '0' COMMENT '文章浏览数',
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('2', '关于我的介绍', '第一次想做这么一个网站，去记录自己的生活和学习，前行的脚步太过匆忙，不如停下来好好整理整理，自己选择的路，不论如何都要走完。', '\r\n    Just about me\r\n\r\n    About my blog\r\n\r\n    域 名：www.rainweb.site 创建于2017年01月20日\r\n\r\n    服务器：Centos6.5 + mysql5.6 + php5 \r\n\r\n    程 序：PHP', '2017-01-20', '魏春雨', '2', '生活', '10', '/images/01.jpg', '1', '10');
INSERT INTO `article` VALUES ('3', '压缩算法', '无论是在我们的开发项目中，还是在我们的日常生活中，都会较多的涉及到文件压缩。谈到文件压缩，可能会有人想问文件压缩到底是怎么实现的，实现的原理是什么，对于开发人员来说，怎么实现这样一个压缩的功能。', '无论是在我们的开发项目中，还是在我们的日常生活中，都会较多的涉及到文件压缩。谈到文件压缩，可能会有人想问文件压缩到底是怎么实现的，实现的原理是什么，对于开发人员来说，怎么实现这样一个压缩的功能。\r\n\r\n接下来，我们就来了解一下文件压缩的相关知识。文件压缩是如何实现的？这个我们就得了解一下数据结构，因为文件在压缩的过程中会转化为数据流，那么如何将数据流进行对应的压缩，这个问题就得靠算法来实现。那么文件压缩的算法是什么呢？那就是HuffmanTree。\r\n\r\n', '2017-01-22', '魏春雨', '1', '算法，技术', '0', '/images/article2.jpg', '0', '10');
INSERT INTO `article` VALUES ('13', '4324', '4324', '4324', '2017-01-19', '432', '1', '4324', '0', '1', '0', '0');

-- ----------------------------
-- Table structure for `diary`
-- ----------------------------
DROP TABLE IF EXISTS `diary`;
CREATE TABLE `diary` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '随记的数据表',
  `d_title` char(255) DEFAULT NULL,
  `d_date` date DEFAULT NULL,
  `d_text` text,
  PRIMARY KEY (`d_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of diary
-- ----------------------------
INSERT INTO `diary` VALUES ('1', '我的博客', '2017-01-21', '今天刚刚写好，欢迎大家都访问和留言，更多功能还会继续开发。');
INSERT INTO `diary` VALUES ('2', '第一篇随记', '2017-01-20', '和文章不同，随记是随时记录一下简单的，简短的文字，心情而已');

-- ----------------------------
-- Table structure for `friend`
-- ----------------------------
DROP TABLE IF EXISTS `friend`;
CREATE TABLE `friend` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_time` char(255) DEFAULT NULL,
  `f_href` char(255) DEFAULT NULL,
  `f_name` char(255) DEFAULT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of friend
-- ----------------------------

-- ----------------------------
-- Table structure for `ip`
-- ----------------------------
DROP TABLE IF EXISTS `ip`;
CREATE TABLE `ip` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_time` char(255) DEFAULT NULL,
  `i_ip` char(255) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ip
-- ----------------------------

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_name` char(255) DEFAULT NULL,
  `m_photo` char(255) DEFAULT NULL,
  `m_text` text,
  `m_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('1', 'Peter', 'images/userpic.gif', 'Griffin', '2016-11-10 15:48:53');
INSERT INTO `message` VALUES ('2', 'wcy', 'images/userpic.gif', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.\r\n								Donec libero. Suspendisse bibendum. Cras id urna. Morbi\r\n								tincidunt, orci ac convallis aliquam, lectus turpis varius\r\n								lorem, eu posuere nunc justo tempus leo.', '2016-11-10 15:49:03');
INSERT INTO `message` VALUES ('22', '(¯―¯٥)', 'images/userpic.gif', '(」゜ロ゜)」啦啦啦⸜(* ॑꒳ ॑* )⸝', '2017-01-20 00:00:00');
INSERT INTO `message` VALUES ('23', 'onion', 'images/userpic.gif', '愣傻子', '2017-01-20 00:00:00');

-- ----------------------------
-- Table structure for `photo`
-- ----------------------------
DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` char(255) DEFAULT NULL,
  `p_src` char(255) DEFAULT NULL,
  `p_addtime` datetime DEFAULT NULL,
  `p_type` tinyint(4) DEFAULT NULL,
  `p_note` char(255) DEFAULT NULL,
  `p_adduser` char(255) DEFAULT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photo
-- ----------------------------
INSERT INTO `photo` VALUES ('1', '小黄人', 'images/001.jpg', '2016-11-11 16:11:53', '1', 'wu', 'wcy');
INSERT INTO `photo` VALUES ('2', '小黄人2', 'images/002.jpg', '2016-12-24 16:12:31', '1', 'wu', 'wcy');
INSERT INTO `photo` VALUES ('3', '小黄人3', 'images/003.jpg', '2016-11-11 16:13:06', '1', 'wu', 'rain');
INSERT INTO `photo` VALUES ('4', '小黄人4', 'images/004.jpg', '2016-11-09 00:00:00', '1', 'wu', 'rai');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` char(255) DEFAULT NULL,
  `u_passwd` char(255) DEFAULT NULL,
  `u_photo` char(255) DEFAULT NULL,
  `u_last_time` datetime DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for `visit`
-- ----------------------------
DROP TABLE IF EXISTS `visit`;
CREATE TABLE `visit` (
  `v_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ip访问的表',
  `v_ip` char(255) DEFAULT NULL COMMENT '访问ip',
  `v_i_num` int(11) DEFAULT '0',
  `v_state` tinyint(4) DEFAULT NULL,
  `v_e_id` int(11) DEFAULT NULL,
  `v_m_id` int(11) DEFAULT NULL,
  `v_e_num` int(11) DEFAULT '0',
  `v_m_num` int(11) DEFAULT '0',
  `v_date` char(255) DEFAULT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of visit
-- ----------------------------
