<?php
/**
 * The Gallery RS 
 * Grs Gallery Smart
 * 1.0.0
 */
 
class GRSGallerySmart extends LIMB_Gallery {

	// Costructor
	public function __construct($task = 'grs') {	
		if(method_exists($this, $task))
			$this->{$task}();
		else
			return;
	}
	
	// Activate
	public function activate() {
		$this->checkVersion();
		return;
	}
	
	// Fast update check fastUpdateCheck
	public function fastUpdateCheck() {
		$existVersion = get_option( parent::$vOptName, false );
		if($existVersion) {
			if(version_compare(parent::$currentVersion, $existVersion) == 1) {
				if($this->doUpdates()) {
					$this->storeStatus('success', 'Successfully update');
					parent::$version = parent::$currentVersion;
				}
				else
					$this->storeStatus('error', 'Problems with update');
			}
		}
		return;
	}
	// Uninstall
	public function uninstall() {
		require_once(GRS_PLG_DIR . '/database/GRSGalleryUninstall.php');
		$obj = new GRSGalleryUninstall();
		$result = $obj->uninstall();
		if($result !== false) {
			$this->storeStatus('error', 'Plugin uninstalled');
		}
		return $result;
	}

	// CHeck version
	public function checkVersion() {
		/*
		  * Get current version,
		  * get exists version,
		  * compare versions,
		  * check for tables, check for updates, check for inserts.
		*/
		$existVersion = get_option( parent::$vOptName, false );
		if($existVersion) {
			switch(version_compare(parent::$currentVersion, $existVersion)) {
				case -1:
					$this->storeStatus('error', 'Trying to update old version, Please uninstall current then install your version');
				break;
				case 0: // do nothing
					if($this->checkTables()) {
						if($this->insertData()) {
							$this->storeStatus('success', 'Successfully activate');
						}
						else {
							$this->storeStatus('error', 'Some rows droped and cant be inserted');
						}
					} else {
						$this->storeStatus('error', 'Some tables dropped, or can\'t be created');
					}
				break;
				case 1:
					if($this->checkTables()) {
						if($this->doUpdates()) {
							$this->storeStatus('success', 'Successfully update');
						}
						else {
							$this->storeStatus('error', 'Problems with update');
						}
					}
					else {
						$this->storeStatus('error', 'Some tables not exists and cant created');
					}
				break;
				default:
					$this->storeStatus('error', 'Unknown version');
				break;
			}
		} else {
			// First time so lets set activation status option, insert data 
			if($this->checkTables()) {
				if($this->insertData()) {
					$add = add_option(parent::$vOptName, parent::$currentVersion);
					$this->storeStatus('success', 'Plugin successfully activate');
				}
				else {
					$this->storeStatus('error', 'Data has not been inserted');
				}
			} else {
				$this->storeStatus('error', 'Some tables have not been created');
			}
		}
	}

	// Do updates
	public function doUpdates() {
		require_once(GRS_PLG_DIR . '/database/GRSGalleryUpdate.php');
		$obj = new GRSGalleryUpdate();
		return $obj->update();
	}

	// Do bulk updates
	public function bulkUpdate($options) {
	    $dirAndName = plugin_basename(parent::$grsMainFile);
	    if ($options['action'] == 'update' && $options['type'] == 'plugin' ) {
	       foreach($options['plugins'] as $each_plugin) {
	          	if ($each_plugin == $dirAndName) {
	          		$this->activate();
	          	}
	       }
	    }
	}
	
	// CHeck tables
	public function checkTables() {
		global $wpdb;
		$ok = true;
		$query = "SELECT COUNT(*) as `grsTc` 
			      FROM `information_schema`.`tables`
				  WHERE
				  `TABLE_SCHEMA` = '".DB_NAME."' AND 
				  `TABLE_NAME` IN ('". $wpdb->prefix . "limb_gallery_galleries',
								   '". $wpdb->prefix . "limb_gallery_galleriescontent', 
								   '". $wpdb->prefix . "limb_gallery_albums',
								   '". $wpdb->prefix . "limb_gallery_albumscontent',
								   '". $wpdb->prefix . "limb_gallery_comments',
								   '". $wpdb->prefix . "limb_gallery_settings',
								   '". $wpdb->prefix . "limb_gallery_themes')";
		$c = $wpdb->get_var($query);
		if($c < 7) {
			require_once(GRS_PLG_DIR . '/database/GRSGalleryCreate.php');
			$obj = new GRSGalleryCreate();
			$ok = $obj->create();
		}
		return $ok;
	}
	
	// Insert data
	public function insertData() {
		require_once(GRS_PLG_DIR . '/database/GRSGalleryInsert.php');
		$obj = new GRSGalleryInsert();
		return $obj->insert();
	}
	
	// Message
	public function storeStatus($mood, $message, $saveInDb = false) {
		$statusObj = new stdClass();
		$statusObj->date = date('Y-m-d-H:i:s', time());
		$statusObj->mood = $mood;
		$statusObj->content = $message;
		if(get_option(parent::$aCsOptName))
			update_option(parent::$aCsOptName, json_encode($statusObj));
		else
			add_option(parent::$aCsOptName, json_encode($statusObj));
	}
}