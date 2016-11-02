<?php
  class Like {
    public $id;
    public $user_id;
    public $image_id;

    public function __construct($id, $user_id, $image_id){
			$this->id = $id;
			$this->user_id = $user_id;
      $this->image_id = $image_id;
		}

    public function add_like($image_id, $user_id){
      $pdo = Db::getInstance();
      $stmt = $pdo->prepare("INSERT INTO like_image(image_id, user_id) VALUES(:image_id, :user_id)");
      $stmt->bindValue(':user_id', $user_id);
      $stmt->bindValue(':image_id', $image_id);
      $stmt->execute();
    }

    public function liked($image_id, $user_id){
      $pdo = Db::getInstance();
      $user_id = intval($user_id);
      $image_id = intval($image_id);
      $stmt = $pdo->prepare("SELECT * FROM like_image LEFT JOIN image ON image.id = like_image.image_id LEFT JOIN user ON user.id = like_image.user_id WHERE like_image.image_id = :image_id and like_image.user_id = :user_id");
      $stmt->execute(array('user_id' => $user_id, 'image_id' => $image_id));
      $liked = $stmt->fetch();
      return $liked;
    }

    public function add_dislike($image_id, $user_id){
      $pdo = Db::getInstance();
      $stmt = $pdo->prepare("DELETE FROM `like_image` WHERE image_id = :image_id AND user_id = :user_id");
      $stmt->bindValue(':user_id', $user_id);
      $stmt->bindValue(':image_id', $image_id);
      $stmt->execute();
    }
  }
 ?>
