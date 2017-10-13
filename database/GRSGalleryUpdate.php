<?php

/**
 * LIMB gallery
 * Grs Gallery Update
 */
class GRSGalleryUpdate extends GRSGallerySmart
{
    // Private vars
    private $options = array(
        'sameForFreeAndPro' => true
    );

    // Constructor
    public function __construct()
    {
    }

    // Update
    public function update()
    {
        parent::__construct('setVersionVars');
        if ($this->alter()) {
            return update_option(parent::$vOptName, parent::$currentVersion);
        }

        return false;
    }

    /**
     * Alter
     *
     * @return bool
     */
    public function alter()
    {
        $existVersion = get_option(parent::$vOptName, false);
        if (version_compare(parent::$currentVersion, $existVersion) == 1) {
            $vArr = explode('.', parent::$currentVersion);
            // Check update type ( maybe for free or pro or both )
            $updateMethod = ($this->options['sameForFreeAndPro']) ? 'alter_' . $vArr[1] . '_' . $vArr[2] : 'alter_' . $vArr[0] . $vArr[1] . '_' . $vArr[2];
            //TODO always rewrite themes css
            if (method_exists($this, $updateMethod)) {
                return $this->{$updateMethod}();
            }

            return false;
        }

        return false;
    }

    /**
     * Alter for 1.2.3
     * Fixed social content sharing issue
     *
     * @return bool
     */
    public function alter_2_3() {
        global $wpdb;
        $ok22 = true;

        $theme = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `default`=1");
        if ($theme != null) {
            if(isset($theme->lightbox)) {
                $themeLightboxObj = json_decode($theme->lightbox);
                if(!isset($themeLightboxObj->pint)) {
                    $ok22 = $this->alter_2_2();
                }
            }
        }
        // Write themes css files
        require_once(GRS_PLG_DIR . '/database/GRSGalleryInsert.php');
        $grsGalleryInsert = new GRSGalleryInsert();
        return $ok22 && $grsGalleryInsert->generateThemesCss();
    }

    /**
     * Alter for 1.2.2
     * Add styles for new social buttons
     *
     * @return bool
     */
    public function alter_2_2()
    {
        global $wpdb;
        $ok21 = true;
        $ok = false;
        $alter_2_1 = "SHOW COLUMNS FROM `" . $wpdb->prefix . "limb_gallery_galleriescontent` LIKE 'wp_sizes'";
        $alter_2_1 = $wpdb->get_row($alter_2_1);
        if (!isset($alter_2_1->Field)) {
            $ok21 = $this->alter_2_1();
        }

        $themes = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "limb_gallery_themes`");
        if ($themes != null) {
            foreach ($themes as $theme) {
                $themeLightboxObj = json_decode($theme->lightbox);
                $themeLightboxObj->pint = "pinterest";
                $themeLightboxObj->tumb = "tumblr";
                $themeLightboxObj->lini = "linkedin";
                $themeLightboxObj->redd = "reddit";

                $ok = $wpdb->update($wpdb->prefix . 'limb_gallery_themes',
                    array(
                        'lightbox' => json_encode($themeLightboxObj),
                    ),
                    array(
                        'id' => $theme->id
                    )
                );
            }
        }

        // Write themes css files
        require_once(GRS_PLG_DIR . '/database/GRSGalleryInsert.php');
        $grsGalleryInsert = new GRSGalleryInsert();
        return $ok21 && $ok && $grsGalleryInsert->generateThemesCss();
    }

    /**
     * Alter for 1.2.1
     * Add wp_sizes column
     *
     * @return bool
     */
    public function alter_2_1()
    {
        global $wpdb;
        $ok20 = true;
        $alter_2_0 = "SHOW COLUMNS FROM `" . $wpdb->prefix . "limb_gallery_settings` LIKE 'openCommTrig'";
        $alter_2_0 = $wpdb->get_row($alter_2_0);
        if (!isset($alter_2_0->Field)) {
            $ok20 = $this->alter_2_0();
        }
        $ok = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_galleriescontent` ADD `wp_sizes` VARCHAR(256) AFTER `height`");

        // Write themes css files
        require_once(GRS_PLG_DIR . '/database/GRSGalleryInsert.php');
        $grsGalleryInsert = new GRSGalleryInsert();
        return $ok20 && $ok && $grsGalleryInsert->generateThemesCss();
    }

    /**
     * Alter for 1.2.0
     *
     * @return bool
     */
    public function alter_2_0()
    {
        global $wpdb;
        $ok14 = true;
        $alter_1_4 = "SHOW COLUMNS FROM `" . $wpdb->prefix . "limb_gallery_settings` LIKE 'fmImMoveCount'";
        $okFor_1_4 = $wpdb->get_row($alter_1_4);
        if (!isset($okFor_1_4->Field)) {
            $ok14 = $this->alter_1_4();
        }
        $okForSettings = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_settings` 
			ADD `openCommTrig` tinyint(1) NOT NULL DEFAULT 0 AFTER `closeLbOnSide`,
			ADD `showTitleDescTrig` tinyint(1) NOT NULL DEFAULT 1 AFTER `openCommTrig`");

        // Write themes css files
        require_once(GRS_PLG_DIR . '/database/GRSGalleryInsert.php');
        $grsGalleryInsert = new GRSGalleryInsert();

        return $ok14 && $okForSettings && $grsGalleryInsert->generateThemesCss();
    }

    /**
     * Alter for 1.1.4
     *
     * @return bool
     */
    public function alter_1_4()
    {
        global $wpdb;
        $okForThemes = true;
        // Check only 1.1.2 version cause there is no db changes in 1.1.3
        $ok12 = true;
        $alter_1_2 = "SHOW COLUMNS FROM `" . $wpdb->prefix . "limb_gallery_themes` LIKE 'thumbnail'";
        $okFor_1_2 = $wpdb->get_row($alter_1_2);
        if (!isset($okFor_1_2->Field)) {
            $ok12 = $this->alter_1_2();
        }

        $themes = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "limb_gallery_themes`");
        if ($themes != null) {
            foreach ($themes as $theme) {
                $themeLightboxObj = json_decode($theme->lightbox);
                $themeFilmObj = json_decode($theme->film);

                unset($themeLightboxObj->closeButtMargin);
                unset($themeLightboxObj->commClButtMargin);
                unset($themeLightboxObj->contButtclHeight);
                unset($themeLightboxObj->contButtclWidth);
                unset($themeLightboxObj->contButtons);
                unset($themeLightboxObj->filmstripMargin);

                if ($theme->id == 1) {
                    $themeFilmObj->fmBgColor = "rgba(255,255,255,0)";
                    $themeFilmObj->fmMargin = "2";
                    $themeFilmObj->fmHoverEffect = "scaleIm";
                    $themeFilmObj->fmThumbBorderWidth = "0";
                    $themeFilmObj->fmThumbBorderStyle = "none";
                    $themeFilmObj->fmThumbBorderColor = "rgba(0,0,0,1)";
                    $themeFilmObj->fmThumbMargin = "5";
                    $themeFilmObj->fmThumbPadding = "0";
                    $themeFilmObj->fmThumbBoxshadowFstVal = "0";
                    $themeFilmObj->fmThumbBoxshadowSecVal = "0";
                    $themeFilmObj->fmThumbBoxshadowThdVal = "0";
                    $themeFilmObj->fmThumbBoxshadowColor = "rgba(0,0,0,1)";
                    $themeFilmObj->fmThumbBgColor = "rgba(0,0,0,0)";
                    $themeFilmObj->fmNavButtons = "arrow";
                    $themeFilmObj->fmNavWidth = "60";
                    $themeFilmObj->fmNavBgColor = "rgba(255,255,255,0.85)";
                    $themeFilmObj->fmNavBoxshadowFstVal = "0";
                    $themeFilmObj->fmNavBoxshadowSecVal = "0";
                    $themeFilmObj->fmNavBoxshadowThdVal = "0";
                    $themeFilmObj->fmNavBoxshadowColor = "rgba(0,0,0,1)";
                    $themeFilmObj->fmNavBorderWidth = "1";
                    $themeFilmObj->fmNavBorderStyle = "none";
                    $themeFilmObj->fmNavBorderColor = "rgba(0,0,0,0.42)";
                    $themeFilmObj->fmTpadding = "10";
                    $themeFilmObj->fmTBgcolor = "rgba(255,255,255,0.8)";
                    $themeFilmObj->fmTFSize = "18";
                    $themeFilmObj->fmTcolor = "rgba(94,94,94,1)";
                    $themeFilmObj->fmTFFamily = "sans-serif";
                    $themeFilmObj->fmTFWeight = "bold";
                    $themeFilmObj->fmTFstyle = "normal";
                    $themeFilmObj->fmThumbTeffect = "grsTransUp";
                    $themeFilmObj->fmTpos = "bottom";
                    $themeFilmObj->fmNavBorderRadius = "30";
                    $themeFilmObj->fmNavColor = "rgba(135,135,135,1)";
                    $themeFilmObj->fmNavHeight = "60";
                    $themeFilmObj->fmNavHoverBgColor = "rgba(255,255,255,0.85)";
                    $themeFilmObj->fmNavHoverColor = "rgba(87,87,87,1)";
                    $themeFilmObj->fmNavOffset = "20";
                    $themeFilmObj->fmNavSize = "30";

                    $themeLightboxObj->bgColor = "rgba(0, 0, 0, 0.63)";
                    $themeLightboxObj->closeButtBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->closeButtSize = "26";
                    $themeLightboxObj->closeButtBoxshadowFstVal = "0";
                    $themeLightboxObj->closeButtBoxshadowSecVal = "0";
                    $themeLightboxObj->closeButtBoxshadowThdVal = "0";
                    $themeLightboxObj->closeButtBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->closeButtBorderWidth = "0";
                    $themeLightboxObj->closeButtBorderStyle = "none";
                    $themeLightboxObj->closeButtBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->titleDescpFWith = "1";
                    $themeLightboxObj->titleDescpWith = "200";
                    $themeLightboxObj->titleDescpPos = "topCenter";
                    $themeLightboxObj->titleDescpMargin = "24";
                    $themeLightboxObj->titleDescpPadding = "25";
                    $themeLightboxObj->titleDescpBgColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->titleDescpTColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->titleDescpDColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->titleDescpshadowFstVal = "0";
                    $themeLightboxObj->titleDescpshadowSecVal = "0";
                    $themeLightboxObj->titleDescpshadowThdVal = "0";
                    $themeLightboxObj->titleDescpshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->titleDescpTffamily = "sans-serif";
                    $themeLightboxObj->titleDescpTfsize = "20";
                    $themeLightboxObj->titleDescpDfsize = "15";
                    $themeLightboxObj->titleDescpTfweight = "bold";
                    $themeLightboxObj->titleDescpDfweight = "600";
                    $themeLightboxObj->titleDescpBrad = "0";
                    $themeLightboxObj->imgcoPos = "topRight";
                    $themeLightboxObj->imgcoMargin = "24";
                    $themeLightboxObj->imgcoPadding = "3";
                    $themeLightboxObj->imgcoBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->imgcoColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->imgcoshadowFstVal = "0";
                    $themeLightboxObj->imgcoshadowSecVal = "0";
                    $themeLightboxObj->imgcoshadowThdVal = "0";
                    $themeLightboxObj->imgcoshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->imgcoBrad = "0";
                    $themeLightboxObj->imgcoffamily = "sans-serif";
                    $themeLightboxObj->imgcofsize = "11";
                    $themeLightboxObj->imgcofweight = "bold";
                    $themeLightboxObj->navButtons = "angle";
                    $themeLightboxObj->navButtBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->navButtBoxshadowFstVal = "0";
                    $themeLightboxObj->navButtBoxshadowSecVal = "0";
                    $themeLightboxObj->navButtBoxshadowThdVal = "0";
                    $themeLightboxObj->navButtBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->navButtBorderWidth = "1";
                    $themeLightboxObj->navButtBorderStyle = "none";
                    $themeLightboxObj->navButtBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->navButtBorderRadius = "0";
                    $themeLightboxObj->navButtSize = "45";
                    $themeLightboxObj->navButtMargin = "24";
                    $themeLightboxObj->navButtHoverEffect = "fade";
                    $themeLightboxObj->navButtShButts = "onhover";
                    $themeLightboxObj->filmstripSize = "60";
                    $themeLightboxObj->filmstripBgColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->filmstripPos = "top";
                    $themeLightboxObj->filmThumbWidth = "90";
                    $themeLightboxObj->filmThumbBorderWidth = "2";
                    $themeLightboxObj->filmThumbBorderStyle = "none";
                    $themeLightboxObj->filmThumbBorderColor = "rgba(232,232,232,0.43)";
                    $themeLightboxObj->filmThumbMargin = "10";
                    $themeLightboxObj->filmThumbPadding = "0";
                    $themeLightboxObj->filmThumbBoxshadowFstVal = "0";
                    $themeLightboxObj->filmThumbBoxshadowSecVal = "0";
                    $themeLightboxObj->filmThumbBoxshadowThdVal = "0";
                    $themeLightboxObj->filmThumbBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->filmThumbBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->filmThumbSelEffect = "border";
                    $themeLightboxObj->filmNavButtons = "caret";
                    $themeLightboxObj->filmNavWidth = "25";
                    $themeLightboxObj->filmNavBgColor = "rgba(255,255,255,0.83)";
                    $themeLightboxObj->filmNavBoxshadowFstVal = "0";
                    $themeLightboxObj->filmNavBoxshadowSecVal = "0";
                    $themeLightboxObj->filmNavBoxshadowThdVal = "0";
                    $themeLightboxObj->filmNavBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->filmNavBorderWidth = "0";
                    $themeLightboxObj->filmNavBorderStyle = "none";
                    $themeLightboxObj->filmNavBorderColor = "rgba(0,0,0,0.52)";
                    $themeLightboxObj->contButtContBgcolor = "rgba(92,92,92,0.26)";
                    $themeLightboxObj->contButtContBoxshadowFstVal = "0";
                    $themeLightboxObj->contButtContBoxshadowSecVal = "0";
                    $themeLightboxObj->contButtContBoxshadowThdVal = "0";
                    $themeLightboxObj->contButtContBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->contButtBgColor = "rgba(74,74,74,0.35)";
                    $themeLightboxObj->contButtSize = "14";
                    $themeLightboxObj->contButtBoxshadowFstVal = "0";
                    $themeLightboxObj->contButtBoxshadowSecVal = "0";
                    $themeLightboxObj->contButtBoxshadowThdVal = "0";
                    $themeLightboxObj->contButtBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->contButtBorderWidth = "2";
                    $themeLightboxObj->contButtBorderStyle = "none";
                    $themeLightboxObj->contButtBorderColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->contButtcontMargin = "10";
                    $themeLightboxObj->contButtMargin = "10";
                    $themeLightboxObj->contButtContBorderWidth = "2";
                    $themeLightboxObj->contButtContBorderStyle = "none";
                    $themeLightboxObj->contButtContBorderColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->contButtOnhover = "0";
                    $themeLightboxObj->commContBgcolor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commContMargin = "35";
                    $themeLightboxObj->commContMarginH = "10";
                    $themeLightboxObj->commFontSize = "12";
                    $themeLightboxObj->commFontColor = "rgba(74,74,74,1)";
                    $themeLightboxObj->commFontFamily = "sans-serif";
                    $themeLightboxObj->commFontWeight = "600";
                    $themeLightboxObj->commFontStyle = "inherit";
                    $themeLightboxObj->commButtBgcolor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commButtHBgcolor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commButtBoxshadowFstVal = "0";
                    $themeLightboxObj->commButtBoxshadowSecVal = "0";
                    $themeLightboxObj->commButtBoxshadowThdVal = "0";
                    $themeLightboxObj->commButtBoxshadowColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commButtSize = "15";
                    $themeLightboxObj->commInpFSize = "12";
                    $themeLightboxObj->commInpColor = "rgba(44,74,82,0.67)";
                    $themeLightboxObj->commInpFFamily = "sans-serif";
                    $themeLightboxObj->commInpFWeight = "inherit";
                    $themeLightboxObj->commInpFFstyle = "inherit";
                    $themeLightboxObj->commInpBoxshadowFstVal = "0";
                    $themeLightboxObj->commInpBoxshadowSecVal = "0";
                    $themeLightboxObj->commInpBoxshadowThdVal = "0";
                    $themeLightboxObj->commInpBoxshadowColor = "rgba(209,209,209,1)";
                    $themeLightboxObj->commInpBorderWidth = "1";
                    $themeLightboxObj->commInpBorderStyle = "solid";
                    $themeLightboxObj->commInpBorderColor = "rgba(176,176,176,1)";
                    $themeLightboxObj->commInpBgColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commInpBorderRadius = "2";
                    $themeLightboxObj->commInpAcBorderColor = "rgba(44,74,82,0.87)";
                    $themeLightboxObj->commInpAcBoxshadowFstVal = "0";
                    $themeLightboxObj->commInpAcBoxshadowSecVal = "0";
                    $themeLightboxObj->commInpAcBoxshadowThdVal = "0";
                    $themeLightboxObj->commInpAcBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->commButtColor = "rgba(44,74,82,0.67)";
                    $themeLightboxObj->commButtBorderRadius = "3";
                    $themeLightboxObj->commButtBorderWidth = "1";
                    $themeLightboxObj->commButtBorderStyle = "solid";
                    $themeLightboxObj->commButtBorderColor = "rgba(142,155,151,1)";
                    $themeLightboxObj->commClButtSize = "14";
                    $themeLightboxObj->commClButtBoxshadowFstVal = "0";
                    $themeLightboxObj->commClButtBoxshadowSecVal = "0";
                    $themeLightboxObj->commClButtBoxshadowThdVal = "0";
                    $themeLightboxObj->commClButtBoxshadowColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commClButtBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->commClButtBorderRadius = "0";
                    $themeLightboxObj->commClButtBorderWidth = "1";
                    $themeLightboxObj->commClButtBorderStyle = "none";
                    $themeLightboxObj->commClButtBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commCpButtSize = "20";
                    $themeLightboxObj->commCpButtBoxshadowFstVal = "0";
                    $themeLightboxObj->commCpButtBoxshadowSecVal = "0";
                    $themeLightboxObj->commCpButtBoxshadowThdVal = "0";
                    $themeLightboxObj->commCpButtBoxshadowColor = "rgba(99,99,99,1)";
                    $themeLightboxObj->commCpButtBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->commCpButtBorderRadius = "2";
                    $themeLightboxObj->commCpButtBorderWidth = "1";
                    $themeLightboxObj->commCpButtBorderStyle = "none";
                    $themeLightboxObj->commCpButtBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commAFontSize = "13";
                    $themeLightboxObj->commAFontColor = "rgba(74,74,74,1)";
                    $themeLightboxObj->commAFontFamily = "sans-serif";
                    $themeLightboxObj->commAFontWeight = "600";
                    $themeLightboxObj->commAFontStyle = "italic";
                    $themeLightboxObj->commTFontSize = "12";
                    $themeLightboxObj->commTFontColor = "rgba(119,119,119,1)";
                    $themeLightboxObj->commTFontFamily = "sans-serif";
                    $themeLightboxObj->commTFontWeight = "normal";
                    $themeLightboxObj->commTFontStyle = "inherit";
                    $themeLightboxObj->commDFontSize = "11";
                    $themeLightboxObj->commDFontColor = "rgba(132,132,132,1)";
                    $themeLightboxObj->commDFontFamily = "sans-serif";
                    $themeLightboxObj->commDFontWeight = "normal";
                    $themeLightboxObj->commDFontStyle = "normal";
                    $themeLightboxObj->boxBgColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->ccl = "arrow-right";
                    $themeLightboxObj->closeButtBRad = "0";
                    $themeLightboxObj->closeButtBoxSize = "25";
                    $themeLightboxObj->closeButtColor = "rgba(185,185,185,1)";
                    $themeLightboxObj->closeButtHoverColor = "rgba(112,112,112,1)";
                    $themeLightboxObj->closeButtPos = "topRight";
                    $themeLightboxObj->closeButtPosXoffset = "-28";
                    $themeLightboxObj->closeButtPosYoffset = "-2";
                    $themeLightboxObj->commClButtBoxSize = "25";
                    $themeLightboxObj->commClButtColor = "rgba(197,197,197,1)";
                    $themeLightboxObj->commClButtHoverColor = "rgba(112,112,112,1)";
                    $themeLightboxObj->commClButtPosXoffset = "5";
                    $themeLightboxObj->commClButtPosYoffset = "5";
                    $themeLightboxObj->commCpButtBoxSize = "30";
                    $themeLightboxObj->commCpButtColor = "rgba(197,197,197,1)";
                    $themeLightboxObj->commCpButtHoverColor = "rgba(112,112,112,1)";
                    $themeLightboxObj->contButtBoxSize = "25";
                    $themeLightboxObj->contButtColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->contButtContBgGrDir = "0deg";
                    $themeLightboxObj->contButtContBgGrFrColor = "rgba(64,64,64,0.17)";
                    $themeLightboxObj->contButtContBgGrToColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->contButtHoverBgColor = "rgba(199,199,199,0.21)";
                    $themeLightboxObj->contButtHoverColor = "rgba(110,110,110,1)";
                    $themeLightboxObj->contButtShadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->contButtShadowFstVal = "0";
                    $themeLightboxObj->contButtShadowSecVal = "0";
                    $themeLightboxObj->contButtShadowThdVal = "0";
                    $themeLightboxObj->contButtBorderRadius = "4";
                    $themeLightboxObj->cop = "comments";
                    $themeLightboxObj->crl = "refresh";
                    $themeLightboxObj->fb = "facebook";
                    $themeLightboxObj->filmNavBorderRadius = "12.5";
                    $themeLightboxObj->filmNavButtColor = "rgba(168,168,168,1)";
                    $themeLightboxObj->filmNavButtHoverColor = "rgba(102,93,93,1)";
                    $themeLightboxObj->filmNavButtSize = "15";
                    $themeLightboxObj->filmNavButtonsSh = "onhover";
                    $themeLightboxObj->filmNavHeight = "25";
                    $themeLightboxObj->filmNavHoverBgColor = "rgba(255,255,255,0.83)";
                    $themeLightboxObj->filmNavOffset = "15";
                    $themeLightboxObj->filmSelThumbBorderColor = "rgba(156,156,156,1)";
                    $themeLightboxObj->filmSelThumbBorderStyle = "solid";
                    $themeLightboxObj->filmSelThumbBorderWidth = "2";
                    $themeLightboxObj->filmstripMarginBottom = "5";
                    $themeLightboxObj->filmstripMarginTop = "5";
                    $themeLightboxObj->gplus = "google-plus";
                    $themeLightboxObj->imgcoPosXoffset = "10";
                    $themeLightboxObj->imgcoPosYoffset = "30";
                    $themeLightboxObj->info = "info";
                    $themeLightboxObj->max = "expand";
                    $themeLightboxObj->min = "compress";
                    $themeLightboxObj->navButtBoxSize = "150";
                    $themeLightboxObj->navButtColor = "rgba(189,189,189,1)";
                    $themeLightboxObj->navButtHoverColor = "rgba(122,122,122,1)";
                    $themeLightboxObj->navButtHoverShadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->navButtHoverShadowFstVal = "0";
                    $themeLightboxObj->navButtHoverShadowSecVal = "0";
                    $themeLightboxObj->navButtHoverShadowThdVal = "0";
                    $themeLightboxObj->navButtShadowColor = "rgba(171,171,171,1)";
                    $themeLightboxObj->navButtShadowFstVal = "0";
                    $themeLightboxObj->navButtShadowSecVal = "0";
                    $themeLightboxObj->navButtShadowThdVal = "1";
                    $themeLightboxObj->pause = "pause";
                    $themeLightboxObj->pcl = "times-circle";
                    $themeLightboxObj->play = "play";
                    $themeLightboxObj->titleDescpBgGrDir = "180deg";
                    $themeLightboxObj->titleDescpBgGrFrColor = "rgba(64,64,64,0.43)";
                    $themeLightboxObj->titleDescpBgGrToColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->titleDescpPosXoffset = "0";
                    $themeLightboxObj->titleDescpPosYoffset = "0";
                    $themeLightboxObj->titleDescpTmaxWidth = "60";
                    $themeLightboxObj->twitt = "twitter";
                    $themeLightboxObj->titleDescpDmaxWidth = "90";

                } else {
                    $themeFilmObj->fmBgColor = "rgba(255,255,255,0)";
                    $themeFilmObj->fmMargin = "2";
                    $themeFilmObj->fmHoverEffect = "none";
                    $themeFilmObj->fmThumbBorderWidth = "0";
                    $themeFilmObj->fmThumbBorderStyle = "none";
                    $themeFilmObj->fmThumbBorderColor = "rgba(0,0,0,1)";
                    $themeFilmObj->fmThumbMargin = "10";
                    $themeFilmObj->fmThumbPadding = "5";
                    $themeFilmObj->fmThumbBoxshadowFstVal = "0";
                    $themeFilmObj->fmThumbBoxshadowSecVal = "0";
                    $themeFilmObj->fmThumbBoxshadowThdVal = "3";
                    $themeFilmObj->fmThumbBoxshadowColor = "rgba(0,0,0,1)";
                    $themeFilmObj->fmThumbBgColor = "rgba(255,255,255,1)";
                    $themeFilmObj->fmNavButtons = "chevron";
                    $themeFilmObj->fmNavWidth = "45";
                    $themeFilmObj->fmNavBgColor = "rgba(0,0,0,0.28)";
                    $themeFilmObj->fmNavBoxshadowFstVal = "0";
                    $themeFilmObj->fmNavBoxshadowSecVal = "0";
                    $themeFilmObj->fmNavBoxshadowThdVal = "0";
                    $themeFilmObj->fmNavBoxshadowColor = "rgba(0,0,0,0)";
                    $themeFilmObj->fmNavBorderWidth = "0";
                    $themeFilmObj->fmNavBorderStyle = "none";
                    $themeFilmObj->fmNavBorderColor = "rgba(0,0,0,0.42)";
                    $themeFilmObj->fmTpadding = "15";
                    $themeFilmObj->fmTBgcolor = "rgba(0,0,0,0.4)";
                    $themeFilmObj->fmTFSize = "18";
                    $themeFilmObj->fmTcolor = "rgba(255,255,255,1)";
                    $themeFilmObj->fmTFFamily = "sans-serif";
                    $themeFilmObj->fmTFWeight = "bold";
                    $themeFilmObj->fmTFstyle = "normal";
                    $themeFilmObj->fmThumbTeffect = "grsFadeIn";
                    $themeFilmObj->fmTpos = "middle";
                    $themeFilmObj->fmNavBorderRadius = "22.5";
                    $themeFilmObj->fmNavColor = "rgba(255,255,255,1)";
                    $themeFilmObj->fmNavHeight = "45";
                    $themeFilmObj->fmNavHoverBgColor = "rgba(0,0,0,0.51)";
                    $themeFilmObj->fmNavHoverColor = "rgba(255,255,255,1)";
                    $themeFilmObj->fmNavOffset = "25";
                    $themeFilmObj->fmNavSize = "25";

                    $themeLightboxObj->bgColor = "rgba(0, 0, 0, 0.63)";
                    $themeLightboxObj->closeButtBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->closeButtSize = "24";
                    $themeLightboxObj->closeButtBoxshadowFstVal = "0";
                    $themeLightboxObj->closeButtBoxshadowSecVal = "0";
                    $themeLightboxObj->closeButtBoxshadowThdVal = "0";
                    $themeLightboxObj->closeButtBoxshadowColor = "rgba(122,122,122,0.87)";
                    $themeLightboxObj->closeButtBorderWidth = "0";
                    $themeLightboxObj->closeButtBorderStyle = "none";
                    $themeLightboxObj->closeButtBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->titleDescpFWith = "1";
                    $themeLightboxObj->titleDescpWith = "200";
                    $themeLightboxObj->titleDescpPos = "bottomCenter";
                    $themeLightboxObj->titleDescpMargin = "24";
                    $themeLightboxObj->titleDescpPadding = "20";
                    $themeLightboxObj->titleDescpBgColor = "rgba(0,0,0,1)";
                    $themeLightboxObj->titleDescpTColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->titleDescpDColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->titleDescpshadowFstVal = "0";
                    $themeLightboxObj->titleDescpshadowSecVal = "0";
                    $themeLightboxObj->titleDescpshadowThdVal = "0";
                    $themeLightboxObj->titleDescpshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->titleDescpTffamily = "sans-serif";
                    $themeLightboxObj->titleDescpTfsize = "20";
                    $themeLightboxObj->titleDescpDfsize = "15";
                    $themeLightboxObj->titleDescpTfweight = "bold";
                    $themeLightboxObj->titleDescpDfweight = "500";
                    $themeLightboxObj->titleDescpBrad = "2";
                    $themeLightboxObj->imgcoPos = "bottomRight";
                    $themeLightboxObj->imgcoMargin = "24";
                    $themeLightboxObj->imgcoPadding = "3";
                    $themeLightboxObj->imgcoBgColor = "rgba(0,0,0,0)";
                    $themeLightboxObj->imgcoColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->imgcoshadowFstVal = "0";
                    $themeLightboxObj->imgcoshadowSecVal = "0";
                    $themeLightboxObj->imgcoshadowThdVal = "0";
                    $themeLightboxObj->imgcoshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->imgcoBrad = "4";
                    $themeLightboxObj->imgcoffamily = "sans-serif";
                    $themeLightboxObj->imgcofsize = "11";
                    $themeLightboxObj->imgcofweight = "bold";
                    $themeLightboxObj->navButtons = "angle";
                    $themeLightboxObj->navButtBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->navButtBoxshadowFstVal = "0";
                    $themeLightboxObj->navButtBoxshadowSecVal = "0";
                    $themeLightboxObj->navButtBoxshadowThdVal = "0";
                    $themeLightboxObj->navButtBoxshadowColor = "rgba(99,99,99,0)";
                    $themeLightboxObj->navButtBorderWidth = "1";
                    $themeLightboxObj->navButtBorderStyle = "none";
                    $themeLightboxObj->navButtBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->navButtBorderRadius = "0";
                    $themeLightboxObj->navButtSize = "50";
                    $themeLightboxObj->navButtMargin = "30";
                    $themeLightboxObj->navButtHoverEffect = "fade";
                    $themeLightboxObj->navButtShButts = "onhover";
                    $themeLightboxObj->filmstripSize = "60";
                    $themeLightboxObj->filmstripBgColor = "rgba(0,0,0,1)";
                    $themeLightboxObj->filmstripPos = "bottom";
                    $themeLightboxObj->filmThumbWidth = "90";
                    $themeLightboxObj->filmThumbBorderWidth = "0";
                    $themeLightboxObj->filmThumbBorderStyle = "none";
                    $themeLightboxObj->filmThumbBorderColor = "rgba(115,115,115,0)";
                    $themeLightboxObj->filmThumbMargin = "7";
                    $themeLightboxObj->filmThumbPadding = "0";
                    $themeLightboxObj->filmThumbBoxshadowFstVal = "0";
                    $themeLightboxObj->filmThumbBoxshadowSecVal = "0";
                    $themeLightboxObj->filmThumbBoxshadowThdVal = "0";
                    $themeLightboxObj->filmThumbBoxshadowColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->filmThumbBgColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->filmThumbSelEffect = "border";
                    $themeLightboxObj->filmNavButtons = "arrow";
                    $themeLightboxObj->filmNavWidth = "27";
                    $themeLightboxObj->filmNavBgColor = "rgba(218,218,218,0.64)";
                    $themeLightboxObj->filmNavBoxshadowFstVal = "0";
                    $themeLightboxObj->filmNavBoxshadowSecVal = "0";
                    $themeLightboxObj->filmNavBoxshadowThdVal = "0";
                    $themeLightboxObj->filmNavBoxshadowColor = "rgba(115,115,115,1)";
                    $themeLightboxObj->filmNavBorderWidth = "0";
                    $themeLightboxObj->filmNavBorderStyle = "none";
                    $themeLightboxObj->filmNavBorderColor = "rgba(0,0,0,0.52)";
                    $themeLightboxObj->contButtContBgcolor = "rgba(0,0,0,0.72)";
                    $themeLightboxObj->contButtContBoxshadowFstVal = "0";
                    $themeLightboxObj->contButtContBoxshadowSecVal = "0";
                    $themeLightboxObj->contButtContBoxshadowThdVal = "0";
                    $themeLightboxObj->contButtContBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->contButtBgColor = "rgba(218,218,218,0.19)";
                    $themeLightboxObj->contButtSize = "15";
                    $themeLightboxObj->contButtBoxshadowFstVal = "0";
                    $themeLightboxObj->contButtBoxshadowSecVal = "0";
                    $themeLightboxObj->contButtBoxshadowThdVal = "0";
                    $themeLightboxObj->contButtBoxshadowColor = "rgba(84,84,84,0.5)";
                    $themeLightboxObj->contButtBorderWidth = "2";
                    $themeLightboxObj->contButtBorderStyle = "none";
                    $themeLightboxObj->contButtBorderColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->contButtcontMargin = "10";
                    $themeLightboxObj->contButtMargin = "10";
                    $themeLightboxObj->contButtContBorderWidth = "2";
                    $themeLightboxObj->contButtContBorderStyle = "none";
                    $themeLightboxObj->contButtContBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->contButtOnhover = "1";
                    $themeLightboxObj->commContBgcolor = "rgba(0,0,0,1)";
                    $themeLightboxObj->commContMargin = "35";
                    $themeLightboxObj->commContMarginH = "10";
                    $themeLightboxObj->commFontSize = "12";
                    $themeLightboxObj->commFontColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commFontFamily = "inherit";
                    $themeLightboxObj->commFontWeight = "600";
                    $themeLightboxObj->commFontStyle = "inherit";
                    $themeLightboxObj->commButtBgcolor = "rgba(0,0,0,1)";
                    $themeLightboxObj->commButtHBgcolor = "rgba(0,0,0,1)";
                    $themeLightboxObj->commButtBoxshadowFstVal = "0";
                    $themeLightboxObj->commButtBoxshadowSecVal = "0";
                    $themeLightboxObj->commButtBoxshadowThdVal = "0";
                    $themeLightboxObj->commButtBoxshadowColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commButtSize = "15";
                    $themeLightboxObj->commInpFSize = "12";
                    $themeLightboxObj->commInpColor = "rgba(255,255,255,0.67)";
                    $themeLightboxObj->commInpFFamily = "inherit";
                    $themeLightboxObj->commInpFWeight = "inherit";
                    $themeLightboxObj->commInpFFstyle = "inherit";
                    $themeLightboxObj->commInpBoxshadowFstVal = "0";
                    $themeLightboxObj->commInpBoxshadowSecVal = "0";
                    $themeLightboxObj->commInpBoxshadowThdVal = "0";
                    $themeLightboxObj->commInpBoxshadowColor = "rgba(209,209,209,1)";
                    $themeLightboxObj->commInpBorderWidth = "1";
                    $themeLightboxObj->commInpBorderStyle = "solid";
                    $themeLightboxObj->commInpBorderColor = "rgba(99,99,99,1)";
                    $themeLightboxObj->commInpBgColor = "rgba(0,0,0,1)";
                    $themeLightboxObj->commInpBorderRadius = "2";
                    $themeLightboxObj->commInpAcBorderColor = "rgba(255,255,255,0.87)";
                    $themeLightboxObj->commInpAcBoxshadowFstVal = "0";
                    $themeLightboxObj->commInpAcBoxshadowSecVal = "0";
                    $themeLightboxObj->commInpAcBoxshadowThdVal = "0";
                    $themeLightboxObj->commInpAcBoxshadowColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->commButtColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commButtBorderRadius = "3";
                    $themeLightboxObj->commButtBorderWidth = "1";
                    $themeLightboxObj->commButtBorderStyle = "solid";
                    $themeLightboxObj->commButtBorderColor = "rgba(161,161,161,1)";
                    $themeLightboxObj->commClButtSize = "14";
                    $themeLightboxObj->commClButtBoxshadowFstVal = "0";
                    $themeLightboxObj->commClButtBoxshadowSecVal = "0";
                    $themeLightboxObj->commClButtBoxshadowThdVal = "0";
                    $themeLightboxObj->commClButtBoxshadowColor = "rgba(97,97,97,1)";
                    $themeLightboxObj->commClButtBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->commClButtBorderRadius = "3";
                    $themeLightboxObj->commClButtBorderWidth = "1";
                    $themeLightboxObj->commClButtBorderStyle = "none";
                    $themeLightboxObj->commClButtBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commCpButtSize = "18";
                    $themeLightboxObj->commCpButtBoxshadowFstVal = "0";
                    $themeLightboxObj->commCpButtBoxshadowSecVal = "0";
                    $themeLightboxObj->commCpButtBoxshadowThdVal = "0";
                    $themeLightboxObj->commCpButtBoxshadowColor = "rgba(99,99,99,1)";
                    $themeLightboxObj->commCpButtBgColor = "rgba(255,255,255,0)";
                    $themeLightboxObj->commCpButtBorderRadius = "2";
                    $themeLightboxObj->commCpButtBorderWidth = "1";
                    $themeLightboxObj->commCpButtBorderStyle = "none";
                    $themeLightboxObj->commCpButtBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commAFontSize = "13";
                    $themeLightboxObj->commAFontColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commAFontFamily = "inherit";
                    $themeLightboxObj->commAFontWeight = "normal";
                    $themeLightboxObj->commAFontStyle = "italic";
                    $themeLightboxObj->commTFontSize = "12";
                    $themeLightboxObj->commTFontColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commTFontFamily = "inherit";
                    $themeLightboxObj->commTFontWeight = "normal";
                    $themeLightboxObj->commTFontStyle = "inherit";
                    $themeLightboxObj->commDFontSize = "10";
                    $themeLightboxObj->commDFontColor = "rgba(255,255,255,0.8)";
                    $themeLightboxObj->commDFontFamily = "inherit";
                    $themeLightboxObj->commDFontWeight = "normal";
                    $themeLightboxObj->commDFontStyle = "normal";
                    $themeLightboxObj->boxBgColor = "rgba(0,0,0,1)";
                    $themeLightboxObj->ccl = "arrow-right";
                    $themeLightboxObj->closeButtBRad = "20";
                    $themeLightboxObj->closeButtBoxSize = "20";
                    $themeLightboxObj->closeButtColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->closeButtHoverColor = "rgba(135,135,135,1)";
                    $themeLightboxObj->closeButtPos = "topRight";
                    $themeLightboxObj->closeButtPosXoffset = "-24";
                    $themeLightboxObj->closeButtPosYoffset = "-2";
                    $themeLightboxObj->commClButtBoxSize = "25";
                    $themeLightboxObj->commClButtColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commClButtHoverColor = "rgba(92,92,92,1)";
                    $themeLightboxObj->commClButtPosXoffset = "5";
                    $themeLightboxObj->commClButtPosYoffset = "5";
                    $themeLightboxObj->commCpButtBoxSize = "30";
                    $themeLightboxObj->commCpButtColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->commCpButtHoverColor = "rgba(92,92,92,1)";
                    $themeLightboxObj->contButtBoxSize = "27";
                    $themeLightboxObj->contButtColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->contButtContBgGrDir = "180deg";
                    $themeLightboxObj->contButtContBgGrFrColor = "rgba(0,0,0,0.16)";
                    $themeLightboxObj->contButtContBgGrToColor = "rgba(0,0,0,0)";
                    $themeLightboxObj->contButtHoverBgColor = "rgba(168,168,168,0.5)";
                    $themeLightboxObj->contButtHoverColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->contButtShadowColor = "rgba(0,0,0,0)";
                    $themeLightboxObj->contButtShadowFstVal = "0";
                    $themeLightboxObj->contButtShadowSecVal = "0";
                    $themeLightboxObj->contButtShadowThdVal = "0";
                    $themeLightboxObj->contButtBorderRadius = "4";
                    $themeLightboxObj->cop = "commenting-o";
                    $themeLightboxObj->crl = "refresh";
                    $themeLightboxObj->fb = "facebook";
                    $themeLightboxObj->filmNavBorderRadius = "15";
                    $themeLightboxObj->filmNavButtColor = "rgba(92,92,92,1)";
                    $themeLightboxObj->filmNavButtHoverColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->filmNavButtSize = "15";
                    $themeLightboxObj->filmNavButtonsSh = "onhover";
                    $themeLightboxObj->filmNavHeight = "27";
                    $themeLightboxObj->filmNavHoverBgColor = "rgba(218,218,218,0.64)";
                    $themeLightboxObj->filmNavOffset = "20";
                    $themeLightboxObj->filmSelThumbBorderColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->filmSelThumbBorderStyle = "solid";
                    $themeLightboxObj->filmSelThumbBorderWidth = "2";
                    $themeLightboxObj->filmstripMarginBottom = "10";
                    $themeLightboxObj->filmstripMarginTop = "10";
                    $themeLightboxObj->gplus = "google-plus";
                    $themeLightboxObj->imgcoPosXoffset = "10";
                    $themeLightboxObj->imgcoPosYoffset = "10";
                    $themeLightboxObj->info = "info";
                    $themeLightboxObj->max = "expand";
                    $themeLightboxObj->min = "compress";
                    $themeLightboxObj->navButtBoxSize = "200";
                    $themeLightboxObj->navButtColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->navButtHoverColor = "rgba(255,255,255,1)";
                    $themeLightboxObj->navButtHoverShadowColor = "rgba(13,12,12,1)";
                    $themeLightboxObj->navButtHoverShadowFstVal = "0";
                    $themeLightboxObj->navButtHoverShadowSecVal = "0";
                    $themeLightboxObj->navButtHoverShadowThdVal = "1";
                    $themeLightboxObj->navButtShadowColor = "rgba(5,5,5,0)";
                    $themeLightboxObj->navButtShadowFstVal = "0";
                    $themeLightboxObj->navButtShadowSecVal = "0";
                    $themeLightboxObj->navButtShadowThdVal = "0";
                    $themeLightboxObj->pause = "pause";
                    $themeLightboxObj->pcl = "times";
                    $themeLightboxObj->play = "play";
                    $themeLightboxObj->titleDescpBgGrDir = "0deg";
                    $themeLightboxObj->titleDescpBgGrFrColor = "rgba(0,0,0,0.16)";
                    $themeLightboxObj->titleDescpBgGrToColor = "rgba(0,0,0,0)";
                    $themeLightboxObj->titleDescpPosXoffset = "0";
                    $themeLightboxObj->titleDescpPosYoffset = "0";
                    $themeLightboxObj->titleDescpTmaxWidth = "60";
                    $themeLightboxObj->twitt = "twitter";
                    $themeLightboxObj->titleDescpDmaxWidth = "90";
                }

                $okForThemes = $wpdb->update($wpdb->prefix . 'limb_gallery_themes',
                    array(
                        'film' => json_encode($themeFilmObj),
                        'lightbox' => json_encode($themeLightboxObj),
                    ),
                    array(
                        'id' => $theme->id
                    )
                );
            }
        }

        $okForSettings = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_settings` 
			ADD `fmImMoveCount` tinyint(4) NOT NULL DEFAULT 3 AFTER `collapseNavClicks`,
			ADD `filmImMoveCount` tinyint(4) NOT NULL DEFAULT 3 AFTER `fmImMoveCount`,
			ADD `hideNavButton` tinyint(1) NOT NULL DEFAULT 1 AFTER `filmImMoveCount`,
			ADD `closeLbOnSide` tinyint(1) NOT NULL DEFAULT 1 AFTER `hideNavButton`");

        // Write themes css files
        require_once(GRS_PLG_DIR . '/database/GRSGalleryInsert.php');
        $grsGalleryInsert = new GRSGalleryInsert();

        return $ok12 && $okForThemes && $okForSettings && $grsGalleryInsert->generateThemesCss();
    }

    // Alter for 1.1.3
    public function alter_1_3()
    {
        global $wpdb;
        $ok12 = true;

        $alter_1_2 = "SHOW COLUMNS FROM `" . $wpdb->prefix . "limb_gallery_themes` LIKE 'thumbnail'";
        $okFor_1_2 = $wpdb->get_row($alter_1_2);
        if (!isset($okFor_1_2->Field)) {
            $ok12 = $this->alter_1_2();
        }

        return $ok12;
    }

    // Alter for 1.1.2
    public function alter_1_2()
    {
        /*
		  * Alter table -> change Theme table scheme,
		  * Add css files for each theme
		  * :)
		*/
        global $wpdb;
        $ok11 = true;
        $ok12 = false;
        $save = false;
        $bytes = true; //TODO Set to true because the bottom part is commented
        $alter_1_1 = "SHOW COLUMNS FROM `" . $wpdb->prefix . "limb_gallery_galleriescontent` LIKE '%order%'";
        $okFor_1_1 = $wpdb->get_row($alter_1_1);
        if (!isset($okFor_1_1->Field)) {
            $ok11 = $this->alter_1_1();
        }

        $themes = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "limb_gallery_themes`");
        $newThemeScheme = array();
        if ($themes != null) {
            foreach ($themes as $theme) {
                $newTheme = new stdclass();
                $newTheme->id = $theme->id;
                $newTheme->thumbnail = new stdclass();
                $newTheme->film = new stdclass();
                $newTheme->masonry = new stdclass();
                $newTheme->mosaic = new stdclass();
                $newTheme->navigation = new stdclass();
                $newTheme->lightbox = new stdclass();

                /*Thumbnail*/
                $newTheme->thumbnail->thumbnailmargin = $theme->thumbnailmargin;
                $newTheme->thumbnail->thumbnailpadding = $theme->thumbnailpadding;
                $newTheme->thumbnail->thumbnailBorderWidth = $theme->thumbnailBorderWidth;
                $newTheme->thumbnail->thumbnailBorderStyle = $theme->thumbnailBorderStyle;
                $newTheme->thumbnail->thumbnailBorderColor = $theme->thumbnailBorderColor;
                $newTheme->thumbnail->thumbnailHoverEffect = $theme->thumbnailHoverEffect;
                $newTheme->thumbnail->thumbnailBorderRadius = $theme->thumbnailBorderRadius;
                $newTheme->thumbnail->thumbnailMaskColor = $theme->thumbnailMaskColor;
                $newTheme->thumbnail->thumbnailTpadding = $theme->thumbnailTpadding;
                $newTheme->thumbnail->thumbnailTBgcolor = $theme->thumbnailTBgcolor;
                $newTheme->thumbnail->thumbnailTFSize = $theme->thumbnailTFSize;
                $newTheme->thumbnail->thumbnailTcolor = $theme->thumbnailTcolor;
                $newTheme->thumbnail->thumbnailTFFamily = $theme->thumbnailTFFamily;
                $newTheme->thumbnail->thumbnailTFWeight = $theme->thumbnailTFWeight;
                $newTheme->thumbnail->thumbnailTFstyle = $theme->thumbnailTFstyle;
                $newTheme->thumbnail->thumbnailTEffect = $theme->thumbnailTEffect;
                $newTheme->thumbnail->thumbnailTpos = $theme->thumbnailTpos;
                $newTheme->thumbnail->thumbnailBoxshadowFstVal = $theme->thumbnailBoxshadowFstVal;
                $newTheme->thumbnail->thumbnailBoxshadowSecVal = $theme->thumbnailBoxshadowSecVal;
                $newTheme->thumbnail->thumbnailBoxshadowThdVal = $theme->thumbnailBoxshadowThdVal;
                $newTheme->thumbnail->thumbnailBoxshadowColor = $theme->thumbnailBoxshadowColor;
                $newTheme->thumbnail->thumbnailBgColor = $theme->thumbnailBgColor;

                /*Film*/
                $newTheme->film->fmBgColor = $theme->fmBgColor;
                $newTheme->film->fmMargin = $theme->fmMargin;
                $newTheme->film->fmHoverEffect = $theme->fmHoverEffect;
                $newTheme->film->fmThumbBorderWidth = $theme->fmThumbBorderWidth;
                $newTheme->film->fmThumbBorderStyle = $theme->fmThumbBorderStyle;
                $newTheme->film->fmThumbBorderColor = $theme->fmThumbBorderColor;
                $newTheme->film->fmThumbMargin = $theme->fmThumbMargin;
                $newTheme->film->fmThumbPadding = $theme->fmThumbPadding;
                $newTheme->film->fmThumbBoxshadowFstVal = $theme->fmThumbBoxshadowFstVal;
                $newTheme->film->fmThumbBoxshadowSecVal = $theme->fmThumbBoxshadowSecVal;
                $newTheme->film->fmThumbBoxshadowThdVal = $theme->fmThumbBoxshadowThdVal;
                $newTheme->film->fmThumbBoxshadowColor = $theme->fmThumbBoxshadowColor;
                $newTheme->film->fmThumbBgColor = $theme->fmThumbBgColor;
                $newTheme->film->fmNavButtons = $theme->fmNavButtons;
                $newTheme->film->fmNavWidth = $theme->fmNavWidth;
                $newTheme->film->fmNavBgColor = $theme->fmNavBgColor;
                $newTheme->film->fmNavBoxshadowFstVal = $theme->fmNavBoxshadowFstVal;
                $newTheme->film->fmNavBoxshadowSecVal = $theme->fmNavBoxshadowSecVal;
                $newTheme->film->fmNavBoxshadowThdVal = $theme->fmNavBoxshadowThdVal;
                $newTheme->film->fmNavBoxshadowColor = $theme->fmNavBoxshadowColor;
                $newTheme->film->fmNavBorderWidth = $theme->fmNavBorderWidth;
                $newTheme->film->fmNavBorderStyle = $theme->fmNavBorderStyle;
                $newTheme->film->fmNavBorderColor = $theme->fmNavBorderColor;
                $newTheme->film->fmTpadding = $theme->fmTpadding;
                $newTheme->film->fmTBgcolor = $theme->fmTBgcolor;
                $newTheme->film->fmTFSize = $theme->fmTFSize;
                $newTheme->film->fmTcolor = $theme->fmTcolor;
                $newTheme->film->fmTFFamily = $theme->fmTFFamily;
                $newTheme->film->fmTFWeight = $theme->fmTFWeight;
                $newTheme->film->fmTFstyle = $theme->fmTFstyle;
                $newTheme->film->fmThumbTeffect = $theme->fmThumbTeffect;
                $newTheme->film->fmTpos = $theme->fmTpos;

                /*Masonry*/
                $newTheme->masonry->masonrymargin = $theme->masonrymargin;
                $newTheme->masonry->masonryPadding = $theme->masonryPadding;
                $newTheme->masonry->masonryBorderWidth = $theme->masonryBorderWidth;
                $newTheme->masonry->masonryBorderStyle = $theme->masonryBorderStyle;
                $newTheme->masonry->masonryBorderColor = $theme->masonryBorderColor;
                $newTheme->masonry->masonryHoverEffect = $theme->masonryHoverEffect;
                $newTheme->masonry->masonryBorderRadius = $theme->masonryBorderRadius;
                $newTheme->masonry->masonryBoxshadowFstVal = $theme->masonryBoxshadowFstVal;
                $newTheme->masonry->masonryBoxshadowSecVal = $theme->masonryBoxshadowSecVal;
                $newTheme->masonry->masonryBoxshadowThdVal = $theme->masonryBoxshadowThdVal;
                $newTheme->masonry->masonryBoxshadowColor = $theme->masonryBoxshadowColor;
                $newTheme->masonry->masonryBgColor = $theme->masonryBgColor;
                $newTheme->masonry->masonryTpadding = $theme->masonryTpadding;
                $newTheme->masonry->masonryTBgcolor = $theme->masonryTBgcolor;
                $newTheme->masonry->masonryTFSize = $theme->masonryTFSize;
                $newTheme->masonry->masonryTcolor = $theme->masonryTcolor;
                $newTheme->masonry->masonryTFFamily = $theme->masonryTFFamily;
                $newTheme->masonry->masonryTFWeight = $theme->masonryTFWeight;
                $newTheme->masonry->masonryTFstyle = $theme->masonryTFstyle;
                $newTheme->masonry->masonryTEffect = $theme->masonryTEffect;
                $newTheme->masonry->masonryTpos = $theme->masonryTpos;

                /*Mosaic*/
                $newTheme->mosaic->mosaicPadding = $theme->mosaicPadding;
                $newTheme->mosaic->mosaicBorderWidth = $theme->mosaicBorderWidth;
                $newTheme->mosaic->mosaicBorderStyle = $theme->mosaicBorderStyle;
                $newTheme->mosaic->mosaicBorderColor = $theme->mosaicBorderColor;
                $newTheme->mosaic->mosaicHoverEffect = $theme->mosaicHoverEffect;
                $newTheme->mosaic->mosaicBorderRadius = $theme->mosaicBorderRadius;
                $newTheme->mosaic->mosaicBoxshadowFstVal = $theme->mosaicBoxshadowFstVal;
                $newTheme->mosaic->mosaicBoxshadowSecVal = $theme->mosaicBoxshadowSecVal;
                $newTheme->mosaic->mosaicBoxshadowThdVal = $theme->mosaicBoxshadowThdVal;
                $newTheme->mosaic->mosaicBoxshadowColor = $theme->mosaicBoxshadowColor;
                $newTheme->mosaic->mosaicBgColor = $theme->mosaicBgColor;
                $newTheme->mosaic->mosaicMargin = $theme->mosaicMargin;
                $newTheme->mosaic->mosaicTpadding = $theme->mosaicTpadding;
                $newTheme->mosaic->mosaicTBgcolor = $theme->mosaicTBgcolor;
                $newTheme->mosaic->mosaicTFSize = $theme->mosaicTFSize;
                $newTheme->mosaic->mosaicTcolor = $theme->mosaicTcolor;
                $newTheme->mosaic->mosaicTFFamily = $theme->mosaicTFFamily;
                $newTheme->mosaic->mosaicTFWeight = $theme->mosaicTFWeight;
                $newTheme->mosaic->mosaicTFstyle = $theme->mosaicTFstyle;
                $newTheme->mosaic->mosaicTEffect = $theme->mosaicTEffect;
                $newTheme->mosaic->mosaicTpos = $theme->mosaicTpos;

                /*Navigation*/
                $newTheme->navigation->pnavCMarginT = $theme->pnavCMarginT;
                $newTheme->navigation->pnavAlign = $theme->pnavAlign;
                $newTheme->navigation->pnavBMargin = $theme->pnavBMargin;
                $newTheme->navigation->pnavBPadding = $theme->pnavBPadding;
                $newTheme->navigation->pnavBBorderWidth = $theme->pnavBBorderWidth;
                $newTheme->navigation->pnavBBorderStyle = $theme->pnavBBorderStyle;
                $newTheme->navigation->pnavBBorderColor = $theme->pnavBBorderColor;
                $newTheme->navigation->pnavBBoxshadowFstVal = $theme->pnavBBoxshadowFstVal;
                $newTheme->navigation->pnavBBoxshadowSecVal = $theme->pnavBBoxshadowSecVal;
                $newTheme->navigation->pnavBBoxshadowThdVal = $theme->pnavBBoxshadowThdVal;
                $newTheme->navigation->pnavBBoxshadowColor = $theme->pnavBBoxshadowColor;
                $newTheme->navigation->pnavBBgColor = $theme->pnavBBgColor;
                $newTheme->navigation->pnavBHBgColor = $theme->pnavBHBgColor;
                $newTheme->navigation->pnavBABgColor = $theme->pnavBABgColor;
                $newTheme->navigation->pnavBBorderRadius = $theme->pnavBBorderRadius;
                $newTheme->navigation->pnavBFSize = $theme->pnavBFSize;
                $newTheme->navigation->pnavBcolor = $theme->pnavBcolor;
                $newTheme->navigation->pnavBFFamily = $theme->pnavBFFamily;
                $newTheme->navigation->pnavBFWeight = $theme->pnavBFWeight;
                $newTheme->navigation->pnavBFstyle = $theme->pnavBFstyle;
                $newTheme->navigation->backBorderStyle = $theme->backBorderStyle;
                $newTheme->navigation->backBorderWidth = $theme->backBorderWidth;
                $newTheme->navigation->backBorderColor = $theme->backBorderColor;
                $newTheme->navigation->backBoxshadowFstVal = $theme->backBoxshadowFstVal;
                $newTheme->navigation->backBoxshadowSecVal = $theme->backBoxshadowSecVal;
                $newTheme->navigation->backBoxshadowThdVal = $theme->backBoxshadowThdVal;
                $newTheme->navigation->backBoxshadowColor = $theme->backBoxshadowColor;
                $newTheme->navigation->backBgColor = $theme->backBgColor;
                $newTheme->navigation->backHBgColor = $theme->backHBgColor;
                $newTheme->navigation->backBorderRadius = $theme->backBorderRadius;
                $newTheme->navigation->backFSize = $theme->backFSize;
                $newTheme->navigation->backColor = $theme->backColor;

                /*Lightbox*/
                $newTheme->lightbox->bgColor = $theme->bgColor;
                $newTheme->lightbox->closeButtBgColor = $theme->closeButtBgColor;
                $newTheme->lightbox->closeButtSize = $theme->closeButtSize;
                $newTheme->lightbox->closeButtBoxshadowFstVal = $theme->closeButtBoxshadowFstVal;
                $newTheme->lightbox->closeButtBoxshadowSecVal = $theme->closeButtBoxshadowSecVal;
                $newTheme->lightbox->closeButtBoxshadowThdVal = $theme->closeButtBoxshadowThdVal;
                $newTheme->lightbox->closeButtBoxshadowColor = $theme->closeButtBoxshadowColor;
                $newTheme->lightbox->closeButtBorderWidth = $theme->closeButtBorderWidth;
                $newTheme->lightbox->closeButtBorderStyle = $theme->closeButtBorderStyle;
                $newTheme->lightbox->closeButtBorderColor = $theme->closeButtBorderColor;

                $newTheme->lightbox->titleDescpFWith = $theme->titleDescpFWith;
                $newTheme->lightbox->titleDescpWith = $theme->titleDescpWith;
                $newTheme->lightbox->titleDescpPos = $theme->titleDescpPos;
                $newTheme->lightbox->titleDescpMargin = $theme->titleDescpMargin;
                $newTheme->lightbox->titleDescpPadding = $theme->titleDescpPadding;
                $newTheme->lightbox->titleDescpBgColor = $theme->titleDescpBgColor;
                $newTheme->lightbox->titleDescpTColor = $theme->titleDescpTColor;
                $newTheme->lightbox->titleDescpDColor = $theme->titleDescpDColor;
                $newTheme->lightbox->titleDescpshadowFstVal = $theme->titleDescpshadowFstVal;
                $newTheme->lightbox->titleDescpshadowSecVal = $theme->titleDescpshadowSecVal;
                $newTheme->lightbox->titleDescpshadowThdVal = $theme->titleDescpshadowThdVal;
                $newTheme->lightbox->titleDescpshadowColor = $theme->titleDescpshadowColor;
                $newTheme->lightbox->titleDescpTffamily = $theme->titleDescpTffamily;
                $newTheme->lightbox->titleDescpTfsize = $theme->titleDescpTfsize;
                $newTheme->lightbox->titleDescpDfsize = $theme->titleDescpDfsize;
                $newTheme->lightbox->titleDescpTfweight = $theme->titleDescpTfweight;
                $newTheme->lightbox->titleDescpDfweight = $theme->titleDescpDfweight;
                $newTheme->lightbox->titleDescpBrad = $theme->titleDescpBrad;

                $newTheme->lightbox->imgcoPos = $theme->imgcoPos;
                $newTheme->lightbox->imgcoMargin = $theme->imgcoMargin;
                $newTheme->lightbox->imgcoPadding = $theme->imgcoPadding;
                $newTheme->lightbox->imgcoBgColor = $theme->imgcoBgColor;
                $newTheme->lightbox->imgcoColor = $theme->imgcoColor;
                $newTheme->lightbox->imgcoshadowFstVal = $theme->imgcoshadowFstVal;
                $newTheme->lightbox->imgcoshadowSecVal = $theme->imgcoshadowSecVal;
                $newTheme->lightbox->imgcoshadowThdVal = $theme->imgcoshadowThdVal;
                $newTheme->lightbox->imgcoshadowColor = $theme->imgcoshadowColor;
                $newTheme->lightbox->imgcoBrad = $theme->imgcoBrad;
                $newTheme->lightbox->imgcoffamily = $theme->imgcoffamily;
                $newTheme->lightbox->imgcofsize = $theme->imgcofsize;
                $newTheme->lightbox->imgcofweight = $theme->imgcofweight;

                $newTheme->lightbox->navButtons = $theme->navButtons;
                $newTheme->lightbox->navButtBgColor = $theme->navButtBgColor;
                $newTheme->lightbox->navButtBoxshadowFstVal = $theme->navButtBoxshadowFstVal;
                $newTheme->lightbox->navButtBoxshadowSecVal = $theme->navButtBoxshadowSecVal;
                $newTheme->lightbox->navButtBoxshadowThdVal = $theme->navButtBoxshadowThdVal;
                $newTheme->lightbox->navButtBoxshadowColor = $theme->navButtBoxshadowColor;
                $newTheme->lightbox->navButtBorderWidth = $theme->navButtBorderWidth;
                $newTheme->lightbox->navButtBorderStyle = $theme->navButtBorderStyle;
                $newTheme->lightbox->navButtBorderColor = $theme->navButtBorderColor;
                $newTheme->lightbox->navButtBorderRadius = $theme->navButtBorderRadius;
                $newTheme->lightbox->navButtSize = $theme->navButtSize;
                $newTheme->lightbox->navButtMargin = $theme->navButtMargin;
                $newTheme->lightbox->navButtHoverEffect = $theme->navButtHoverEffect;
                $newTheme->lightbox->navButtShButts = $theme->navButtShButts;
                $newTheme->lightbox->filmstripSize = $theme->filmstripSize;
                $newTheme->lightbox->filmstripBgColor = $theme->filmstripBgColor;
                $newTheme->lightbox->filmstripMargin = $theme->filmstripMargin;
                $newTheme->lightbox->filmstripPos = $theme->filmstripPos;
                $newTheme->lightbox->filmThumbWidth = $theme->filmThumbWidth;
                $newTheme->lightbox->filmThumbBorderWidth = $theme->filmThumbBorderWidth;
                $newTheme->lightbox->filmThumbBorderStyle = $theme->filmThumbBorderStyle;
                $newTheme->lightbox->filmThumbBorderColor = $theme->filmThumbBorderColor;
                $newTheme->lightbox->filmThumbMargin = $theme->filmThumbMargin;
                $newTheme->lightbox->filmThumbPadding = $theme->filmThumbPadding;
                $newTheme->lightbox->filmThumbBoxshadowFstVal = $theme->filmThumbBoxshadowFstVal;
                $newTheme->lightbox->filmThumbBoxshadowSecVal = $theme->filmThumbBoxshadowSecVal;
                $newTheme->lightbox->filmThumbBoxshadowThdVal = $theme->filmThumbBoxshadowThdVal;
                $newTheme->lightbox->filmThumbBoxshadowColor = $theme->filmThumbBoxshadowColor;
                $newTheme->lightbox->filmThumbBgColor = $theme->filmThumbBgColor;
                $newTheme->lightbox->filmThumbSelEffect = $theme->filmThumbSelEffect;
                $newTheme->lightbox->filmNavButtons = $theme->filmNavButtons;
                $newTheme->lightbox->filmNavWidth = $theme->filmNavWidth;
                $newTheme->lightbox->filmNavBgColor = $theme->filmNavBgColor;
                $newTheme->lightbox->filmNavBoxshadowFstVal = $theme->filmNavBoxshadowFstVal;
                $newTheme->lightbox->filmNavBoxshadowSecVal = $theme->filmNavBoxshadowSecVal;
                $newTheme->lightbox->filmNavBoxshadowThdVal = $theme->filmNavBoxshadowThdVal;
                $newTheme->lightbox->filmNavBoxshadowColor = $theme->filmNavBoxshadowColor;
                $newTheme->lightbox->filmNavBorderWidth = $theme->filmNavBorderWidth;
                $newTheme->lightbox->filmNavBorderStyle = $theme->filmNavBorderStyle;
                $newTheme->lightbox->filmNavBorderColor = $theme->filmNavBorderColor;
                $newTheme->lightbox->contButtContBgcolor = $theme->contButtContBgcolor;
                $newTheme->lightbox->contButtContBoxshadowFstVal = $theme->contButtContBoxshadowFstVal;
                $newTheme->lightbox->contButtContBoxshadowSecVal = $theme->contButtContBoxshadowSecVal;
                $newTheme->lightbox->contButtContBoxshadowThdVal = $theme->contButtContBoxshadowThdVal;
                $newTheme->lightbox->contButtContBoxshadowColor = $theme->contButtContBoxshadowColor;
                $newTheme->lightbox->contButtons = $theme->contButtons;
                $newTheme->lightbox->contButtBgColor = $theme->contButtBgColor;
                $newTheme->lightbox->contButtSize = $theme->contButtSize;
                $newTheme->lightbox->contButtBoxshadowFstVal = $theme->contButtBoxshadowFstVal;
                $newTheme->lightbox->contButtBoxshadowSecVal = $theme->contButtBoxshadowSecVal;
                $newTheme->lightbox->contButtBoxshadowThdVal = $theme->contButtBoxshadowThdVal;
                $newTheme->lightbox->contButtBoxshadowColor = $theme->contButtBoxshadowColor;
                $newTheme->lightbox->contButtBorderWidth = $theme->contButtBorderWidth;
                $newTheme->lightbox->contButtBorderStyle = $theme->contButtBorderStyle;
                $newTheme->lightbox->contButtBorderColor = $theme->contButtBorderColor;
                $newTheme->lightbox->contButtcontMargin = $theme->contButtcontMargin;
                $newTheme->lightbox->contButtMargin = $theme->contButtMargin;
                $newTheme->lightbox->contButtclWidth = $theme->contButtclWidth;
                $newTheme->lightbox->contButtclHeight = $theme->contButtclHeight;
                $newTheme->lightbox->contButtContBorderWidth = $theme->contButtContBorderWidth;
                $newTheme->lightbox->contButtContBorderStyle = $theme->contButtContBorderStyle;
                $newTheme->lightbox->contButtContBorderColor = $theme->contButtContBorderColor;
                $newTheme->lightbox->contButtOnhover = $theme->contButtOnhover;
                $newTheme->lightbox->commContBgcolor = $theme->commContBgcolor;
                $newTheme->lightbox->commContMargin = $theme->commContMargin;
                $newTheme->lightbox->commContMarginH = $theme->commContMarginH;
                $newTheme->lightbox->commFontSize = $theme->commFontSize;
                $newTheme->lightbox->commFontColor = $theme->commFontColor;
                $newTheme->lightbox->commFontFamily = $theme->commFontFamily;
                $newTheme->lightbox->commFontWeight = $theme->commFontWeight;
                $newTheme->lightbox->commFontStyle = $theme->commFontStyle;
                $newTheme->lightbox->commButtBgcolor = $theme->commButtBgcolor;
                $newTheme->lightbox->commButtHBgcolor = $theme->commButtHBgcolor;
                $newTheme->lightbox->commButtBoxshadowFstVal = $theme->commButtBoxshadowFstVal;
                $newTheme->lightbox->commButtBoxshadowSecVal = $theme->commButtBoxshadowSecVal;
                $newTheme->lightbox->commButtBoxshadowThdVal = $theme->commButtBoxshadowThdVal;
                $newTheme->lightbox->commButtBoxshadowColor = $theme->commButtBoxshadowColor;
                $newTheme->lightbox->commButtSize = $theme->commButtSize;
                $newTheme->lightbox->commInpFSize = $theme->commInpFSize;
                $newTheme->lightbox->commInpColor = $theme->commInpColor;
                $newTheme->lightbox->commInpFFamily = $theme->commInpFFamily;
                $newTheme->lightbox->commInpFWeight = $theme->commInpFWeight;
                $newTheme->lightbox->commInpFFstyle = $theme->commInpFFstyle;
                $newTheme->lightbox->commInpBoxshadowFstVal = $theme->commInpBoxshadowFstVal;
                $newTheme->lightbox->commInpBoxshadowSecVal = $theme->commInpBoxshadowSecVal;
                $newTheme->lightbox->commInpBoxshadowThdVal = $theme->commInpBoxshadowThdVal;
                $newTheme->lightbox->commInpBoxshadowColor = $theme->commInpBoxshadowColor;
                $newTheme->lightbox->commInpBorderWidth = $theme->commInpBorderWidth;
                $newTheme->lightbox->commInpBorderStyle = $theme->commInpBorderStyle;
                $newTheme->lightbox->commInpBorderColor = $theme->commInpBorderColor;
                $newTheme->lightbox->commInpBgColor = $theme->commInpBgColor;
                $newTheme->lightbox->commInpBorderRadius = $theme->commInpBorderRadius;
                $newTheme->lightbox->commInpAcBorderColor = $theme->commInpAcBorderColor;
                $newTheme->lightbox->commInpAcBoxshadowFstVal = $theme->commInpAcBoxshadowFstVal;
                $newTheme->lightbox->commInpAcBoxshadowSecVal = $theme->commInpAcBoxshadowSecVal;
                $newTheme->lightbox->commInpAcBoxshadowThdVal = $theme->commInpAcBoxshadowThdVal;
                $newTheme->lightbox->commInpAcBoxshadowColor = $theme->commInpAcBoxshadowColor;
                $newTheme->lightbox->commButtColor = $theme->commButtColor;
                $newTheme->lightbox->commButtBorderRadius = $theme->commButtBorderRadius;
                $newTheme->lightbox->commButtBorderWidth = $theme->commButtBorderWidth;
                $newTheme->lightbox->commButtBorderStyle = $theme->commButtBorderStyle;
                $newTheme->lightbox->commButtBorderColor = $theme->commButtBorderColor;
                $newTheme->lightbox->commClButtSize = $theme->commClButtSize;
                $newTheme->lightbox->commClButtBoxshadowFstVal = $theme->commClButtBoxshadowFstVal;
                $newTheme->lightbox->commClButtBoxshadowSecVal = $theme->commClButtBoxshadowSecVal;
                $newTheme->lightbox->commClButtBoxshadowThdVal = $theme->commClButtBoxshadowThdVal;
                $newTheme->lightbox->commClButtBoxshadowColor = $theme->commClButtBoxshadowColor;
                $newTheme->lightbox->commClButtBgColor = $theme->commClButtBgColor;
                $newTheme->lightbox->commClButtBorderRadius = $theme->commClButtBorderRadius;
                $newTheme->lightbox->commClButtBorderWidth = $theme->commClButtBorderWidth;
                $newTheme->lightbox->commClButtBorderStyle = $theme->commClButtBorderStyle;
                $newTheme->lightbox->commClButtBorderColor = $theme->commClButtBorderColor;
                $newTheme->lightbox->commClButtMargin = $theme->commClButtMargin;
                $newTheme->lightbox->commCpButtSize = $theme->commCpButtSize;
                $newTheme->lightbox->commCpButtBoxshadowFstVal = $theme->commCpButtBoxshadowFstVal;
                $newTheme->lightbox->commCpButtBoxshadowSecVal = $theme->commCpButtBoxshadowSecVal;
                $newTheme->lightbox->commCpButtBoxshadowThdVal = $theme->commCpButtBoxshadowThdVal;
                $newTheme->lightbox->commCpButtBoxshadowColor = $theme->commCpButtBoxshadowColor;
                $newTheme->lightbox->commCpButtBgColor = $theme->commCpButtBgColor;
                $newTheme->lightbox->commCpButtBorderRadius = $theme->commCpButtBorderRadius;
                $newTheme->lightbox->commCpButtBorderWidth = $theme->commCpButtBorderWidth;
                $newTheme->lightbox->commCpButtBorderStyle = $theme->commCpButtBorderStyle;
                $newTheme->lightbox->commCpButtBorderColor = $theme->commCpButtBorderColor;
                $newTheme->lightbox->commAFontSize = $theme->commAFontSize;
                $newTheme->lightbox->commAFontColor = $theme->commAFontColor;
                $newTheme->lightbox->commAFontFamily = $theme->commAFontFamily;
                $newTheme->lightbox->commAFontWeight = $theme->commAFontWeight;
                $newTheme->lightbox->commAFontStyle = $theme->commAFontStyle;
                $newTheme->lightbox->commTFontSize = $theme->commTFontSize;
                $newTheme->lightbox->commTFontColor = $theme->commTFontColor;
                $newTheme->lightbox->commTFontFamily = $theme->commTFontFamily;
                $newTheme->lightbox->commTFontWeight = $theme->commTFontWeight;
                $newTheme->lightbox->commTFontStyle = $theme->commTFontStyle;
                $newTheme->lightbox->commDFontSize = $theme->commDFontSize;
                $newTheme->lightbox->commDFontColor = $theme->commDFontColor;
                $newTheme->lightbox->commDFontFamily = $theme->commDFontFamily;
                $newTheme->lightbox->commDFontWeight = $theme->commDFontWeight;
                $newTheme->lightbox->commDFontStyle = $theme->commDFontStyle;

                array_push($newThemeScheme, $newTheme);
            }
            $deleteColumns = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_themes` 
				DROP `thumbnailmargin`, DROP `thumbnailBorderWidth`, DROP `thumbnailBorderStyle`, DROP `thumbnailBorderColor`, DROP `thumbnailHoverEffect`, DROP `thumbnailBorderRadius`, DROP `thumbnailMaskColor`, DROP `thumbnailpadding`, DROP `thumbnailTpadding`, DROP `thumbnailTBgcolor`, DROP `thumbnailTFSize`, DROP `thumbnailTcolor`, DROP `thumbnailTFFamily`, DROP `thumbnailTFWeight`, DROP `thumbnailTFstyle`, DROP `thumbnailTEffect`, DROP `thumbnailTpos`, DROP `thumbnailBoxshadowFstVal`, DROP `thumbnailBoxshadowSecVal`, DROP `thumbnailBoxshadowThdVal`, DROP `thumbnailBoxshadowColor`, DROP `thumbnailBgColor`, DROP `fmBgColor`, DROP `fmMargin`, DROP `fmHoverEffect`, DROP `fmThumbBorderWidth`, DROP `fmThumbBorderStyle`, DROP `fmThumbBorderColor`, DROP `fmThumbMargin`, DROP `fmThumbPadding`, DROP `fmThumbBoxshadowFstVal`, DROP `fmThumbBoxshadowSecVal`, DROP `fmThumbBoxshadowThdVal`, DROP `fmThumbBoxshadowColor`, DROP `fmThumbBgColor`, DROP `fmNavButtons`, DROP `fmNavWidth`, DROP `fmNavBgColor`, DROP `fmNavBoxshadowFstVal`, DROP `fmNavBoxshadowSecVal`, DROP `fmNavBoxshadowThdVal`, DROP `fmNavBoxshadowColor`, DROP `fmNavBorderWidth`, DROP `fmNavBorderStyle`, DROP `fmNavBorderColor`, DROP `fmTpadding`, DROP `fmTBgcolor`, DROP `fmTFSize`, DROP `fmTcolor`, DROP `fmTFFamily`, DROP `fmTFWeight`, DROP `fmTFstyle`, DROP `fmThumbTeffect`, DROP `fmTpos`, DROP `masonrymargin`, DROP `masonryPadding`, DROP `masonryBorderWidth`, DROP `masonryBorderStyle`, DROP `masonryBorderColor`, DROP `masonryHoverEffect`, DROP `masonryBorderRadius`, DROP `masonryBoxshadowFstVal`, DROP `masonryBoxshadowSecVal`, DROP `masonryBoxshadowThdVal`, DROP `masonryBoxshadowColor`, DROP `masonryBgColor`, DROP `masonryTpadding`, DROP `masonryTBgcolor`, DROP `masonryTFSize`, DROP `masonryTcolor`, DROP `masonryTFFamily`, DROP `masonryTFWeight`, DROP `masonryTFstyle`, DROP `masonryTEffect`, DROP `masonryTpos`, DROP `mosaicPadding`, DROP `mosaicBorderWidth`, DROP `mosaicBorderStyle`, DROP `mosaicBorderColor`, DROP `mosaicHoverEffect`, DROP `mosaicBorderRadius`, DROP `mosaicBoxshadowFstVal`, DROP `mosaicBoxshadowSecVal`, DROP `mosaicBoxshadowThdVal`, DROP `mosaicBoxshadowColor`, DROP `mosaicBgColor`, DROP `mosaicMargin`, DROP `mosaicTpadding`, DROP `mosaicTBgcolor`, DROP `mosaicTFSize`, DROP `mosaicTcolor`, DROP `mosaicTFFamily`, DROP `mosaicTFWeight`, DROP `mosaicTFstyle`, DROP `mosaicTEffect`, DROP `mosaicTpos`, DROP `pnavCMarginT`, DROP `pnavAlign`, DROP `pnavBMargin`, DROP `pnavBPadding`, DROP `pnavBBorderWidth`, DROP `pnavBBorderStyle`, DROP `pnavBBorderColor`, DROP `pnavBBoxshadowFstVal`, DROP `pnavBBoxshadowSecVal`, DROP `pnavBBoxshadowThdVal`, DROP `pnavBBoxshadowColor`, DROP `pnavBBgColor`, DROP `pnavBHBgColor`, DROP `pnavBABgColor`, DROP `pnavBBorderRadius`, DROP `pnavBFSize`, DROP `pnavBcolor`, DROP `pnavBFFamily`, DROP `pnavBFWeight`, DROP `pnavBFstyle`, DROP `backBorderStyle`, DROP `backBorderWidth`, DROP `backBorderColor`, DROP `backBoxshadowFstVal`, DROP `backBoxshadowSecVal`, DROP `backBoxshadowThdVal`, DROP `backBoxshadowColor`, DROP `backBgColor`, DROP `backHBgColor`, DROP `backBorderRadius`, DROP `backFSize`, DROP `backColor`, DROP `bgColor`, DROP `closeButtBgColor`, DROP `closeButtMargin`, DROP `closeButtSize`, DROP `closeButtBoxshadowFstVal`, DROP `closeButtBoxshadowSecVal`, DROP `closeButtBoxshadowThdVal`, DROP `closeButtBoxshadowColor`, DROP `closeButtBorderWidth`, DROP `closeButtBorderStyle`, DROP `closeButtBorderColor`, DROP `titleDescpFWith`, DROP `titleDescpWith`, DROP `titleDescpPos`, DROP `titleDescpMargin`, DROP `titleDescpPadding`, DROP `titleDescpBgColor`, DROP `titleDescpTColor`, DROP `titleDescpDColor`, DROP `titleDescpshadowFstVal`, DROP `titleDescpshadowSecVal`, DROP `titleDescpshadowThdVal`, DROP `titleDescpshadowColor`, DROP `titleDescpTffamily`, DROP `titleDescpTfsize`, DROP `titleDescpDfsize`, DROP `titleDescpTfweight`, DROP `titleDescpDfweight`, DROP `titleDescpBrad`, DROP `imgcoPos`, DROP `imgcoMargin`, DROP `imgcoPadding`, DROP `imgcoBgColor`, DROP `imgcoColor`, DROP `imgcoshadowFstVal`, DROP `imgcoshadowSecVal`, DROP `imgcoshadowThdVal`, DROP `imgcoshadowColor`, DROP `imgcoBrad`, DROP `imgcoffamily`, DROP `imgcofsize`, DROP `imgcofweight`, DROP `navButtons`, DROP `navButtBgColor`, DROP `navButtBoxshadowFstVal`, DROP `navButtBoxshadowSecVal`, DROP `navButtBoxshadowThdVal`, DROP `navButtBoxshadowColor`, DROP `navButtBorderWidth`, DROP `navButtBorderStyle`, DROP `navButtBorderColor`, DROP `navButtBorderRadius`, DROP `navButtSize`, DROP `navButtMargin`, DROP `navButtHoverEffect`, DROP `navButtShButts`, DROP `filmstripSize`, DROP `filmstripBgColor`, DROP `filmstripMargin`, DROP `filmstripPos`, DROP `filmThumbWidth`, DROP `filmThumbBorderWidth`, DROP `filmThumbBorderStyle`, DROP `filmThumbBorderColor`, DROP `filmThumbMargin`, DROP `filmThumbPadding`, DROP `filmThumbBoxshadowFstVal`, DROP `filmThumbBoxshadowSecVal`, DROP `filmThumbBoxshadowThdVal`, DROP `filmThumbBoxshadowColor`, DROP `filmThumbBgColor`, DROP `filmThumbSelEffect`, DROP `filmNavButtons`, DROP `filmNavWidth`, DROP `filmNavBgColor`, DROP `filmNavBoxshadowFstVal`, DROP `filmNavBoxshadowSecVal`, DROP `filmNavBoxshadowThdVal`, DROP `filmNavBoxshadowColor`, DROP `filmNavBorderWidth`, DROP `filmNavBorderStyle`, DROP `filmNavBorderColor`, DROP `contButtContBgcolor`, DROP `contButtContBoxshadowFstVal`, DROP `contButtContBoxshadowSecVal`, DROP `contButtContBoxshadowThdVal`, DROP `contButtContBoxshadowColor`, DROP `contButtons`, DROP `contButtBgColor`, DROP `contButtSize`, DROP `contButtBoxshadowFstVal`, DROP `contButtBoxshadowSecVal`, DROP `contButtBoxshadowThdVal`, DROP `contButtBoxshadowColor`, DROP `contButtBorderWidth`, DROP `contButtBorderStyle`, DROP `contButtBorderColor`, DROP `contButtcontMargin`, DROP `contButtMargin`, DROP `contButtclWidth`, DROP `contButtclHeight`, DROP `contButtContBorderWidth`, DROP `contButtContBorderStyle`, DROP `contButtContBorderColor`, DROP `contButtOnhover`, DROP `commContBgcolor`, DROP `commContMargin`, DROP `commContMarginH`, DROP `commFontSize`, DROP `commFontColor`, DROP `commFontFamily`, DROP `commFontWeight`, DROP `commFontStyle`, DROP `commButtBgcolor`, DROP `commButtHBgcolor`, DROP `commButtBoxshadowFstVal`, DROP `commButtBoxshadowSecVal`, DROP `commButtBoxshadowThdVal`, DROP `commButtBoxshadowColor`, DROP `commButtSize`, DROP `commInpFSize`, DROP `commInpColor`, DROP `commInpFFamily`, DROP `commInpFWeight`, DROP `commInpFFstyle`, DROP `commInpBoxshadowFstVal`, DROP `commInpBoxshadowSecVal`, DROP `commInpBoxshadowThdVal`, DROP `commInpBoxshadowColor`, DROP `commInpBorderWidth`, DROP `commInpBorderStyle`, DROP `commInpBorderColor`, DROP `commInpBgColor`, DROP `commInpBorderRadius`, DROP `commInpAcBorderColor`, DROP `commInpAcBoxshadowFstVal`, DROP `commInpAcBoxshadowSecVal`, DROP `commInpAcBoxshadowThdVal`, DROP `commInpAcBoxshadowColor`, DROP `commButtColor`, DROP `commButtBorderRadius`, DROP `commButtBorderWidth`, DROP `commButtBorderStyle`, DROP `commButtBorderColor`, DROP `commClButtSize`, DROP `commClButtBoxshadowFstVal`, DROP `commClButtBoxshadowSecVal`, DROP `commClButtBoxshadowThdVal`, DROP `commClButtBoxshadowColor`, DROP `commClButtBgColor`, DROP `commClButtBorderRadius`, DROP `commClButtBorderWidth`, DROP `commClButtBorderStyle`, DROP `commClButtBorderColor`, DROP `commClButtMargin`, DROP `commCpButtSize`, DROP `commCpButtBoxshadowFstVal`, DROP `commCpButtBoxshadowSecVal`, DROP `commCpButtBoxshadowThdVal`, DROP `commCpButtBoxshadowColor`, DROP `commCpButtBgColor`, DROP `commCpButtBorderRadius`, DROP `commCpButtBorderWidth`, DROP `commCpButtBorderStyle`, DROP `commCpButtBorderColor`, DROP `commAFontSize`, DROP `commAFontColor`, DROP `commAFontFamily`, DROP `commAFontWeight`, DROP `commAFontStyle`, DROP `commTFontSize`, DROP `commTFontColor`, DROP `commTFontFamily`, DROP `commTFontWeight`, DROP `commTFontStyle`, DROP `commDFontSize`, DROP `commDFontColor`, DROP `commDFontFamily`, DROP `commDFontWeight`, DROP `commDFontStyle`;");
            if ($deleteColumns) {
                $addColumns = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_themes` 
                	ADD `thumbnail` VARCHAR(2048) NOT NULL AFTER `lastmodified`,
                	ADD `film` VARCHAR(2048) NOT NULL AFTER `thumbnail`,
                	ADD `masonry` VARCHAR(2048) NOT NULL AFTER `film`,
                	ADD `mosaic` VARCHAR(2048) NOT NULL AFTER `masonry`,
                	ADD `navigation` VARCHAR(2048) NOT NULL AFTER `mosaic`,
                	ADD `lightbox` VARCHAR(10240) NOT NULL AFTER `navigation`"
                );
                // Save theme to file
//				require_once(GRS_PLG_DIR . '/ajax/GRSGetThumbnailCss.php');
//				require_once(GRS_PLG_DIR . '/ajax/GRSGetMasonryCss.php');
//				require_once(GRS_PLG_DIR . '/ajax/GRSGetMosaicCss.php');
//				require_once(GRS_PLG_DIR . '/ajax/GRSGetFilmCss.php');
//				require_once(GRS_PLG_DIR . '/ajax/GRSGetLightboxCss.php');
//				require_once(GRS_PLG_DIR . '/ajax/GRSGetNavigationCss.php');
//				$thumbnailCssObj = new GRSGetThumbnailCss();
//				$filmCssObj = new GRSGetFilmCss();
//				$masonryCssObj = new GRSGetMasonryCss();
//				$mosaicCssObj = new GRSGetMosaicCss();
//				$lightboxCssObj = new GRSGetLightboxCss();
//				$navigationCssObj = new GRSGetNavigationCss();
                foreach ($newThemeScheme as $obj) {
                    $save = $wpdb->update($wpdb->prefix . 'limb_gallery_themes',
                        array(
                            'thumbnail' => json_encode($obj->thumbnail),
                            'film' => json_encode($obj->film),
                            'masonry' => json_encode($obj->masonry),
                            'mosaic' => json_encode($obj->mosaic),
                            'navigation' => json_encode($obj->navigation),
                            'lightbox' => json_encode($obj->lightbox),
                        ),
                        array(
                            'id' => $obj->id
                        )
                    );
//					$thumbnailCss = $thumbnailCssObj->get_($obj->id, $obj->thumbnail);
//					$filmCss = $filmCssObj->get_($obj->id, $obj->film);
//					$masonryCss = $masonryCssObj->get_($obj->id, $obj->masonry);
//					$mosaicCss = $mosaicCssObj->get_($obj->id, $obj->mosaic);
//					$lightboxCss = $lightboxCssObj->get_($obj->id, $obj->lightbox);
//					$navigationCss = $navigationCssObj->get_($obj->id, $obj->navigation);
//
//					$grsTemplate = fopen(GRS_PLG_DIR . '/css/grsTemplate'.$obj->id.'.css', "w");
//					$css = $thumbnailCss . $filmCss . $masonryCss . $mosaicCss . $lightboxCss . $navigationCss;
//					// Minimize process
//					$css = trim(preg_replace('/\s\s+/', ' ', $css));
//					$bytes = fwrite($grsTemplate, $css);
//					fclose($grsTemplate);
                }
                $ok12 = $bytes && $save && $addColumns;
            }
        }

        return $ok11 && $ok12;
    }

    // Alter for 1.1.1
    public function alter_1_1()
    {
        /*
		  * Alter table -> add Order column
		  * Loop through galleries, update order value for each gallery start from 0
		  * :)
		*/
        global $wpdb;
        $ok10 = true;
        $alter_1_0 = "SHOW COLUMNS FROM `" . $wpdb->prefix . "limb_gallery_galleriescontent` LIKE '%link%'";
        $okFor_1_0 = $wpdb->get_row($alter_1_0);
        if (!isset($okFor_1_0->Field)) {
            $ok10 = $this->alter_1_0();
        }

        $addOrderColumn = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_galleriescontent` 
			ADD `order` bigint(20) NOT NULL DEFAULT 0 AFTER `publish`");
        $galls = "SELECT `id` FROM `" . $wpdb->prefix . "limb_gallery_galleries`";
        $gallsRes = $wpdb->get_results($galls);
        $okForOrder = false;
        if ($addOrderColumn) {
            foreach ($gallsRes as $key => $obj) {
                $wpdb->query("set @i=-1;");
                $okForOrder = $wpdb->query("UPDATE `" . $wpdb->prefix . "limb_gallery_galleriescontent` SET `order` = (@i:=@i+1) WHERE `galId`=" . $obj->id);
            }
        }

        return $ok10 && $okForOrder;
    }

    // Alter for 1.1.0
    public function alter_1_0()
    {
        global $wpdb;
        $ok9 = true;
        $alter_0_9 = "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `default` = 1";
        $okFor_0_9 = $wpdb->get_row($alter_0_9);
        if (!isset($okFor_0_9->imgcofweight)) {
            $ok9 = $this->alter_0_9();
        }
        // Add columns for galleries content
        $addColumns = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_galleriescontent` 
			ADD `link` varchar(1024) NOT NULL DEFAULT '' AFTER `path`");

        return $ok9 && $addColumns;
    }

    // Alter for 1.0.9
    public function alter_0_9()
    {
        global $wpdb;
        // Add columns for theme
        $addColumns = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_themes` 
			ADD `titleDescpFWith` tinyint(1) NOT NULL DEFAULT 0 AFTER `closeButtBorderColor`,
			ADD `titleDescpWith` int(10) NOT NULL DEFAULT 200 AFTER `titleDescpFWith`,
			ADD `titleDescpPos` varchar(16) NOT NULL DEFAULT 'top_left' AFTER `titleDescpWith`,
			ADD `titleDescpMargin` int(11) NOT NULL DEFAULT 24 AFTER `titleDescpPos`,
		    ADD `titleDescpPadding` int(11) NOT NULL DEFAULT 15 AFTER `titleDescpMargin`,
		    ADD `titleDescpBgColor` varchar(32) NOT NULL DEFAULT 'rgba(255,255,255,1)' AFTER `titleDescpPadding`,
		    ADD `titleDescpTColor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,1)' AFTER `titleDescpBgColor`,
		    ADD `titleDescpDColor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,1)' AFTER `titleDescpTColor`,
		    ADD `titleDescpshadowFstVal` int(11) NOT NULL DEFAULT 0 AFTER `titleDescpDColor`,
		    ADD `titleDescpshadowSecVal` int(11) NOT NULL DEFAULT 0 AFTER `titleDescpshadowFstVal`,
		    ADD `titleDescpshadowThdVal` int(11) NOT NULL DEFAULT 0 AFTER `titleDescpshadowSecVal`,
		    ADD `titleDescpshadowColor` varchar(32) NOT NULL DEFAULT 'rgba(255,255,255,0)' AFTER `titleDescpshadowThdVal`,
		    ADD `titleDescpTffamily` varchar(16) NOT NULL DEFAULT 'inherit' AFTER `titleDescpshadowColor`,
		    ADD `titleDescpTfsize` int(11) NOT NULL DEFAULT 12 AFTER `titleDescpTffamily`,
		    ADD `titleDescpDfsize` int(11) NOT NULL DEFAULT 11 AFTER `titleDescpTfsize`,
		    ADD `titleDescpTfweight` varchar(16) NOT NULL DEFAULT 'bold' AFTER `titleDescpDfsize`,
		    ADD `titleDescpDfweight` varchar(16) NOT NULL DEFAULT 'normal' AFTER `titleDescpTfweight`,
		    ADD `titleDescpBrad` int(11) NOT NULL DEFAULT 3 AFTER `titleDescpDfweight`,
			ADD `imgcoPos` varchar(16) NOT NULL DEFAULT 'top_right' AFTER `titleDescpDfweight`,
			ADD `imgcoMargin` int(11) NOT NULL DEFAULT 24 AFTER `imgcoPos`,
			ADD `imgcoPadding` int(11) NOT NULL DEFAULT 5 AFTER `imgcoMargin`,
			ADD `imgcoBgColor` varchar(32) NOT NULL DEFAULT 'rgba(255,255,255,1)' AFTER 
			`imgcoPadding`,
			ADD `imgcoColor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,1)' AFTER 
			`imgcoBgColor`,
			ADD `imgcoshadowFstVal` int(11) NOT NULL DEFAULT 0 AFTER `imgcoColor`,
			ADD `imgcoshadowSecVal` int(11) NOT NULL DEFAULT 0 AFTER `imgcoshadowFstVal`,
			ADD `imgcoshadowThdVal` int(11) NOT NULL DEFAULT 0 AFTER `imgcoshadowSecVal`,
			ADD `imgcoshadowColor` varchar(32) NOT NULL DEFAULT 'rgba(255,255,255,0)' AFTER 
			`imgcoshadowThdVal`,
			ADD `imgcoffamily` varchar(16) NOT NULL DEFAULT 'inherit' AFTER 
			`imgcoshadowColor`,
			ADD `imgcoBrad` int(11) NOT NULL DEFAULT 3 AFTER `imgcoffamily`,
			ADD `imgcofsize` int(11) NOT NULL DEFAULT 12 AFTER `imgcoBrad`,
			ADD `imgcofweight` varchar(16) NOT NULL DEFAULT 'bold' AFTER `imgcofsize`");

        $ok8 = true;
        $alter_0_8 = "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `default` = 1";
        $okFor_0_8 = $wpdb->get_row($alter_0_8);
        if (!isset($okFor_0_8->fmBgColor)) {
            $ok8 = $this->alter_0_8();
        }

        return $ok8 && $addColumns;
    }

    // Alter for 1.0.8
    public function alter_0_8()
    {
        // Check for last updates
        global $wpdb;
        // Add columns for theme
        $addColumns = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_themes` 
			ADD `fmBgColor` VARCHAR(32) NOT NULL DEFAULT 'rgba(255,255,255,0)' AFTER `thumbnailBgColor`,
			ADD `fmMargin` int(10) NOT NULL DEFAULT 2 AFTER `fmBgColor`,
			ADD `fmHoverEffect` varchar(16) NOT NULL DEFAULT 'flash' AFTER `fmMargin`,
			ADD `fmThumbBorderWidth` int(10) NOT NULL DEFAULT 0 AFTER `fmHoverEffect`,
		    ADD `fmThumbBorderStyle` varchar(16) NOT NULL DEFAULT 'none' AFTER `fmThumbBorderWidth`,
		    ADD `fmThumbBorderColor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,1)' AFTER `fmThumbBorderStyle`,
		    ADD `fmThumbMargin` int(10) NOT NULL DEFAULT 10 AFTER `fmThumbBorderColor`,
		    ADD `fmThumbPadding` int(11) NOT NULL DEFAULT 0 AFTER `fmThumbMargin`,
		    ADD `fmThumbBoxshadowFstVal` int(11) NOT NULL DEFAULT 0 AFTER `fmThumbPadding`,
		    ADD `fmThumbBoxshadowSecVal` int(11) NOT NULL DEFAULT 0 AFTER `fmThumbBoxshadowFstVal`,
		    ADD `fmThumbBoxshadowThdVal` int(11) NOT NULL DEFAULT 0 AFTER `fmThumbBoxshadowSecVal`,
		    ADD `fmThumbBoxshadowColor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,1)' AFTER `fmThumbBoxshadowThdVal`,
		    ADD `fmThumbBgColor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,0)' AFTER `fmThumbBoxshadowColor`,
		    ADD `fmNavButtons` varchar(16) NOT NULL DEFAULT 'circle_simple' AFTER `fmThumbBgColor`,
		    ADD `fmNavWidth` int(10) NOT NULL DEFAULT 40 AFTER `fmNavButtons`,
		    ADD `fmNavBgColor` varchar(32) NOT NULL DEFAULT 'rgba(255,255,255,0.32)' AFTER `fmNavWidth`,
		    ADD `fmNavBoxshadowFstVal` int(10) NOT NULL DEFAULT 0 AFTER `fmNavBgColor`,
		    ADD `fmNavBoxshadowSecVal` int(10) NOT NULL DEFAULT 0 AFTER `fmNavBoxshadowFstVal`,
		    ADD `fmNavBoxshadowThdVal` int(10) NOT NULL DEFAULT 0 AFTER `fmNavBoxshadowSecVal`,
		    ADD `fmNavBoxshadowColor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,1)' AFTER `fmNavBoxshadowThdVal`,
		    ADD `fmNavBorderWidth` int(10) NOT NULL DEFAULT 1 AFTER `fmNavBoxshadowColor`,
		    ADD `fmNavBorderStyle` varchar(16) NOT NULL DEFAULT 'solid' AFTER `fmNavBorderWidth`,
		    ADD `fmNavBorderColor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,0.42)' AFTER `fmNavBorderStyle`,
 			ADD `fmTpadding` int(11) NOT NULL DEFAULT 10 AFTER `fmNavBorderColor`,
		    ADD `fmTBgcolor` varchar(32) NOT NULL DEFAULT 'rgba(255,255,255,0.5)' AFTER `fmTpadding`,
		    ADD `fmTFSize` int(11) NOT NULL DEFAULT 15 AFTER `fmTBgcolor`,
		    ADD `fmTcolor` varchar(32) NOT NULL DEFAULT 'rgba(0,0,0,1)' AFTER `fmTFSize`,
		    ADD `fmTFFamily` varchar(16) NOT NULL DEFAULT 'inherit' AFTER `fmTcolor`,
		    ADD `fmTFWeight` varchar(16) NOT NULL DEFAULT 'bold' AFTER `fmTFFamily`,
		    ADD `fmTFstyle` varchar(16) NOT NULL DEFAULT 'normal' AFTER `fmTFWeight`,
		    ADD `fmThumbTeffect` varchar(16) NOT NULL DEFAULT 'grsFadeIn' AFTER `fmTFstyle`,
		    ADD `fmTpos` varchar(8) NOT NULL DEFAULT 'bottom' AFTER `fmThumbTeffect`");

        return $this->alter_0_7() && $addColumns;
    }

    // Alter for 1.0.7
    public function alter_0_7()
    {
        // Check for last updates
        global $wpdb;
        $ok6 = true;

        $alter_0_6 = "SELECT `name` FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `name` = 'Black'";
        $okFor_0_6 = $wpdb->get_var($alter_0_6);
        if ($okFor_0_6 == null) {
            $ok6 = $this->alter_0_6();
        } else {
            $save = $wpdb->update($wpdb->prefix . 'limb_gallery_themes',
                array(
                    'masonryTcolor' => 'rgba(255,255,255,1)',
                ),
                array(
                    'name' => 'Black'
                )
            );
        }

        return $ok6;
    }

    // Alter for 1.0.6
    public function alter_0_6()
    {
        global $wpdb;
        $date = date_create(null);
        date_timezone_set($date, timezone_open('UTC'));
        $createDate = date_format($date, "Y-m-d H:i:s");
        $saveTheme = $wpdb->insert($wpdb->prefix . 'limb_gallery_themes',
            array(
                'default' => 0,
                'name' => 'Black',
                'createDate' => $createDate,
                'lastmodified' => $createDate,/*Thumbnail*/
                'thumbnailmargin' => 5,
                'thumbnailpadding' => 0,
                'thumbnailBorderWidth' => 2,
                'thumbnailBorderStyle' => 'none',
                'thumbnailBorderColor' => 'rgba(142,155,151,1)',
                'thumbnailHoverEffect' => 'shine',
                'thumbnailBorderRadius' => 0,
                'thumbnailMaskColor' => 'rgba(0,0,0,0.75)',
                'thumbnailTpadding' => 10,
                'thumbnailTBgcolor' => 'rgba(0,0,0,0.75)',
                'thumbnailTFSize' => 14,
                'thumbnailTcolor' => 'rgba(255,255,255,1)',
                'thumbnailTFFamily' => 'inherit',
                'thumbnailTFWeight' => 'bold',
                'thumbnailTFstyle' => 'inherit',
                'thumbnailTEffect' => 'mask',
                'thumbnailTpos' => 'middle',
                'thumbnailBoxshadowFstVal' => 0,
                'thumbnailBoxshadowSecVal' => 0,
                'thumbnailBoxshadowThdVal' => 0,
                'thumbnailBoxshadowColor' => 'rgba(0,0,0,1)',
                'thumbnailBgColor' => 'rgba(255,255,255,0)',/*Masonry*/
                'masonrymargin' => 5,
                'masonryPadding' => 0,
                'masonryBorderWidth' => 2,
                'masonryBorderStyle' => 'none',
                'masonryBorderColor' => 'rgba(0,0,0,1)',
                'masonryHoverEffect' => 'shine',
                'masonryBorderRadius' => 0,
                'masonryBoxshadowFstVal' => 0,
                'masonryBoxshadowSecVal' => 0,
                'masonryBoxshadowThdVal' => 0,
                'masonryBoxshadowColor' => 'rgba(255,255,255,1)',
                'masonryBgColor' => 'rgba(255,255,255,0)',
                'masonryTpadding' => 10,
                'masonryTBgcolor' => 'rgba(0,0,0,0.75)',
                'masonryTFSize' => 14,
                'masonryTcolor' => 'rgba(255,255,255,1)',
                'masonryTFFamily' => 'inherit',
                'masonryTFWeight' => 'bold',
                'masonryTFstyle' => 'inherit',
                'masonryTEffect' => 'mask',
                'masonryTpos' => 'middle',/*Mosaic*/
                'mosaicPadding' => 0,
                'mosaicBorderWidth' => 2,
                'mosaicBorderStyle' => 'none',
                'mosaicBorderColor' => 'rgba(0,0,0,1)',
                'mosaicHoverEffect' => 'shine',
                'mosaicBorderRadius' => 0,
                'mosaicBoxshadowFstVal' => 0,
                'mosaicBoxshadowSecVal' => 0,
                'mosaicBoxshadowThdVal' => 0,
                'mosaicBoxshadowColor' => 'rgba(0,0,0,1)',
                'mosaicBgColor' => 'rgba(255,255,255,0)',
                'mosaicMargin' => 5,
                'mosaicTpadding' => 10,
                'mosaicTBgcolor' => 'rgba(0,0,0,0.75)',
                'mosaicTFSize' => 14,
                'mosaicTcolor' => 'rgba(255,255,255,1)',
                'mosaicTFFamily' => 'inherit',
                'mosaicTFWeight' => 'bold',
                'mosaicTFstyle' => 'inherit',
                'mosaicTEffect' => 'mask',
                'mosaicTpos' => 'middle',/*Navigation*/
                'pnavCMarginT' => 30,
                'pnavAlign' => 'center',
                'pnavBMargin' => 5,
                'pnavBPadding' => 12,
                'pnavBBorderWidth' => 1,
                'pnavBBorderStyle' => 'solid',
                'pnavBBorderColor' => 'rgba(0,0,0,1)',
                'pnavBBoxshadowFstVal' => 0,
                'pnavBBoxshadowSecVal' => 0,
                'pnavBBoxshadowThdVal' => 0,
                'pnavBBoxshadowColor' => 'rgba(255,255,255,1)',
                'pnavBBgColor' => 'rgba(255,255,255,0.73)',
                'pnavBHBgColor' => 'rgba(56,56,56,1)',
                'pnavBABgColor' => 'rgba(56,56,56,1)',
                'pnavBBorderRadius' => 2,
                'pnavBFSize' => 13,
                'pnavBcolor' => 'rgba(0,0,0,1)',
                'pnavBFFamily' => 'inherit',
                'pnavBFWeight' => '400',
                'pnavBFstyle' => 'inherit',
                'backBorderStyle' => 'solid',
                'backBorderWidth' => 1,
                'backBorderColor' => 'rgba(0,0,0,1)',
                'backBoxshadowFstVal' => 0,
                'backBoxshadowSecVal' => 0,
                'backBoxshadowThdVal' => 0,
                'backBoxshadowColor' => 'rgba(255,255,255,0)',
                'backBgColor' => 'rgba(255,255,255,0.73)',
                'backHBgColor' => 'rgba(56,56,56,1)',
                'backBorderRadius' => 2,
                'backFSize' => 13,
                'backColor' => 'rgba(0,0,0,1)',/*Lightbox*/
                'bgColor' => 'rgba(0,0,0,1)',
                'closeButtBgColor' => 'rgba(255,255,255,0)',
                'closeButtMargin' => -10,
                'closeButtSize' => 35,
                'closeButtBoxshadowFstVal' => 0,
                'closeButtBoxshadowSecVal' => 0,
                'closeButtBoxshadowThdVal' => 0,
                'closeButtBoxshadowColor' => 'rgba(122,122,122,0.87)',
                'closeButtBorderWidth' => 0,
                'closeButtBorderStyle' => 'none',
                'closeButtBorderColor' => 'rgba(255,255,255,1)',
                'navButtons' => 'circle_simple',
                'navButtBgColor' => 'rgba(255,255,255,0)',
                'navButtBoxshadowFstVal' => 0,
                'navButtBoxshadowSecVal' => 0,
                'navButtBoxshadowThdVal' => 0,
                'navButtBoxshadowColor' => 'rgba(99,99,99,0)',
                'navButtBorderWidth' => 1,
                'navButtBorderStyle' => 'none',
                'navButtBorderColor' => 'rgba(255,255,255,1)',
                'navButtBorderRadius' => 0,
                'navButtSize' => 60,
                'navButtMargin' => 30,
                'navButtHoverEffect' => 'slideIn',
                'navButtShButts' => 'onhover',
                'filmstripSize' => 50,
                'filmstripBgColor' => 'rgba(0,0,0,1)',
                'filmstripMargin' => 7,
                'filmstripPos' => 'bottom',
                'filmThumbWidth' => 50,
                'filmThumbBorderWidth' => 0,
                'filmThumbBorderStyle' => 'none',
                'filmThumbBorderColor' => 'rgba(255,255,255,1)',
                'filmThumbMargin' => 7,
                'filmThumbPadding' => 0,
                'filmThumbBoxshadowFstVal' => 0,
                'filmThumbBoxshadowSecVal' => 0,
                'filmThumbBoxshadowThdVal' => 0,
                'filmThumbBoxshadowColor' => 'rgba(255,255,255,1)',
                'filmThumbBgColor' => 'rgba(255,255,255,1)',
                'filmThumbSelEffect' => 'fadeIn',
                'filmNavButtons' => 'circle_simple',
                'filmNavWidth' => 30,
                'filmNavBgColor' => 'rgba(0,0,0,0.72)',
                'filmNavBoxshadowFstVal' => 0,
                'filmNavBoxshadowSecVal' => 0,
                'filmNavBoxshadowThdVal' => 2,
                'filmNavBoxshadowColor' => 'rgba(115,115,115,1)',
                'filmNavBorderWidth' => 0,
                'filmNavBorderStyle' => 'none',
                'filmNavBorderColor' => 'rgba(0,0,0,0.52)',
                'contButtContBgcolor' => 'rgba(0,0,0,0.72)',
                'contButtContBoxshadowFstVal' => 0,
                'contButtContBoxshadowSecVal' => 0,
                'contButtContBoxshadowThdVal' => 0,
                'contButtContBoxshadowColor' => 'rgba(255,255,255,0)',
                'contButtons' => 'elegant_black',
                'contButtBgColor' => 'rgba(255,255,255,0)',
                'contButtSize' => 23,
                'contButtBoxshadowFstVal' => 0,
                'contButtBoxshadowSecVal' => 0,
                'contButtBoxshadowThdVal' => 0,
                'contButtBoxshadowColor' => 'rgba(84,84,84,0.5)',
                'contButtBorderWidth' => 2,
                'contButtBorderStyle' => 'none',
                'contButtBorderColor' => 'rgba(255,255,255,0)',
                'contButtcontMargin' => 5,
                'contButtMargin' => 10,
                'contButtclWidth' => 80,
                'contButtclHeight' => 13,
                'contButtContBorderWidth' => 2,
                'contButtContBorderStyle' => 'none',
                'contButtContBorderColor' => 'rgba(255,0,153,1)',
                'contButtOnhover' => 1,
                'commContBgcolor' => 'rgba(0,0,0,1)',
                'commContMargin' => 35,
                'commContMarginH' => 10,
                'commFontSize' => 13,
                'commFontColor' => 'rgba(44,74,82,1)',
                'commFontFamily' => 'inherit',
                'commFontWeight' => 'normal',
                'commFontStyle' => 'inherit',
                'commButtBgcolor' => 'rgba(0,0,0,1)',
                'commButtHBgcolor' => 'rgba(0,0,0,1)',
                'commButtBoxshadowFstVal' => 0,
                'commButtBoxshadowSecVal' => 0,
                'commButtBoxshadowThdVal' => 0,
                'commButtBoxshadowColor' => 'rgba(255,255,255,1)',
                'commButtSize' => 15,
                'commInpFSize' => 12,
                'commInpColor' => 'rgba(255,255,255,0.67)',
                'commInpFFamily' => 'inherit',
                'commInpFWeight' => 'inherit',
                'commInpFFstyle' => 'inherit',
                'commInpBoxshadowFstVal' => 0,
                'commInpBoxshadowSecVal' => 0,
                'commInpBoxshadowThdVal' => 0,
                'commInpBoxshadowColor' => 'rgba(209,209,209,1)',
                'commInpBorderWidth' => 1,
                'commInpBorderStyle' => 'solid',
                'commInpBorderColor' => 'rgba(99,99,99,1)',
                'commInpBgColor' => 'rgba(0,0,0,1)',
                'commInpBorderRadius' => 2,
                'commInpAcBorderColor' => 'rgba(255,255,255,0.87)',
                'commInpAcBoxshadowFstVal' => 0,
                'commInpAcBoxshadowSecVal' => 0,
                'commInpAcBoxshadowThdVal' => 0,
                'commInpAcBoxshadowColor' => 'rgba(255,255,255,0)',
                'commButtColor' => 'rgba(255,255,255,0.67)',
                'commButtBorderRadius' => 3,
                'commButtBorderWidth' => 1,
                'commButtBorderStyle' => 'solid',
                'commButtBorderColor' => 'rgba(161,161,161,1)',
                'commClButtSize' => 40,
                'commClButtBoxshadowFstVal' => 0,
                'commClButtBoxshadowSecVal' => 0,
                'commClButtBoxshadowThdVal' => 0,
                'commClButtBoxshadowColor' => 'rgba(97,97,97,1)',
                'commClButtBgColor' => 'rgba(255,255,255,0)',
                'commClButtBorderRadius' => 3,
                'commClButtBorderWidth' => 1,
                'commClButtBorderStyle' => 'none',
                'commClButtBorderColor' => 'rgba(255,0,0,1)',
                'commClButtMargin' => 0,
                'commCpButtSize' => 40,
                'commCpButtBoxshadowFstVal' => 0,
                'commCpButtBoxshadowSecVal' => 0,
                'commCpButtBoxshadowThdVal' => 0,
                'commCpButtBoxshadowColor' => 'rgba(99,99,99,1)',
                'commCpButtBgColor' => 'rgba(255,255,255,0)',
                'commCpButtBorderRadius' => 2,
                'commCpButtBorderWidth' => 1,
                'commCpButtBorderStyle' => 'none',
                'commCpButtBorderColor' => 'rgba(255,0,0,1)',
                'commAFontSize' => 13,
                'commAFontColor' => 'rgba(255,255,255,1)',
                'commAFontFamily' => 'inherit',
                'commAFontWeight' => 'normal',
                'commAFontStyle' => 'italic',
                'commTFontSize' => 12,
                'commTFontColor' => 'rgba(255,255,255,1)',
                'commTFontFamily' => 'inherit',
                'commTFontWeight' => 'normal',
                'commTFontStyle' => 'inherit',
                'commDFontSize' => 11,
                'commDFontColor' => 'rgba(255,255,255,0.8)',
                'commDFontFamily' => 'inherit',
                'commDFontWeight' => 'normal',
                'commDFontStyle' => 'italic',
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',/*Thumbnail*/
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',/*Masonry*/
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',/*Mosaic*/
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',/*Navigation*/
                '%d',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',/*Lightbox*/
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );

        return $saveTheme && $this->alter_0_5();
    }

    // Alter for 1.0.5
    public function alter_0_5()
    {
        return $this->alter_0_4();
    }

    // Alter for 1.0.4
    public function alter_0_4()
    {
        // Check for last updates
        global $wpdb;
        $ok2 = true;
        $ok3 = true;
        $alter_0_2 = "SHOW COLUMNS FROM `" . $wpdb->prefix . "limb_gallery_galleriescontent` WHERE field = 'embed'";
        $okFor_0_2 = $wpdb->get_row($alter_0_2);

        $alter_0_3 = "SELECT `name` FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `name` = 'Tender black'";
        $okFor_0_3 = $wpdb->get_var($alter_0_3);
        if ($okFor_0_2 == null) {
            $ok2 = $this->alter_0_2();
        }
        if ($okFor_0_3 == null) {
            $ok3 = $this->alter_0_3();
        }

        return $ok2 && $ok3;
    }

    public function alter_0_3()
    {
        global $wpdb;
        $date = date_create(null);
        date_timezone_set($date, timezone_open('UTC'));
        $createDate = date_format($date, "Y-m-d H:i:s");
        $saveTheme = $wpdb->insert($wpdb->prefix . 'limb_gallery_themes',
            array(
                'default' => 0,
                'name' => 'Tender black',
                'createDate' => $createDate,
                'lastmodified' => $createDate,/*Thumbnail*/
                'thumbnailmargin' => 5,
                'thumbnailpadding' => 0,
                'thumbnailBorderWidth' => 2,
                'thumbnailBorderStyle' => 'none',
                'thumbnailBorderColor' => 'rgba(142,155,151,1)',
                'thumbnailHoverEffect' => 'flash',
                'thumbnailBorderRadius' => 0,
                'thumbnailMaskColor' => 'rgba(255,255,255,0.75)',
                'thumbnailTpadding' => 10,
                'thumbnailTBgcolor' => 'rgba(255,255,255,0.75)',
                'thumbnailTFSize' => 13,
                'thumbnailTcolor' => 'rgba(0,0,0,1)',
                'thumbnailTFFamily' => 'inherit',
                'thumbnailTFWeight' => 'normal',
                'thumbnailTFstyle' => 'inherit',
                'thumbnailTEffect' => 'grsFadeIn',
                'thumbnailTpos' => 'bottom',
                'thumbnailBoxshadowFstVal' => 0,
                'thumbnailBoxshadowSecVal' => 0,
                'thumbnailBoxshadowThdVal' => 0,
                'thumbnailBoxshadowColor' => 'rgba(0,0,0,1)',
                'thumbnailBgColor' => 'rgba(255,255,255,0)',/*Masonry*/
                'masonrymargin' => 5,
                'masonryPadding' => 0,
                'masonryBorderWidth' => 2,
                'masonryBorderStyle' => 'none',
                'masonryBorderColor' => 'rgba(0,0,0,1)',
                'masonryHoverEffect' => 'flash',
                'masonryBorderRadius' => 0,
                'masonryBoxshadowFstVal' => 0,
                'masonryBoxshadowSecVal' => 0,
                'masonryBoxshadowThdVal' => 0,
                'masonryBoxshadowColor' => 'rgba(255,255,255,1)',
                'masonryBgColor' => 'rgba(255,255,255,0)',
                'masonryTpadding' => 10,
                'masonryTBgcolor' => 'rgba(255,255,255,0.75)',
                'masonryTFSize' => 13,
                'masonryTcolor' => 'rgba(0,0,0,1)',
                'masonryTFFamily' => 'inherit',
                'masonryTFWeight' => 'normal',
                'masonryTFstyle' => 'inherit',
                'masonryTEffect' => 'grsFadeIn',
                'masonryTpos' => 'middle',/*Mosaic*/
                'mosaicPadding' => 0,
                'mosaicBorderWidth' => 2,
                'mosaicBorderStyle' => 'none',
                'mosaicBorderColor' => 'rgba(0,0,0,1)',
                'mosaicHoverEffect' => 'flash',
                'mosaicBorderRadius' => 0,
                'mosaicBoxshadowFstVal' => 0,
                'mosaicBoxshadowSecVal' => 0,
                'mosaicBoxshadowThdVal' => 0,
                'mosaicBoxshadowColor' => 'rgba(0,0,0,1)',
                'mosaicBgColor' => 'rgba(255,255,255,0)',
                'mosaicMargin' => 5,
                'mosaicTpadding' => 10,
                'mosaicTBgcolor' => 'rgba(255,255,255,0.75)',
                'mosaicTFSize' => 13,
                'mosaicTcolor' => 'rgba(0,0,0,1)',
                'mosaicTFFamily' => 'inherit',
                'mosaicTFWeight' => 'normal',
                'mosaicTFstyle' => 'inherit',
                'mosaicTEffect' => 'grsFlipInX',
                'mosaicTpos' => 'bottom',/*Navigation*/
                'pnavCMarginT' => 30,
                'pnavAlign' => 'center',
                'pnavBMargin' => 5,
                'pnavBPadding' => 12,
                'pnavBBorderWidth' => 1,
                'pnavBBorderStyle' => 'solid',
                'pnavBBorderColor' => 'rgba(168,168,168,0.65)',
                'pnavBBoxshadowFstVal' => 0,
                'pnavBBoxshadowSecVal' => 0,
                'pnavBBoxshadowThdVal' => 0,
                'pnavBBoxshadowColor' => 'rgba(255,255,255,1)',
                'pnavBBgColor' => 'rgba(255,255,255,0.73)',
                'pnavBHBgColor' => 'rgba(242,242,242,1)',
                'pnavBABgColor' => 'rgba(194,194,194,1)',
                'pnavBBorderRadius' => 1,
                'pnavBFSize' => 13,
                'pnavBcolor' => 'rgba(0,0,0,1)',
                'pnavBFFamily' => 'inherit',
                'pnavBFWeight' => '400',
                'pnavBFstyle' => 'inherit',
                'backBorderStyle' => 'solid',
                'backBorderWidth' => 1,
                'backBorderColor' => 'rgba(168,168,168,0.72)',
                'backBoxshadowFstVal' => 0,
                'backBoxshadowSecVal' => 0,
                'backBoxshadowThdVal' => 0,
                'backBoxshadowColor' => 'rgba(255,255,255,0)',
                'backBgColor' => 'rgba(255,255,255,0.73)',
                'backHBgColor' => 'rgba(242,242,242,1)',
                'backBorderRadius' => 1,
                'backFSize' => 13,
                'backColor' => 'rgba(0,0,0,1)',/*Lightbox*/
                'bgColor' => 'rgba(255,255,255,1)',
                'closeButtBgColor' => 'rgba(255,255,255,0)',
                'closeButtMargin' => -10,
                'closeButtSize' => 35,
                'closeButtBoxshadowFstVal' => 0,
                'closeButtBoxshadowSecVal' => 0,
                'closeButtBoxshadowThdVal' => 0,
                'closeButtBoxshadowColor' => 'rgba(122,122,122,0.87)',
                'closeButtBorderWidth' => 0,
                'closeButtBorderStyle' => 'none',
                'closeButtBorderColor' => 'rgba(255,255,255,1)',
                'navButtons' => 'elegant_simple_1',
                'navButtBgColor' => 'rgba(158,0,255,0)',
                'navButtBoxshadowFstVal' => 0,
                'navButtBoxshadowSecVal' => 0,
                'navButtBoxshadowThdVal' => 0,
                'navButtBoxshadowColor' => 'rgba(0,0,0,0.52)',
                'navButtBorderWidth' => 1,
                'navButtBorderStyle' => 'none',
                'navButtBorderColor' => 'rgba(255,255,255,1)',
                'navButtBorderRadius' => 0,
                'navButtSize' => 60,
                'navButtMargin' => 30,
                'navButtHoverEffect' => 'slideIn',
                'navButtShButts' => 'onhover',
                'filmstripSize' => 50,
                'filmstripBgColor' => 'rgba(255,255,255,1)',
                'filmstripMargin' => 7,
                'filmstripPos' => 'top',
                'filmThumbWidth' => 50,
                'filmThumbBorderWidth' => 0,
                'filmThumbBorderStyle' => 'none',
                'filmThumbBorderColor' => 'rgba(255,255,255,1)',
                'filmThumbMargin' => 7,
                'filmThumbPadding' => 0,
                'filmThumbBoxshadowFstVal' => 0,
                'filmThumbBoxshadowSecVal' => 0,
                'filmThumbBoxshadowThdVal' => 0,
                'filmThumbBoxshadowColor' => 'rgba(255,255,255,1)',
                'filmThumbBgColor' => 'rgba(255,255,255,1)',
                'filmThumbSelEffect' => 'fadeIn',
                'filmNavButtons' => 'fang_simple',
                'filmNavWidth' => 45,
                'filmNavBgColor' => 'rgba(255,255,255,0.72)',
                'filmNavBoxshadowFstVal' => 0,
                'filmNavBoxshadowSecVal' => 0,
                'filmNavBoxshadowThdVal' => 2,
                'filmNavBoxshadowColor' => 'rgba(115,115,115,1)',
                'filmNavBorderWidth' => 0,
                'filmNavBorderStyle' => 'none',
                'filmNavBorderColor' => 'rgba(0,0,0,0.52)',
                'contButtContBgcolor' => 'rgba(92,92,92,0.26)',
                'contButtContBoxshadowFstVal' => 0,
                'contButtContBoxshadowSecVal' => 0,
                'contButtContBoxshadowThdVal' => 0,
                'contButtContBoxshadowColor' => 'rgba(255,255,255,0)',
                'contButtons' => 'elegant_black',
                'contButtBgColor' => 'rgba(255,255,255,0)',
                'contButtSize' => 23,
                'contButtBoxshadowFstVal' => 0,
                'contButtBoxshadowSecVal' => 0,
                'contButtBoxshadowThdVal' => 0,
                'contButtBoxshadowColor' => 'rgba(84,84,84,0.5)',
                'contButtBorderWidth' => 2,
                'contButtBorderStyle' => 'none',
                'contButtBorderColor' => 'rgba(255,255,255,0)',
                'contButtcontMargin' => 5,
                'contButtMargin' => 10,
                'contButtclWidth' => 80,
                'contButtclHeight' => 13,
                'contButtContBorderWidth' => 2,
                'contButtContBorderStyle' => 'none',
                'contButtContBorderColor' => 'rgb(255, 0, 153)',
                'contButtOnhover' => 0,
                'commContBgcolor' => 'rgba(255,255,255,1)',
                'commContMargin' => 35,
                'commContMarginH' => 10,
                'commFontSize' => 13,
                'commFontColor' => 'rgba(44,74,82,1)',
                'commFontFamily' => 'inherit',
                'commFontWeight' => 'normal',
                'commFontStyle' => 'inherit',
                'commButtBgcolor' => 'rgba(255,255,255,1)',
                'commButtHBgcolor' => 'rgba(255,255,255,1)',
                'commButtBoxshadowFstVal' => 0,
                'commButtBoxshadowSecVal' => 0,
                'commButtBoxshadowThdVal' => 0,
                'commButtBoxshadowColor' => 'rgba(255,255,255,1)',
                'commButtSize' => 15,
                'commInpFSize' => 12,
                'commInpColor' => 'rgba(44,74,82,0.67)',
                'commInpFFamily' => 'inherit',
                'commInpFWeight' => 'inherit',
                'commInpFFstyle' => 'inherit',
                'commInpBoxshadowFstVal' => 0,
                'commInpBoxshadowSecVal' => 0,
                'commInpBoxshadowThdVal' => 0,
                'commInpBoxshadowColor' => 'rgba(209,209,209,1)',
                'commInpBorderWidth' => 1,
                'commInpBorderStyle' => 'solid',
                'commInpBorderColor' => 'rgba(176,176,176,1)',
                'commInpBgColor' => 'rgba(255,255,255,1)',
                'commInpBorderRadius' => 2,
                'commInpAcBorderColor' => 'rgba(44,74,82,0.87)',
                'commInpAcBoxshadowFstVal' => 0,
                'commInpAcBoxshadowSecVal' => 0,
                'commInpAcBoxshadowThdVal' => 0,
                'commInpAcBoxshadowColor' => 'rgba(255,255,255,0)',
                'commButtColor' => 'rgba(44,74,82,0.67)',
                'commButtBorderRadius' => 3,
                'commButtBorderWidth' => 1,
                'commButtBorderStyle' => 'solid',
                'commButtBorderColor' => 'rgba(142,155,151,1)',
                'commClButtSize' => 40,
                'commClButtBoxshadowFstVal' => 0,
                'commClButtBoxshadowSecVal' => 0,
                'commClButtBoxshadowThdVal' => 0,
                'commClButtBoxshadowColor' => 'rgba(97,97,97,1)',
                'commClButtBgColor' => 'rgba(255,255,255,0)',
                'commClButtBorderRadius' => 3,
                'commClButtBorderWidth' => 1,
                'commClButtBorderStyle' => 'none',
                'commClButtBorderColor' => 'rgba(255,0,0,1)',
                'commClButtMargin' => 0,
                'commCpButtSize' => 40,
                'commCpButtBoxshadowFstVal' => 0,
                'commCpButtBoxshadowSecVal' => 0,
                'commCpButtBoxshadowThdVal' => 0,
                'commCpButtBoxshadowColor' => 'rgba(99,99,99,1)',
                'commCpButtBgColor' => 'rgba(255,255,255,0)',
                'commCpButtBorderRadius' => 2,
                'commCpButtBorderWidth' => 1,
                'commCpButtBorderStyle' => 'none',
                'commCpButtBorderColor' => 'rgba(255,0,0,1)',
                'commAFontSize' => 13,
                'commAFontColor' => 'rgba(83,112,114,1)',
                'commAFontFamily' => 'inherit',
                'commAFontWeight' => 'normal',
                'commAFontStyle' => 'italic',
                'commTFontSize' => 12,
                'commTFontColor' => 'rgba(44,74,82,1)',
                'commTFontFamily' => 'inherit',
                'commTFontWeight' => 'normal',
                'commTFontStyle' => 'inherit',
                'commDFontSize' => 11,
                'commDFontColor' => 'rgba(44,74,82,0.8)',
                'commDFontFamily' => 'inherit',
                'commDFontWeight' => 'normal',
                'commDFontStyle' => 'italic',
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',/*Thumbnail*/
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',/*Masonry*/
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',/*Mosaic*/
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',/*Navigation*/
                '%d',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',/*Lightbox*/
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );

        return $saveTheme;
    }

    // Alter for 1.0.2
    public function alter_0_2()
    {
        global $wpdb;
        // Update title column
        $title = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_galleriescontent` CHANGE `title` `title` LONGTEXT CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL");
        // Add embed, thumb_url columns
        $addColumns = $wpdb->query("ALTER TABLE `" . $wpdb->prefix . "limb_gallery_galleriescontent` ADD `embed` VARCHAR(12) NOT NULL DEFAULT '' AFTER `type`, ADD `thumb_url` VARCHAR(256) NOT NULL DEFAULT '' AFTER `embed`");

        return $title && $addColumns;
    }

    // Alter for 1.0.1
    public function alter_0_1()
    {
        return true;
    }

    public function changeLog()
    {
    }
}