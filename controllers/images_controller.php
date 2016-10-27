<?php
	require_once 'config/database.php';
	require_once 'routes.php';
	require_once 'models/user.php';

	class imagesController {
		public function index() {
			$images = Image::all();
			require_once('views/images/index.php');
		}

		public function new() {
			// 	if(!isset($_GET['id']))
			$user = User::find($_SESSION['login']);
			$user_id = $user->id;
			$last_images = Image::last_images($user_id);
			$last_image = Image::last_image($user_id);
			require_once('views/images/new.php');
		}

		public function create() {
			// init
			//if (isset($_POST[''])
			if (isset($_POST['image'])) {
					$img = $_POST['image'];
					$clip = $_POST['clip'];
					$clip_explode = explode('_', $clip);
					$user = User::find($_SESSION['login']);
					$user_id = $user->id;
					// format
					$creation_date = date('Y-m-d H:i:s');

					if (!file_exists('assets/webcam_images/'.$_SESSION['login'])) {
		    			mkdir('assets/webcam_images/'.$_SESSION['login'], 0775, true);
					}
					$url_link = 'assets/webcam_images/'.$_SESSION['login'].'/'.uniqid().'.jpg';
					$img = str_replace('data:image/jpeg;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					/* decode */
					$destim = base64_decode($img);
					$dest = imagecreatefromstring($destim);
					imagealphablending($dest, true);
					imagesavealpha($dest, true);
					/* montage */
					$clip = imagecreatefrompng('assets/clip/'.$_POST['clip'].'.png');
					imagecopy($dest, $clip, $clip_explode[1], $clip_explode[2], 0, 0, imagesx($clip), imagesy($clip));
					/* save */
					ob_start();
					imagejpeg($dest, $url_link);
					ob_end_clean();
					/* insert */
					try {
						$new_image = Image::new($url_link, $creation_date, $user_id);
					}
					catch (exception $e){
						$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
						call('pages', "error");
					}
					imagedestroy($dest);
					call('images', 'new');
					exit;
			}
			else {
				call('pages', 'error');
			}
		}

		public function delete_from_index() {
			if (isset($_POST['image_id'])) {
				try {
					$delete = Image::delete($_POST['image_id']);
				}
			catch(exception $e){
					$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
					call('pages', "error");
				}
				call('images', 'index');
			}
			else {
				call('images', 'index');
			}
		}


		public function delete_from_new() {
			if (isset($_POST['image_id'])) {
				try {
					$delete = Image::delete($_POST['image_id']);
				}
			catch(exception $e){
					$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
					call('pages', "error");
				}
				call('images', 'new');
			}
			else {
				call('images', 'new');
			}
		}

	}

?>
