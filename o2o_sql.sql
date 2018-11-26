#生活服务分类表
CREATE TABLE `o2o_category`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY parent_id(`parent_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#城市表
CREATE TABLE `o2o_city`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `uname` VARCHAR(50) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY parent_id(`parent_id`),
  UNIQUE KEY uname(`uname`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#商圈表
CREATE TABLE `o2o_area`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `city_id` int(11) unsigned NOT NULL DEFAULT 0,
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY parent_id(`parent_id`),
  KEY city_id(`city_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#商户表
CREATE TABLE `o2o_bis`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `email` VARCHAR(50) NOT NULL DEFAULT '',
  `logo` VARCHAR(255) NOT NULL DEFAULT '',
  `licence_logo` VARCHAR(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `city_id` int(11) unsigned NOT NULL DEFAULT 0,
  `city_path` varchar(50) NOT NULL DEFAULT '',
  `bank_info` varchar(50) NOT NULL DEFAULT '',
  `money` decimal(20,2) NOT NULL default '0.00',
  `bank_name` varchar(50) NOT NULL DEFAULT '',
  `bank_user` varchar(50) NOT NULL DEFAULT '',
  `faren` varchar(20) NOT NULL DEFAULT '',
  `faren_tel` varchar(20) NOT NULL DEFAULT '',
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY name(`name`),
  KEY city_id(`city_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#商户帐号表
CREATE TABLE `o2o_bis_account`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` VARCHAR(50) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL default '',
  `bis_id` int(11) unsigned NOT NULL DEFAULT 0,
  `last_login_ip` VARCHAR(20) NOT NULL DEFAULT '',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT 0,
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY bis_id(`bis_id`),
  KEY username(`username`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#商户门店表
CREATE TABLE `o2o_bis_location`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(50) NOT NULL DEFAULT '',
  `logo` VARCHAR(255) NOT NULL DEFAULT '',
  `address` VARCHAR(255) NOT NULL DEFAULT '',
  `tel` VARCHAR(20) NOT NULL DEFAULT '',
  `contact` VARCHAR(20) NOT NULL DEFAULT '',
  `xpoint` VARCHAR(20) NOT NULL DEFAULT '',
  `ypoint` VARCHAR(20) NOT NULL DEFAULT '',
  `bis_id` int(11) unsigned NOT NULL DEFAULT 0,
  `open_time` int(11) unsigned NOT NULL DEFAULT 0,
  `content` text NOT NULL,
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `api_address` VARCHAR(255) NOT NULL DEFAULT '',
  `city_id` int(11) unsigned NOT NULL DEFAULT 0,
  `city_path` varchar(50) NOT NULL DEFAULT '',
  `category_id` int(11) unsigned NOT NULL DEFAULT 0,
  `category_path` VARCHAR(50) NOT NULL DEFAULT '',
  `bank_info` varchar(50) NOT NULL DEFAULT '',
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY name(`name`),
  KEY bis_id(`bis_id`),
  KEY category_id(`category_id`),
  KEY city_id(`city_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


#团购商品表
CREATE TABLE `o2o_deal`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(100) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT 0,
  `se_category_id` int(11) NOT NULL DEFAULT 0,
  `bis_id` int(11) unsigned NOT NULL DEFAULT 0,
  `location_ids` VARCHAR(100) NOT NULL DEFAULT '',
  `image` VARCHAR(200) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `start_time` int(11) not null default 0,
  `end_time` int(11) not null default 0,
  `origin_price` decimal(20,2) not null default '0.00',
  `current_price` decimal(20,2) not null default '0.00',
  `city_id` int(11) not null default 0,
  `buy_count` int(11) not null default 0,
  `total_count` int(11) not null default 0,
  `coupons_begin_time` int(11) not null default 0,
  `coupons_end_time` int(11) not null default 0,
  `xpoint` VARCHAR(20) NOT NULL DEFAULT '',
  `ypoint` VARCHAR(20) NOT NULL DEFAULT '',
  `bis_account_id` int(10) not null default 0,
  `balance_price` decimal(20,2) not null default '0.00',
  `notes` text not null,
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY bis_id(`bis_id`),
  KEY category_id(`category_id`),
  KEY se_category_id(`se_category_id`),
  KEY start_time(`start_time`),
  KEY end_time(`end_time`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#用户表
CREATE TABLE `o2o_user`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` VARCHAR(20) not null default '',
  `password` char(32) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL default '',
  `last_login_ip` VARCHAR(20) NOT NULL DEFAULT '',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT 0,
  `email` varchar(30) not null default '',
  `mobile` varchar(20) not null default '',
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY username(`username`),
  UNIQUE KEY email(`email`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#推荐位表
CREATE TABLE `o2o_featured`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `type` tinyint(1) not null default 0,
  `title` varchar(30) not null default '',
  `image` varchar(255) not null default '',
  `url` varchar(255) not null default '',
  `description` varchar(255) not null default '',
  `listorder` int(8) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `create_time` int(11) unsigned NOT NULL DEFAULT 0,
  `update_time` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `o2o_order` (
  `id` int(11) UNSIGNED NOT NULL,
  `out_trade_no` varchar(100) NOT NULL DEFAULT '',
  `transaction_id` varchar(100) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '',
  `pay_time` varchar(20) NOT NULL DEFAULT '',
  `payment_id` tinyint(1) NOT NULL DEFAULT '1',
  `deal_id` int(11) NOT NULL DEFAULT '0',
  `deal_count` int(11) NOT NULL DEFAULT '0',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0',
  `total_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `pay_amount` decimal(20,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `referer` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `use_type` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT '',
  `send_status` tinyint(1) DEFAULT '0',
  `bis_id` int(11) NOT NULL DEFAULT '0',
  `is_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为未评价，1为已评价'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `o2o_coupons` (
 `id` int(11) UNSIGNED NOT NULL,
 `sn` varchar(100) NOT NULL DEFAULT '',
 `password` varchar(100) NOT NULL DEFAULT '',
 `user_id` int(11) NOT NULL DEFAULT '0',
 `deal_id` int(11) NOT NULL DEFAULT '0',
 `order_id` int(11) NOT NULL DEFAULT '0',
 `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:生成未发送给用户 \r\n		1:已经发送给用户 2：用户已经使用 3 禁用',
 `create_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
 `update_time` int(11) UNSIGNED NOT NULL DEFAULT '0',
 `deal_count` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;