<?php

/**
 * LIMB gallery
 * Create
 */
class GRSGalleryCreate extends GRSGallerySmart {
	// Costructor
	public function __construct() {
	}

	// Updates
	public function create() {
		global $wpdb;
		$grsGalleries = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "limb_gallery_galleries` (
		    `id` int(11) NOT NULL AUTO_INCREMENT,
		    `title` varchar(255) NOT NULL,
		    `description` longtext NOT NULL,
		    `createDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		    `lastmodified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		    `prevImgName` varchar(512) NOT NULL,
		    `prevImgPath` varchar(1024) NOT NULL,
		    `prevImgType` varchar(8) NOT NULL,
		    `prevImgWidth` int(5) NOT NULL,
		    `prevImgHeight` int(5) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY (`title`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";

		$okGall = $wpdb->query( $grsGalleries );

		$grsgalleriescontent = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "limb_gallery_galleriescontent` (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`galId` int(11) NOT NULL,
			`name` varchar(512) NOT NULL,
			`title` longtext CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
			`description` longtext NOT NULL,
			`createDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`lastmodified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`path` varchar(1024) NOT NULL,
			`link` varchar(1024) NOT NULL DEFAULT '',
			`type` varchar(8) NOT NULL,
			`embed` varchar(12) NOT NULL DEFAULT '',
			`thumb_url` varchar(256) NOT NULL DEFAULT '',
			`width` int(5) NOT NULL,
			`height` int(5) NOT NULL,
            `wp_sizes` VARCHAR(256),
			`publish` tinyint(1) NOT NULL,
			`order` bigint(20) NOT NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`galId`) 
			REFERENCES `" . $wpdb->prefix . "limb_gallery_galleries`(id)
			ON DELETE CASCADE
			ON UPDATE CASCADE
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
		// print_r($grsgalleriescontent);
		// die();
		$okIm = $wpdb->query( $grsgalleriescontent );

		$grsAlbums = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "limb_gallery_albums` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(255) NOT NULL,
			`description` longtext NOT NULL,
			`createDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`lastmodified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`prevImgName` varchar(512) NOT NULL,
			`prevImgPath` varchar(1024) NOT NULL,
			`prevImgType` varchar(8) NOT NULL,
			`prevImgWidth` int(5) NOT NULL,
			`prevImgHeight` int(5) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY (`title`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
		$okAlb     = $wpdb->query( $grsAlbums );

		$grsalbumscontent = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "limb_gallery_albumscontent` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`albId` int(11) NOT NULL,
			`contentId` int(11) NOT NULL,
			`type` varchar(5) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE INDEX `unContent` (`albId`, `contentId`, `type`),
			FOREIGN KEY (`albId`) 
			REFERENCES `" . $wpdb->prefix . "limb_gallery_albums`(id)
			ON DELETE CASCADE
			ON UPDATE CASCADE
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
		$okAlbC           = $wpdb->query( $grsalbumscontent );
		// Check for type coloumn to be alb or gall
		$grsComments = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "limb_gallery_comments` (
			`id` bigint(20) NOT NULL AUTO_INCREMENT,
			`imgId` bigint(20) NOT NULL,
			`galId` int(11) NOT NULL,
			`name` varchar(128) NOT NULL,
			`comment` mediumtext NOT NULL,
			`email` varchar(128) NOT NULL,
			`createDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			`publish` tinyint(1) NOT NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`imgId`) 
			REFERENCES `" . $wpdb->prefix . "limb_gallery_galleriescontent`(id)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
			FOREIGN KEY (`galId`) 
			REFERENCES `" . $wpdb->prefix . "limb_gallery_galleries`(id)
			ON DELETE CASCADE
			ON UPDATE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$okCom       = $wpdb->query( $grsComments );

		$grsSettings = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "limb_gallery_settings` (
			`default` tinyint(1) NOT NULL DEFAULT '0',
			`timezone` varchar(64) NOT NULL,
			`timeformat` varchar(64) NOT NULL,
			`collapseNavClicks` tinyint(1) NOT NULL DEFAULT '0',
			`fmImMoveCount` int(11) NOT NULL DEFAULT '3',
			`filmImMoveCount` int(11) NOT NULL DEFAULT '3',
			`hideNavButton` tinyint(1) NOT NULL DEFAULT '0',
			`closeLbOnSide` tinyint(1) NOT NULL DEFAULT '1',
			`openCommTrig` tinyint(1) NOT NULL DEFAULT 0,
			`showTitleDescTrig` tinyint(1) NOT NULL DEFAULT 1,
			`clicksCount` int(11) NOT NULL,
			`lastmodified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$okSett      = $wpdb->query( $grsSettings );

		$grsThemes = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "limb_gallery_themes` (
			`id` int(4) NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
		    `default` tinyint(1) NOT NULL DEFAULT '0',
		    `createDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		    `lastmodified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
		    `thumbnail` varchar(2048) NOT NULL,
		    `film` varchar(2048) NOT NULL,
		    `masonry` varchar(2048) NOT NULL,
		    `mosaic` varchar(2048) NOT NULL,
		    `navigation` varchar(2048) NOT NULL,
		    `lightbox` varchar(10240) NOT NULL,
		    PRIMARY KEY (`id`),
			UNIQUE KEY (`name`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8";
		$okTh      = $wpdb->query( $grsThemes );

		return ( $okGall AND $okIm AND $okAlb AND $okAlbC AND $okCom AND $okSett AND $okTh );
	}
}