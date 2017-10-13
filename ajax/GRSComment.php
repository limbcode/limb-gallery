<?php
/**
 * LIMB gallery
 * Ajax
 * GRSComment
 */
 
class GRSComment extends GRSGalleryAjax {
	// Costructor
	public function __construct($action) {				
		if(method_exists($this, $action))
			$this->{$action}();
	}
	private function comment() {
		global $wpdb; 
		// $wpdb->show_errors();
		$name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
		$email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
		$comment = isset($_POST['comment']) ? sanitize_text_field($_POST['comment']) : '';
		$imageId = isset($_POST['imageId']) ? (int) $_POST['imageId'] : 0;
		$galId = isset($_POST['galId']) ? (int) $_POST['galId'] : 0;
		$captchaCode = isset($_POST['captchaCode']) ? sanitize_text_field($_POST['captchaCode']) : '';
		if($captchaCode === $_SESSION['captcha']['code']) {
			if ($name == '') {
				$message = 'Invalid name';
				$result = 'error';
			}
			elseif($email == '') {
				$message = 'Invalid email adress';
				$result = 'error';
			}
			elseif($comment == '') {
				$message = 'Invalid comment';
				$result = 'error';
			}
			elseif(!$imageId) {
				$message = 'Invalid image';
				$result = 'error';
			}
			elseif(!$galId) {
				$message = 'Invalid gallery';
				$result = 'error';
			} 
			else {
				$grsSettings = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . "limb_gallery_settings` WHERE `default`=1");
				$date = date_create(NULL);
				date_timezone_set($date, timezone_open('UTC'));
				$createDate = date_format($date, "Y-m-d H:i:s");
				$insert = $wpdb->insert($wpdb->prefix . 'limb_gallery_comments', 
					array( 
						'imgId' => $imageId,
						'galId' => $galId,
						'publish' => 1,
						'name' => $name, 
						'email' => $email,
						'comment' => $comment,
						'createDate' => $createDate 
					), 
					array( 
						'%d',
						'%d',
						'%d',
						'%s',
						'%s', 
						'%s', 
						'%s' 
					)
				);
				if($insert !== false) {
					$result = 'success';
					$message = new stdclass();
					$message->insert_id = $wpdb->insert_id;
					// $grsSettings = $wpdb->get_row("SELECT `timezone`, `timeformat` FROM `" . $wpdb->prefix . "grssettings` WHERE `default`=1");
					date_timezone_set($date, timezone_open($grsSettings->timezone));
					$message->createDate = date_format($date, $grsSettings->timeformat);
				}
				else {
					// $wpdb->print_error();
					$message = 'Problem with save';
					$result = 'error';
				}
			}
		}
		else {
			$message = 'Inccorect captcha code';
			$result = 'error';
		}
		$this->result($result, $message);
		return;
	}
	public function showComments() {
		global $wpdb;
		$id = (isset($_POST['id']) && $_POST['id'] != '') ? (int) $_POST['id'] : 0;
		$gallId = (isset($_POST['gallId']) && $_POST['gallId'] != '') ? (int) $_POST['gallId'] : 0;
		$grsSettings = $wpdb->get_row("SELECT `timezone`, `timeformat` FROM `" . $wpdb->prefix . "limb_gallery_settings` WHERE `default`=1");
		if($id && $gallId) {
			$query = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "limb_gallery_comments WHERE `imgId`=%d AND `galId`=%d", $id, $gallId);
			$comments = $wpdb->get_results($query);
			foreach ($comments as $key => $comment) {
				$date = date_create($comment->createDate);
				date_timezone_set($date, timezone_open($grsSettings->timezone));
				$comment->createDate = date_format($date, $grsSettings->timeformat);
			}
			$this->result('success', $comments);
		}
		else
			$this->result('error', 'Invalid image id');
	}
}