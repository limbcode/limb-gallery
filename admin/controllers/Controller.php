<?php
/**
 * LIMB gallery
 * Admin controller
 */
 
class GRSAdminController extends LIMB_Gallery {
	//Costructor
	public function __construct() {
    }
	
	public function display($view) {
	    require_once(GRS_PLG_DIR . '/admin/models/Model.php');
		$fileName = 'View'.ucfirst(strtolower($view));
		$className = 'GRSView'.ucfirst(strtolower($view));
		require_once(GRS_PLG_DIR . '/admin/views/'.$fileName.'.php');
		$model = new GRSAdminModel(parent::$version);
		$view = new $className($model);
	    $view->display();	
	}

	// shortcode filter
	public function filter($atts) {
		if(method_exists($this, strtolower($atts['view']))) {
			$forallArr = $this->forall();
			$viewArr = $this->{strtolower($atts['view'])}();
			$lightboxArr = $this->lightbox();
			$paramsArr = array_merge($forallArr, $viewArr, $lightboxArr);
			$atts = shortcode_atts($paramsArr, $atts, 'GRS');
		}
		else {
			$atts = array('error' => 'There is no view type like ' . $atts['view']);
		}
		return $atts;
	}
	
	public function thumbnail() {
		return array (
			'width' => 300,
			'height' => 200,
			'contwidth' => 100,
			'imagesperpage' => 20,
			'pagination' => 'loadMore',
			'title' => 'onhover',
			'orderby' => 'createDate',
			'ordering' => 'DESC',
			'polaroid' => 0,
            'clickaction' => 'openLightbox',
            'openlinktarget' => '_self',
			// 'maxcolumnscount' => 5
		);
	}
	public function film() {
		return array (
			'width' => 200,
			'height' => 160,
			'contwidth' => 100,
			'imagesperpage' => 20,
			'pagination' => 'scrolling',
			'nav' => 'both',
			'title' => 'onhover',
			'orderby' => 'createDate',
			'ordering' => 'DESC',
            'clickaction' => 'openLightbox',
            'openlinktarget' => '_self',
		);
	}
	public function masonry() {
		return array (
			'width' => 200,
			'height' => 110,
			'contwidth' => 100,
			'imagesperpage' => 20,
			'type' => 'hor',
			'pagination' => 'loadMore',
			'title' => 'onhover',
			'orderby' => 'createDate',
			'ordering' => 'DESC',
            'clickaction' => 'openLightbox',
            'openlinktarget' => '_self',
		);
	}
	public function mosaic() {
		return $this->masonry();
	}
	public function album() {
		return array (
			'width' => 200,
			'height' => 110,
			'contwidth' => 70,
			'mainview' => 'thumbnail',
			'masmostype' => 'ver',
			'title' => 'always',
			'orderby' => 'date',
			'ordering' => 'DESC',
			'galview' => 'thumbnail',
			'galmasmostype' => 'ver',
			'galwidth' => 200,
			'galheight' => 110,
			'galcontwidth' => 100,
			'galtitle' => 'onhover',
			'galorderby' => 'createDate',
			'galordering' => 'DESC',
            'galclickaction' => 'openLightbox',
            'galopenlinktarget' => '_self',
			'imagesperpage' => '',
			'pagination' => 'numbers',
		);
	}
	public function lightbox() {
		return array (
			'lightboxwidth' => 1000,
			'lightboxheight' => 800,
			'lightboxfilmstrip' => 1,
			'lightboxcontbutts' => 1,
			'lightboxfbutt' => 1,
			'lightboxgbutt' => 1,
			'lightboxtbutt' => 1,
			'lightboxpbutt' => 1,
			'lightboxtbbutt' => 1,
			'lightboxlibutt' => 1,
			'lightboxreddbutt' => 1,
			'lightboxfsbutt' => 1,
			'lightboxap' => 1,
			'lightboxapin' => 3,
			'lightboximinf' => 1,
			'lightboxcomment' => 1,
			'lightboxswipe' => 1,
			'lightboximcn' => 1,
			'lightboxfullw' => 0,
			'lightboxeffect' => 'fade',
		);
	}
	public function forall() {
		return array(
			'id' => 0,
			'view' => 'thumbnail',
			'theme' => 0,
		);
	}	
} 