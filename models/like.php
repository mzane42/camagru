<?php
  require_once ('config/database.php');

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

    public function add_dislike(){

    }
  }
 ?>
