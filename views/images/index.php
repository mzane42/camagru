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
              <div class="comments-container">
                <form action="index.php" method="post">
									<input name="controller" value="comments" hidden />
									<input name="action" value="create" hidden/>
									<input name="image_id" value="<?php echo $image['image_id']; ?>" hidden />
									<textarea placeholder="Votre commentaire ..." name="content" required></textarea>
                  <button class="send-comment-btn" type="submit"><img class="send-comment" src="assets/images/send.png" /></button>
                </form>
								<?php if (isset($image['comments'])) { ?>
									<div class="all-comments-container">
										<h2>Commentaires :</h2>
										<?php $comments = explode(',',$image['comments']);
												$authors = explode(',', $image['authors']);
												foreach(array_combine($comments, $authors) as $comment => $author) { ?>
														<div class="comment">
															<p class="author"> <?php echo $author; ?> </p>
															<p class="content"> <?php echo $comment; ?> </p>
														</div>
											<?php }?>
								<?php }?>
								</div>
              </div>
            </div>
    <?php } ?>
  </div>
</div>
