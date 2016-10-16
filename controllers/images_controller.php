<?php
	require_once 'config/database.php';
	require_once 'routes.php';

	class ImagesController {
		public function index() {
			$images = Image::all();
			require_once('views/images/index.php');
		}

		public function new() {
			// 	if(!isset($_GET['id']))
			$user_id = 1;
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
					//$user_id = $_POST['user_id'];
					$user_id = 1;
					// format
					$creation_date = date('Y-m-d H:i:s');
					
					if (!file_exists('assets/webcam_images/mzane')) {
		    			mkdir('assets/webcam_images/mzane', 0775, true);
					}
					$url_link = 'assets/webcam_images/mzane/'.uniqid().'.jpg';
					$img = str_replace('data:image/jpeg;base64,', '', $img);
					$img = str_replace(' ', '+', $img);
					/* decode */
					$destim = base64_decode($img);
					$dest = imagecreatefromstring($destim);
					imagealphablending($dest, true);
					imagesavealpha($dest, true);
					/* montage */
					$clip = imagecreatefrompng('assets/clip/'.$_POST['clip'].'.png');

					imagecopy($dest, $clip, (imagesx($dest) / 2) - 60, imagesy($dest) / 4, 0, 0, imagesx($clip), imagesy($clip));

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
		
		// public function show() {
		// 	if(!isset($_GET['id']))
		// 		return call('pages', 'error');
		// 	$image = Image::find($_GET['id']);
		// 	require_once('views/posts/show.php')
		// }

	}

?>