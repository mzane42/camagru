<?php
	require_once 'config/database.php';
	require_once 'routes.php';
	require_once 'models/user.php';

	class imagesController {
		public function index() {
			$total = image::total();
			$perpage = 2;
			$total_images  = $total['rows'];
			$pages  = ceil($total_images / $perpage);

			# default
			$get_pages = isset($_GET['page']) ? $_GET['page'] : 1;

			$data = array(
				'options' => array(
					'default'   => 1,
					'min_range' => 1,
					'max_range' => $pages
					)
			);

			$number = trim($get_pages);
			$number = filter_var($number, FILTER_VALIDATE_INT, $data);
			$range  = $perpage * ($number - 1);

			$prev = $number - 1;
			$next = $number + 1;
			// try{
				$images = Image::all($perpage, $range);
			// }
			// catch(exception $e) {
			// 	$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
			// 	call('pages', "error");
			// }
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
			if (isset($_POST['image']) || isset($_FILES["upload"]["name"])) {
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
					if (isset($_FILES["upload"]["name"]) && $_FILES["upload"]["size"] != 0){
						$target_dir = "uploads/";
						$target_file = $target_dir . basename($_FILES["upload"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$check = getimagesize($_FILES["upload"]["tmp_name"]);
						if($check !== false) {
							if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
								$dest = imagecreatefromjpeg($target_file);
								unlink($target_file);
							}

						}
						else {
							$img = $_POST['image'];
							$img = str_replace('data:image/jpeg;base64,', '', $img);
							$img = str_replace(' ', '+', $img);
							$destim = base64_decode($img);
							$dest = imagecreatefromstring($destim);
						}
					}
					else {
						$img = $_POST['image'];
						$img = str_replace('data:image/jpeg;base64,', '', $img);
						$img = str_replace(' ', '+', $img);
						$destim = base64_decode($img);
						$dest = imagecreatefromstring($destim);
					}
					/* decode */
					imagealphablending($dest, true);
					imagesavealpha($dest, true);
					/* montage */
					$clip = imagecreatefrompng('assets/clip/'.$_POST['clip'].'.png');
					//imagecopy($dest, $clip, $clip_explode[1], $clip_explode[2], 0, 0, imagesx($clip), imagesy($clip));
					if ($clip_explode[1] == 'l'){
						imagecopy($dest, $clip, imagesx($dest) / 6, imagesy($dest) / 6, 0, 0, imagesx($clip), imagesy($clip));
					}
					else if ($clip_explode[1] == 'r'){
						imagecopy($dest, $clip, imagesx($dest) - imagesx($dest) / 3, imagesy($dest) / 2, 0, 0, imagesx($clip), imagesy($clip));
					}
					else {
						imagecopy($dest, $clip, 0, imagesy($dest) - imagesy($clip), 0, 0, imagesx($clip), imagesy($clip));
					}
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
