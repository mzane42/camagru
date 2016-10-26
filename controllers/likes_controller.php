<?php
  require_once('models/user.php');
  class likesController {
    public function like() {
      //if like
      if (isset($_POST['image_id'])) {
        $user= User::find($_SESSION['login']);
        $user_id = $user->id;
        $image_id = $_POST['image_id'];
        //try{}
        //catch(execption e){}
        $like = Like::add_like($image_id, $user_id);
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
