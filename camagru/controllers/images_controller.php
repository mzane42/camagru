<?php
	require_once '../models/user.php';

	class imagesController {
		public function imagecreatefromfile( $filename ) {
		    if (!file_exists($filename)) {
		        throw new InvalidArgumentException('File "'.$filename.'" not found.');
		    }
		    switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
		        case 'jpeg':
		        case 'jpg':
		            return imagecreatefromjpeg($filename);
		        break;

		        case 'png':
		            return imagecreatefrompng($filename);
		        break;

		        case 'gif':
		            return imagecreatefromgif($filename);
		        break;

		        default:
		            throw new InvalidArgumentException('File "'.$filename.'" is not valid jpg, png or gif image.');
		        break;
		    }
		}
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
			 try{
				$images = Image::all($perpage, $range);
			}
			catch(exception $e) {
			 	$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
			 	call('pages', "error");
			}
			require_once('views/images/index.php');
		}

		public function new() {
			$user = User::find($_SESSION['login']);
			$user_id = $user->id;
			$last_images = Image::last_images($user_id);
			return $last_images;
		}

		public function create() {
			if (isset($_POST['image']) || isset($_FILES["upload"]["name"])) {
					$clip = $_POST['clip'];
					$clip_explode = explode('_', $clip);
					$user = User::find($_SESSION['login']);
					$user_id = $user->id;
					// format
					$creation_date = date('Y-m-d H:i:s');

					if (!file_exists('../assets/webcam_images/'.$_SESSION['login'])) {
		    			mkdir('../assets/webcam_images/'.$_SESSION['login'], 0775, true);
					}
					$url_link = '/assets/webcam_images/'.$_SESSION['login'].'/'.uniqid().'.jpg';
					if (isset($_FILES["upload"]["name"]) && $_FILES["upload"]["size"] != 0){
						$target_dir = "../uploads/";
						if (!file_exists('../uploads')) {
							mkdir('../uploads', 0775, true);
						}
						$target_file = $target_dir . basename($_FILES["upload"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$check = getimagesize($_FILES["upload"]["tmp_name"]);
						if($check !== false) {
							if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
								$dest = imagesController::imagecreatefromfile($target_file);
								unlink($target_file);
							}
						}
						else {
							header('Location: /views/snapshots.php');
							exit;
							// $img = $_POST['image'];
							// $img = str_replace('data:image/jpeg;base64,', '', $img);
							// $img = str_replace(' ', '+', $img);
							// $destim = base64_decode($img);
							// $dest = imagecreatefromstring($destim);
						}
					}
					else {
						$img = $_POST['image'];
						$img = str_replace('data:image/jpeg;base64,', '', $img);
						$img = str_replace(' ', '+', $img);
						$destim = base64_decode($img);
						$dest = imagecreatefromstring($destim);
					}
					imagealphablending($dest, true);
					imagesavealpha($dest, true);
					$clip = imagecreatefrompng('../assets/clip/'.$_POST['clip'].'.png');
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
						imagejpeg($dest, '../'.$url_link);
						$image_data = ob_get_contents();
					ob_end_clean();
					/* insert */
					try {
						$new_image = Image::new($url_link, $creation_date, $user_id);
					}
					catch (exception $e){
						$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
						header('Location: /views/pages/error.php');
						exit;
					}
					imagedestroy($dest);
					header('Location: /views/snapshots.php');
					exit;
			}
			else {
				header('Location: /views/pages/error.php');
				exit;
			}
		}

		public function delete_image() {
			if (isset($_POST['image_id'])) {
				try {
					$delete = Image::delete($_POST['image_id']);
				}
			catch(exception $e){
					$msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
					header('Location: /views/pages/error.php');
					exit;
				}
				header('Location: '.$_SERVER['HTTP_REFERER']);
				exit;
			}
			else {
				header('Location: '.$_SERVER['HTTP_REFERER']);
				exit;
			}
		}

	}

?>
