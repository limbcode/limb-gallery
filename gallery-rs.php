<?php

/**
 * Plugin Name: Limb Gallery
 * Plugin URI: http://limbcode.com
 * Description: Limb Gallery is an advanced solution to build gallery with multiple views, create awesome albums, embed social media, view photos and videos via stunning lightboxes and share them to social networks.
 * Version: 1.2.3
 * Author: Limb
 * Author URI: http://limbcode.com
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
class LIMB_Gallery {

	// vars
	private $grsAjaxNonce = '';
	// static vars
	protected static $wpUploadDir;
	protected static $grsUplDirName = 'limb-gallery';
	protected static $aCsOptName = 'LIMB_gallery_act_status';
	protected static $vOptName = 'LIMB_gallery_version';
	protected static $currentVersion = '1.2.3';
	protected static $grsMainFile;
	protected static $version;
	protected static $uploadDir;
	protected static $uploadUrl;
	protected static $grsCounter;

	public function __construct() {
		$this->registerHooks();
		$this->startSession();
		$this->defineVars();
		$this->createGrsFolder();
		$this->fastUpdateCheck();
		// Activate without hook
		// $this->grsActivate();
	}

	public function startSession() {
		// also we can create session path folder
		if ( session_id() == '' ) {
			session_start();
		}
	}

	public function defineVars() {
		self::$wpUploadDir = wp_upload_dir();
		define( 'GRS_PLG_DIR', WP_PLUGIN_DIR . "/" . plugin_basename( dirname( __FILE__ ) ) );
		// Plugin folder url
		define( 'GRS_PLG_URL', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
		self::$grsCounter  = 0;
		self::$grsMainFile = __FILE__;
		self::$version     = get_option( self::$vOptName, false );
	}

	public function createGrsFolder() {
		$dirname = self::$wpUploadDir['basedir'] . '/' . self::$grsUplDirName;
		$dirurl  = self::$wpUploadDir['baseurl'] . '/' . self::$grsUplDirName;
		if ( ! is_dir( $dirname ) ) {
			$ok = wp_mkdir_p( $dirname );
		} else {
			$ok = true;
		}

		self::$uploadDir = $dirname . '/';
		self::$uploadUrl = $dirurl . '/';

		return $ok; // If not ok alert it 
	}

	public function fastUpdateCheck() {
		require_once( GRS_PLG_DIR . '/smart/GRSGallerySmart.php' );
		new GRSGallerySmart( 'fastUpdateCheck' );
	}

	public function registerHooks() {
		// For admin menu
		add_action( 'admin_menu', array( &$this, 'grs_menu' ) );
		// For ajax calls
		add_action( 'wp_ajax_grsGalleryAjax', array( &$this, 'grsGalleryAjax' ) );
		add_action( 'wp_ajax_nopriv_grsGalleryAjax', array( &$this, 'grsGalleryAjax' ) );
		// For shortcode
		add_shortcode( 'GRS', array( &$this, 'grsShortcode' ) );
		// Load the TinyMCE plugin : editor_plugin.js 
		add_filter( 'mce_external_plugins', array( &$this, 'myplugin_register_tinymce_javascript' ) );
		// GRS mce button
		add_filter( 'mce_buttons', array( &$this, 'myplugin_register_buttons' ) );
		// Frontend scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'grsFrontendScripts' ) );
		// For admin head
		add_action( 'admin_head', array( &$this, 'grs_admin_head' ) );
		// Media button hook
		add_action( 'media_buttons', array( &$this, 'grs_media_button' ) );
		// Activation hook
		register_activation_hook( __FILE__, array( &$this, 'grsActivate' ) );
		// Bulk update hook
		// add_action( 'upgrader_process_complete', array( &$this, 'grsBulkUpdate'), 10, 2);
		// Deactivation hook
	}

	public function grs_media_button() {
		$img  = GRS_PLG_URL . '/images/logo/limb-02.png';
		$href = add_query_arg( array(
			'action'    => 'grsGalleryAjax',
			'grsAction' => 'shortcode',
			'TB_iframe' => '1',
			'height'    => '465',
		), admin_url( 'admin-ajax.php' ) );
		echo '<a href="' . $href . '" onclick="if(!tinyMCE.execCommand(\'grsMce\'))tb_click.call(this);return false;" id="grs-media-insert" class="button"><span class="wp-media-buttons-icon" style="background: url(' . $img . ') no-repeat 0 -1px;padding: 0 2px;"></span>Add Limb gallery</a>';
	}

	public function grsBulkUpdate( $upgrader_object, $options ) {
		require_once( GRS_PLG_DIR . '/smart/GRSGallerySmart.php' );
		$smart = new GRSGallerySmart();
		$smart->bulkUpdate( $options );
	}

	public function grsActivate() {
		require_once( GRS_PLG_DIR . '/smart/GRSGallerySmart.php' );
		new GRSGallerySmart( 'activate' );
	}

	// Plugin menu.
	public function grs_menu() {
		add_menu_page( 'Limb Gallery', 'Limb Gallery', 'manage_options', 'galleries_grs', array(
			&$this,
			'grs_gallery'
		), GRS_PLG_URL . '/images/logo/limb-07.png' );
		$galleries_page = add_submenu_page( 'galleries_grs', 'Galleries', 'Galleries', 'manage_options', 'galleries_grs', array(
			&$this,
			'grs_gallery'
		) );
		add_action( 'admin_print_styles-' . $galleries_page, array( &$this, 'grs_styles' ) );
		add_action( 'admin_print_scripts-' . $galleries_page, array( &$this, 'grs_scripts' ) );
	}

	public function grs_gallery() {
//        Check nonce
		$page = ( isset( $_REQUEST['page'] ) ) ? $_REQUEST['page'] : 'no';
		$file = GRS_PLG_DIR . '/admin/controllers/Controller.php';
		if ( file_exists( $file ) ) {
			require_once( $file );
			$object = new GRSAdminController();
			$object->display( 'galleries' );
		}
	}

	public function grs_styles() {
		wp_enqueue_style( 'bootstrap-colorpicker', GRS_PLG_URL . '/js/colorpicker/css/bootstrap-colorpicker.css', array(), self::$version );
		wp_enqueue_style( 'jquery-ui-1.10.3.custom.css', GRS_PLG_URL . '/css/jquery-ui-1.10.3.custom.css', array(), self::$version );
		wp_enqueue_style( 'grsAdmin.css', GRS_PLG_URL . '/css/grsAdmin.css', array(), self::$version );
		wp_enqueue_style( 'thickbox' );
	}

	public function grs_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
//        wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script( 'jquery-ui-position' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-tooltip' );
		wp_enqueue_script( 'bootstrap-colorpicker', GRS_PLG_URL . '/js/colorpicker/js/bootstrap-colorpicker.js', array(), self::$version );
		wp_enqueue_script( 'angular.min.js', GRS_PLG_URL . '/js/angular.min.js', array(), self::$version );
		wp_enqueue_script( 'jquery.ui.widget.js', GRS_PLG_URL . '/js/jquery.ui.widget.js', array(), self::$version );
		wp_enqueue_script( 'jquery.iframe-transport.js', GRS_PLG_URL . '/js/jquery.iframe-transport.js', array(), self::$version );
		wp_enqueue_script( 'jquery.fileupload.js', GRS_PLG_URL . '/js/jquery.fileupload.js', array(), self::$version );
		wp_enqueue_script( 'jquery.knob.js', GRS_PLG_URL . '/js/jquery.knob.js', array(), self::$version );
		wp_enqueue_media();
//		wp_enqueue_script( 'grsAdmin.js', GRS_PLG_URL . '/js/grsAdmin.js', array(), self::$version );
		wp_enqueue_script('grsAdmin.min.js', GRS_PLG_URL . '/js/grsAdmin.min.js', array(), self::$version);
		wp_enqueue_script( 'grsFontAwesome.js', 'https://use.fontawesome.com/cc3b90d173.js', array(), self::$version );
		$this->setGrsNonce();
		$grsConfig = GRS_PLG_DIR . '/js/grsConfig.json';
		$handle    = fopen( $grsConfig, "r" );
		$content   = fread( $handle, filesize( $grsConfig ) );
		fclose( $handle );
		?>
        <script>
            var grsWpUploaderUrl = '<?php echo self::$wpUploadDir['baseurl'] . '/'; ?>',
                grsUploaderUrl = '<?php echo self::$uploadUrl; ?>',
                grsPluginUrl = '<?php echo GRS_PLG_URL; ?>',
                grsPluginVer = '<?php echo self::$version; ?>',
                grsAjaxNonce = '<?php echo $this->grsAjaxNonce; ?>',
                grsConfig = JSON.parse('<?php echo preg_replace( "/\r|\n/", "", $content ); ?>');
        </script>
		<?php
	}

	public function grs_admin_head() {
		$this->setGrsNonce();
		?>
        <script>
            var grsAdminAjax = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
        </script>
		<?php
	}

	public function grsGalleryAjax() {
		require_once( GRS_PLG_DIR . '/ajax/GRSGalleryAjax.php' );
		// Check nonce
		$object = new GRSGalleryAjax;
		$object->grsCheckAction();
	}

	public function grsShortcode( $atts ) {
		require_once( GRS_PLG_DIR . '/admin/controllers/Controller.php' );
		$shortcode = new GRSAdminController();
		$atts      = $shortcode->filter( $atts );
		ob_start();
		$this->grsFrontend( $atts );

		return str_replace( array( "\r\n", "\n", "\r" ), '', ob_get_clean() );
	}

	public function myplugin_register_buttons( $buttons ) {
		array_push( $buttons, 'grsMce' );

		return $buttons;
	}

	public function myplugin_register_tinymce_javascript( $plugin_array ) {
		$plugin_array['grs'] = plugins_url( '/js/grsMce/tinymce-plugin.js?ver=' . self::$version, __FILE__ );

		return $plugin_array;
	}

	public function setGrsNonce() {
		$this->grsAjaxNonce = wp_create_nonce( "grs-ajax-nonce" );
	}

	// GRS frontend scripts
	public function grsFrontendScripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'angular.min.js', GRS_PLG_URL . '/js/angular.min.js', array(), self::$version );
		wp_enqueue_script( 'angular-touch.min.js', GRS_PLG_URL . '/js/angular-touch.min.js', array(), self::$version );
		wp_enqueue_style( 'grsFrontend.css', GRS_PLG_URL . '/css/grsFrontend.css', array(), self::$version );
		wp_enqueue_script( 'grsFontAwesome.js', 'https://use.fontawesome.com/cc3b90d173.js', array(), self::$version );
//		wp_enqueue_script( 'grsFrontend', GRS_PLG_URL . '/js/grsFrontend.js', array(), self::$version );
        wp_enqueue_script('grsFrontend.min', GRS_PLG_URL . '/js/grsFrontend.min.js', array(), self::$version);
		$grsConfig = GRS_PLG_DIR . '/js/grsConfig.json';
		$handle    = fopen( $grsConfig, "r" );
		$content   = fread( $handle, filesize( $grsConfig ) );
		fclose( $handle );
		?>
        <script>
            var grsWpUploaderUrl = '<?php echo self::$wpUploadDir['baseurl'] . '/'; ?>',
                grsPluginUrl = '<?php echo GRS_PLG_URL ?>',
                grsShareUrl = '<?php echo add_query_arg( array(
					"action"    => "grsGalleryAjax",
					"grsAction" => "share"
				), admin_url( "admin-ajax.php" ) ); ?>';
            grsAjaxUrl = '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                grsUploaderUrl = '<?php echo self::$uploadUrl; ?>',
                grsPluginVer = '<?php echo self::$version; ?>',
                grsConfig = JSON.parse('<?php echo preg_replace( "/\r|\n/", "", $content ); ?>');
        </script>
		<?php
	}

	public function grsFrontend( $atts ) {
		include_once GRS_PLG_DIR . '/frontend/controllers/Controller.php';
		$object = new GRSController( $atts, self::$grsCounter );
		$object->main();
		self::$grsCounter ++;
	}
}

$limb = new LIMB_Gallery();