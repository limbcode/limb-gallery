<?php
/**
 * LIMB gallery
 * Admin model
 */
 
class GRSAdminModel {
	// vars
	public $version;
	//Costructor
	public function __construct($version) {
		$this->version = $version;
    }

	// method declaration
	public function check_action() {
	}

	public function getGrsGalleries() {
		global $wpdb;
		$grsGalleries = $wpdb->get_results("SELECT `id`, `title` FROM `" . $wpdb->prefix . "limb_gallery_galleries`");
		return $grsGalleries;
	}
	
	public function getGrsAlbums() {
		global $wpdb;
		$grsAlbums = $wpdb->get_results("SELECT `id`, `title` FROM `" . $wpdb->prefix . "limb_gallery_albums`");
		return $grsAlbums;
	}
	
	public function getGrsThemes() {
		global $wpdb;
		$grsThemes = $wpdb->get_results("SELECT `id`, `name`, `default` FROM `" . $wpdb->prefix . "limb_gallery_themes`");
		return $grsThemes;
	}

	public function addDotes($str) {
		return strlen($str) > 15 ? substr($str, 0, 15)."..." : $str;
	}

	public function getConfig() {
		$grsConfig = GRS_PLG_DIR . '/js/grsConfig.json';
		$handle = fopen($grsConfig, "r");
		$content = fread($handle, filesize($grsConfig));
		fclose($handle);
		return json_decode($content);
	}

	public function getViewConf($conf) {
	    $viewConf = array();
        foreach ($conf as $key => $value) {
        	$viewConf[$key] = array();
        	$viewConf[$key]['mode'] = $value ? '' : 'disabled';
        	$viewConf[$key]['class'] = $value ? 'enabled' : 'disabled';
        	$viewConf[$key]['checked_yes'] = $value ? 'checked' : '';
        	$viewConf[$key]['checked_no'] = $value ? '' : 'checked';
        }
        return $viewConf;
	}	
	public function getOrderbies() {
        return array(
        	'order' => 'Custom Order',
        	'createDate' => 'Date',
        	'id' => 'Id',
        	'title' => 'Title',
        	'description' => 'Description',
        	'type' => 'Type',
        );
	}
	public function getOrderbiesForAlb() {
        return array(
        	'date' => 'Date',
        	'contentId' => 'Id',
        	'title' => 'Title',
        	'description' => 'Description',
        	'contentType' => 'Type',
        );
	}

	public function getClickActions() {
        return array(
            'openLightbox' => 'Open lightbox',
            'openLink' => 'Open link',
            'doNothing' => 'Do nothing',
        );
    }

    public function getOpenLinkTargets() {
        return array(
            '_top' => 'Same tab',
            '_blank' => 'New tab',
            '_self' => 'Same frame',
            '_parent' => 'Parent frame',
        );
    }
} 