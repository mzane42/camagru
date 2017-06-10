<?php
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

		public static function all($perpage, $range) {
			$list = [];
			$db = Db::getInstance();
			$req = $db->prepare("SELECT image.id AS image_id, user.login, url_link, creation_date, user.id AS user_id, GROUP_CONCAT(ci.content) AS comments, GROUP_CONCAT(u1.login) AS authors_comments, COUNT(ci.content) as nb_comments, likes.nb_likes, likes.authors_likes FROM image LEFT JOIN `user` ON user.id = image.user_id LEFT JOIN comment_image ci ON image.id = ci.image_id LEFT JOIN user u1 ON u1.id = ci.user_id LEFT JOIN (SELECT COUNT(like_image.id) AS nb_likes, like_image.image_id, GROUP_CONCAT(user.login) as authors_likes FROM like_image LEFT JOIN image ON image.id = like_image.image_id LEFT JOIN user ON user.id = like_image.user_id WHERE like_image.image_id = image.id GROUP BY image.id) likes ON likes.image_id = image.id GROUP BY image.id ORDER BY creation_date LIMIT $range, $perpage");
			$req->execute();
			foreach ($req->fetchAll() as $img) {
				$list[] = $img;
			}
			return $list;
		}

		public static function total() {
			$db = Db::getInstance();
			$req = $db->query('SELECT COUNT(image.id) AS rows FROM image');
			$total = $req->fetch();
			return $total;
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

		public function delete($image_id){
      $pdo = Db::getInstance();
      $stmt = $pdo->prepare("DELETE FROM `image` WHERE id = :id");
      $stmt->bindValue(':id', $image_id);
      $stmt->execute();
    }

	}
?>
