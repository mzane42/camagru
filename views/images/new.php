<div class="camagru_container">
	<h1 class="camagru-title"> _Camagru </h1>
	<div class="main-container">
		<div class="instruction-one"> 
			<img src="assets/images/one.png" />
			<p>  Choisis une image :</p>
		</div>
		<table class="clip-gallery">
			<form action="index.php" name="uploadphoto" method="post" enctype="multipart/form-data">
			  <input name="controller" value="images" hidden /> 
			  <input name="action" value="create" hidden /> 
			  <tr>
			    <th>
			    	<img src="assets/clip/mustache.png"/> <br>
			      	<input type="radio" name="clip" class="clip" value="mustache">					    
			    </th>
			    <th>
			    	<img src="assets/clip/glasses.png"/> <br>
		    		<input type="radio" name="clip" class="clip" value="glasses">
			    </th>
			    <th>
			    	<img src="assets/clip/hat.png"/> <br>
			      	<input type="radio" name="clip" class="clip" value="hat">
			    </th>
			  </tr>
		</table>
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
