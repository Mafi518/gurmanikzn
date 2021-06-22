

CREATE TABLE `dishes` (
    `dish_id` int(11) NOT NULL auto_increment,
    `dish_fid` int(11) NOT NULL,
    `dish_chapter` int(11) NOT NULL,
    `dish_num` int(11) NOT NULL,
    `dish_type` varchar(32) NOT NULL,
    `dish_variants` int(11) NOT NULL,
    `dish_photos` varchar(2048) NOT NULL,
    `dish_name` varchar(64) NOT NULL,
    `dish_desc` text NOT NULL,
    `dish_structure` varcahr(256) NOT NULL,
	`dish_weight` int(11) NOT NULL,
    `dish_price` int(11) NOT NULL,
    `dish_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `dish_date_edit` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY KEY (`dish_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `dishes_variants` (
    `variant_id` int(11) NOT NULL auto_increment,
    `variant_did` int(11) NOT NULL,
    `variant_name` varchar(64) NOT NULL,
    `variant_diameter` int(11) NOT NULL,
    `variant_weight` int(11) NOT NULL,
    `variant_price` int(11) NOT NULL,
    `variant_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `variant_date_edit` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY KEY (`variant_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `dishes_chapters` (
    `chapter_id` int(11) NOT NULL auto_increment,
    `chapter_num` int(11) NOT NULL,
    `chapter_title` varchar(32) NOT NULL,
    `chapter_desc` text NOT NULL,
    `chapter_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
    `chapter_date_edit` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
    PRIMARY KEY (`chapter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `dishes_chapters` SET chapter_title='Классические роллы', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='Сливочные роллы', chapter_num='2';
INSERT INTO `dishes_chapters` SET chapter_title='Запеченые роллы', chapter_num='3';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';
INSERT INTO `dishes_chapters` SET chapter_title='', chapter_num='1';