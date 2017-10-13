<?php
/**
 * LIMB gallery
 * Ajax
 */
class GRSGalleryAjax extends LIMB_Gallery {
	// Private variables
	private $action;
	public $actions = array(
		"getUploderItems" 	   => 'GRSAdminActions',
		"delItemsFromUploader" => 'GRSAdminActions',
		"renameItemInUploader" => 'GRSAdminActions',
		"addImageToUploader"   => 'GRSAdminActions',
		"addFolderInUploader"  => 'GRSAdminActions',
		"copyItemInUploader"   => 'GRSAdminActions',
		"getGalleryItems" 	   => 'GRSAdminActions',
		"getGalleryTItems" 	   => 'GRSAdminActions',
		"embedMedia" 	   => 'GRSAdminActions',
		"saveOrder" 	   => 'GRSAdminActions',
		"insert" 	   => 'GRSAdminActions',
		"update" 	   => 'GRSAdminActions',
		"delete" 	   => 'GRSAdminActions',
		"addImages" 	   => 'GRSAdminActions',
		"addImagesFromWP" 	   => 'GRSAdminActions',
		"addPwAIm" 	   => 'GRSAdminActions',
		"addGPvIm" 	   => 'GRSAdminActions',
		"deleteImage" 	   => 'GRSAdminActions',
		"deleteImages" 	   => 'GRSAdminActions',
		"removeComments" 	   => 'GRSAdminActions',
		"getAlbumItems" 	   => 'GRSAdminActions',
		"addContentForAlbum" 	   => 'GRSAdminActions',
		"deleteContentFromAlbum" 	   => 'GRSAdminActions',
		"addUpdateAlbum" 	   => 'GRSAdminActions',
		"deleteAlbum" 	   => 'GRSAdminActions',
		"saveSettings" 	   => 'GRSAdminActions',
		"getSettings" 	   => 'GRSAdminActions',
		"uninstall" 	   => 'GRSAdminActions',
		"setDefault" 	   => 'GRSAdminActions',
		"getThemeItems" 	   => 'GRSAdminActions',
		"addTheme" 	   => 'GRSAdminActions',
		"updateTheme" 	   => 'GRSAdminActions',
		"deleteTheme" 	   => 'GRSAdminActions',
		"saveThemeToFile" 	   => 'GRSAdminActions',
		"getGalleryData"  	   => 'GRSGetFrontendData',
		"getAlbumData"  	   => 'GRSGetFrontendData',
		"getPopupData"  	   => 'GRSGetFrontendData',
		"showComments"  	   => 'GRSComment',
		"comment"  	   => 'GRSComment',
		"reloadCaptcha"  	   => 'GRSCaptcha',
		"captcha"  	   => 'GRSCaptcha',
		"share"  	   => 'GRSShare',
		"shortcode" 	   => 'GRSGetFrontendData',
		"getSettingsForF" 	   => 'GRSGetFrontendData',
	);
	// Costructor
	public function __construct() {				
		if(isset($_POST['grsAction']))
			$this->action = $_POST['grsAction'];
		elseif(isset($_GET['grsAction']))
			$this->action = $_GET['grsAction'];
		else 
			$this->action = 'It isnt grs action';
	}
	// Check action
	public function grsCheckAction() {
		$this->checkStatus();
		if(array_key_exists($this->action, $this->actions)) {
			require_once(GRS_PLG_DIR . '/ajax/'.$this->actions[$this->action].'.php');
			$obj = new $this->actions[$this->action]($this->action);
		} else 
			$this->result('error', 'Unknown action.');
	}
	// Verify nonce
	protected function verifyNonce() {
		if(!check_ajax_referer( 'grs-ajax-nonce', 'grsAjaxNonce', false ))
			$this->result('error', 'Your nonce is not verified');
	}
	// Print result
	protected function result($result, $message = 'message', $num = false) {
		print_r(json_encode(array($result => $message)));
		wp_die();
	}
	// DataTables errors
	private function checkStatus() {
		$statusJs = get_option( parent::$aCsOptName, false );
		$status = json_decode($statusJs);
		if($status->mood == 'error') {
			$this->result('error', $status->content . ", try to reacrivate plugin.");
		} else {
		 	return true;
		}
	}
}