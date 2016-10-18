<?php
	require_once 'config/database.php';

	class Image {
		public $id;
		public $url_link;
		public $creation_date;
		public $user_id;

		public function __construct($id, $url_link, $creation_date, $user_id){
			$this->id = $id;
			$this->url_link = $url_link;
			$this->creation_date = $creation_date;
			$this->user_id = $user_id;
		}

		public static function all() {
			$list = [];
			$db = Db::getInstance();
			$req = $db->query('SELECT image.id, login, url_link, creation_date, user.id AS user_id, GROUP_CONCAT(content) AS comments FROM `image` LEFT JOIN `user` ON user.id = image.user_id LEFT JOIN comment_image ON image.id = comment_image.image_id GROUP BY image.id');
			foreach ($req->fetchAll() as $img) {
				$list[] = $img;
			}
			return $list;
		}

		public static function find_creator($id) {
			$db = Db::getInstance();
			$id = intval($id);
			$req = $db->prepare('SELECT user.id AS user_id, user.login, user.email, image.id AS image_id FROM user LEFT JOIN image ON user.id = image.user_id WHERE image.id = :id');
			$req->execute(array('id' => $id));
			$user = $req->fetch();

			return $user;
		}

		public static function find($id){
			$db = Db::getInstance();
			$id = intval($id);
			$req = $db->prepare('SELECT * FROM image where id = :id');
			$req->execute(array('id' => $id));
			$img = $req->fetch();

			return new Image($img['id'], $img['url_link'], $img['creation_date'], $img['user_id']);
		}

		public static function last_images($user_id){
			$list = [];
			$db = Db::getInstance();
			$req = $db->prepare('SELECT * FROM `image` where user_id = :user_id ORDER BY id DESC LIMIT 18');
			$req->execute(array('user_id' => $user_id));
			foreach ($req->fetchAll() as $img) {
				$list[] = new Image($img['id'], $img['url_link'], $img['creation_date'], $img['user_id']);
			}
			return $list;
		}

		public static function last_image($user_id){
			$list = [];
			$db = Db::getInstance();
			$req = $db->prepare('SELECT * FROM `image` where user_id = :user_id ORDER BY id DESC LIMIT 1');
			$req->execute(array('user_id' => $user_id));
			$img = $req->fetch();
			return new Image($img['id'], $img['url_link'], $img['creation_date'], $img['user_id']);
		}

		public static function new($url_link, $creation_date, $user_id) {
			$pdo = Db::getInstance();
			$stmt = $pdo->prepare("INSERT INTO image(url_link, user_id, creation_date) VALUES(:url_link, :user_id, :creation_date)");
			$stmt->bindValue(':user_id', $user_id);
			$stmt->bindValue(':url_link', $url_link);
			$stmt->bindValue(':creation_date', $creation_date);
			$stmt->execute();
		}
	}
?>
