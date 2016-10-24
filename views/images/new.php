<div class="camagru_container">
	<h1 class="camagru-title"> _Camagru </h1>
	<div class="main-container">
		<div class="instruction-one">
			<img src="assets/images/one.png" />
			<p>  Choisis une image :</p>
		</div>
		<div class="clips-container">	
			<table class="clip-gallery">
				<form action="index.php" name="uploadphoto" method="post" enctype="multipart/form-data">
				  <input name="controller" value="images" hidden />
				  <input name="action" value="create" hidden />
					<tr>
						<?php
							$clips_dir = "assets/clip/*.png";
							$clips = glob($clips_dir);
							// $value = substr($clip, 12, -4);
							// echo "<th>".PHP_EOL;
							// echo "<img src='" . $clip ."' class='clip' name='clip' value='". $value ."'/>".PHP_EOL;
							foreach( $clips as $clip ){
								$value = substr($clip, 12, -4);
								?>
								<th>
						    	<img src='<?php echo $clip; ?>'/> <br>
						      	<input type="radio" name="clip" class="clip" value="<?php echo $value; ?>">
						    </th>

						<?php	} ?>
						<!-- .container {
	    width: 30em;
	    overflow-x: auto;
	    white-space: nowrap;
	}!-->
				  </tr>
			</table>
		</div>
		<div class="instruction-one">
			<img src="assets/images/two.png" />
			<p>  Fais-toi beau/belle : </p>
		</div>
		<div class="video-container">
			<video id="video"></video>
		</div>
		<div class="instruction-one">
				<input name="login_id" value="1" hidden/>
				<input name="image" id="image_capture" hidden/>
				<img src="assets/images/three.png" />
				<p>  Souris et Click ici :  </p>
				<button type="submit" class="disabled" id="startbutton"><img class="capture-photo" src="/assets/images/photo-camera.png"/></button>
			</form>
		</div>
		<div class="preview-container">
			<canvas id="canvas" hidden></canvas>
			<img src="<?php echo $last_image->url_link; ?>"/>
		</div>
	</div>
	<div class=side-container>
		<div class="title-side-container">
			<h2>Mes photos : </h2>
		</div>
		<div class="last-images">

			<?php
			    if (count($last_images) > 0) {
				    $table = "<table class='image-gallery'><tbody><tr>";
				    foreach($last_images as $a => $img) {

				        $table .= "<td><img class='last-image' src='$img->url_link'/> </td>";
				        if(($a+1) % 3 == 0)
				            $table .= "</tr><tr>";

				    }
				    $table .= "</tr></tbody></table>";
				    echo $table;
			    }
			?>
		</div>
	</div>
</div>
<script src="/assets/js/camera.js"></script>
