<?php
/**
 * LIMB gallery
 * Frontend
 * Controller
 */
 
class GRSController extends LIMB_Gallery {
	
	//Private variables
	private $atts; 
	//Costructor
	public function __construct($atts) {
		$this->atts = $atts;
    }

	// method declaration
	public function main() {
		include_once GRS_PLG_DIR . '/frontend/models/Model.php';
		include_once GRS_PLG_DIR . '/frontend/views/View'.$this->atts['view'].'.php';
		
		$model = new GRSModel($this->atts);
		$viewClass = 'GRSView'.$this->atts['view'];
		$view = new $viewClass($model);
		$view->display(parent::$grsCounter);
	}
	
}