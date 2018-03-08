-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-03-08 09:32:19
-- 服务器版本： 10.1.25-MariaDB
-- PHP Version: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company`
--

DELIMITER $$
--
-- 存储过程
--
CREATE DEFINER=```root```@```localhost``` PROCEDURE `init_detail_vacation` ()  NO SQL
begin
UPDATE `ci_vacation` SET jan=0,feb=0,mar=0,apr=0,may=0,jun=0,jul=0,aug=0,sep=0,oct=0,nov=0,`dec`=0 WHERE uid > 0;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `vacation_copy` ()  begin
insert into `ci_record` (uid,year,standard,real_vacation,have_vacation,left_vacation,last_standard,last_real,last_have,last_left,pre_left,pre_vacation,jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,`dec`) select uid,year,standard,real_vacation,have_vacation,left_vacation,last_standard,last_real,last_have,last_left,pre_left,pre_vacation,jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,`dec` from `ci_vacation`;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `ci_assign_user`
--

CREATE TABLE `ci_assign_user` (
  `id` int(11) NOT NULL,
  `quarter_id` int(11) NOT NULL COMMENT '分配季度id',
  `user_id` int(11) NOT NULL COMMENT '被评用户id',
  `judger_id` int(11) NOT NULL COMMENT '评价人id',
  `create_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分配用户表';

-- --------------------------------------------------------

--
-- 表的结构 `ci_auth_group`
--

CREATE TABLE `ci_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '' COMMENT '角色名称（用户组中文名称）',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text NOT NULL,
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  `remark` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ci_auth_group`
--

INSERT INTO `ci_auth_group` (`id`, `title`, `status`, `rules`, `add_time`, `update_time`, `remark`) VALUES
(1, '超级管理员', 1, '1,109,140,175,173,174,176,179,154,170,171,172,166,167,168,169,155,163,164,165,156,157,158,159,33,105,43,108,116,103,35,45,119,120,161,28,2', '2017-02-10 14:40:53', '2018-01-17 11:17:44', ''),
(2, '管理员', 1, '1,109,140,175,173,174,176,154,170,171,172,166,167,168,169,155,163,164,165,156,157,158,159,33,35,45,119,120,161,28,2', '2017-02-10 15:13:33', '2017-06-28 08:58:44', ''),
(33, '员工', 1, '1,109,175,178,154,170,171,172,166,167,155,156,157,158,159,33,105,103,35,28,2,29', '2017-05-17 14:56:53', '2017-06-20 14:48:42', ''),
(35, '员工考核', 1, '1,109,175,173,174,154,170,171,172', '2017-05-17 15:04:06', '2017-07-03 09:45:22', '跨部门考核');

-- --------------------------------------------------------

--
-- 表的结构 `ci_auth_group_access`
--

CREATE TABLE `ci_auth_group_access` (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ci_auth_group_access`
--

INSERT INTO `ci_auth_group_access` (`uid`, `group_id`) VALUES
(1, 1),
(27, 35),
(28, 35),
(29, 35),
(31, 35),
(34, 35),
(35, 35),
(36, 35),
(39, 35),
(42, 35),
(43, 35),
(51, 35),
(52, 35),
(54, 35),
(55, 35),
(56, 35),
(57, 35),
(58, 35),
(59, 35),
(60, 35),
(61, 35),
(62, 35),
(63, 35),
(64, 35),
(65, 35),
(67, 35),
(68, 35),
(69, 35),
(70, 35),
(71, 35),
(72, 35),
(74, 35),
(75, 35),
(76, 35),
(77, 35),
(78, 35),
(79, 35),
(80, 35),
(81, 35),
(83, 35),
(84, 35),
(86, 35),
(87, 35),
(88, 35),
(89, 35),
(91, 35),
(92, 35),
(93, 35),
(94, 35),
(95, 35),
(96, 35),
(97, 35),
(98, 35),
(99, 35),
(101, 35),
(102, 35),
(104, 35),
(105, 35),
(106, 35),
(107, 35),
(108, 35),
(109, 35),
(110, 35),
(112, 35),
(113, 35),
(114, 35),
(115, 35),
(116, 35),
(117, 35),
(118, 35),
(119, 35),
(120, 35),
(121, 35),
(122, 35),
(123, 35),
(124, 35),
(125, 35),
(126, 35),
(127, 35),
(128, 35),
(129, 35),
(130, 35),
(131, 35),
(132, 35),
(133, 35),
(134, 35),
(135, 35),
(137, 35),
(138, 35),
(139, 35),
(140, 35),
(141, 35),
(143, 35),
(144, 35),
(146, 35),
(147, 35),
(148, 35),
(149, 35),
(150, 35),
(152, 35),
(154, 35),
(155, 35),
(156, 35),
(157, 35),
(158, 35),
(159, 35),
(160, 35),
(161, 35),
(163, 35),
(164, 35),
(166, 35),
(167, 35),
(168, 35),
(170, 35),
(171, 35),
(173, 35),
(177, 35),
(178, 35),
(179, 35),
(180, 35),
(181, 35),
(182, 35),
(184, 35),
(185, 35),
(187, 35),
(188, 1),
(188, 35),
(190, 35),
(195, 1),
(195, 2),
(195, 35),
(199, 35),
(201, 35),
(202, 35),
(203, 35),
(204, 35),
(205, 35),
(206, 35),
(207, 35),
(208, 35),
(209, 35),
(210, 35),
(211, 35),
(215, 35),
(216, 35),
(218, 35),
(219, 35),
(220, 35),
(221, 35),
(222, 35),
(223, 35),
(224, 35),
(225, 33),
(225, 35),
(226, 33),
(226, 35),
(227, 33),
(227, 35),
(228, 33),
(228, 35),
(229, 33),
(229, 35),
(230, 33),
(230, 35);

-- --------------------------------------------------------

--
-- 表的结构 `ci_auth_rule`
--

CREATE TABLE `ci_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL,
  `name` char(100) NOT NULL DEFAULT '' COMMENT '规则名（Controller/method）',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '权限名',
  `icon` varchar(255) NOT NULL COMMENT '图标',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1-正常 0-禁用',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示 1-是 0-否',
  `condition` char(100) NOT NULL DEFAULT '',
  `o` int(11) NOT NULL COMMENT '排序',
  `is_menu` int(11) NOT NULL DEFAULT '1' COMMENT '是否菜单 1-是 0-否'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ci_auth_rule`
--

INSERT INTO `ci_auth_rule` (`id`, `pid`, `name`, `title`, `icon`, `type`, `status`, `is_show`, `condition`, `o`, `is_menu`) VALUES
(1, 0, '', '首页', 'fa fa-home', 1, 1, 1, '', 0, 1),
(2, 28, 'Menu/index', '菜单管理', 'fa fa-circle-o', 1, 1, 1, '', 1, 1),
(119, 35, 'User/edit', '编辑用户', '', 1, 1, 1, '', 2, 0),
(33, 0, '', '权限管理', 'fa fa-lock', 1, 1, 1, '', 5, 1),
(29, 28, 'Database/index', '数据库备份', 'fa fa-circle-o', 1, 1, 0, '', 2, 1),
(28, 0, '', '系统设置', 'fa  fa-cog', 1, 1, 1, '', 6, 1),
(105, 33, 'Role/index', '角色管理', 'fa fa-circle-o', 1, 1, 1, '', 1, 1),
(154, 0, '', '跨部门考核', 'fa fa-balance-scale', 1, 1, 1, '', 3, 1),
(35, 33, 'User/index', '用户管理', 'fa fa-circle-o', 1, 1, 1, '', 3, 1),
(103, 33, 'Rule/index', '规则管理', 'fa fa-circle-o', 1, 1, 1, '', 2, 1),
(110, 103, 'Rule/edit', '编辑规则', '', 1, 1, 1, '', 2, 0),
(115, 2, 'Menu/edit', '编辑菜单', '', 1, 1, 1, '', 2, 0),
(108, 105, 'Role/edit', '编辑角色', '', 1, 1, 1, '', 2, 0),
(43, 105, 'Role/add', '添加角色', '', 1, 1, 1, '', 1, 0),
(44, 2, 'Menu/add', '添加菜单', '', 1, 1, 1, '', 1, 0),
(45, 35, 'User/add', '添加用户', '', 1, 1, 1, '', 1, 0),
(118, 103, 'Rule/del', '删除规则', '', 1, 1, 1, '', 3, 0),
(117, 103, 'Rule/add', '添加规则', '', 1, 1, 1, '', 1, 0),
(109, 1, 'Home/index', '首页统计', 'fa fa-circle-o', 1, 1, 1, '', 1, 1),
(111, 2, 'Menu/del', '删除菜单', '', 1, 1, 1, '', 3, 0),
(116, 105, 'Role/del', '删除角色', '', 1, 1, 1, '', 3, 0),
(120, 35, 'User/del', '删除用户', '', 1, 1, 1, '', 3, 0),
(140, 1, 'Log/index', '日志内容', 'fa fa-circle-o', 1, 1, 1, '', 2, 1),
(156, 154, 'Quarter/index', '时间段管理', 'fa fa-circle-o', 1, 1, 1, '', 4, 1),
(155, 154, 'Group/index', '分组管理', 'fa fa-circle-o', 1, 1, 1, '', 3, 1),
(157, 154, 'Check/index', '考核内容管理', 'fa fa-circle-o', 1, 1, 1, '', 5, 1),
(158, 154, 'Result/detail', '考核结果明细表', 'fa fa-circle-o', 1, 1, 1, '', 6, 1),
(159, 154, 'Result/analysis', '考核结果分析表', 'fa fa-circle-o', 1, 1, 1, '', 7, 1),
(161, 35, 'User/status', '修改状态', '', 1, 1, 1, '', 4, 0),
(163, 155, 'Group/add', '添加分组', '', 1, 1, 1, '', 1, 0),
(164, 155, 'Group/edit', '编辑分组', '', 1, 1, 1, '', 2, 0),
(165, 155, 'Group/del', '删除分组', '', 1, 1, 1, '', 3, 0),
(166, 154, 'Department/index', '部门管理', 'fa fa-circle-o', 1, 1, 1, '', 2, 1),
(167, 166, 'Department/add', '添加部门', '', 1, 1, 1, '', 1, 0),
(168, 166, 'Department/edit', '编辑部门', '', 1, 1, 1, '', 2, 0),
(169, 166, 'Department/del', '删除部门', '', 1, 1, 1, '', 3, 0),
(170, 154, 'Score/index', '考核打分', 'fa fa-circle-o', 1, 1, 1, '', 1, 1),
(171, 170, 'Score/comment', '评价', '', 1, 1, 1, '', 1, 0),
(172, 170, 'Score/mark', '提交按钮', '', 1, 1, 1, '', 2, 0),
(173, 0, '', '年假查询', 'fa fa-edit', 1, 1, 1, '', 2, 1),
(174, 173, 'Vacation/index', '年假列表', 'fa fa-circle-o', 1, 1, 1, '', 1, 1),
(175, 1, 'Setting/index', '修改密码', 'fa fa-circle-o', 1, 1, 1, '', 3, 1),
(176, 174, 'Vacation/save_table_cell', '修改年假', '', 1, 1, 1, '', 1, 0),
(179, 173, 'Record/index', '历史年假', 'fa fa-circle-o', 1, 1, 1, '', 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ci_check`
--

CREATE TABLE `ci_check` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL COMMENT '考核级别 1-员工 2-总监',
  `title` varchar(200) NOT NULL,
  `proportion` int(11) NOT NULL COMMENT '占比',
  `content1` text NOT NULL COMMENT '考核标准内容1',
  `content2` text NOT NULL,
  `content3` text NOT NULL,
  `content4` text NOT NULL,
  `content5` text NOT NULL,
  `score1` text NOT NULL COMMENT '分值1',
  `score2` text NOT NULL,
  `score3` text NOT NULL,
  `score4` text NOT NULL,
  `score5` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='考核内容';

--
-- 转存表中的数据 `ci_check`
--

INSERT INTO `ci_check` (`id`, `group_id`, `title`, `proportion`, `content1`, `content2`, `content3`, `content4`, `content5`, `score1`, `score2`, `score3`, `score4`, `score5`) VALUES
(1, 1, '工作效率质量', 30, '在任何情况下能够高效率高质量的完成工作，为协助团队成员提供充分的支持及向客户提供优质的解决方案，深受好评。', '能同时处理多件事务，并保质保量按时完成，偶有精彩独到之处。', '中规中矩，虽无亮点，但也无谬误。', '工作经常不能按期完成，效率偏低，经常收到内外部对其工作质量部满意投诉，甚至导致项目进度被拖延。', '', '100-91', '90-76', '75-61', '60-0', ''),
(2, 1, '团队协作', 30, '与团队成员沟通 、协作顺畅，有团队意识，在团队中能主动承担工作并积极推进项目，因其加入，团队的工作效率和质量上都能得到极大提升。', '能按时按质按量的完成团队分工，与团队成员保持较好的沟通及协作关系。', '能基本完成团队需要其承担的工作，偶有拖延，质量基本合格。', '不能与项目相关人员进行良好的沟通，常因自身原因导致工作出现纰漏，需要督促才能基本完成工作，无责任心。', '', '100-91', '90-76', '75-61', '60-0', ''),
(3, 1, '应变创新能力', 20, '有卓越的应变能力，对事态的变化具有前瞻性，能够抓住事物的关键作出正确的决策，提高整体团队工作效率。', '能够对公司现有工作方式提出建设性的改进，在一些问题上能灵活变通，对项目工作推进有着积极性作用。', '习惯按照常规办事，能积极响应团队创新，但不主动提出创新或应急处理意见。', '无法依据项目要求提出任何有价值的新思路及办法，也无法配合团队灵活的开展工作。遇突发状况不能及时处理，影响项目推进或造成损失。', '', '100-91', '90-76', '75-61', '60-0', ''),
(26, 1, '解决问题能力', 20, '能迅速理解，把握复杂事物，发现明确关键问题、找到解决办法。', '问题发生后，能够分辨关键问题，找到解决问题办法，并设法解决。', '发生问题，能够去想办法，但有时抓不到关键。', '遇到问题，束手无策。', '', '100-91', '90-76', '75-61', '60-0', ''),
(16, 2, '55222', 22, '2120120', '', '', '', '', '14242', '', '', '', ''),
(17, 2, '77', 0, '', '', '', '', '', '', '', '', '', ''),
(21, 2, '55555', 55, '555555555555555555', '88', '', '', '', '50', '', '', '', ''),
(23, 2, '88', 80, '99990000', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `ci_department`
--

CREATE TABLE `ci_department` (
  `id` int(11) NOT NULL,
  `dept_name` varchar(255) NOT NULL COMMENT '部门名称',
  `remark` text NOT NULL COMMENT '备注',
  `deptno` int(11) NOT NULL COMMENT '部门编号'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='部门表';

--
-- 转存表中的数据 `ci_department`
--

INSERT INTO `ci_department` (`id`, `dept_name`, `remark`, `deptno`) VALUES
(1, '管理团队', '', 0),
(2, '第一事业部', '', 0),
(3, '重庆办事业部', '', 0),
(4, '广州办事业部', '', 0),
(5, '媒介部', '', 0),
(6, '策划部', '', 0),
(7, '创意部', '', 0),
(8, '技术部', '', 0),
(9, '行政部', '', 0),
(40, '第二事业部', '', 0),
(42, '广州办策划部', '', 0),
(43, '广州办媒介部', '', 0),
(44, '广州办创意部', '', 0),
(45, '重庆办创意部', '', 0),
(46, '重庆办策划部', '', 0),
(47, '重庆办媒介部', '', 0),
(48, '重庆办', '', 0),
(49, '广州办', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ci_evaluation`
--

CREATE TABLE `ci_evaluation` (
  `id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL COMMENT '分配id',
  `score1` int(11) DEFAULT NULL,
  `score2` int(11) DEFAULT NULL,
  `score3` int(11) DEFAULT NULL,
  `score4` int(11) DEFAULT NULL,
  `score5` int(11) DEFAULT NULL,
  `advantage` text NOT NULL,
  `advise` text NOT NULL,
  `create_time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评价';

-- --------------------------------------------------------

--
-- 表的结构 `ci_group`
--

CREATE TABLE `ci_group` (
  `id` int(11) NOT NULL,
  `title` char(100) NOT NULL COMMENT '组名',
  `assess_num` int(11) NOT NULL COMMENT '评价 互评数',
  `remark` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='跨部门分组表';

--
-- 转存表中的数据 `ci_group`
--

INSERT INTO `ci_group` (`id`, `title`, `assess_num`, `remark`) VALUES
(1, '一组', 8, ''),
(2, '二组', 8, ''),
(3, '三组', 8, ''),
(4, '四组', 8, ''),
(5, '五组', 8, ''),
(17, '六组', 8, '');

-- --------------------------------------------------------

--
-- 表的结构 `ci_log`
--

CREATE TABLE `ci_log` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `log` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ci_log`
--

INSERT INTO `ci_log` (`id`, `username`, `time`, `ip`, `log`) VALUES
(1, 'admin', 1520497745, '10.35.128.70', '登录成功！'),
(2, 'admin', 1520497905, '10.35.128.70', '菜单更新成功！菜单名称 : 数据库备份');

-- --------------------------------------------------------

--
-- 表的结构 `ci_quarter`
--

CREATE TABLE `ci_quarter` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `quarter` varchar(100) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `createtime` int(11) NOT NULL,
  `isalloted` tinyint(4) NOT NULL COMMENT '是否分配',
  `status` tinyint(4) NOT NULL COMMENT '0-未考核 1-考核中 2-考核结束',
  `remark` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='季度表';

--
-- 转存表中的数据 `ci_quarter`
--

INSERT INTO `ci_quarter` (`id`, `year`, `quarter`, `startdate`, `enddate`, `createtime`, `isalloted`, `status`, `remark`) VALUES
(1, 2017, '上半年', '2017-06-29', '2017-06-30', 0, 1, 2, ''),
(3, 2017, '下半年', '2017-12-22', '2018-01-04', 0, 1, 2, ''),
(4, 2018, '上半年', '2018-03-07', '2018-03-21', 0, 1, 2, ''),
(5, 2018, '下半年', '2018-02-28', '2018-03-13', 0, 1, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `ci_record`
--

CREATE TABLE `ci_record` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `year` int(11) NOT NULL,
  `standard` int(11) NOT NULL COMMENT '标准年假',
  `real_vacation` double NOT NULL COMMENT '今年可休年假',
  `have_vacation` double NOT NULL COMMENT '今年已休年假',
  `left_vacation` double NOT NULL COMMENT '今年剩余年假',
  `last_standard` int(11) NOT NULL COMMENT '去年标准年假',
  `last_real` double NOT NULL COMMENT '去年可休年假',
  `last_have` double NOT NULL COMMENT '去年已休年假',
  `last_left` double NOT NULL COMMENT '去年剩余年假',
  `pre_left` double NOT NULL COMMENT '(如果当前时间在下半年) 把去年已休年假存这里',
  `pre_vacation` double NOT NULL COMMENT '(如果当前时间在上半年) 把今年已休年假存到这里 ',
  `jan` double NOT NULL,
  `feb` double NOT NULL,
  `mar` double NOT NULL,
  `apr` double NOT NULL,
  `may` double NOT NULL,
  `jun` double NOT NULL,
  `jul` double NOT NULL,
  `aug` double NOT NULL,
  `sep` double NOT NULL,
  `oct` double NOT NULL,
  `nov` double NOT NULL,
  `dec` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='年假查询表';

-- --------------------------------------------------------

--
-- 表的结构 `ci_user`
--

CREATE TABLE `ci_user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `name` varchar(100) NOT NULL COMMENT '姓名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '分组id',
  `department_id` int(11) NOT NULL COMMENT '部门id',
  `position` varchar(250) NOT NULL COMMENT '职位',
  `entry_date` date NOT NULL COMMENT '入职日期',
  `phone` varchar(30) NOT NULL DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `login_time` datetime DEFAULT NULL COMMENT '最近登陆时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态：0-启用，1-禁用',
  `identifier` varchar(32) NOT NULL,
  `token` varchar(32) NOT NULL,
  `timeout` int(11) NOT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除 0-否 1-是'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员';

--
-- 转存表中的数据 `ci_user`
--

INSERT INTO `ci_user` (`id`, `username`, `name`, `password`, `gid`, `department_id`, `position`, `entry_date`, `phone`, `email`, `create_time`, `login_time`, `status`, `identifier`, `token`, `timeout`, `is_delete`) VALUES
(1, 'admin', 'admin', '435bd6c30fd66e8463f19b869cf90323', 0, 0, '', '2016-10-17', '13077847700', 'huangfl@mediav.cn', '2016-09-20 17:37:09', '2018-03-08 16:29:05', 0, 'd6fba5a9250d0c77abcb23472a3aab60', '6555063c239ea6553ceda5e4fdb05999', 1521102545, 0);

--
-- 触发器 `ci_user`
--
DELIMITER $$
CREATE TRIGGER `insertva` AFTER INSERT ON `ci_user` FOR EACH ROW INSERT INTO `ci_vacation` (`uid`) VALUES (new.id)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `ci_vacation`
--

CREATE TABLE `ci_vacation` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `year` int(11) NOT NULL,
  `standard` int(11) NOT NULL COMMENT '标准年假',
  `real_vacation` double NOT NULL COMMENT '今年可休年假',
  `have_vacation` double NOT NULL COMMENT '今年已休年假',
  `left_vacation` double NOT NULL COMMENT '今年剩余年假',
  `last_standard` int(11) NOT NULL COMMENT '去年标准年假',
  `last_real` double NOT NULL COMMENT '去年可休年假',
  `last_have` double NOT NULL COMMENT '去年已休年假',
  `last_left` double NOT NULL COMMENT '去年剩余年假',
  `pre_left` double NOT NULL COMMENT '(如果当前时间在下半年) 把去年已休年假存这里',
  `pre_vacation` double NOT NULL COMMENT '(如果当前时间在上半年) 把今年已休年假存到这里 ',
  `jan` double NOT NULL,
  `feb` double NOT NULL,
  `mar` double NOT NULL,
  `apr` double NOT NULL,
  `may` double NOT NULL,
  `jun` double NOT NULL,
  `jul` double NOT NULL,
  `aug` double NOT NULL,
  `sep` double NOT NULL,
  `oct` double NOT NULL,
  `nov` double NOT NULL,
  `dec` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='年假查询表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_assign_user`
--
ALTER TABLE `ci_assign_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quarter_id` (`quarter_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `judger_id` (`judger_id`);

--
-- Indexes for table `ci_auth_group`
--
ALTER TABLE `ci_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_auth_group_access`
--
ALTER TABLE `ci_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `ci_auth_rule`
--
ALTER TABLE `ci_auth_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_check`
--
ALTER TABLE `ci_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_department`
--
ALTER TABLE `ci_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_evaluation`
--
ALTER TABLE `ci_evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_id` (`assign_id`);

--
-- Indexes for table `ci_group`
--
ALTER TABLE `ci_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_log`
--
ALTER TABLE `ci_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_quarter`
--
ALTER TABLE `ci_quarter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_record`
--
ALTER TABLE `ci_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_user`
--
ALTER TABLE `ci_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ci_vacation`
--
ALTER TABLE `ci_vacation`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `ci_assign_user`
--
ALTER TABLE `ci_assign_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `ci_auth_group`
--
ALTER TABLE `ci_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- 使用表AUTO_INCREMENT `ci_auth_rule`
--
ALTER TABLE `ci_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
--
-- 使用表AUTO_INCREMENT `ci_check`
--
ALTER TABLE `ci_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- 使用表AUTO_INCREMENT `ci_department`
--
ALTER TABLE `ci_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- 使用表AUTO_INCREMENT `ci_evaluation`
--
ALTER TABLE `ci_evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `ci_group`
--
ALTER TABLE `ci_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- 使用表AUTO_INCREMENT `ci_log`
--
ALTER TABLE `ci_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `ci_quarter`
--
ALTER TABLE `ci_quarter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `ci_record`
--
ALTER TABLE `ci_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `ci_user`
--
ALTER TABLE `ci_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;
--
-- 使用表AUTO_INCREMENT `ci_vacation`
--
ALTER TABLE `ci_vacation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
DELIMITER $$
--
-- 事件
--
CREATE DEFINER=`root`@`localhost` EVENT `vacation_event` ON SCHEDULE EVERY 1 YEAR STARTS '2017-12-31 19:00:00' ON COMPLETION PRESERVE ENABLE DO call vacation_copy()$$

CREATE DEFINER=`root`@`localhost` EVENT `init_vacation_event` ON SCHEDULE EVERY 1 YEAR STARTS '2018-01-01 00:00:00' ON COMPLETION PRESERVE ENABLE DO call init_detail_vacation()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
