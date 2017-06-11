<?php
  if( !session_id() ) {
        session_start();
    }
  require_once('../function_helper.php');
  require_once('../connection.php');
  require_once('partials/header.php');
  require_once('../controllers/images_controller.php');
  require_once('../models/image.php');
  require_once('../servers/gallery.php');

?>
<link rel="stylesheet" type="text/css" href="/assets/css/gallery.css">
<div class="camagru_container">
	<h1 class="camagru-title"> _Gallerie </h1>

		<?php foreach($images as $image) { ?>
			<div class="billboard-container">
            <div class="billboard">
              <div class="billboard-informations">
                <div class="informations-left">
                  <p class="billboard-login"> <?php echo $image['login']; ?> </p>
                </div>
                <div class="informations-right">
									<?php if (isset($_SESSION['login']) && $_SESSION['login'] == $image['login']){?>
										<form class="delete_form" name="delete_image" action="/servers/delete_image.php" method="post">
												<input hidden name="image_id" value="<?php echo $image['image_id']; ?>" />
												<button type="submit"> <img class="billboard-delete" src="/assets/images/delete.png"/></button>
										</form>
										<?php }?>
              		<p class="billboard-date"> <?php echo "il y'a ".humanTiming(strtotime($image['creation_date'])); ?></p>
                </div> 
              </div>
              <div class="image-wrapper">
                <img src="<?php echo $image['url_link']; ?>"/>
              </div>
              <div class="billboard-social">
				              <?php if (isset($_SESSION['login'])) { ?>
								<form class="like_form" name="like" action="/servers/like_image.php" method="post">
									<input hidden name="image_id" value="<?php echo $image['image_id']; ?>" />
									<?php $authors_likes = explode(',', $image['authors_likes']);
												if (in_array($_SESSION['login'], $authors_likes)){
													$src = "/assets/images/like.png";
												}else {
													$src = "/assets/images/dislike.png";
												}
											?>
											<button type="submit">
												<img class="social-like" src="<?php echo $src; ?>"/>
											</button>
								</form>
							<?php }else { ?>
									<img class="social-like" src="/assets/images/like.png"/>
								<?php } ?>
								<p class="count_likes"><?php echo $image['nb_likes']; ?></p>
								<img class="social-comment" src="/assets/images/chat.png"/>
								<a class="count_comments"> <?php echo $image['nb_comments']; ?> </a>
              </div>
              <div class="comments-container">
              <?php if (isset($_SESSION['login'])) { ?>
                <form action="/servers/comment_image.php" method="post">
									<input name="image_id" value="<?php echo $image['image_id']; ?>" hidden />
									<textarea placeholder="Votre commentaire ..." name="content" required></textarea>
                  <button class="send-comment-btn" type="submit"><img class="send-comment" src="/assets/images/send.png" /></button>
                </form>
                <?php } ?>
								<?php if (isset($image['comments'])) { ?>
									<div class="all-comments-container">
										<h2>Commentaires :</h2>
										<?php $comments = explode(',',$image['comments']);
												$authors = explode(',', $image['authors_comments']);
												foreach(array_combine($comments, $authors) as $comment => $author) { ?>
														<div class="comment">
															<p class="author"> <?php echo $author; ?> </p>
															<p class="content"> <?php echo $comment; ?> </p>
														</div>
											<?php }?>
										</div>
								<?php }?>
              </div>
            </div>
					</div>
    <?php } ?>
		<div class="navigation">
				<?php
					if($images && count($images) > 0)
					{
						echo "<h3 class='nb_pages'>Nombre de pages : $pages</h3>";
						echo "<p class='nb_images'>Nombre d'images : $total_images</p>";

						# first page
						if($number <= 1)
							echo "<span>&laquo; Precedent</span> | <a href=\"?controller=images&action=index&page=$next\">Suivant &raquo;</a>";

						# last page
						elseif($number >= $pages)
							echo "<a href=\"?controller=images&action=index&page=$prev\">&laquo; Precedent</a> | <span>Suivant &raquo;</span>";

						# in range
						else
							echo "<a href=\"?controller=images&action=index&page=$prev\">&laquo; Precedent</a> | <a href=\"?controller=images&action=index&page=$next\">Suivant &raquo;</a>";
					}

					else
					{
						echo "<p> Aucune images trouves.</p>";
					}

				?>
			</div>
</div>
<?php
  require_once('partials/footer.php');
?>
