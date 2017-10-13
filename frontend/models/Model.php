<?php
/**
 * LIMB gallery
 * Frontend
 * Model
 */
 
class GRSModel {
	//Private variables
	public $atts;
	//Costructor
	public function __construct($atts) {
		$this->atts = $atts;
		$this->setSomeThemeParams();
    }
    public function setSomeThemeParams() {
    	global $wpdb;
		$lastModDate = $wpdb->get_var($wpdb->prepare("SELECT `lastmodified` FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `id` = %d", $this->atts['theme']));
		if($lastModDate == NULL) {
			$defTheme = $wpdb->get_row("SELECT `id`, `lastmodified` FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `default` = 1");
			if($defTheme != NULL) {
				$this->atts['theme'] = $defTheme->id;
				$this->atts['themeLastModDate'] =  strtotime($defTheme->lastmodified);
			} else {
				$this->atts['theme'] = 0;
				$this->atts['themeLastModDate'] = '';
			}
		} else {
			$this->atts['themeLastModDate'] = strtotime($lastModDate);
		}
    }
}