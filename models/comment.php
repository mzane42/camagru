<?php

  class Comment {
    public $id;
    public $content;
    public $image_id;
    public $user_id;

    public function __construct($id, $content, $image_id, $user_id){
			$this->id = $id;
			$this->content = $content;
			$this->image_id = $image_id;
			$this->user_id = $user_id;
		}

    public function create_comment($content, $image_id, $user_id){
      $pdo = Db::getInstance();
      $stmt = $pdo->prepare("INSERT INTO comment_image(content, image_id, user_id) VALUES(:content, :image_id, :user_id)");
      $stmt->bindValue(':content', $content);
      $stmt->bindValue(':image_id', $image_id);
      $stmt->bindValue(':user_id', $user_id);
      $stmt->execute();
    }

    public function find_comments_image(){

    }
  }
 ?>
