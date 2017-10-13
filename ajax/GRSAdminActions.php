<?php

/**
 * LIMB gallery
 * Ajax
 * GRSAdminActions
 */
class GRSAdminActions extends GRSGalleryAjax {
	// Costructor
	public function __construct( $action ) {
		$this->verifyNonce();
		if ( method_exists( $this, $action ) ) {
			$this->{$action}();
		}
	}

	// For all directories data store
	private $dirs = array();
	// For curent directory index store
	private $index = 0;

	// Get unique name
	private function getUniqueName( $tableName, $column, $name, $firstCall = false, $update = false, $id = 0 ) {
		global $wpdb;
		// $name = esc_sql( $name );
		$idW    = ( $id ) ? " AND `id` != $id" : "";
		$result = $wpdb->get_var( "SELECT `" . $column . "` FROM `" . $wpdb->prefix . $tableName . "` WHERE " . $column . " = '" . esc_sql( $name ) . "' " . $idW );
		if ( $result != null/* && !$update*/ ) {
			$str_arr   = explode( "_", $result );
			$count     = count( $str_arr );
			$last_elem = end( $str_arr );
			if ( $count == 1 ) {
				$result .= "_1";
			} elseif ( $count > 1 ) {
				if ( preg_match( "/^[0-9 -]+$/", $last_elem ) === 1 && ! $firstCall ) {
					$num                   = (int) $last_elem;
					$num                   += 1;
					$str_arr[ $count - 1 ] = $num;
					$result                = implode( "_", $str_arr );
				} else {
					$result .= "_1";
				}
			}

			return $this->getUniqueName( $tableName, $column, $result );
		} else {
			return $name;
		}
	}

	// Uploader data
	private function getUploderItems() {
		$dirs = $this->getItems( scandir( parent::$uploadDir ) );
		$this->result( 'success', $dirs );
	}

	private function getItems( $directories = array(), $namee = '', $parentDirIndex = - 1 ) {
		$uploadDir = parent::$uploadDir;
		$uploadUrl = parent::$uploadUrl;
		usort( $directories, create_function( '$a,$b', '
			return	is_dir ($a)
				? (is_dir ($b) ? strnatcasecmp ($a, $b) : -1)
				: (is_dir ($b) ? 1 : (
					strcasecmp (pathinfo ($a, PATHINFO_EXTENSION), pathinfo ($b, PATHINFO_EXTENSION)) == 0
					? strnatcasecmp ($a, $b)
					: strcasecmp (pathinfo ($a, PATHINFO_EXTENSION), pathinfo ($b, PATHINFO_EXTENSION))
				))
			;
		' ) );
		$files                 = new stdClass();
		$files->path           = ( $namee == '' ) ? $namee : $namee . '/';
		$files->items          = array();
		$files->curentDirIndex = $this->index;
		$files->parentDirIndex = $parentDirIndex;
		foreach ( $directories as $key => $name ) {
			$content      = new stdClass();
			$content->key = $key;
			if ( is_dir( $uploadDir . $files->path . $name . '/' ) ) {
				if ( $name == '.' || $name == '..' || $name == 'thumbnail' || $name == 'medium' || $name == 'large' || $name == 'extralarge' ) {
					continue;
				} // or some other version
				$content->name     = $name;
				$content->dirPath  = $uploadUrl . $files->path . $name;
				$content->path     = GRS_PLG_URL . '/images/admin/folder.png';
				$content->dirIndex = ++ $this->index;
				$content->isDir    = true;
				$content->ext      = '';
				array_push( $files->items, $content );
				$this->getItems( scandir( $uploadDir . $files->path . $name . '/' ), $files->path . $name, $files->curentDirIndex );
			} else {
				$type              = ( substr( strrchr( $name, '.' ), 1 ) );
				$content->ext      = "." . $type;
				$content->name     = basename( $name, "." . $type );
				$content->dirPath  = '';
				$content->dirIndex = '';
				$content->isDir    = false;
				$content->path     = $uploadUrl . $files->path . 'thumbnail/' . $name;
				array_push( $files->items, $content );
			}
		}
		array_push( $this->dirs, $files );

		return $this->dirs;
	}

	private function delItemsFromUploader() {
		require_once( GRS_PLG_DIR . '/uploader/UploadHandler.php' );
		error_reporting( E_ALL | E_STRICT );
		$upload_handler = new GRSUploadHandler();
		// If success delete from images table

		$resArr = $upload_handler->get_option_value( 'deleted_items' );
		$this->deleteItemsInGalleries( $resArr );
		if ( is_array( $resArr ) ) {
			print_r( json_encode( $resArr ) );
			wp_die();
		} else {
			$this->result( 'error', 'Something went wrong' );
		}
	}

	private function deleteItemsInGalleries( $resArr ) {
		if ( is_array( $resArr ) && count( $resArr ) > 0 ) {
			global $wpdb;
			foreach ( $resArr as $key => $item ) {
				if ( $item->success ) {
					// For images delete them
					$wpdb->delete( $wpdb->prefix . 'limb_gallery_galleriescontent',
						array(
							'name' => $item->name,
							'path' => $item->path,
						)
					);
					// For preview images (update them)
					$wpdb->update( $wpdb->prefix . 'limb_gallery_galleries',
						array(
							'prevImgPath'   => '',
							'prevImgName'   => 'grsnopv',
							'prevImgType'   => '.png',
							'prevImgWidth'  => 300,
							'prevImgHeight' => 300,
						),
						array(
							'prevImgName' => $item->name,
							'prevImgPath' => $item->path,
						)
					);
					$wpdb->update( $wpdb->prefix . 'limb_gallery_albums',
						array(
							'prevImgPath'   => '',
							'prevImgName'   => 'grsnopv',
							'prevImgType'   => '.png',
							'prevImgWidth'  => 300,
							'prevImgHeight' => 300,
						),
						array(
							'prevImgName' => $item->name,
							'prevImgPath' => $item->path,
						)
					);
				}
			}
		}
	}

	private function deleteByPath( $path ) {
		global $wpdb;
		$destDir = parent::$uploadDir . $path;
		$items   = array_slice( scandir( $destDir ), 2 );
		foreach ( $items as $item ) {
			$itemPath = $destDir . $item;
			if ( is_file( $itemPath ) ) {
				$type = ( substr( strrchr( $item, '.' ), 1 ) );
				$name = basename( $item, "." . $type );

				$wpdb->update( $wpdb->prefix . 'limb_gallery_galleriescontent',
					array(
						'path' => $itemParentNewPath,
					),
					array(
						'name' => $name,
						'path' => $itemParentOldPath
					)
				);

				$wpdb->update( $wpdb->prefix . 'limb_gallery_galleries',
					array(
						'prevImgPath' => $itemParentNewPath,
					),
					array(
						'prevImgName' => $name,
						'prevImgPath' => $itemParentOldPath,
					)
				);
				$wpdb->update( $wpdb->prefix . 'limb_gallery_albums',
					array(
						'prevImgPath' => $itemParentNewPath,
					),
					array(
						'prevImgName' => $name,
						'prevImgPath' => $itemParentOldPath,
					)
				);
			} elseif ( is_dir( $itemPath ) ) {
				if ( $item == 'thumbnail' || $item == 'medium' || $item == 'large' || $item == 'extralarge' ) // or some other version
				{
					continue;
				}
				$nextNewPath = $newPath . $item . "/";
				$nextOldPath = $oldPath . $item . "/";
				$this->renameByPath( $nextOldPath, $nextNewPath );
			}
		}
	}

	private function renameItemInUploader() {
		require_once( GRS_PLG_DIR . '/uploader/UploadHandler.php' );
		error_reporting( E_ALL | E_STRICT );
		$upload_handler = new GRSUploadHandler();

		$resArr = $upload_handler->get_option_value( 'renamed_item' );
		$this->renameItemsInGalleries( $resArr );

		print_r( json_encode( $resArr ) );
		wp_die();
	}

	private function renameItemsInGalleries( $resArr ) {
		if ( $resArr['success'] ) {
			global $wpdb;
			if ( $resArr['type'] ) {
				// For images
				$wpdb->update( $wpdb->prefix . 'limb_gallery_galleriescontent',
					array(
						'name' => $resArr['new_name'],
					),
					array(
						'name' => $resArr['old_name'],
						'path' => $resArr['path'],
					)
				);
				// For preview images
				$wpdb->update( $wpdb->prefix . 'limb_gallery_galleries',
					array(
						'prevImgName' => $resArr['new_name'],
					),
					array(
						'prevImgName' => $resArr['old_name'],
						'prevImgPath' => $resArr['path'],
					)
				);
				$wpdb->update( $wpdb->prefix . 'limb_gallery_albums',
					array(
						'prevImgName' => $resArr['new_name'],
					),
					array(
						'prevImgName' => $resArr['old_name'],
						'prevImgPath' => $resArr['path'],
					)
				);
			} else {
				// For folder
				$newPath = $resArr['path'] . $resArr['new_name'] . "/";
				$oldPath = $resArr['path'] . $resArr['old_name'] . "/";
				$this->renameByPath( $oldPath, $newPath );
			}
		}
	}

	private function renameByPath( $oldPath, $newPath ) {
		global $wpdb;
		$uploadDir  = parent::$uploadDir;
		$destNewDIr = $uploadDir . $newPath;
		$destOLdDIr = $uploadDir . $oldPath;
		$items      = array_slice( scandir( $destNewDIr ), 2 );
		foreach ( $items as $item ) {
			$itemPath          = $destNewDIr . $item;
			$itemParentNewPath = $newPath;
			$itemParentOldPath = $oldPath;
			if ( is_file( $itemPath ) ) {
				$type = ( substr( strrchr( $item, '.' ), 1 ) );
				$name = basename( $item, "." . $type );

				$ok = $wpdb->update( $wpdb->prefix . 'limb_gallery_galleriescontent',
					array(
						'path' => $itemParentNewPath,
					),
					array(
						'name' => $name,
						'path' => $itemParentOldPath
					)
				);

				$wpdb->update( $wpdb->prefix . 'limb_gallery_galleries',
					array(
						'prevImgPath' => $itemParentNewPath,
					),
					array(
						'prevImgName' => $name,
						'prevImgPath' => $itemParentOldPath,
					)
				);
				$wpdb->update( $wpdb->prefix . 'limb_gallery_albums',
					array(
						'prevImgPath' => $itemParentNewPath,
					),
					array(
						'prevImgName' => $name,
						'prevImgPath' => $itemParentOldPath,
					)
				);
			} elseif ( is_dir( $itemPath ) ) {
				if ( $item == 'thumbnail' || $item == 'medium' || $item == 'large' || $item == 'extralarge' ) // or some other version
				{
					continue;
				}
				$nextNewPath = $newPath . $item . "/";
				$nextOldPath = $oldPath . $item . "/";
				$this->renameByPath( $nextOldPath, $nextNewPath );
			}
		}
	}

	private function addImageToUploader() {
		require_once( GRS_PLG_DIR . '/uploader/index.php' );
	}

	private function addFolderInUploader() {
		require_once( GRS_PLG_DIR . '/uploader/index.php' );
	}

	private function copyItemInUploader() {
		require_once( GRS_PLG_DIR . '/uploader/index.php' );
	}

	// Galleries data
	private function getGalleryItems() {
		global $wpdb;
		$grsGalleries = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_galleries` ORDER BY `id` DESC" );
		$data         = array();
		foreach ( $grsGalleries as $key => $grsGallerie ) :
			$grsGallerieImages        = $this->getGrsGallerieContent( $grsGallerie->id );
			$grsGallerie->imagesCount = count( $grsGallerieImages );
			$grsGallerie->images      = $grsGallerieImages;
			array_push( $data, $grsGallerie );
		endforeach;
		$this->result( 'success', $data, true );
	}

	private function getGrsGallerieContent( $galId ) {
		global $wpdb;
		$query             = $wpdb->prepare( "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_galleriescontent` WHERE galId=%d ORDER BY `order` ASC", $galId );
		$grsGallerieImages = $wpdb->get_results( $query );

		return $grsGallerieImages;
	}

	private function getGalleryTItems() {
		global $wpdb;
		$grsGalleries = $wpdb->get_results( "SELECT `id`, `title` FROM `" . $wpdb->prefix . "limb_gallery_galleries` ORDER BY `id` DESC" );
		$this->result( 'success', $grsGalleries );
	}

	// Embed media
	private function embedMedia() {
		require_once( GRS_PLG_DIR . '/embed/GRSGalleryEmbed.php' );
		$embed = new GRSGalleryEmbed();
		$embed->checkProvider();
	}

	// Save order
	private function saveOrder() {
		global $wpdb;
		$id      = isset( $_POST['gallery'] ) ? (int) $_POST['gallery'] : 0;
		$items   = ( isset( $_POST['items'] ) && is_array( $_POST['items'] ) ) ? $_POST['items'] : array();
		$success = false;
		if ( $id && is_array( $items ) ) {
			foreach ( $items as $key => $item ) {
				$success = $wpdb->update( $wpdb->prefix . 'limb_gallery_galleriescontent',
					array(
						'order' => $item['order'],
					),
					array(
						'id' => $item['id']
					)
				);
				if ( $success === false ) {
					$this->result( 'error' );
					break;
				}
			}
		} else {
			$this->result( 'error', 'There is no items selected or' );
		}
		if ( $success !== false ) {
			$this->result( 'success', array() );
		} else {
			$this->result( 'error', 'Problem with Order saveing' );
		}
	}

	private function insert() {
		global $wpdb;
		$title       = ( isset( $_POST['title'] ) && $_POST['title'] != '' ) ? htmlspecialchars( stripslashes( $_POST['title'] ) ) : 'New gallery';
		$title       = $this->getUniqueName( 'limb_gallery_galleries', 'title', $title );
		$description = isset( $_POST['description'] ) ? htmlspecialchars( stripslashes( $_POST['description'] ) ) : '';
		$date        = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$createDate = date_format( $date, "Y-m-d H:i:s" );
		$success    = $wpdb->insert( $wpdb->prefix . 'limb_gallery_galleries',
			array(
				'title'         => $title,
				'description'   => $description,
				'prevImgName'   => 'grsnopv',
				'prevImgPath'   => '',
				'prevImgType'   => '.png',
				'prevImgWidth'  => 300,
				'prevImgHeight' => 300,
				'createDate'    => $createDate
			),
			array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%s'
			)
		);
		if ( $success !== false ) {
			$this->result( 'success', array( 'id' => $wpdb->insert_id, 'title' => $title ) );
		} else {
			$this->result( 'error', 'Problem with gallery save' );
		}
	}

	private function update() {
		global $wpdb;
		$id          = isset( $_POST['grsGallid'] ) ? (int) $_POST['grsGallid'] : 0;
		$title       = ( isset( $_POST['title'] ) && $_POST['title'] != '' ) ? htmlspecialchars_decode( stripslashes( $_POST['title'] ) ) : 'Gallery title';
		$title       = $this->getUniqueName( "limb_gallery_galleries", "title", $title, true, true, $id );
		$description = isset( $_POST['description'] ) ? htmlspecialchars_decode( stripslashes( $_POST['description'] ) ) : '';
		$grsImages   = isset( $_POST['grsImages'] ) ? json_decode( stripslashes( $_POST['grsImages'] ) ) : array();
		$successImg  = true;
		$date        = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$curDate = date_format( $date, "Y-m-d H:i:s" );
        $successGal = false;
		if ( $id ) {
			$successGal = $wpdb->update( $wpdb->prefix . 'limb_gallery_galleries',
				array(
					'title'        => $title,
					'description'  => $description,
					'lastmodified' => $curDate
				),
				array(
					'id' => $id
				)
			);
			if ( is_array( $grsImages ) ) {
				foreach ( $grsImages as $key => $grsImage ) {
					$successImg = $wpdb->update( $wpdb->prefix . 'limb_gallery_galleriescontent',
						array(
							'title'        => $grsImage->title,
							'description'  => $grsImage->description,
							'publish'      => $grsImage->publish,
							'order'        => $grsImage->order,
							'link'         => $grsImage->link,
							'lastmodified' => $curDate
						),
						array(
							'id' => $grsImage->id
						)
					);
					if ( $successImg === false ) {
						$this->result( 'error' );
						$this->result( 'error' );
						break;
					}
				}
			}
		}
		if ( $successGal !== false && $successImg !== false ) {
			$this->result( 'success', array( 'id' => $id, 'title' => $title ) );
		} else {
			$this->result( 'error', 'Problem with image or gallery update' );
		}
	}

	private function delete() {
		global $wpdb;
		$id         = isset( $_POST['grsGallid'] ) ? (int) $_POST['grsGallid'] : 0;
		$successGal = $wpdb->delete( $wpdb->prefix . 'limb_gallery_galleries', array( 'id' => $id ), array( '%d' ) );
		// $successIm = $wpdb->delete( $wpdb->prefix . 'limb_gallery_galleriescontent', array( 'galId' => $id ), array( '%d' ) );
		$deleteContent = $wpdb->delete( $wpdb->prefix . 'limb_gallery_albumscontent', array(
			'contentId' => $id,
			'type'      => 'gal'
		), array( '%d' ) );
		if ( $successGal || $deleteContent ) {
			$this->result( 'success', $successGal );
		} else {
			$this->result( 'error' );
		}
	}

	private function addImagesFromWP() {
		global $wpdb;
		$grsId     = isset( $_POST['grsId'] ) ? (int) $_POST['grsId'] : 0;
		$files     = ( isset( $_POST['files'] ) && is_array( $_POST['files'] ) ) ? $_POST['files'] : array();
		$insertIds = array();
		$date      = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$createDate = date_format( $date, "Y-m-d H:i:s" );
		$success    = false;
		foreach ( $files as $key => $file ) {
		    $success = $wpdb->insert( $wpdb->prefix . 'limb_gallery_galleriescontent',
				array(
					'galId'        => $grsId,
					'name'         => $file['name'],
					'title'        => $file['title'],
					'description'  => $file['description'],
					'path'         => $file['path'],
					'type'         => $file['type'],
					'embed'        => 'wp',
					'width'        => $file['width'],
					'height'       => $file['height'],
					'wp_sizes'     => json_encode($file['wp_sizes']),
					'publish'      => 1,
					'order'        => $file['order'],
					'createDate'   => $createDate,
					'lastmodified' => $createDate
				),
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%d',
					'%s',
					'%d',
					'%d',
					'%s',
					'%s',
				)
			);
			array_push( $insertIds, $wpdb->insert_id );
		}
		if ( $success !== false ) {
			$this->result( 'success', $insertIds );
		} else {
			$this->result( 'error', 'Problem with save' );
		}
	}

	private function addImages() {
		global $wpdb;
		$grsId     = isset( $_POST['grsId'] ) ? (int) $_POST['grsId'] : 0;
		$files     = ( isset( $_POST['files'] ) && is_array( $_POST['files'] ) ) ? $_POST['files'] : array();
		$path      = isset( $_POST['parentDirPath'] ) ? htmlspecialchars_decode( stripslashes( $_POST['parentDirPath'] ) ) : '';
		$types     = ( isset( $_POST['types'] ) && is_array( $_POST['types'] ) ) ? $_POST['types'] : array();
		$orders    = ( isset( $_POST['orders'] ) && is_array( $_POST['orders'] ) ) ? $_POST['orders'] : array();
		$insertIds = array();
		$date      = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$createDate = date_format( $date, "Y-m-d H:i:s" );
		$success    = false;
		foreach ( $files as $key => $file ) {
			$file      = htmlspecialchars_decode( stripslashes( $file ) );
			$file_path = parent::$uploadDir . $path . $file . $types[ $key ];
			if ( function_exists( 'getimagesize' ) ) {
				list( $width, $height ) = getimagesize( $file_path );
			} else {
				$this->result( 'error', 'Function not found: getimagesize. Please connect to plugin support.' );

				return;
			}
			$success = $wpdb->insert( $wpdb->prefix . 'limb_gallery_galleriescontent',
				array(
					'galId'        => $grsId,
					'name'         => $file,
					'title'        => $file,
					'description'  => '',
					'path'         => $path,
					'type'         => $types[ $key ],
					'width'        => $width,
					'height'       => $height,
					'publish'      => 1,
					'order'        => $orders[ $key ],
					'createDate'   => $createDate,
					'lastmodified' => $createDate
				),
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%d',
					'%d',
					'%d',
					'%s',
					'%s',
				)
			);
			array_push( $insertIds, $wpdb->insert_id );
		}
		if ( $success !== false ) {
			$this->result( 'success', $insertIds );
		} else {
			$this->result( 'error', 'Problem with save' );
		}
	}

	private function addPv( $table, $id ) {
		global $wpdb;
		$file      = ( isset( $_POST['files'] ) && is_array( $_POST['files'] ) ) ? htmlspecialchars_decode( stripslashes( $_POST['files'][0] ) ) : '';
		$path      = isset( $_POST['parentDirPath'] ) ? htmlspecialchars_decode( stripslashes( $_POST['parentDirPath'] ) ) : '';
		$type      = ( isset( $_POST['types'] ) && is_array( $_POST['types'] ) ) ? htmlspecialchars_decode( stripslashes( $_POST['types'][0] ) ) : '';
		$file_path = parent::$uploadDir . $path . $file . $type;
		$success   = false;
		// Clear white spaces
		// $file_path = str_replace(' ','%20', $file_path);
		if ( function_exists( 'getimagesize' ) ) {
			list( $width, $height ) = getimagesize( $file_path );
		} else {
			$this->result( 'error', 'Function not found: getimagesize. Please connect to plugin support.' );

			return;
		}
		if ( $id && $file != '' && $type != '' ) {
			$success = $wpdb->update( $wpdb->prefix . $table,
				array(
					'prevImgName'   => $file,
					'prevImgPath'   => $path,
					'prevImgType'   => $type,
					'prevImgWidth'  => $width,
					'prevImgHeight' => $height,
				),
				array(
					'id' => $id
				)
			);
		}
		if ( $success !== false ) {
			$this->result( 'success', $id );
		} else {
			$this->result( 'error', 'Problem with save' );
		}
	}

	private function addPwAIm() {
		$id = isset( $_POST['grsId'] ) ? (int) $_POST['grsId'] : 0;
		$this->addPv( 'limb_gallery_albums', $id );
	}

	private function addGPvIm() {
		$id = isset( $_POST['grsId'] ) ? (int) $_POST['grsId'] : 0;
		$this->addPv( 'limb_gallery_galleries', $id );
	}

	private function deleteImage() {
		global $wpdb;
		$id      = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		$success = $wpdb->delete( $wpdb->prefix . 'limb_gallery_galleriescontent', array( 'id' => $id ), array( '%d' ) );
		//$success (count of deleted rows)
		if ( $success !== false ) {
			$this->result( 'success', $success );
		} else {
			$this->result( 'error', 'Problem with delete' );
		}
	}

	private function deleteImages() {
		global $wpdb;
		$ids     = isset( $_POST['ids'] ) ? $_POST['ids'] : array();
		$success = 0;
		foreach ( $ids as $id ) {
			$success += $wpdb->delete( $wpdb->prefix . 'limb_gallery_galleriescontent', array( 'id' => $id ), array( '%d' ) );
		}
		if ( $success !== false ) {
			$this->result( 'success', $success );
		} else {
			$this->result( 'error', 'Problem with delete' );
		}
	}

	// Comments
	private function removeComments() {
		global $wpdb;
		$id = ( isset( $_POST['id'] ) && $_POST['id'] != '' ) ? (int) $_POST['id'] : 0;
		if ( $id ) {
			$query  = $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'limb_gallery_comments WHERE id="%d"', $id );
			$result = $wpdb->query( $query );
			if ( $result !== false ) {
				$this->result( 'success', $id );
			} else {
				$this->result( 'error', 'Problem with delete' );
			}
		} else {
			$this->result( 'error', 'Invalid comment id' );
		}
	}

	// Albums data
	private function getAlbumItems() {
		global $wpdb;
		$grsAlbums = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'limb_gallery_albums ORDER BY `id` DESC' );
		foreach ( $grsAlbums as $key => $grsAlbum ) :
			$query = $wpdb->prepare( "SELECT `" . $wpdb->prefix . "limb_gallery_albumscontent`.`id`,
			`" . $wpdb->prefix . "limb_gallery_albumscontent`.`albId`,
			`" . $wpdb->prefix . "limb_gallery_albumscontent`.`contentId`,
			`" . $wpdb->prefix . "limb_gallery_albumscontent`.`type`,
			`" . $wpdb->prefix . "limb_gallery_albums`.`title`,
			`" . $wpdb->prefix . "limb_gallery_albums`.`description`,
			`" . $wpdb->prefix . "limb_gallery_albums`.`prevImgName`,
			`" . $wpdb->prefix . "limb_gallery_albums`.`prevImgPath`, 
			`" . $wpdb->prefix . "limb_gallery_albums`.`prevImgType` FROM `" . $wpdb->prefix . "limb_gallery_albumscontent` INNER JOIN `" . $wpdb->prefix . "limb_gallery_albums` ON ( `" . $wpdb->prefix . "limb_gallery_albumscontent`.`contentId` = `" . $wpdb->prefix . "limb_gallery_albums`.`id` AND `" . $wpdb->prefix . "limb_gallery_albumscontent`.`type` = 'alb'  AND `" . $wpdb->prefix . "limb_gallery_albumscontent`.`albId` = %d) 
									UNION 
									SELECT `" . $wpdb->prefix . "limb_gallery_albumscontent`.`id`,
			`" . $wpdb->prefix . "limb_gallery_albumscontent`.`albId`,
			`" . $wpdb->prefix . "limb_gallery_albumscontent`.`contentId`,
			`" . $wpdb->prefix . "limb_gallery_albumscontent`.`type`,
			`" . $wpdb->prefix . "limb_gallery_galleries`.`title`,
			`" . $wpdb->prefix . "limb_gallery_galleries`.`description`,
			`" . $wpdb->prefix . "limb_gallery_galleries`.`prevImgName`,
			`" . $wpdb->prefix . "limb_gallery_galleries`.`prevImgPath`, 
			`" . $wpdb->prefix . "limb_gallery_galleries`.`prevImgType` FROM `" . $wpdb->prefix . "limb_gallery_albumscontent` INNER JOIN `" . $wpdb->prefix . "limb_gallery_galleries` ON ( `" . $wpdb->prefix . "limb_gallery_albumscontent`.`contentId` = `" . $wpdb->prefix . "limb_gallery_galleries`.`id` AND `" . $wpdb->prefix . "limb_gallery_albumscontent`.`type` = 'gal'  AND `" . $wpdb->prefix . "limb_gallery_albumscontent`.`albId` = %d) 
									", $grsAlbum->id, $grsAlbum->id );
			// var_dump($query);
			// die();
			$grsAlbumContent   = $wpdb->get_results( $query );
			$grsAlbum->content = $grsAlbumContent;
		endforeach;
		$this->result( 'success', $grsAlbums );
	}

	private function addContentForAlbum() {
		global $wpdb;
		$wpdb->hide_errors();
		$albId     = isset( $_POST['albId'] ) ? (int) $_POST['albId'] : 0;
		$contentId = isset( $_POST['contentId'] ) ? (int) $_POST['contentId'] : 0;
		$type      = ( isset( $_POST['type'] ) && $_POST['type'] != '' ) ? (string) $_POST['type'] : '';
		if ( $albId != 0 ) {
			$save = $wpdb->insert( $wpdb->prefix . 'limb_gallery_albumscontent',
				array(
					'albId'     => $albId,
					'contentId' => $contentId,
					'type'      => $type
				),
				array(
					'%d',
					'%d',
					'%s'
				)
			);
		} else {
			$save = false;
		}
		if ( $save !== false ) {
			$result  = 'success';
			$message = $wpdb->insert_id;
		} else {
			$message = 'You are trying to duplicate content or there is some other problem.';
			$result  = 'error';
		}
		$this->result( $result, $message );

		return;
	}

	private function deleteContentFromAlbum() {
		global $wpdb;
		$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		if ( $id ) {
			$delete = $wpdb->delete( $wpdb->prefix . 'limb_gallery_albumscontent',
				array(
					'id' => $id
				)
			);
			if ( $delete !== false ) {
				$result  = 'success';
				$message = 'Succesfully delete';
			} else {
				$message = 'Problem with save';
				$result  = 'error';
			}
		} else {
			$message = 'Oh there is a problem';
			$result  = 'error';
		}
		$this->result( $result, $message );

		return;
	}

	private function addUpdateAlbum() {
		global $wpdb;
		$wpdb->show_errors();
		$album       = ( isset( $_POST['album'] ) && is_array( $_POST['album'] ) ) ? $_POST['album'] : array();
		$id          = ( isset( $album['id'] ) && $album['id'] != '' ) ? (int) $album['id'] : 0;
		$save        = false;
		$title       = ( isset( $album['title'] ) && $album['title'] != '' ) ? htmlspecialchars_decode( stripslashes( $album['title'] ) ) : 'New Album';
		$update      = ( $id != 0 ) ? true : false;
		$title       = $this->getUniqueName( "limb_gallery_albums", "title", $title, true, $update, $id );
		$description = ( isset( $album['description'] ) && $album['description'] != '' ) ? htmlspecialchars_decode( stripslashes( $album['description'] ) ) : '';
		$prevImgName = ( isset( $album['prevImgName'] ) && $album['prevImgName'] != '' ) ? htmlspecialchars_decode( stripslashes( $album['prevImgName'] ) ) : 'grsnopv';
		$prevImgPath = ( isset( $album['prevImgPath'] ) && $album['prevImgPath'] != '' ) ? htmlspecialchars_decode( stripslashes( $album['prevImgPath'] ) ) : '';
		$prevImgType = ( isset( $album['prevImgType'] ) && $album['prevImgType'] != '' ) ? htmlspecialchars_decode( stripslashes( $album['prevImgType'] ) ) : '.png';
		$date        = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$curDate = date_format( $date, "Y-m-d H:i:s" );
		if ( $id == 0 ) {
			$save = $wpdb->insert( $wpdb->prefix . 'limb_gallery_albums',
				array(
					'title'         => $title,
					'description'   => $description,
					'prevImgName'   => $prevImgName,
					'prevImgPath'   => $prevImgPath,
					'prevImgType'   => $prevImgType,
					'prevImgWidth'  => 300,
					'prevImgHeight' => 300,
					'createDate'    => $curDate
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%d',
					'%s'
				)
			);
		} else {
			$save = $wpdb->update( $wpdb->prefix . 'limb_gallery_albums',
				array(
					'title'        => $title,
					'description'  => $description,
					'lastmodified' => $curDate,
				),
				array(
					'id' => $id
				)
			);
		}
		if ( $save !== false ) {
			$result  = 'success';
			$message = ( $id == 0 ) ? array( $wpdb->insert_id, $title ) : array( $title );
		} else {
			$wpdb->print_error();
			$message = 'Problem with save';
			$result  = 'error';
		}
		$this->result( $result, $message );

		return;
	}

	private function deleteAlbum() {
		global $wpdb;
		$ids = ( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) ? $_POST['ids'] : array();
		if ( count( $ids ) ) {
			foreach ( $ids as $key => $i ) {
				$ids[ $key ] = (int) $i;
			}
			$ids_string = implode( $ids, "," );
			//echo $ids_string;
			$delete        = $wpdb->query( "DELETE FROM `" . $wpdb->prefix . "limb_gallery_albums` WHERE id IN(" . $ids_string . ")" );
			$deleteContent = $wpdb->query( "DELETE FROM `" . $wpdb->prefix . "limb_gallery_albumscontent` WHERE `type`='alb' AND `contentId` IN(" . $ids_string . ")" );
			if ( $delete !== false ) {
				$result  = 'success';
				$message = 'Succesfully delete';
			} else {
				$message = 'Problem with save';
				$result  = 'error';
			}
		} else {
			$message = 'Error something went wrong';
			$result  = 'error';
		}
		$this->result( $result, $message );

		return;
	}

	// Settings data
	private function saveSettings() {
		global $wpdb;
		$settings = isset( $_POST['settings'] ) ? $_POST['settings'] : array();
		$date     = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$lastmodified = date_format( $date, "Y-m-d H:i:s" );
		$grsConfig    = GRS_PLG_DIR . '/js/grsConfig.json';
		$handle       = fopen( $grsConfig, "r" );
		$content      = fread( $handle, filesize( $grsConfig ) );
		fclose( $handle );
		$conf = json_decode( $content );
		$save = $wpdb->update( $wpdb->prefix . "limb_gallery_settings",
			array(
				'timezone'          => ( $conf->comments ? $settings['timezone'] : 'UTC' ),
				'timeformat'        => ( $conf->comments ? stripslashes( $settings['timeformat'] ) : 'F d y h:i:s' ),
				'collapseNavClicks' => ( $conf->effects ? $settings['collapseNavClicks'] : 1 ),
				'clicksCount'       => ( $conf->effects ? $settings['clicksCount'] : 2 ),
				'hideNavButton'     => ( $conf->effects ? $settings['hideNavButton'] : 0 ),
				'closeLbOnSide'     => ( $conf->effects ? $settings['closeLbOnSide'] : 1 ),
				'openCommTrig'      => ( $conf->comments ? $settings['openCommTrig'] : 0 ),
				'showTitleDescTrig' => $settings['showTitleDescTrig'],
				'fmImMoveCount'     => ( $conf->filmstrip ? $settings['fmImMoveCount'] : 2 ),
				'filmImMoveCount'   => ( $conf->filmstrip ? $settings['filmImMoveCount'] : 2 ),
				'lastmodified'      => $lastmodified
			),
			array(
				'default' => 1
			)
		);
		if ( $save !== false ) {
			$this->result( 'success', $save );
		} else {
			$this->result( 'error', 'Problem with delete' );
		}

		return;
	}

	private function getSettings() {
		global $wpdb;
		$grsSettings       = $wpdb->get_row( "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_settings` WHERE `default`=1" );
		$data              = new stdclass();
		$data->settings    = ( $grsSettings != null ) ? $grsSettings : ( new stdclass() );
		$data->timezones   = timezone_identifiers_list();
		$data->timeformats = array(
			"Y-M-d"                                                => "2016-Jun-01",
			"g:ia " . ( htmlspecialchars( '\o\n' ) ) . " l jS F Y" => "5:45pm on Wednesday 1st June 2016",
			"l jS F Y"                                             => "Wednesday 1st June 2016",
			"jS F Y"                                               => "1st June 2016",
			"Y-m-d H:i:s"                                          => "2016-06-01 17:45:12",
			"d/m/Y H:i:s"                                          => "01/06/2016 17:45:12",
			"d/m/y"                                                => "01/06/16",
			"Y.m.d"                                                => "2016.06.01",
			"l, F d y h:i:s"                                       => "Wednesday, June 01 16 17:45:12",
			"F d y h:i:s"                                          => "June 01 16 17:45:12",
		);
		$this->result( 'success', $data, true );
	}

	private function uninstall() {
		require_once( GRS_PLG_DIR . '/smart/GRSGallerySmart.php' );
		$result = new GRSGallerySmart();
		$result = $result->uninstall();
		if ( $result !== false ) {
			$this->result( 'success', $result );
		} else {
			$this->result( 'error', 'Problem with uninstall' );
		}

		return;
	}

	private function setDefault() {
		global $wpdb;
		$id = isset( $_POST['id'] ) ? $_POST['id'] : 0;
		if ( $id ) {
			$unsetDefault = $wpdb->update( $wpdb->prefix . 'limb_gallery_themes',
				array(
					'default' => 0
				),
				array(
					'default' => 1
				)
			);
			if ( $unsetDefault !== false ) {
				$setDefault = $wpdb->update( $wpdb->prefix . 'limb_gallery_themes',
					array(
						'default' => 1
					),
					array(
						'id' => $id
					)
				);
				if ( $setDefault !== false ) {
					$result  = 'success';
					$message = 'Succesfully update';
				} else {
					$message = 'Problem with save';
					$result  = 'error';
				}
			} else {
				$message = 'Problem with save';
				$result  = 'error';
			}
		} else {
			$message = 'Oh there is a problem';
			$result  = 'error';
		}
		$this->result( $result, $message );

		return;
	}

	// Themes data
	private function getThemeItems() {
		global $wpdb;
		$data      = new stdClass();
		$grsThemes = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_themes`" );

		// return $grsThemes;
		$newTheme        = $this->getNewTheme();
		$data->grsThemes = $grsThemes;
		foreach ( $data->grsThemes as $key => $value ) {
			$value->film       = json_decode( $value->film );
			$value->thumbnail  = json_decode( $value->thumbnail );
			$value->mosaic     = json_decode( $value->mosaic );
			$value->masonry    = json_decode( $value->masonry );
			$value->navigation = json_decode( $value->navigation );
			$value->lightbox   = json_decode( $value->lightbox );
		}
		$data->newTheme = $newTheme;
		$this->result( 'success', $data, true );
	}

	private function addTheme() {
		global $wpdb;
		$newTheme       = $this->getNewTheme();
		$newTheme->name = $this->getUniqueName( "limb_gallery_themes", "name", $newTheme->name, true, false, 0 );
		$date           = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$curDate = date_format( $date, "Y-m-d H:i:s" );
		$wpdb->show_errors();
		$save = $wpdb->insert( $wpdb->prefix . 'limb_gallery_themes',
			array(
				'default'      => 0,
				'name'         => $newTheme->name,
				'createDate'   => $curDate,
				'lastmodified' => $curDate,
				'thumbnail'    => json_encode( $newTheme->thumbnail ),
				'film'         => json_encode( $newTheme->film ),
				'mosaic'       => json_encode( $newTheme->mosaic ),
				'masonry'      => json_encode( $newTheme->masonry ),
				'navigation'   => json_encode( $newTheme->navigation ),
				'lightbox'     => json_encode( $newTheme->lightbox ),
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
				'%s',
			)
		);
		if ( $save !== false ) {
			$newTheme->id = $wpdb->insert_id;
			$result       = $this->saveThemeToFile( $newTheme->id ) ? 'success' : 'error';
			$message      = $result == 'success' ? $newTheme : 'Unable to create css file.';
		} else {
			$wpdb->print_error();
			$message = 'Problem with save';
			$result  = 'error';
		}
		$this->result( $result, $message );

		return;
	}

	private function updateTheme() {
		global $wpdb;
		$theme = isset( $_POST['theme'] ) ? $_POST['theme'] : array();
		$date  = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$curDate = date_format( $date, "Y-m-d H:i:s" );
//print_r($theme);
//die();
		$id   = ( isset( $theme['id'] ) && $theme['id'] != '' ) ? (int) $theme['id'] : 0;
		$name = ( isset( $theme['name'] ) && $theme['name'] != '' ) ? stripslashes( $theme['name'] ) : 'New Theme';
		$name = $this->getUniqueName( "limb_gallery_themes", "name", $name, true, true, $id );
		$save = $wpdb->update( $wpdb->prefix . 'limb_gallery_themes',
			array(
				'name'         => $name,
				'lastmodified' => $curDate,
				'thumbnail'    => json_encode( $theme['thumbnail'] ),
				'film'         => json_encode( $theme['film'] ),
				'mosaic'       => json_encode( $theme['mosaic'] ),
				'masonry'      => json_encode( $theme['masonry'] ),
				'navigation'   => json_encode( $theme['navigation'] ),
				'lightbox'     => json_encode( $theme['lightbox'] ),
			),
			array(
				'id' => $id
			)
		);
		if ( $save !== false ) {
			$result  = $this->saveThemeToFile( $id ) ? 'success' : 'error';
			$message = $result == 'success' ? array( $name ) : 'Unable to create css file.';
		} else {
			$message = 'Problem with save';
			$result  = 'error';
		}
		$this->result( $result, $message );

		return;
	}

	private function saveThemeToFile( $id ) {
		global $wpdb;
		$grsTheme = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `id` = %d", $id ) );
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
		$thumbnailCss     = $thumbnailCssObj->get_( $id, json_decode( $grsTheme->thumbnail ) );
		$filmCss          = $filmCssObj->get_( $id, json_decode( $grsTheme->film ) );
		$masonryCss       = $masonryCssObj->get_( $id, json_decode( $grsTheme->masonry ) );
		$mosaicCss        = $mosaicCssObj->get_( $id, json_decode( $grsTheme->mosaic ) );
		$lightboxCss      = $lightboxCssObj->get_( $id, json_decode( $grsTheme->lightbox ) );
		$navigationCss    = $navigationCssObj->get_( $id, json_decode( $grsTheme->navigation ) );

		$grsTemplate = fopen( GRS_PLG_DIR . '/css/grsTemplate' . $id . '.css', "w" );
		$css         = $thumbnailCss . $filmCss . $masonryCss . $mosaicCss . $lightboxCss . $navigationCss;
		// Minimize process
		$css   = trim( preg_replace( '/\s\s+/', ' ', $css ) );
		$bytes = fwrite( $grsTemplate, $css );
		fclose( $grsTemplate );

		return $bytes;
	}

	private function deleteTheme() {
		global $wpdb;
		$id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		if ( $id ) {
			$delete = $wpdb->delete( $wpdb->prefix . 'limb_gallery_themes',
				array(
					'id' => $id
				)
			);
			if ( $delete !== false ) {
				$result  = 'success';
				$message = 'Succesfully delete';
			} else {
				$message = 'Problem with save';
				$result  = 'error';
			}
		} else {
			$message = 'Oh there is a problem';
			$result  = 'error';
		}
		$this->result( $result, $message );

		return;
	}

	private function getNewTheme() {
		$newTheme             = new stdclass();
		$newTheme->id         = 0;
		$newTheme->default    = 0;
		$newTheme->name       = 'New theme';
		$newTheme->thumbnail  = new stdclass();
		$newTheme->film       = new stdclass();
		$newTheme->masonry    = new stdclass();
		$newTheme->mosaic     = new stdclass();
		$newTheme->navigation = new stdclass();
		$newTheme->lightbox   = new stdclass();
		/*Thumbnail*/
		$newTheme->thumbnail->thumbnailmargin          = 5;
		$newTheme->thumbnail->thumbnailpadding         = 0;
		$newTheme->thumbnail->thumbnailBorderWidth     = 1;
		$newTheme->thumbnail->thumbnailBorderStyle     = 'none';
		$newTheme->thumbnail->thumbnailBorderColor     = 'rgba(142,155,151,1)';
		$newTheme->thumbnail->thumbnailHoverEffect     = 'none';
		$newTheme->thumbnail->thumbnailBorderRadius    = 0;
		$newTheme->thumbnail->thumbnailMaskColor       = 'rgba(255,255,255,0.75)';
		$newTheme->thumbnail->thumbnailTpadding        = 10;
		$newTheme->thumbnail->thumbnailTBgcolor        = 'rgba(255,255,255,0.8)';
		$newTheme->thumbnail->thumbnailTFSize          = 18;
		$newTheme->thumbnail->thumbnailTcolor          = 'rgba(94,94,94,1)';
		$newTheme->thumbnail->thumbnailTFFamily        = 'sans-serif';
		$newTheme->thumbnail->thumbnailTFWeight        = 'bold';
		$newTheme->thumbnail->thumbnailTFstyle         = 'normal';
		$newTheme->thumbnail->thumbnailTEffect         = 'grsTransUp';
		$newTheme->thumbnail->thumbnailTpos            = 'bottom';
		$newTheme->thumbnail->thumbnailBoxshadowFstVal = 0;
		$newTheme->thumbnail->thumbnailBoxshadowSecVal = 0;
		$newTheme->thumbnail->thumbnailBoxshadowThdVal = 0;
		$newTheme->thumbnail->thumbnailBoxshadowColor  = 'rgba(0,0,0,1)';
		$newTheme->thumbnail->thumbnailBgColor         = 'rgba(255,255,255,0)';
		/*Film*/
		$newTheme->film->fmBgColor              = "rgba(255,255,255,0)";
		$newTheme->film->fmMargin               = "2";
		$newTheme->film->fmHoverEffect          = "none";
		$newTheme->film->fmThumbBorderWidth     = "0";
		$newTheme->film->fmThumbBorderStyle     = "none";
		$newTheme->film->fmThumbBorderColor     = "rgba(0,0,0,1)";
		$newTheme->film->fmThumbMargin          = "10";
		$newTheme->film->fmThumbPadding         = "5";
		$newTheme->film->fmThumbBoxshadowFstVal = "0";
		$newTheme->film->fmThumbBoxshadowSecVal = "0";
		$newTheme->film->fmThumbBoxshadowThdVal = "3";
		$newTheme->film->fmThumbBoxshadowColor  = "rgba(0,0,0,1)";
		$newTheme->film->fmThumbBgColor         = "rgba(255,255,255,1)";
		$newTheme->film->fmNavButtons           = "chevron";
		$newTheme->film->fmNavWidth             = "45";
		$newTheme->film->fmNavBgColor           = "rgba(0,0,0,0.28)";
		$newTheme->film->fmNavBoxshadowFstVal   = "0";
		$newTheme->film->fmNavBoxshadowSecVal   = "0";
		$newTheme->film->fmNavBoxshadowThdVal   = "0";
		$newTheme->film->fmNavBoxshadowColor    = "rgba(0,0,0,0)";
		$newTheme->film->fmNavBorderWidth       = "0";
		$newTheme->film->fmNavBorderStyle       = "none";
		$newTheme->film->fmNavBorderColor       = "rgba(0,0,0,0.42)";
		$newTheme->film->fmTpadding             = "15";
		$newTheme->film->fmTBgcolor             = "rgba(0,0,0,0.4)";
		$newTheme->film->fmTFSize               = "18";
		$newTheme->film->fmTcolor               = "rgba(255,255,255,1)";
		$newTheme->film->fmTFFamily             = "sans-serif";
		$newTheme->film->fmTFWeight             = "bold";
		$newTheme->film->fmTFstyle              = "normal";
		$newTheme->film->fmThumbTeffect         = "grsFadeIn";
		$newTheme->film->fmTpos                 = "middle";
		$newTheme->film->fmNavBorderRadius      = "22.5";
		$newTheme->film->fmNavColor             = "rgba(255,255,255,1)";
		$newTheme->film->fmNavHeight            = "45";
		$newTheme->film->fmNavHoverBgColor      = "rgba(0,0,0,0.51)";
		$newTheme->film->fmNavHoverColor        = "rgba(255,255,255,1)";
		$newTheme->film->fmNavOffset            = "25";
		$newTheme->film->fmNavSize              = "25";
		/*Masonry*/
		$newTheme->masonry->masonrymargin          = 5;
		$newTheme->masonry->masonryPadding         = 0;
		$newTheme->masonry->masonryBorderWidth     = 1;
		$newTheme->masonry->masonryBorderStyle     = 'none';
		$newTheme->masonry->masonryBorderColor     = 'rgba(0,0,0,1)';
		$newTheme->masonry->masonryHoverEffect     = 'none';
		$newTheme->masonry->masonryBorderRadius    = 0;
		$newTheme->masonry->masonryBoxshadowFstVal = 0;
		$newTheme->masonry->masonryBoxshadowSecVal = 0;
		$newTheme->masonry->masonryBoxshadowThdVal = 0;
		$newTheme->masonry->masonryBoxshadowColor  = 'rgba(255,255,255,1)';
		$newTheme->masonry->masonryBgColor         = 'rgba(255,255,255,0)';
		$newTheme->masonry->masonryTpadding        = 10;
		$newTheme->masonry->masonryTBgcolor        = 'rgba(255,255,255,0.8)';
		$newTheme->masonry->masonryTFSize          = 18;
		$newTheme->masonry->masonryTcolor          = 'rgba(94,94,94,1)';
		$newTheme->masonry->masonryTFFamily        = 'sans-serif';
		$newTheme->masonry->masonryTFWeight        = 'bold';
		$newTheme->masonry->masonryTFstyle         = 'normal';
		$newTheme->masonry->masonryTEffect         = 'grsSlideInLeft';
		$newTheme->masonry->masonryTpos            = 'middle';
		/*Mosaic**/
		$newTheme->mosaic->mosaicPadding         = 0;
		$newTheme->mosaic->mosaicBorderWidth     = 1;
		$newTheme->mosaic->mosaicBorderStyle     = 'none';
		$newTheme->mosaic->mosaicBorderColor     = 'rgba(0,0,0,1)';
		$newTheme->mosaic->mosaicHoverEffect     = 'scaleRotIm';
		$newTheme->mosaic->mosaicBorderRadius    = 0;
		$newTheme->mosaic->mosaicBoxshadowFstVal = 0;
		$newTheme->mosaic->mosaicBoxshadowSecVal = 0;
		$newTheme->mosaic->mosaicBoxshadowThdVal = 0;
		$newTheme->mosaic->mosaicBoxshadowColor  = 'rgba(0,0,0,1)';
		$newTheme->mosaic->mosaicBgColor         = 'rgba(255,255,255,0)';
		$newTheme->mosaic->mosaicMargin          = 5;
		$newTheme->mosaic->mosaicTpadding        = 10;
		$newTheme->mosaic->mosaicTBgcolor        = 'rgba(255,255,255,0.8)';
		$newTheme->mosaic->mosaicTFSize          = 18;
		$newTheme->mosaic->mosaicTcolor          = 'rgba(94,94,94,1)';
		$newTheme->mosaic->mosaicTFFamily        = 'sans-serif';
		$newTheme->mosaic->mosaicTFWeight        = 'bold';
		$newTheme->mosaic->mosaicTFstyle         = 'normal';
		$newTheme->mosaic->mosaicTEffect         = 'grsFadeIn';
		$newTheme->mosaic->mosaicTpos            = 'bottom';
		/*Navigation*/
		$newTheme->navigation->pnavCMarginT         = 30;
		$newTheme->navigation->pnavAlign            = 'center';
		$newTheme->navigation->pnavBMargin          = 5;
		$newTheme->navigation->pnavBPadding         = 12;
		$newTheme->navigation->pnavBBorderWidth     = 1;
		$newTheme->navigation->pnavBBorderStyle     = 'solid';
		$newTheme->navigation->pnavBBorderColor     = 'rgba(168,168,168,0.65)';
		$newTheme->navigation->pnavBBoxshadowFstVal = 0;
		$newTheme->navigation->pnavBBoxshadowSecVal = 0;
		$newTheme->navigation->pnavBBoxshadowThdVal = 0;
		$newTheme->navigation->pnavBBoxshadowColor  = 'rgba(255,255,255,1)';
		$newTheme->navigation->pnavBBgColor         = 'rgba(255,255,255,0.73)';
		$newTheme->navigation->pnavBHBgColor        = 'rgba(242,242,242,1)';
		$newTheme->navigation->pnavBABgColor        = 'rgba(194,194,194,1)';
		$newTheme->navigation->pnavBBorderRadius    = 1;
		$newTheme->navigation->pnavBFSize           = 12;
		$newTheme->navigation->pnavBcolor           = 'rgba(0,0,0,1)';
		$newTheme->navigation->pnavBFFamily         = 'sans-serif';
		$newTheme->navigation->pnavBFWeight         = '400';
		$newTheme->navigation->pnavBFstyle          = 'normal';
		$newTheme->navigation->backBorderStyle      = 'solid';
		$newTheme->navigation->backBorderWidth      = 1;
		$newTheme->navigation->backBorderColor      = 'rgba(168,168,168,0.72)';
		$newTheme->navigation->backBoxshadowFstVal  = 0;
		$newTheme->navigation->backBoxshadowSecVal  = 0;
		$newTheme->navigation->backBoxshadowThdVal  = 0;
		$newTheme->navigation->backBoxshadowColor   = 'rgba(255,255,255,0)';
		$newTheme->navigation->backBgColor          = 'rgba(255,255,255,0.73)';
		$newTheme->navigation->backHBgColor         = 'rgba(242,242,242,1)';
		$newTheme->navigation->backBorderRadius     = 1;
		$newTheme->navigation->backFSize            = 12;
		$newTheme->navigation->backColor            = 'rgba(0,0,0,1)';
		/*Lightbox*/
		$newTheme->lightbox->bgColor                     = "rgba(0, 0, 0, 0.63)";
		$newTheme->lightbox->closeButtBgColor            = "rgba(255,255,255,0)";
		$newTheme->lightbox->closeButtSize               = "24";
		$newTheme->lightbox->closeButtBoxshadowFstVal    = "0";
		$newTheme->lightbox->closeButtBoxshadowSecVal    = "0";
		$newTheme->lightbox->closeButtBoxshadowThdVal    = "0";
		$newTheme->lightbox->closeButtBoxshadowColor     = "rgba(122,122,122,0.87)";
		$newTheme->lightbox->closeButtBorderWidth        = "0";
		$newTheme->lightbox->closeButtBorderStyle        = "none";
		$newTheme->lightbox->closeButtBorderColor        = "rgba(255,255,255,1)";
		$newTheme->lightbox->titleDescpFWith             = "1";
		$newTheme->lightbox->titleDescpWith              = "200";
		$newTheme->lightbox->titleDescpPos               = "bottomCenter";
		$newTheme->lightbox->titleDescpMargin            = "24";
		$newTheme->lightbox->titleDescpPadding           = "20";
		$newTheme->lightbox->titleDescpBgColor           = "rgba(0,0,0,1)";
		$newTheme->lightbox->titleDescpTColor            = "rgba(255,255,255,1)";
		$newTheme->lightbox->titleDescpDColor            = "rgba(255,255,255,1)";
		$newTheme->lightbox->titleDescpshadowFstVal      = "0";
		$newTheme->lightbox->titleDescpshadowSecVal      = "0";
		$newTheme->lightbox->titleDescpshadowThdVal      = "0";
		$newTheme->lightbox->titleDescpshadowColor       = "rgba(255,255,255,0)";
		$newTheme->lightbox->titleDescpTffamily          = "sans-serif";
		$newTheme->lightbox->titleDescpTfsize            = "20";
		$newTheme->lightbox->titleDescpDfsize            = "15";
		$newTheme->lightbox->titleDescpTfweight          = "bold";
		$newTheme->lightbox->titleDescpDfweight          = "500";
		$newTheme->lightbox->titleDescpBrad              = "2";
		$newTheme->lightbox->imgcoPos                    = "bottomRight";
		$newTheme->lightbox->imgcoMargin                 = "24";
		$newTheme->lightbox->imgcoPadding                = "3";
		$newTheme->lightbox->imgcoBgColor                = "rgba(0,0,0,0)";
		$newTheme->lightbox->imgcoColor                  = "rgba(255,255,255,1)";
		$newTheme->lightbox->imgcoshadowFstVal           = "0";
		$newTheme->lightbox->imgcoshadowSecVal           = "0";
		$newTheme->lightbox->imgcoshadowThdVal           = "0";
		$newTheme->lightbox->imgcoshadowColor            = "rgba(255,255,255,0)";
		$newTheme->lightbox->imgcoBrad                   = "4";
		$newTheme->lightbox->imgcoffamily                = "sans-serif";
		$newTheme->lightbox->imgcofsize                  = "11";
		$newTheme->lightbox->imgcofweight                = "bold";
		$newTheme->lightbox->navButtons                  = "angle";
		$newTheme->lightbox->navButtBgColor              = "rgba(255,255,255,0)";
		$newTheme->lightbox->navButtBoxshadowFstVal      = "0";
		$newTheme->lightbox->navButtBoxshadowSecVal      = "0";
		$newTheme->lightbox->navButtBoxshadowThdVal      = "0";
		$newTheme->lightbox->navButtBoxshadowColor       = "rgba(99,99,99,0)";
		$newTheme->lightbox->navButtBorderWidth          = "1";
		$newTheme->lightbox->navButtBorderStyle          = "none";
		$newTheme->lightbox->navButtBorderColor          = "rgba(255,255,255,1)";
		$newTheme->lightbox->navButtBorderRadius         = "0";
		$newTheme->lightbox->navButtSize                 = "50";
		$newTheme->lightbox->navButtMargin               = "30";
		$newTheme->lightbox->navButtHoverEffect          = "fade";
		$newTheme->lightbox->navButtShButts              = "onhover";
		$newTheme->lightbox->filmstripSize               = "60";
		$newTheme->lightbox->filmstripBgColor            = "rgba(0,0,0,1)";
		$newTheme->lightbox->filmstripPos                = "bottom";
		$newTheme->lightbox->filmThumbWidth              = "90";
		$newTheme->lightbox->filmThumbBorderWidth        = "0";
		$newTheme->lightbox->filmThumbBorderStyle        = "none";
		$newTheme->lightbox->filmThumbBorderColor        = "rgba(115,115,115,0)";
		$newTheme->lightbox->filmThumbMargin             = "7";
		$newTheme->lightbox->filmThumbPadding            = "0";
		$newTheme->lightbox->filmThumbBoxshadowFstVal    = "0";
		$newTheme->lightbox->filmThumbBoxshadowSecVal    = "0";
		$newTheme->lightbox->filmThumbBoxshadowThdVal    = "0";
		$newTheme->lightbox->filmThumbBoxshadowColor     = "rgba(255,255,255,1)";
		$newTheme->lightbox->filmThumbBgColor            = "rgba(255,255,255,1)";
		$newTheme->lightbox->filmThumbSelEffect          = "border";
		$newTheme->lightbox->filmNavButtons              = "arrow";
		$newTheme->lightbox->filmNavWidth                = "27";
		$newTheme->lightbox->filmNavBgColor              = "rgba(218,218,218,0.64)";
		$newTheme->lightbox->filmNavBoxshadowFstVal      = "0";
		$newTheme->lightbox->filmNavBoxshadowSecVal      = "0";
		$newTheme->lightbox->filmNavBoxshadowThdVal      = "0";
		$newTheme->lightbox->filmNavBoxshadowColor       = "rgba(115,115,115,1)";
		$newTheme->lightbox->filmNavBorderWidth          = "0";
		$newTheme->lightbox->filmNavBorderStyle          = "none";
		$newTheme->lightbox->filmNavBorderColor          = "rgba(0,0,0,0.52)";
		$newTheme->lightbox->contButtContBgcolor         = "rgba(0,0,0,0.72)";
		$newTheme->lightbox->contButtContBoxshadowFstVal = "0";
		$newTheme->lightbox->contButtContBoxshadowSecVal = "0";
		$newTheme->lightbox->contButtContBoxshadowThdVal = "0";
		$newTheme->lightbox->contButtContBoxshadowColor  = "rgba(255,255,255,0)";
		$newTheme->lightbox->contButtBgColor             = "rgba(218,218,218,0.19)";
		$newTheme->lightbox->contButtSize                = "15";
		$newTheme->lightbox->contButtBoxshadowFstVal     = "0";
		$newTheme->lightbox->contButtBoxshadowSecVal     = "0";
		$newTheme->lightbox->contButtBoxshadowThdVal     = "0";
		$newTheme->lightbox->contButtBoxshadowColor      = "rgba(84,84,84,0.5)";
		$newTheme->lightbox->contButtBorderWidth         = "2";
		$newTheme->lightbox->contButtBorderStyle         = "none";
		$newTheme->lightbox->contButtBorderColor         = "rgba(255,255,255,0)";
		$newTheme->lightbox->contButtcontMargin          = "10";
		$newTheme->lightbox->contButtMargin              = "10";
		$newTheme->lightbox->contButtContBorderWidth     = "2";
		$newTheme->lightbox->contButtContBorderStyle     = "none";
		$newTheme->lightbox->contButtContBorderColor     = "rgba(255,255,255,1)";
		$newTheme->lightbox->contButtOnhover             = "1";
		$newTheme->lightbox->commContBgcolor             = "rgba(0,0,0,1)";
		$newTheme->lightbox->commContMargin              = "35";
		$newTheme->lightbox->commContMarginH             = "10";
		$newTheme->lightbox->commFontSize                = "12";
		$newTheme->lightbox->commFontColor               = "rgba(255,255,255,1)";
		$newTheme->lightbox->commFontFamily              = "inherit";
		$newTheme->lightbox->commFontWeight              = "600";
		$newTheme->lightbox->commFontStyle               = "inherit";
		$newTheme->lightbox->commButtBgcolor             = "rgba(0,0,0,1)";
		$newTheme->lightbox->commButtHBgcolor            = "rgba(0,0,0,1)";
		$newTheme->lightbox->commButtBoxshadowFstVal     = "0";
		$newTheme->lightbox->commButtBoxshadowSecVal     = "0";
		$newTheme->lightbox->commButtBoxshadowThdVal     = "0";
		$newTheme->lightbox->commButtBoxshadowColor      = "rgba(255,255,255,1)";
		$newTheme->lightbox->commButtSize                = "15";
		$newTheme->lightbox->commInpFSize                = "12";
		$newTheme->lightbox->commInpColor                = "rgba(255,255,255,0.67)";
		$newTheme->lightbox->commInpFFamily              = "inherit";
		$newTheme->lightbox->commInpFWeight              = "inherit";
		$newTheme->lightbox->commInpFFstyle              = "inherit";
		$newTheme->lightbox->commInpBoxshadowFstVal      = "0";
		$newTheme->lightbox->commInpBoxshadowSecVal      = "0";
		$newTheme->lightbox->commInpBoxshadowThdVal      = "0";
		$newTheme->lightbox->commInpBoxshadowColor       = "rgba(209,209,209,1)";
		$newTheme->lightbox->commInpBorderWidth          = "1";
		$newTheme->lightbox->commInpBorderStyle          = "solid";
		$newTheme->lightbox->commInpBorderColor          = "rgba(99,99,99,1)";
		$newTheme->lightbox->commInpBgColor              = "rgba(0,0,0,1)";
		$newTheme->lightbox->commInpBorderRadius         = "2";
		$newTheme->lightbox->commInpAcBorderColor        = "rgba(255,255,255,0.87)";
		$newTheme->lightbox->commInpAcBoxshadowFstVal    = "0";
		$newTheme->lightbox->commInpAcBoxshadowSecVal    = "0";
		$newTheme->lightbox->commInpAcBoxshadowThdVal    = "0";
		$newTheme->lightbox->commInpAcBoxshadowColor     = "rgba(255,255,255,0)";
		$newTheme->lightbox->commButtColor               = "rgba(255,255,255,1)";
		$newTheme->lightbox->commButtBorderRadius        = "3";
		$newTheme->lightbox->commButtBorderWidth         = "1";
		$newTheme->lightbox->commButtBorderStyle         = "solid";
		$newTheme->lightbox->commButtBorderColor         = "rgba(161,161,161,1)";
		$newTheme->lightbox->commClButtSize              = "14";
		$newTheme->lightbox->commClButtBoxshadowFstVal   = "0";
		$newTheme->lightbox->commClButtBoxshadowSecVal   = "0";
		$newTheme->lightbox->commClButtBoxshadowThdVal   = "0";
		$newTheme->lightbox->commClButtBoxshadowColor    = "rgba(97,97,97,1)";
		$newTheme->lightbox->commClButtBgColor           = "rgba(255,255,255,0)";
		$newTheme->lightbox->commClButtBorderRadius      = "3";
		$newTheme->lightbox->commClButtBorderWidth       = "1";
		$newTheme->lightbox->commClButtBorderStyle       = "none";
		$newTheme->lightbox->commClButtBorderColor       = "rgba(255,255,255,1)";
		$newTheme->lightbox->commCpButtSize              = "18";
		$newTheme->lightbox->commCpButtBoxshadowFstVal   = "0";
		$newTheme->lightbox->commCpButtBoxshadowSecVal   = "0";
		$newTheme->lightbox->commCpButtBoxshadowThdVal   = "0";
		$newTheme->lightbox->commCpButtBoxshadowColor    = "rgba(99,99,99,1)";
		$newTheme->lightbox->commCpButtBgColor           = "rgba(255,255,255,0)";
		$newTheme->lightbox->commCpButtBorderRadius      = "2";
		$newTheme->lightbox->commCpButtBorderWidth       = "1";
		$newTheme->lightbox->commCpButtBorderStyle       = "none";
		$newTheme->lightbox->commCpButtBorderColor       = "rgba(255,255,255,1)";
		$newTheme->lightbox->commAFontSize               = "13";
		$newTheme->lightbox->commAFontColor              = "rgba(255,255,255,1)";
		$newTheme->lightbox->commAFontFamily             = "inherit";
		$newTheme->lightbox->commAFontWeight             = "normal";
		$newTheme->lightbox->commAFontStyle              = "italic";
		$newTheme->lightbox->commTFontSize               = "12";
		$newTheme->lightbox->commTFontColor              = "rgba(255,255,255,1)";
		$newTheme->lightbox->commTFontFamily             = "inherit";
		$newTheme->lightbox->commTFontWeight             = "normal";
		$newTheme->lightbox->commTFontStyle              = "inherit";
		$newTheme->lightbox->commDFontSize               = "10";
		$newTheme->lightbox->commDFontColor              = "rgba(255,255,255,0.8)";
		$newTheme->lightbox->commDFontFamily             = "inherit";
		$newTheme->lightbox->commDFontWeight             = "normal";
		$newTheme->lightbox->commDFontStyle              = "normal";
		$newTheme->lightbox->boxBgColor                  = "rgba(0,0,0,1)";
		$newTheme->lightbox->ccl                         = "arrow-right";
		$newTheme->lightbox->closeButtBRad               = "20";
		$newTheme->lightbox->closeButtBoxSize            = "20";
		$newTheme->lightbox->closeButtColor              = "rgba(255,255,255,1)";
		$newTheme->lightbox->closeButtHoverColor         = "rgba(135,135,135,1)";
		$newTheme->lightbox->closeButtPos                = "topRight";
		$newTheme->lightbox->closeButtPosXoffset         = "-24";
		$newTheme->lightbox->closeButtPosYoffset         = "-2";
		$newTheme->lightbox->commClButtBoxSize           = "25";
		$newTheme->lightbox->commClButtColor             = "rgba(255,255,255,1)";
		$newTheme->lightbox->commClButtHoverColor        = "rgba(92,92,92,1)";
		$newTheme->lightbox->commClButtPosXoffset        = "5";
		$newTheme->lightbox->commClButtPosYoffset        = "5";
		$newTheme->lightbox->commCpButtBoxSize           = "30";
		$newTheme->lightbox->commCpButtColor             = "rgba(255,255,255,1)";
		$newTheme->lightbox->commCpButtHoverColor        = "rgba(92,92,92,1)";
		$newTheme->lightbox->contButtBoxSize             = "27";
		$newTheme->lightbox->contButtColor               = "rgba(255,255,255,1)";
		$newTheme->lightbox->contButtContBgGrDir         = "180deg";
		$newTheme->lightbox->contButtContBgGrFrColor     = "rgba(0,0,0,0.16)";
		$newTheme->lightbox->contButtContBgGrToColor     = "rgba(0,0,0,0)";
		$newTheme->lightbox->contButtHoverBgColor        = "rgba(168,168,168,0.5)";
		$newTheme->lightbox->contButtHoverColor          = "rgba(255,255,255,1)";
		$newTheme->lightbox->contButtShadowColor         = "rgba(0,0,0,0)";
		$newTheme->lightbox->contButtShadowFstVal        = "0";
		$newTheme->lightbox->contButtShadowSecVal        = "0";
		$newTheme->lightbox->contButtShadowThdVal        = "0";
		$newTheme->lightbox->contButtBorderRadius        = "4";
		$newTheme->lightbox->cop                         = "commenting-o";
		$newTheme->lightbox->crl                         = "refresh";
		$newTheme->lightbox->fb                          = "facebook";
		$newTheme->lightbox->filmNavBorderRadius         = "15";
		$newTheme->lightbox->filmNavButtColor            = "rgba(92,92,92,1)";
		$newTheme->lightbox->filmNavButtHoverColor       = "rgba(255,255,255,1)";
		$newTheme->lightbox->filmNavButtSize             = "15";
		$newTheme->lightbox->filmNavButtonsSh            = "onhover";
		$newTheme->lightbox->filmNavHeight               = "27";
		$newTheme->lightbox->filmNavHoverBgColor         = "rgba(218,218,218,0.64)";
		$newTheme->lightbox->filmNavOffset               = "20";
		$newTheme->lightbox->filmSelThumbBorderColor     = "rgba(255,255,255,1)";
		$newTheme->lightbox->filmSelThumbBorderStyle     = "solid";
		$newTheme->lightbox->filmSelThumbBorderWidth     = "2";
		$newTheme->lightbox->filmstripMarginBottom       = "10";
		$newTheme->lightbox->filmstripMarginTop          = "10";
		$newTheme->lightbox->gplus                       = "google-plus";
		$newTheme->lightbox->imgcoPosXoffset             = "10";
		$newTheme->lightbox->imgcoPosYoffset             = "10";
		$newTheme->lightbox->info                        = "info";
		$newTheme->lightbox->max                         = "expand";
		$newTheme->lightbox->min                         = "compress";
		$newTheme->lightbox->navButtBoxSize              = "200";
		$newTheme->lightbox->navButtColor                = "rgba(255,255,255,1)";
		$newTheme->lightbox->navButtHoverColor           = "rgba(255,255,255,1)";
		$newTheme->lightbox->navButtHoverShadowColor     = "rgba(13,12,12,1)";
		$newTheme->lightbox->navButtHoverShadowFstVal    = "0";
		$newTheme->lightbox->navButtHoverShadowSecVal    = "0";
		$newTheme->lightbox->navButtHoverShadowThdVal    = "1";
		$newTheme->lightbox->navButtShadowColor          = "rgba(5,5,5,0)";
		$newTheme->lightbox->navButtShadowFstVal         = "0";
		$newTheme->lightbox->navButtShadowSecVal         = "0";
		$newTheme->lightbox->navButtShadowThdVal         = "0";
		$newTheme->lightbox->pause                       = "pause";
		$newTheme->lightbox->pcl                         = "times";
		$newTheme->lightbox->play                        = "play";
		$newTheme->lightbox->titleDescpBgGrDir           = "0deg";
		$newTheme->lightbox->titleDescpBgGrFrColor       = "rgba(0,0,0,0.16)";
		$newTheme->lightbox->titleDescpBgGrToColor       = "rgba(0,0,0,0)";
		$newTheme->lightbox->titleDescpPosXoffset        = "0";
		$newTheme->lightbox->titleDescpPosYoffset        = "0";
		$newTheme->lightbox->titleDescpTmaxWidth         = "60";
		$newTheme->lightbox->twitt                       = "twitter";
		$newTheme->lightbox->titleDescpDmaxWidth         = "90";

		return $newTheme;
	}
}