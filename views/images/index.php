<?php require_once('function_helper.php'); ?>
<link rel="stylesheet" type="text/css" href="/assets/css/gallery.css">
<div class="camagru_container">
	<h1 class="camagru-title"> _Gallerie </h1>
  <div class="billboard-container">
    <?php foreach($images as $image) { ?>
            <div class="billboard">
              <div class="billboard-informations">
                <div class="informations-left">
                  <p class="billboard-login"> <?php echo $image['login']; ?> </p>
                </div>
                <div class="informations-right">
                  <p class="billboard-date"> <?php echo "il y'a ".humanTiming(strtotime($image['creation_date'])); ?></p>
                </div>
              </div>
              <div class="image-wrapper">
                <img src="<?php echo $image['url_link']; ?>"/>
              </div>
              <div class="billboard-social">
                <img class="social-like" src="assets/images/like.png"/>
                <img class="social-comment" src="assets/images/chat.png"/>
              </div>
              <div class="comment-container">
                <form>
                  <textarea placeholder="Votre commentaire ..."></textarea>
                  <img class="send-comment" src="assets/images/send.png" />
                </form>
                <!-- <h2>Commentaires :</h2> !-->
              </div>
            </div>
    <?php } ?>
  </div>
</div>
