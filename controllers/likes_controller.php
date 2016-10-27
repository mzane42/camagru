<?php
  require_once('models/user.php');
  class likesController {

    public function like() {
      if (isset($_POST['image_id'])) {
        $user= User::find($_SESSION['login']);
        $user_id = $user->id;
        $image_id = $_POST['image_id'];
        $liked = Like::liked($image_id, $user_id);
        if (!$liked) {
          try{
            $like = Like::add_like($image_id, $user_id);
          }
          catch (exception $e){
              $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
              call('pages', "error");
            }
            call('images', 'index');
        }
        else {
            $dislike = Like::add_dislike($image_id, $user_id);
            call('images', 'index');
        }
      }
      else {
        call('images', 'index');
      }
      //if dislike
    }

    public function dislike() {

    }

    public function count_likes() {

    }

  }
?>
