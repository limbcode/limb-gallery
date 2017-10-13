<?php

/**
 * LIMB gallery
 * Insert
 */
class GRSGalleryInsert extends GRSGallerySmart {
	/**
	 * GRSGalleryInsert constructor.
	 */
	public function __construct() {
	}

	// Updates
	public function insert() {
		global $wpdb;
		$grsThemes = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "limb_gallery_themes WHERE `default`=1" );
		$saveTheme = ( $grsThemes == 0 ) ? false : true;
		if ( ! $saveTheme ) {
			$date = date_create( null );
			date_timezone_set( $date, timezone_open( 'UTC' ) );
			$createDate = date_format( $date, "Y-m-d H:i:s" );

			$theme1             = new stdclass();
			$theme1->thumbnail  = new stdclass();
			$theme1->film       = new stdclass();
			$theme1->masonry    = new stdclass();
			$theme1->mosaic     = new stdclass();
			$theme1->navigation = new stdclass();
			$theme1->lightbox   = new stdclass();

			$theme1->thumbnail->thumbnailmargin          = 5;
			$theme1->thumbnail->thumbnailpadding         = 0;
			$theme1->thumbnail->thumbnailBorderWidth     = 1;
			$theme1->thumbnail->thumbnailBorderStyle     = 'none';
			$theme1->thumbnail->thumbnailBorderColor     = 'rgba(142,155,151,1)';
			$theme1->thumbnail->thumbnailHoverEffect     = 'none';
			$theme1->thumbnail->thumbnailBorderRadius    = 0;
			$theme1->thumbnail->thumbnailMaskColor       = 'rgba(255,255,255,0.75)';
			$theme1->thumbnail->thumbnailTpadding        = 10;
			$theme1->thumbnail->thumbnailTBgcolor        = 'rgba(255,255,255,0.8)';
			$theme1->thumbnail->thumbnailTFSize          = 18;
			$theme1->thumbnail->thumbnailTcolor          = 'rgba(94,94,94,1)';
			$theme1->thumbnail->thumbnailTFFamily        = 'sans-serif';
			$theme1->thumbnail->thumbnailTFWeight        = 'bold';
			$theme1->thumbnail->thumbnailTFstyle         = 'normal';
			$theme1->thumbnail->thumbnailTEffect         = 'grsTransUp';
			$theme1->thumbnail->thumbnailTpos            = 'bottom';
			$theme1->thumbnail->thumbnailBoxshadowFstVal = 0;
			$theme1->thumbnail->thumbnailBoxshadowSecVal = 0;
			$theme1->thumbnail->thumbnailBoxshadowThdVal = 0;
			$theme1->thumbnail->thumbnailBoxshadowColor  = 'rgba(0,0,0,1)';
			$theme1->thumbnail->thumbnailBgColor         = 'rgba(255,255,255,0)';
			/*Film*/
			$theme1->film->fmBgColor              = "rgba(255,255,255,0)";
			$theme1->film->fmMargin               = "2";
			$theme1->film->fmHoverEffect          = "scaleIm";
			$theme1->film->fmThumbBorderWidth     = "0";
			$theme1->film->fmThumbBorderStyle     = "none";
			$theme1->film->fmThumbBorderColor     = "rgba(0,0,0,1)";
			$theme1->film->fmThumbMargin          = "5";
			$theme1->film->fmThumbPadding         = "0";
			$theme1->film->fmThumbBoxshadowFstVal = "0";
			$theme1->film->fmThumbBoxshadowSecVal = "0";
			$theme1->film->fmThumbBoxshadowThdVal = "0";
			$theme1->film->fmThumbBoxshadowColor  = "rgba(0,0,0,1)";
			$theme1->film->fmThumbBgColor         = "rgba(0,0,0,0)";
			$theme1->film->fmNavButtons           = "arrow";
			$theme1->film->fmNavWidth             = "60";
			$theme1->film->fmNavBgColor           = "rgba(255,255,255,0.85)";
			$theme1->film->fmNavBoxshadowFstVal   = "0";
			$theme1->film->fmNavBoxshadowSecVal   = "0";
			$theme1->film->fmNavBoxshadowThdVal   = "0";
			$theme1->film->fmNavBoxshadowColor    = "rgba(0,0,0,1)";
			$theme1->film->fmNavBorderWidth       = "1";
			$theme1->film->fmNavBorderStyle       = "none";
			$theme1->film->fmNavBorderColor       = "rgba(0,0,0,0.42)";
			$theme1->film->fmTpadding             = "10";
			$theme1->film->fmTBgcolor             = "rgba(255,255,255,0.8)";
			$theme1->film->fmTFSize               = "18";
			$theme1->film->fmTcolor               = "rgba(94,94,94,1)";
			$theme1->film->fmTFFamily             = "sans-serif";
			$theme1->film->fmTFWeight             = "bold";
			$theme1->film->fmTFstyle              = "normal";
			$theme1->film->fmThumbTeffect         = "grsTransUp";
			$theme1->film->fmTpos                 = "bottom";
			$theme1->film->fmNavBorderRadius      = "30";
			$theme1->film->fmNavColor             = "rgba(135,135,135,1)";
			$theme1->film->fmNavHeight            = "60";
			$theme1->film->fmNavHoverBgColor      = "rgba(255,255,255,0.85)";
			$theme1->film->fmNavHoverColor        = "rgba(87,87,87,1)";
			$theme1->film->fmNavOffset            = "20";
			$theme1->film->fmNavSize              = "30";
			/*Masonry*/
			$theme1->masonry->masonrymargin          = 5;
			$theme1->masonry->masonryPadding         = 0;
			$theme1->masonry->masonryBorderWidth     = 1;
			$theme1->masonry->masonryBorderStyle     = 'none';
			$theme1->masonry->masonryBorderColor     = 'rgba(0,0,0,1)';
			$theme1->masonry->masonryHoverEffect     = 'none';
			$theme1->masonry->masonryBorderRadius    = 0;
			$theme1->masonry->masonryBoxshadowFstVal = 0;
			$theme1->masonry->masonryBoxshadowSecVal = 0;
			$theme1->masonry->masonryBoxshadowThdVal = 0;
			$theme1->masonry->masonryBoxshadowColor  = 'rgba(255,255,255,1)';
			$theme1->masonry->masonryBgColor         = 'rgba(255,255,255,0)';
			$theme1->masonry->masonryTpadding        = 10;
			$theme1->masonry->masonryTBgcolor        = 'rgba(255,255,255,0.8)';
			$theme1->masonry->masonryTFSize          = 18;
			$theme1->masonry->masonryTcolor          = 'rgba(94,94,94,1)';
			$theme1->masonry->masonryTFFamily        = 'sans-serif';
			$theme1->masonry->masonryTFWeight        = 'bold';
			$theme1->masonry->masonryTFstyle         = 'normal';
			$theme1->masonry->masonryTEffect         = 'grsSlideInLeft';
			$theme1->masonry->masonryTpos            = 'middle';
			/*Mosaic**/
			$theme1->mosaic->mosaicPadding         = 0;
			$theme1->mosaic->mosaicBorderWidth     = 1;
			$theme1->mosaic->mosaicBorderStyle     = 'none';
			$theme1->mosaic->mosaicBorderColor     = 'rgba(0,0,0,1)';
			$theme1->mosaic->mosaicHoverEffect     = 'scaleRotIm';
			$theme1->mosaic->mosaicBorderRadius    = 0;
			$theme1->mosaic->mosaicBoxshadowFstVal = 0;
			$theme1->mosaic->mosaicBoxshadowSecVal = 0;
			$theme1->mosaic->mosaicBoxshadowThdVal = 0;
			$theme1->mosaic->mosaicBoxshadowColor  = 'rgba(0,0,0,1)';
			$theme1->mosaic->mosaicBgColor         = 'rgba(255,255,255,0)';
			$theme1->mosaic->mosaicMargin          = 5;
			$theme1->mosaic->mosaicTpadding        = 10;
			$theme1->mosaic->mosaicTBgcolor        = 'rgba(255,255,255,0.8)';
			$theme1->mosaic->mosaicTFSize          = 18;
			$theme1->mosaic->mosaicTcolor          = 'rgba(94,94,94,1)';
			$theme1->mosaic->mosaicTFFamily        = 'sans-serif';
			$theme1->mosaic->mosaicTFWeight        = 'bold';
			$theme1->mosaic->mosaicTFstyle         = 'normal';
			$theme1->mosaic->mosaicTEffect         = 'grsFadeIn';
			$theme1->mosaic->mosaicTpos            = 'bottom';
			/*Navigation*/
			$theme1->navigation->pnavCMarginT         = 30;
			$theme1->navigation->pnavAlign            = 'center';
			$theme1->navigation->pnavBMargin          = 5;
			$theme1->navigation->pnavBPadding         = 12;
			$theme1->navigation->pnavBBorderWidth     = 1;
			$theme1->navigation->pnavBBorderStyle     = 'solid';
			$theme1->navigation->pnavBBorderColor     = 'rgba(168,168,168,0.65)';
			$theme1->navigation->pnavBBoxshadowFstVal = 0;
			$theme1->navigation->pnavBBoxshadowSecVal = 0;
			$theme1->navigation->pnavBBoxshadowThdVal = 0;
			$theme1->navigation->pnavBBoxshadowColor  = 'rgba(255,255,255,1)';
			$theme1->navigation->pnavBBgColor         = 'rgba(255,255,255,0.73)';
			$theme1->navigation->pnavBHBgColor        = 'rgba(242,242,242,1)';
			$theme1->navigation->pnavBABgColor        = 'rgba(194,194,194,1)';
			$theme1->navigation->pnavBBorderRadius    = 1;
			$theme1->navigation->pnavBFSize           = 12;
			$theme1->navigation->pnavBcolor           = 'rgba(0,0,0,1)';
			$theme1->navigation->pnavBFFamily         = 'sans-serif';
			$theme1->navigation->pnavBFWeight         = '400';
			$theme1->navigation->pnavBFstyle          = 'normal';
			$theme1->navigation->backBorderStyle      = 'solid';
			$theme1->navigation->backBorderWidth      = 1;
			$theme1->navigation->backBorderColor      = 'rgba(168,168,168,0.72)';
			$theme1->navigation->backBoxshadowFstVal  = 0;
			$theme1->navigation->backBoxshadowSecVal  = 0;
			$theme1->navigation->backBoxshadowThdVal  = 0;
			$theme1->navigation->backBoxshadowColor   = 'rgba(255,255,255,0)';
			$theme1->navigation->backBgColor          = 'rgba(255,255,255,0.73)';
			$theme1->navigation->backHBgColor         = 'rgba(242,242,242,1)';
			$theme1->navigation->backBorderRadius     = 1;
			$theme1->navigation->backFSize            = 12;
			$theme1->navigation->backColor            = 'rgba(0,0,0,1)';
			/*Lightbox*/
			$theme1->lightbox->bgColor                     = "rgba(0, 0, 0, 0.63)";
			$theme1->lightbox->closeButtBgColor            = "rgba(255,255,255,0)";
			$theme1->lightbox->closeButtSize               = "26";
			$theme1->lightbox->closeButtBoxshadowFstVal    = "0";
			$theme1->lightbox->closeButtBoxshadowSecVal    = "0";
			$theme1->lightbox->closeButtBoxshadowThdVal    = "0";
			$theme1->lightbox->closeButtBoxshadowColor     = "rgba(255,255,255,0)";
			$theme1->lightbox->closeButtBorderWidth        = "0";
			$theme1->lightbox->closeButtBorderStyle        = "none";
			$theme1->lightbox->closeButtBorderColor        = "rgba(255,255,255,1)";
			$theme1->lightbox->titleDescpFWith             = "1";
			$theme1->lightbox->titleDescpWith              = "200";
			$theme1->lightbox->titleDescpPos               = "topCenter";
			$theme1->lightbox->titleDescpMargin            = "24";
			$theme1->lightbox->titleDescpPadding           = "25";
			$theme1->lightbox->titleDescpBgColor           = "rgba(255,255,255,1)";
			$theme1->lightbox->titleDescpTColor            = "rgba(255,255,255,1)";
			$theme1->lightbox->titleDescpDColor            = "rgba(255,255,255,1)";
			$theme1->lightbox->titleDescpshadowFstVal      = "0";
			$theme1->lightbox->titleDescpshadowSecVal      = "0";
			$theme1->lightbox->titleDescpshadowThdVal      = "0";
			$theme1->lightbox->titleDescpshadowColor       = "rgba(255,255,255,0)";
			$theme1->lightbox->titleDescpTffamily          = "sans-serif";
			$theme1->lightbox->titleDescpTfsize            = "20";
			$theme1->lightbox->titleDescpDfsize            = "15";
			$theme1->lightbox->titleDescpTfweight          = "bold";
			$theme1->lightbox->titleDescpDfweight          = "600";
			$theme1->lightbox->titleDescpBrad              = "0";
			$theme1->lightbox->imgcoPos                    = "topRight";
			$theme1->lightbox->imgcoMargin                 = "24";
			$theme1->lightbox->imgcoPadding                = "3";
			$theme1->lightbox->imgcoBgColor                = "rgba(255,255,255,0)";
			$theme1->lightbox->imgcoColor                  = "rgba(255,255,255,1)";
			$theme1->lightbox->imgcoshadowFstVal           = "0";
			$theme1->lightbox->imgcoshadowSecVal           = "0";
			$theme1->lightbox->imgcoshadowThdVal           = "0";
			$theme1->lightbox->imgcoshadowColor            = "rgba(255,255,255,0)";
			$theme1->lightbox->imgcoBrad                   = "0";
			$theme1->lightbox->imgcoffamily                = "sans-serif";
			$theme1->lightbox->imgcofsize                  = "11";
			$theme1->lightbox->imgcofweight                = "bold";
			$theme1->lightbox->navButtons                  = "angle";
			$theme1->lightbox->navButtBgColor              = "rgba(255,255,255,0)";
			$theme1->lightbox->navButtBoxshadowFstVal      = "0";
			$theme1->lightbox->navButtBoxshadowSecVal      = "0";
			$theme1->lightbox->navButtBoxshadowThdVal      = "0";
			$theme1->lightbox->navButtBoxshadowColor       = "rgba(255,255,255,0)";
			$theme1->lightbox->navButtBorderWidth          = "1";
			$theme1->lightbox->navButtBorderStyle          = "none";
			$theme1->lightbox->navButtBorderColor          = "rgba(255,255,255,1)";
			$theme1->lightbox->navButtBorderRadius         = "0";
			$theme1->lightbox->navButtSize                 = "45";
			$theme1->lightbox->navButtMargin               = "24";
			$theme1->lightbox->navButtHoverEffect          = "fade";
			$theme1->lightbox->navButtShButts              = "onhover";
			$theme1->lightbox->filmstripSize               = "60";
			$theme1->lightbox->filmstripBgColor            = "rgba(255,255,255,1)";
			$theme1->lightbox->filmstripPos                = "top";
			$theme1->lightbox->filmThumbWidth              = "90";
			$theme1->lightbox->filmThumbBorderWidth        = "2";
			$theme1->lightbox->filmThumbBorderStyle        = "none";
			$theme1->lightbox->filmThumbBorderColor        = "rgba(232,232,232,0.43)";
			$theme1->lightbox->filmThumbMargin             = "10";
			$theme1->lightbox->filmThumbPadding            = "0";
			$theme1->lightbox->filmThumbBoxshadowFstVal    = "0";
			$theme1->lightbox->filmThumbBoxshadowSecVal    = "0";
			$theme1->lightbox->filmThumbBoxshadowThdVal    = "0";
			$theme1->lightbox->filmThumbBoxshadowColor     = "rgba(255,255,255,0)";
			$theme1->lightbox->filmThumbBgColor            = "rgba(255,255,255,0)";
			$theme1->lightbox->filmThumbSelEffect          = "border";
			$theme1->lightbox->filmNavButtons              = "caret";
			$theme1->lightbox->filmNavWidth                = "25";
			$theme1->lightbox->filmNavBgColor              = "rgba(255,255,255,0.83)";
			$theme1->lightbox->filmNavBoxshadowFstVal      = "0";
			$theme1->lightbox->filmNavBoxshadowSecVal      = "0";
			$theme1->lightbox->filmNavBoxshadowThdVal      = "0";
			$theme1->lightbox->filmNavBoxshadowColor       = "rgba(255,255,255,0)";
			$theme1->lightbox->filmNavBorderWidth          = "0";
			$theme1->lightbox->filmNavBorderStyle          = "none";
			$theme1->lightbox->filmNavBorderColor          = "rgba(0,0,0,0.52)";
			$theme1->lightbox->contButtContBgcolor         = "rgba(92,92,92,0.26)";
			$theme1->lightbox->contButtContBoxshadowFstVal = "0";
			$theme1->lightbox->contButtContBoxshadowSecVal = "0";
			$theme1->lightbox->contButtContBoxshadowThdVal = "0";
			$theme1->lightbox->contButtContBoxshadowColor  = "rgba(255,255,255,0)";
			$theme1->lightbox->contButtBgColor             = "rgba(74,74,74,0.35)";
			$theme1->lightbox->contButtSize                = "14";
			$theme1->lightbox->contButtBoxshadowFstVal     = "0";
			$theme1->lightbox->contButtBoxshadowSecVal     = "0";
			$theme1->lightbox->contButtBoxshadowThdVal     = "0";
			$theme1->lightbox->contButtBoxshadowColor      = "rgba(255,255,255,0)";
			$theme1->lightbox->contButtBorderWidth         = "2";
			$theme1->lightbox->contButtBorderStyle         = "none";
			$theme1->lightbox->contButtBorderColor         = "rgba(255,255,255,0)";
			$theme1->lightbox->contButtcontMargin          = "10";
			$theme1->lightbox->contButtMargin              = "10";
			$theme1->lightbox->contButtContBorderWidth     = "2";
			$theme1->lightbox->contButtContBorderStyle     = "none";
			$theme1->lightbox->contButtContBorderColor     = "rgba(255,255,255,0)";
			$theme1->lightbox->contButtOnhover             = "0";
			$theme1->lightbox->commContBgcolor             = "rgba(255,255,255,1)";
			$theme1->lightbox->commContMargin              = "35";
			$theme1->lightbox->commContMarginH             = "10";
			$theme1->lightbox->commFontSize                = "12";
			$theme1->lightbox->commFontColor               = "rgba(74,74,74,1)";
			$theme1->lightbox->commFontFamily              = "sans-serif";
			$theme1->lightbox->commFontWeight              = "600";
			$theme1->lightbox->commFontStyle               = "inherit";
			$theme1->lightbox->commButtBgcolor             = "rgba(255,255,255,1)";
			$theme1->lightbox->commButtHBgcolor            = "rgba(255,255,255,1)";
			$theme1->lightbox->commButtBoxshadowFstVal     = "0";
			$theme1->lightbox->commButtBoxshadowSecVal     = "0";
			$theme1->lightbox->commButtBoxshadowThdVal     = "0";
			$theme1->lightbox->commButtBoxshadowColor      = "rgba(255,255,255,1)";
			$theme1->lightbox->commButtSize                = "15";
			$theme1->lightbox->commInpFSize                = "12";
			$theme1->lightbox->commInpColor                = "rgba(44,74,82,0.67)";
			$theme1->lightbox->commInpFFamily              = "sans-serif";
			$theme1->lightbox->commInpFWeight              = "inherit";
			$theme1->lightbox->commInpFFstyle              = "inherit";
			$theme1->lightbox->commInpBoxshadowFstVal      = "0";
			$theme1->lightbox->commInpBoxshadowSecVal      = "0";
			$theme1->lightbox->commInpBoxshadowThdVal      = "0";
			$theme1->lightbox->commInpBoxshadowColor       = "rgba(209,209,209,1)";
			$theme1->lightbox->commInpBorderWidth          = "1";
			$theme1->lightbox->commInpBorderStyle          = "solid";
			$theme1->lightbox->commInpBorderColor          = "rgba(176,176,176,1)";
			$theme1->lightbox->commInpBgColor              = "rgba(255,255,255,1)";
			$theme1->lightbox->commInpBorderRadius         = "2";
			$theme1->lightbox->commInpAcBorderColor        = "rgba(44,74,82,0.87)";
			$theme1->lightbox->commInpAcBoxshadowFstVal    = "0";
			$theme1->lightbox->commInpAcBoxshadowSecVal    = "0";
			$theme1->lightbox->commInpAcBoxshadowThdVal    = "0";
			$theme1->lightbox->commInpAcBoxshadowColor     = "rgba(255,255,255,0)";
			$theme1->lightbox->commButtColor               = "rgba(44,74,82,0.67)";
			$theme1->lightbox->commButtBorderRadius        = "3";
			$theme1->lightbox->commButtBorderWidth         = "1";
			$theme1->lightbox->commButtBorderStyle         = "solid";
			$theme1->lightbox->commButtBorderColor         = "rgba(142,155,151,1)";
			$theme1->lightbox->commClButtSize              = "14";
			$theme1->lightbox->commClButtBoxshadowFstVal   = "0";
			$theme1->lightbox->commClButtBoxshadowSecVal   = "0";
			$theme1->lightbox->commClButtBoxshadowThdVal   = "0";
			$theme1->lightbox->commClButtBoxshadowColor    = "rgba(255,255,255,1)";
			$theme1->lightbox->commClButtBgColor           = "rgba(255,255,255,0)";
			$theme1->lightbox->commClButtBorderRadius      = "0";
			$theme1->lightbox->commClButtBorderWidth       = "1";
			$theme1->lightbox->commClButtBorderStyle       = "none";
			$theme1->lightbox->commClButtBorderColor       = "rgba(255,255,255,1)";
			$theme1->lightbox->commCpButtSize              = "20";
			$theme1->lightbox->commCpButtBoxshadowFstVal   = "0";
			$theme1->lightbox->commCpButtBoxshadowSecVal   = "0";
			$theme1->lightbox->commCpButtBoxshadowThdVal   = "0";
			$theme1->lightbox->commCpButtBoxshadowColor    = "rgba(99,99,99,1)";
			$theme1->lightbox->commCpButtBgColor           = "rgba(255,255,255,0)";
			$theme1->lightbox->commCpButtBorderRadius      = "2";
			$theme1->lightbox->commCpButtBorderWidth       = "1";
			$theme1->lightbox->commCpButtBorderStyle       = "none";
			$theme1->lightbox->commCpButtBorderColor       = "rgba(255,255,255,1)";
			$theme1->lightbox->commAFontSize               = "13";
			$theme1->lightbox->commAFontColor              = "rgba(74,74,74,1)";
			$theme1->lightbox->commAFontFamily             = "sans-serif";
			$theme1->lightbox->commAFontWeight             = "600";
			$theme1->lightbox->commAFontStyle              = "italic";
			$theme1->lightbox->commTFontSize               = "12";
			$theme1->lightbox->commTFontColor              = "rgba(119,119,119,1)";
			$theme1->lightbox->commTFontFamily             = "sans-serif";
			$theme1->lightbox->commTFontWeight             = "normal";
			$theme1->lightbox->commTFontStyle              = "inherit";
			$theme1->lightbox->commDFontSize               = "11";
			$theme1->lightbox->commDFontColor              = "rgba(132,132,132,1)";
			$theme1->lightbox->commDFontFamily             = "sans-serif";
			$theme1->lightbox->commDFontWeight             = "normal";
			$theme1->lightbox->commDFontStyle              = "normal";
			$theme1->lightbox->boxBgColor                  = "rgba(255,255,255,1)";
			$theme1->lightbox->ccl                         = "arrow-right";
			$theme1->lightbox->closeButtBRad               = "0";
			$theme1->lightbox->closeButtBoxSize            = "25";
			$theme1->lightbox->closeButtColor              = "rgba(185,185,185,1)";
			$theme1->lightbox->closeButtHoverColor         = "rgba(112,112,112,1)";
			$theme1->lightbox->closeButtPos                = "topRight";
			$theme1->lightbox->closeButtPosXoffset         = "-28";
			$theme1->lightbox->closeButtPosYoffset         = "-2";
			$theme1->lightbox->commClButtBoxSize           = "25";
			$theme1->lightbox->commClButtColor             = "rgba(197,197,197,1)";
			$theme1->lightbox->commClButtHoverColor        = "rgba(112,112,112,1)";
			$theme1->lightbox->commClButtPosXoffset        = "5";
			$theme1->lightbox->commClButtPosYoffset        = "5";
			$theme1->lightbox->commCpButtBoxSize           = "30";
			$theme1->lightbox->commCpButtColor             = "rgba(197,197,197,1)";
			$theme1->lightbox->commCpButtHoverColor        = "rgba(112,112,112,1)";
			$theme1->lightbox->contButtBoxSize             = "25";
			$theme1->lightbox->contButtColor               = "rgba(255,255,255,1)";
			$theme1->lightbox->contButtContBgGrDir         = "0deg";
			$theme1->lightbox->contButtContBgGrFrColor     = "rgba(64,64,64,0.17)";
			$theme1->lightbox->contButtContBgGrToColor     = "rgba(255,255,255,0)";
			$theme1->lightbox->contButtHoverBgColor        = "rgba(199,199,199,0.21)";
			$theme1->lightbox->contButtHoverColor          = "rgba(110,110,110,1)";
			$theme1->lightbox->contButtShadowColor         = "rgba(255,255,255,0)";
			$theme1->lightbox->contButtShadowFstVal        = "0";
			$theme1->lightbox->contButtShadowSecVal        = "0";
			$theme1->lightbox->contButtShadowThdVal        = "0";
			$theme1->lightbox->contButtBorderRadius        = "4";
			$theme1->lightbox->cop                         = "comments";
			$theme1->lightbox->crl                         = "refresh";
			$theme1->lightbox->fb                          = "facebook";
			$theme1->lightbox->filmNavBorderRadius         = "12.5";
			$theme1->lightbox->filmNavButtColor            = "rgba(168,168,168,1)";
			$theme1->lightbox->filmNavButtHoverColor       = "rgba(102,93,93,1)";
			$theme1->lightbox->filmNavButtSize             = "15";
			$theme1->lightbox->filmNavButtonsSh            = "onhover";
			$theme1->lightbox->filmNavHeight               = "25";
			$theme1->lightbox->filmNavHoverBgColor         = "rgba(255,255,255,0.83)";
			$theme1->lightbox->filmNavOffset               = "15";
			$theme1->lightbox->filmSelThumbBorderColor     = "rgba(156,156,156,1)";
			$theme1->lightbox->filmSelThumbBorderStyle     = "solid";
			$theme1->lightbox->filmSelThumbBorderWidth     = "2";
			$theme1->lightbox->filmstripMarginBottom       = "5";
			$theme1->lightbox->filmstripMarginTop          = "5";
			$theme1->lightbox->gplus                       = "google-plus";
			$theme1->lightbox->imgcoPosXoffset             = "10";
			$theme1->lightbox->imgcoPosYoffset             = "30";
			$theme1->lightbox->info                        = "info";
			$theme1->lightbox->max                         = "expand";
			$theme1->lightbox->min                         = "compress";
			$theme1->lightbox->navButtBoxSize              = "150";
			$theme1->lightbox->navButtColor                = "rgba(189,189,189,1)";
			$theme1->lightbox->navButtHoverColor           = "rgba(122,122,122,1)";
			$theme1->lightbox->navButtHoverShadowColor     = "rgba(255,255,255,0)";
			$theme1->lightbox->navButtHoverShadowFstVal    = "0";
			$theme1->lightbox->navButtHoverShadowSecVal    = "0";
			$theme1->lightbox->navButtHoverShadowThdVal    = "0";
			$theme1->lightbox->navButtShadowColor          = "rgba(171,171,171,1)";
			$theme1->lightbox->navButtShadowFstVal         = "0";
			$theme1->lightbox->navButtShadowSecVal         = "0";
			$theme1->lightbox->navButtShadowThdVal         = "1";
			$theme1->lightbox->pause                       = "pause";
			$theme1->lightbox->pcl                         = "times-circle";
			$theme1->lightbox->play                        = "play";
			$theme1->lightbox->titleDescpBgGrDir           = "180deg";
			$theme1->lightbox->titleDescpBgGrFrColor       = "rgba(64,64,64,0.43)";
			$theme1->lightbox->titleDescpBgGrToColor       = "rgba(255,255,255,0)";
			$theme1->lightbox->titleDescpPosXoffset        = "0";
			$theme1->lightbox->titleDescpPosYoffset        = "0";
			$theme1->lightbox->titleDescpTmaxWidth         = "60";
			$theme1->lightbox->twitt                       = "twitter";
			$theme1->lightbox->titleDescpDmaxWidth         = "90";
			$theme1->lightbox->pint                        = "pinterest";
			$theme1->lightbox->tumb                        = "tumblr";
			$theme1->lightbox->lini                        = "linkedin";
			$theme1->lightbox->redd                        = "reddit";

			$saveTheme1         = $wpdb->insert( $wpdb->prefix . 'limb_gallery_themes',
				array(
					'default'      => 0,
					'name'         => 'Tender black',
					'createDate'   => $createDate,
					'lastmodified' => $createDate,
					'thumbnail'    => json_encode( $theme1->thumbnail ),
					'film'         => json_encode( $theme1->film ),
					'mosaic'       => json_encode( $theme1->mosaic ),
					'masonry'      => json_encode( $theme1->masonry ),
					'navigation'   => json_encode( $theme1->navigation ),
					'lightbox'     => json_encode( $theme1->lightbox )
				),
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);
			$theme2             = new stdclass();
			$theme2->thumbnail  = new stdclass();
			$theme2->film       = new stdclass();
			$theme2->masonry    = new stdclass();
			$theme2->mosaic     = new stdclass();
			$theme2->navigation = new stdclass();
			$theme2->lightbox   = new stdclass();

			$theme2->thumbnail->thumbnailmargin          = 20;
			$theme2->thumbnail->thumbnailpadding         = 5;
			$theme2->thumbnail->thumbnailBorderWidth     = 1;
			$theme2->thumbnail->thumbnailBorderStyle     = 'none';
			$theme2->thumbnail->thumbnailBorderColor     = 'rgba(142,155,151,1)';
			$theme2->thumbnail->thumbnailHoverEffect     = 'none';
			$theme2->thumbnail->thumbnailBorderRadius    = 0;
			$theme2->thumbnail->thumbnailMaskColor       = 'rgba(0,0,0,0.75)';
			$theme2->thumbnail->thumbnailTpadding        = 10;
			$theme2->thumbnail->thumbnailTBgcolor        = 'rgba(0,0,0,0.75)';
			$theme2->thumbnail->thumbnailTFSize          = 18;
			$theme2->thumbnail->thumbnailTcolor          = 'rgba(255,255,255,1)';
			$theme2->thumbnail->thumbnailTFFamily        = 'sans-serif';
			$theme2->thumbnail->thumbnailTFWeight        = 'bold';
			$theme2->thumbnail->thumbnailTFstyle         = 'normal';
			$theme2->thumbnail->thumbnailTEffect         = 'grsTransUp';
			$theme2->thumbnail->thumbnailTpos            = 'middle';
			$theme2->thumbnail->thumbnailBoxshadowFstVal = 0;
			$theme2->thumbnail->thumbnailBoxshadowSecVal = 0;
			$theme2->thumbnail->thumbnailBoxshadowThdVal = 3;
			$theme2->thumbnail->thumbnailBoxshadowColor  = 'rgba(0,0,0,1)';
			$theme2->thumbnail->thumbnailBgColor         = 'rgba(255,255,255,1)';
			/*Film*/
			$theme2->film->fmBgColor              = "rgba(255,255,255,0)";
			$theme2->film->fmMargin               = "2";
			$theme2->film->fmHoverEffect          = "none";
			$theme2->film->fmThumbBorderWidth     = "0";
			$theme2->film->fmThumbBorderStyle     = "none";
			$theme2->film->fmThumbBorderColor     = "rgba(0,0,0,1)";
			$theme2->film->fmThumbMargin          = "10";
			$theme2->film->fmThumbPadding         = "5";
			$theme2->film->fmThumbBoxshadowFstVal = "0";
			$theme2->film->fmThumbBoxshadowSecVal = "0";
			$theme2->film->fmThumbBoxshadowThdVal = "3";
			$theme2->film->fmThumbBoxshadowColor  = "rgba(0,0,0,1)";
			$theme2->film->fmThumbBgColor         = "rgba(255,255,255,1)";
			$theme2->film->fmNavButtons           = "chevron";
			$theme2->film->fmNavWidth             = "45";
			$theme2->film->fmNavBgColor           = "rgba(0,0,0,0.28)";
			$theme2->film->fmNavBoxshadowFstVal   = "0";
			$theme2->film->fmNavBoxshadowSecVal   = "0";
			$theme2->film->fmNavBoxshadowThdVal   = "0";
			$theme2->film->fmNavBoxshadowColor    = "rgba(0,0,0,0)";
			$theme2->film->fmNavBorderWidth       = "0";
			$theme2->film->fmNavBorderStyle       = "none";
			$theme2->film->fmNavBorderColor       = "rgba(0,0,0,0.42)";
			$theme2->film->fmTpadding             = "15";
			$theme2->film->fmTBgcolor             = "rgba(0,0,0,0.4)";
			$theme2->film->fmTFSize               = "18";
			$theme2->film->fmTcolor               = "rgba(255,255,255,1)";
			$theme2->film->fmTFFamily             = "sans-serif";
			$theme2->film->fmTFWeight             = "bold";
			$theme2->film->fmTFstyle              = "normal";
			$theme2->film->fmThumbTeffect         = "grsFadeIn";
			$theme2->film->fmTpos                 = "middle";
			$theme2->film->fmNavBorderRadius      = "22.5";
			$theme2->film->fmNavColor             = "rgba(255,255,255,1)";
			$theme2->film->fmNavHeight            = "45";
			$theme2->film->fmNavHoverBgColor      = "rgba(0,0,0,0.51)";
			$theme2->film->fmNavHoverColor        = "rgba(255,255,255,1)";
			$theme2->film->fmNavOffset            = "25";
			$theme2->film->fmNavSize              = "25";
			/*Masonry*/
			$theme2->masonry->masonrymargin          = 10;
			$theme2->masonry->masonryPadding         = 5;
			$theme2->masonry->masonryBorderWidth     = 1;
			$theme2->masonry->masonryBorderStyle     = 'none';
			$theme2->masonry->masonryBorderColor     = 'rgba(0,0,0,1)';
			$theme2->masonry->masonryHoverEffect     = 'scaleRotIm';
			$theme2->masonry->masonryBorderRadius    = 0;
			$theme2->masonry->masonryBoxshadowFstVal = 0;
			$theme2->masonry->masonryBoxshadowSecVal = 0;
			$theme2->masonry->masonryBoxshadowThdVal = 3;
			$theme2->masonry->masonryBoxshadowColor  = 'rgba(0,0,0,1)';
			$theme2->masonry->masonryBgColor         = 'rgba(255,255,255,1)';
			$theme2->masonry->masonryTpadding        = 10;
			$theme2->masonry->masonryTBgcolor        = 'rgba(0,0,0,0.75)';
			$theme2->masonry->masonryTFSize          = 18;
			$theme2->masonry->masonryTcolor          = 'rgba(255,255,255,1)';
			$theme2->masonry->masonryTFFamily        = 'sans-serif';
			$theme2->masonry->masonryTFWeight        = 'bold';
			$theme2->masonry->masonryTFstyle         = 'normal';
			$theme2->masonry->masonryTEffect         = 'grsFadeIn';
			$theme2->masonry->masonryTpos            = 'middle';
			/*Mosaic*/
			$theme2->mosaic->mosaicPadding         = 5;
			$theme2->mosaic->mosaicBorderWidth     = 1;
			$theme2->mosaic->mosaicBorderStyle     = 'none';
			$theme2->mosaic->mosaicBorderColor     = 'rgba(0,0,0,1)';
			$theme2->mosaic->mosaicHoverEffect     = 'none';
			$theme2->mosaic->mosaicBorderRadius    = 0;
			$theme2->mosaic->mosaicBoxshadowFstVal = 0;
			$theme2->mosaic->mosaicBoxshadowSecVal = 0;
			$theme2->mosaic->mosaicBoxshadowThdVal = 3;
			$theme2->mosaic->mosaicBoxshadowColor  = 'rgba(0,0,0,1)';
			$theme2->mosaic->mosaicBgColor         = 'rgba(255,255,255,1)';
			$theme2->mosaic->mosaicMargin          = 10;
			$theme2->mosaic->mosaicTpadding        = 5;
			$theme2->mosaic->mosaicTBgcolor        = 'rgba(0,0,0,0.75)';
			$theme2->mosaic->mosaicTFSize          = 18;
			$theme2->mosaic->mosaicTcolor          = 'rgba(255,255,255,1)';
			$theme2->mosaic->mosaicTFFamily        = 'sans-serif';
			$theme2->mosaic->mosaicTFWeight        = 'bold';
			$theme2->mosaic->mosaicTFstyle         = 'normal';
			$theme2->mosaic->mosaicTEffect         = 'grsSlideInLeft';
			$theme2->mosaic->mosaicTpos            = 'middle';
			/*Navigation*/
			$theme2->navigation->pnavCMarginT         = 30;
			$theme2->navigation->pnavAlign            = 'center';
			$theme2->navigation->pnavBMargin          = 5;
			$theme2->navigation->pnavBPadding         = 12;
			$theme2->navigation->pnavBBorderWidth     = 1;
			$theme2->navigation->pnavBBorderStyle     = 'none';
			$theme2->navigation->pnavBBorderColor     = 'rgba(0,0,0,1)';
			$theme2->navigation->pnavBBoxshadowFstVal = 0;
			$theme2->navigation->pnavBBoxshadowSecVal = 0;
			$theme2->navigation->pnavBBoxshadowThdVal = 1;
			$theme2->navigation->pnavBBoxshadowColor  = 'rgba(0,0,0,1)';
			$theme2->navigation->pnavBBgColor         = 'rgba(255,255,255,1)';
			$theme2->navigation->pnavBHBgColor        = 'rgba(222,222,222,1)';
			$theme2->navigation->pnavBABgColor        = 'rgba(212,212,212,1)';
			$theme2->navigation->pnavBBorderRadius    = 0;
			$theme2->navigation->pnavBFSize           = 12;
			$theme2->navigation->pnavBcolor           = 'rgba(68,68,68,1)';
			$theme2->navigation->pnavBFFamily         = 'sans-serif';
			$theme2->navigation->pnavBFWeight         = '500';
			$theme2->navigation->pnavBFstyle          = 'normal';
			$theme2->navigation->backBorderStyle      = 'none';
			$theme2->navigation->backBorderWidth      = 1;
			$theme2->navigation->backBorderColor      = 'rgba(0,0,0,1)';
			$theme2->navigation->backBoxshadowFstVal  = 0;
			$theme2->navigation->backBoxshadowSecVal  = 0;
			$theme2->navigation->backBoxshadowThdVal  = 1;
			$theme2->navigation->backBoxshadowColor   = 'rgba(0,0,0,1)';
			$theme2->navigation->backBgColor          = 'rgba(255,255,255,1)';
			$theme2->navigation->backHBgColor         = 'rgba(222,222,222,1)';
			$theme2->navigation->backBorderRadius     = 0;
			$theme2->navigation->backFSize            = 12;
			$theme2->navigation->backColor            = 'rgba(68,68,68,1)';
			/*Lightbox*/
			$theme2->lightbox->bgColor                     = "rgba(0, 0, 0, 0.63)";
			$theme2->lightbox->closeButtBgColor            = "rgba(255,255,255,0)";
			$theme2->lightbox->closeButtSize               = "24";
			$theme2->lightbox->closeButtBoxshadowFstVal    = "0";
			$theme2->lightbox->closeButtBoxshadowSecVal    = "0";
			$theme2->lightbox->closeButtBoxshadowThdVal    = "0";
			$theme2->lightbox->closeButtBoxshadowColor     = "rgba(122,122,122,0.87)";
			$theme2->lightbox->closeButtBorderWidth        = "0";
			$theme2->lightbox->closeButtBorderStyle        = "none";
			$theme2->lightbox->closeButtBorderColor        = "rgba(255,255,255,1)";
			$theme2->lightbox->titleDescpFWith             = "1";
			$theme2->lightbox->titleDescpWith              = "200";
			$theme2->lightbox->titleDescpPos               = "bottomCenter";
			$theme2->lightbox->titleDescpMargin            = "24";
			$theme2->lightbox->titleDescpPadding           = "20";
			$theme2->lightbox->titleDescpBgColor           = "rgba(0,0,0,1)";
			$theme2->lightbox->titleDescpTColor            = "rgba(255,255,255,1)";
			$theme2->lightbox->titleDescpDColor            = "rgba(255,255,255,1)";
			$theme2->lightbox->titleDescpshadowFstVal      = "0";
			$theme2->lightbox->titleDescpshadowSecVal      = "0";
			$theme2->lightbox->titleDescpshadowThdVal      = "0";
			$theme2->lightbox->titleDescpshadowColor       = "rgba(255,255,255,0)";
			$theme2->lightbox->titleDescpTffamily          = "sans-serif";
			$theme2->lightbox->titleDescpTfsize            = "20";
			$theme2->lightbox->titleDescpDfsize            = "15";
			$theme2->lightbox->titleDescpTfweight          = "bold";
			$theme2->lightbox->titleDescpDfweight          = "500";
			$theme2->lightbox->titleDescpBrad              = "2";
			$theme2->lightbox->imgcoPos                    = "bottomRight";
			$theme2->lightbox->imgcoMargin                 = "24";
			$theme2->lightbox->imgcoPadding                = "3";
			$theme2->lightbox->imgcoBgColor                = "rgba(0,0,0,0)";
			$theme2->lightbox->imgcoColor                  = "rgba(255,255,255,1)";
			$theme2->lightbox->imgcoshadowFstVal           = "0";
			$theme2->lightbox->imgcoshadowSecVal           = "0";
			$theme2->lightbox->imgcoshadowThdVal           = "0";
			$theme2->lightbox->imgcoshadowColor            = "rgba(255,255,255,0)";
			$theme2->lightbox->imgcoBrad                   = "4";
			$theme2->lightbox->imgcoffamily                = "sans-serif";
			$theme2->lightbox->imgcofsize                  = "11";
			$theme2->lightbox->imgcofweight                = "bold";
			$theme2->lightbox->navButtons                  = "angle";
			$theme2->lightbox->navButtBgColor              = "rgba(255,255,255,0)";
			$theme2->lightbox->navButtBoxshadowFstVal      = "0";
			$theme2->lightbox->navButtBoxshadowSecVal      = "0";
			$theme2->lightbox->navButtBoxshadowThdVal      = "0";
			$theme2->lightbox->navButtBoxshadowColor       = "rgba(99,99,99,0)";
			$theme2->lightbox->navButtBorderWidth          = "1";
			$theme2->lightbox->navButtBorderStyle          = "none";
			$theme2->lightbox->navButtBorderColor          = "rgba(255,255,255,1)";
			$theme2->lightbox->navButtBorderRadius         = "0";
			$theme2->lightbox->navButtSize                 = "50";
			$theme2->lightbox->navButtMargin               = "30";
			$theme2->lightbox->navButtHoverEffect          = "fade";
			$theme2->lightbox->navButtShButts              = "onhover";
			$theme2->lightbox->filmstripSize               = "60";
			$theme2->lightbox->filmstripBgColor            = "rgba(0,0,0,1)";
			$theme2->lightbox->filmstripPos                = "bottom";
			$theme2->lightbox->filmThumbWidth              = "90";
			$theme2->lightbox->filmThumbBorderWidth        = "0";
			$theme2->lightbox->filmThumbBorderStyle        = "none";
			$theme2->lightbox->filmThumbBorderColor        = "rgba(115,115,115,0)";
			$theme2->lightbox->filmThumbMargin             = "7";
			$theme2->lightbox->filmThumbPadding            = "0";
			$theme2->lightbox->filmThumbBoxshadowFstVal    = "0";
			$theme2->lightbox->filmThumbBoxshadowSecVal    = "0";
			$theme2->lightbox->filmThumbBoxshadowThdVal    = "0";
			$theme2->lightbox->filmThumbBoxshadowColor     = "rgba(255,255,255,1)";
			$theme2->lightbox->filmThumbBgColor            = "rgba(255,255,255,1)";
			$theme2->lightbox->filmThumbSelEffect          = "border";
			$theme2->lightbox->filmNavButtons              = "arrow";
			$theme2->lightbox->filmNavWidth                = "27";
			$theme2->lightbox->filmNavBgColor              = "rgba(218,218,218,0.64)";
			$theme2->lightbox->filmNavBoxshadowFstVal      = "0";
			$theme2->lightbox->filmNavBoxshadowSecVal      = "0";
			$theme2->lightbox->filmNavBoxshadowThdVal      = "0";
			$theme2->lightbox->filmNavBoxshadowColor       = "rgba(115,115,115,1)";
			$theme2->lightbox->filmNavBorderWidth          = "0";
			$theme2->lightbox->filmNavBorderStyle          = "none";
			$theme2->lightbox->filmNavBorderColor          = "rgba(0,0,0,0.52)";
			$theme2->lightbox->contButtContBgcolor         = "rgba(0,0,0,0.72)";
			$theme2->lightbox->contButtContBoxshadowFstVal = "0";
			$theme2->lightbox->contButtContBoxshadowSecVal = "0";
			$theme2->lightbox->contButtContBoxshadowThdVal = "0";
			$theme2->lightbox->contButtContBoxshadowColor  = "rgba(255,255,255,0)";
			$theme2->lightbox->contButtBgColor             = "rgba(218,218,218,0.19)";
			$theme2->lightbox->contButtSize                = "15";
			$theme2->lightbox->contButtBoxshadowFstVal     = "0";
			$theme2->lightbox->contButtBoxshadowSecVal     = "0";
			$theme2->lightbox->contButtBoxshadowThdVal     = "0";
			$theme2->lightbox->contButtBoxshadowColor      = "rgba(84,84,84,0.5)";
			$theme2->lightbox->contButtBorderWidth         = "2";
			$theme2->lightbox->contButtBorderStyle         = "none";
			$theme2->lightbox->contButtBorderColor         = "rgba(255,255,255,0)";
			$theme2->lightbox->contButtcontMargin          = "10";
			$theme2->lightbox->contButtMargin              = "10";
			$theme2->lightbox->contButtContBorderWidth     = "2";
			$theme2->lightbox->contButtContBorderStyle     = "none";
			$theme2->lightbox->contButtContBorderColor     = "rgba(255,255,255,1)";
			$theme2->lightbox->contButtOnhover             = "1";
			$theme2->lightbox->commContBgcolor             = "rgba(0,0,0,1)";
			$theme2->lightbox->commContMargin              = "35";
			$theme2->lightbox->commContMarginH             = "10";
			$theme2->lightbox->commFontSize                = "12";
			$theme2->lightbox->commFontColor               = "rgba(255,255,255,1)";
			$theme2->lightbox->commFontFamily              = "inherit";
			$theme2->lightbox->commFontWeight              = "600";
			$theme2->lightbox->commFontStyle               = "inherit";
			$theme2->lightbox->commButtBgcolor             = "rgba(0,0,0,1)";
			$theme2->lightbox->commButtHBgcolor            = "rgba(0,0,0,1)";
			$theme2->lightbox->commButtBoxshadowFstVal     = "0";
			$theme2->lightbox->commButtBoxshadowSecVal     = "0";
			$theme2->lightbox->commButtBoxshadowThdVal     = "0";
			$theme2->lightbox->commButtBoxshadowColor      = "rgba(255,255,255,1)";
			$theme2->lightbox->commButtSize                = "15";
			$theme2->lightbox->commInpFSize                = "12";
			$theme2->lightbox->commInpColor                = "rgba(255,255,255,0.67)";
			$theme2->lightbox->commInpFFamily              = "inherit";
			$theme2->lightbox->commInpFWeight              = "inherit";
			$theme2->lightbox->commInpFFstyle              = "inherit";
			$theme2->lightbox->commInpBoxshadowFstVal      = "0";
			$theme2->lightbox->commInpBoxshadowSecVal      = "0";
			$theme2->lightbox->commInpBoxshadowThdVal      = "0";
			$theme2->lightbox->commInpBoxshadowColor       = "rgba(209,209,209,1)";
			$theme2->lightbox->commInpBorderWidth          = "1";
			$theme2->lightbox->commInpBorderStyle          = "solid";
			$theme2->lightbox->commInpBorderColor          = "rgba(99,99,99,1)";
			$theme2->lightbox->commInpBgColor              = "rgba(0,0,0,1)";
			$theme2->lightbox->commInpBorderRadius         = "2";
			$theme2->lightbox->commInpAcBorderColor        = "rgba(255,255,255,0.87)";
			$theme2->lightbox->commInpAcBoxshadowFstVal    = "0";
			$theme2->lightbox->commInpAcBoxshadowSecVal    = "0";
			$theme2->lightbox->commInpAcBoxshadowThdVal    = "0";
			$theme2->lightbox->commInpAcBoxshadowColor     = "rgba(255,255,255,0)";
			$theme2->lightbox->commButtColor               = "rgba(255,255,255,1)";
			$theme2->lightbox->commButtBorderRadius        = "3";
			$theme2->lightbox->commButtBorderWidth         = "1";
			$theme2->lightbox->commButtBorderStyle         = "solid";
			$theme2->lightbox->commButtBorderColor         = "rgba(161,161,161,1)";
			$theme2->lightbox->commClButtSize              = "14";
			$theme2->lightbox->commClButtBoxshadowFstVal   = "0";
			$theme2->lightbox->commClButtBoxshadowSecVal   = "0";
			$theme2->lightbox->commClButtBoxshadowThdVal   = "0";
			$theme2->lightbox->commClButtBoxshadowColor    = "rgba(97,97,97,1)";
			$theme2->lightbox->commClButtBgColor           = "rgba(255,255,255,0)";
			$theme2->lightbox->commClButtBorderRadius      = "3";
			$theme2->lightbox->commClButtBorderWidth       = "1";
			$theme2->lightbox->commClButtBorderStyle       = "none";
			$theme2->lightbox->commClButtBorderColor       = "rgba(255,255,255,1)";
			$theme2->lightbox->commCpButtSize              = "18";
			$theme2->lightbox->commCpButtBoxshadowFstVal   = "0";
			$theme2->lightbox->commCpButtBoxshadowSecVal   = "0";
			$theme2->lightbox->commCpButtBoxshadowThdVal   = "0";
			$theme2->lightbox->commCpButtBoxshadowColor    = "rgba(99,99,99,1)";
			$theme2->lightbox->commCpButtBgColor           = "rgba(255,255,255,0)";
			$theme2->lightbox->commCpButtBorderRadius      = "2";
			$theme2->lightbox->commCpButtBorderWidth       = "1";
			$theme2->lightbox->commCpButtBorderStyle       = "none";
			$theme2->lightbox->commCpButtBorderColor       = "rgba(255,255,255,1)";
			$theme2->lightbox->commAFontSize               = "13";
			$theme2->lightbox->commAFontColor              = "rgba(255,255,255,1)";
			$theme2->lightbox->commAFontFamily             = "inherit";
			$theme2->lightbox->commAFontWeight             = "normal";
			$theme2->lightbox->commAFontStyle              = "italic";
			$theme2->lightbox->commTFontSize               = "12";
			$theme2->lightbox->commTFontColor              = "rgba(255,255,255,1)";
			$theme2->lightbox->commTFontFamily             = "inherit";
			$theme2->lightbox->commTFontWeight             = "normal";
			$theme2->lightbox->commTFontStyle              = "inherit";
			$theme2->lightbox->commDFontSize               = "10";
			$theme2->lightbox->commDFontColor              = "rgba(255,255,255,0.8)";
			$theme2->lightbox->commDFontFamily             = "inherit";
			$theme2->lightbox->commDFontWeight             = "normal";
			$theme2->lightbox->commDFontStyle              = "normal";
			$theme2->lightbox->boxBgColor                  = "rgba(0,0,0,1)";
			$theme2->lightbox->ccl                         = "arrow-right";
			$theme2->lightbox->closeButtBRad               = "20";
			$theme2->lightbox->closeButtBoxSize            = "20";
			$theme2->lightbox->closeButtColor              = "rgba(255,255,255,1)";
			$theme2->lightbox->closeButtHoverColor         = "rgba(135,135,135,1)";
			$theme2->lightbox->closeButtPos                = "topRight";
			$theme2->lightbox->closeButtPosXoffset         = "-24";
			$theme2->lightbox->closeButtPosYoffset         = "-2";
			$theme2->lightbox->commClButtBoxSize           = "25";
			$theme2->lightbox->commClButtColor             = "rgba(255,255,255,1)";
			$theme2->lightbox->commClButtHoverColor        = "rgba(92,92,92,1)";
			$theme2->lightbox->commClButtPosXoffset        = "5";
			$theme2->lightbox->commClButtPosYoffset        = "5";
			$theme2->lightbox->commCpButtBoxSize           = "30";
			$theme2->lightbox->commCpButtColor             = "rgba(255,255,255,1)";
			$theme2->lightbox->commCpButtHoverColor        = "rgba(92,92,92,1)";
			$theme2->lightbox->contButtBoxSize             = "27";
			$theme2->lightbox->contButtColor               = "rgba(255,255,255,1)";
			$theme2->lightbox->contButtContBgGrDir         = "180deg";
			$theme2->lightbox->contButtContBgGrFrColor     = "rgba(0,0,0,0.16)";
			$theme2->lightbox->contButtContBgGrToColor     = "rgba(0,0,0,0)";
			$theme2->lightbox->contButtHoverBgColor        = "rgba(168,168,168,0.5)";
			$theme2->lightbox->contButtHoverColor          = "rgba(255,255,255,1)";
			$theme2->lightbox->contButtShadowColor         = "rgba(0,0,0,0)";
			$theme2->lightbox->contButtShadowFstVal        = "0";
			$theme2->lightbox->contButtShadowSecVal        = "0";
			$theme2->lightbox->contButtShadowThdVal        = "0";
			$theme2->lightbox->contButtBorderRadius        = "4";
			$theme2->lightbox->cop                         = "commenting-o";
			$theme2->lightbox->crl                         = "refresh";
			$theme2->lightbox->fb                          = "facebook";
			$theme2->lightbox->filmNavBorderRadius         = "15";
			$theme2->lightbox->filmNavButtColor            = "rgba(92,92,92,1)";
			$theme2->lightbox->filmNavButtHoverColor       = "rgba(255,255,255,1)";
			$theme2->lightbox->filmNavButtSize             = "15";
			$theme2->lightbox->filmNavButtonsSh            = "onhover";
			$theme2->lightbox->filmNavHeight               = "27";
			$theme2->lightbox->filmNavHoverBgColor         = "rgba(218,218,218,0.64)";
			$theme2->lightbox->filmNavOffset               = "20";
			$theme2->lightbox->filmSelThumbBorderColor     = "rgba(255,255,255,1)";
			$theme2->lightbox->filmSelThumbBorderStyle     = "solid";
			$theme2->lightbox->filmSelThumbBorderWidth     = "2";
			$theme2->lightbox->filmstripMarginBottom       = "10";
			$theme2->lightbox->filmstripMarginTop          = "10";
			$theme2->lightbox->gplus                       = "google-plus";
			$theme2->lightbox->imgcoPosXoffset             = "10";
			$theme2->lightbox->imgcoPosYoffset             = "10";
			$theme2->lightbox->info                        = "info";
			$theme2->lightbox->max                         = "expand";
			$theme2->lightbox->min                         = "compress";
			$theme2->lightbox->navButtBoxSize              = "200";
			$theme2->lightbox->navButtColor                = "rgba(255,255,255,1)";
			$theme2->lightbox->navButtHoverColor           = "rgba(255,255,255,1)";
			$theme2->lightbox->navButtHoverShadowColor     = "rgba(13,12,12,1)";
			$theme2->lightbox->navButtHoverShadowFstVal    = "0";
			$theme2->lightbox->navButtHoverShadowSecVal    = "0";
			$theme2->lightbox->navButtHoverShadowThdVal    = "1";
			$theme2->lightbox->navButtShadowColor          = "rgba(5,5,5,0)";
			$theme2->lightbox->navButtShadowFstVal         = "0";
			$theme2->lightbox->navButtShadowSecVal         = "0";
			$theme2->lightbox->navButtShadowThdVal         = "0";
			$theme2->lightbox->pause                       = "pause";
			$theme2->lightbox->pcl                         = "times";
			$theme2->lightbox->play                        = "play";
			$theme2->lightbox->titleDescpBgGrDir           = "0deg";
			$theme2->lightbox->titleDescpBgGrFrColor       = "rgba(0,0,0,0.16)";
			$theme2->lightbox->titleDescpBgGrToColor       = "rgba(0,0,0,0)";
			$theme2->lightbox->titleDescpPosXoffset        = "0";
			$theme2->lightbox->titleDescpPosYoffset        = "0";
			$theme2->lightbox->titleDescpTmaxWidth         = "60";
			$theme2->lightbox->twitt                       = "twitter";
			$theme2->lightbox->titleDescpDmaxWidth         = "90";
            $theme2->lightbox->pint                        = "pinterest";
            $theme2->lightbox->tumb                        = "tumblr";
            $theme2->lightbox->lini                        = "linkedin";
            $theme2->lightbox->redd                        = "reddit";

			$saveTheme2 = $wpdb->insert( $wpdb->prefix . 'limb_gallery_themes',
				array(
					'default'      => 1,
					'name'         => 'Black',
					'createDate'   => $createDate,
					'lastmodified' => $createDate,
					'thumbnail'    => json_encode( $theme2->thumbnail ),
					'film'         => json_encode( $theme2->film ),
					'mosaic'       => json_encode( $theme2->mosaic ),
					'masonry'      => json_encode( $theme2->masonry ),
					'navigation'   => json_encode( $theme2->navigation ),
					'lightbox'     => json_encode( $theme2->lightbox )
				),
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);
			$saveTheme  = $saveTheme1 && $saveTheme2;
		}
		$grsSettings = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "limb_gallery_settings WHERE `default`=1" );
		$saveSett    = ( $grsSettings == 0 ) ? false : true;
		if ( ! $saveSett ) {
			date_default_timezone_set( 'UTC' );
			$lastmodified = date( "Y-m-d H:i:s" );
			$saveSett     = $wpdb->insert( $wpdb->prefix . 'limb_gallery_settings',
				array(
					'default'           => 1,
					'timezone'          => 'UTC',
					'timeformat'        => 'F d y h:i:s',
					'collapseNavClicks' => 1,
					'fmImMoveCount'     => 3,
					'filmImMoveCount'   => 3,
					'hideNavButton'     => 1,
					'closeLbOnSide'     => 1,
					'openCommTrig'      => 0,
					'showTitleDescTrig' => 1,
					'clicksCount'       => 5,
					'lastmodified'      => $lastmodified
				),
				array(
					'%d',
					'%s',
					'%s',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
					'%s'
				) );
		}

		return $saveTheme && $saveSett && $this->generateThemesCss();
	}

	public function generateThemesCss() {
		global $wpdb;
		// Write themes to css files
		$grsThemes   = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "limb_gallery_themes" );
		$bytesWriten = false;
		require_once( GRS_PLG_DIR . '/ajax/GRSGetThumbnailCss.php' );
		require_once( GRS_PLG_DIR . '/ajax/GRSGetMasonryCss.php' );
		require_once( GRS_PLG_DIR . '/ajax/GRSGetMosaicCss.php' );
		require_once( GRS_PLG_DIR . '/ajax/GRSGetFilmCss.php' );
		require_once( GRS_PLG_DIR . '/ajax/GRSGetLightboxCss.php' );
		require_once( GRS_PLG_DIR . '/ajax/GRSGetNavigationCss.php' );
		$thumbnailCssObj  = new GRSGetThumbnailCss();
		$filmCssObj       = new GRSGetFilmCss();
		$masonryCssObj    = new GRSGetMasonryCss();
		$mosaicCssObj     = new GRSGetMosaicCss();
		$lightboxCssObj   = new GRSGetLightboxCss();
		$navigationCssObj = new GRSGetNavigationCss();

		foreach ( $grsThemes as $key => $theme ) {
			$thumbnailCss  = $thumbnailCssObj->get_( $theme->id, json_decode( $theme->thumbnail ) );
			$filmCss       = $filmCssObj->get_( $theme->id, json_decode( $theme->film ) );
			$masonryCss    = $masonryCssObj->get_( $theme->id, json_decode( $theme->masonry ) );
			$mosaicCss     = $mosaicCssObj->get_( $theme->id, json_decode( $theme->mosaic ) );
			$lightboxCss   = $lightboxCssObj->get_( $theme->id, json_decode( $theme->lightbox ) );
			$navigationCss = $navigationCssObj->get_( $theme->id, json_decode( $theme->navigation ) );

			$grsTemplate = fopen( GRS_PLG_DIR . '/css/grsTemplate' . $theme->id . '.css', "w" );
			$css         = $thumbnailCss . $filmCss . $masonryCss . $mosaicCss . $lightboxCss . $navigationCss;
			// Minimize process
			$css         = trim( preg_replace( '/\s\s+/', ' ', $css ) );
			$bytesWriten = fwrite( $grsTemplate, $css );
			fclose( $grsTemplate );
		}

		return $bytesWriten;
	}
}