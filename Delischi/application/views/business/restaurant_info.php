<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<label style="display:none"><?php echo $json_response ?></label>

<div class="nine columns">
	
	<section id="restaurantInfo">
	<?php if (!isset ($place_details['result']['photos']['0']['photo_reference'])) { ?>
		
		<img class='restaurant-info-avatar template' src='<?php echo base_url() ?>public/images/restaurant.jpg' alt='Restaurant Image'> 
		
	<?php }
	else { 
		
		$picCount = count($place_details['result']['photos']);
		if ($picCount==1) {
			
			$photoreference = $place_details['result']['photos']['0']['photo_reference'];
			echo " <img class='restaurant-info-avatar' src='https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=".$photoreference."&key=AIzaSyBtku3lNVOu_AWRwA3pRGeGUPOTgQ1-nYE' alt='Restaurant Image'> ";
			
		}
		else { ?>																																 
		
		<div class="slideshow-container">
			
			<?php
			for($p=0; $p<$picCount; $p++) {
				$photoreference = $place_details['result']['photos'][$p]['photo_reference'];
			?>
			
			<div class="mySlides fade">
				<img src='https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=<?php echo $photoreference ?>&key=AIzaSyBtku3lNVOu_AWRwA3pRGeGUPOTgQ1-nYE' style="width:100%">
			</div>
		
		<?php } ?>
				<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  			<a class="next" onclick="plusSlides(1)">&#10095;</a>
			</div>
			<br>
			<div style="text-align:center">
				<?php
				for($p=0; $p<$picCount; $p++) {
					$photoreference = $place_details['result']['photos'][$p]['photo_reference'];
					$q = $p+1;
				?>
				<span class="dot" onclick="currentSlide(<?php echo $q ?>)"></span>
				<?php } ?>
			</div>
		<?php } ?>
		
	<?php } ?> 
		
		<div class="restaurantText">
			<h3><?php echo $restaurant->restaurantname; ?></h3>
			
			<?php if (!isset($place_details['result'])) { ?> <!-- If the business is not on google maps -->
			
			<div class='alert alert-danger-outline '>
				<i class='material-icons md-18 app-menu red' style='padding-right:5px'>warning</i>
				<p>People find businesses more easily when they are on Google Maps.</p>
				<p>Follow these steps to add yours to the list:</p>
				<ol>
					<li>Add your business on Google Maps. Find out how <a href='https://support.google.com/business/answer/2911778?hl=en&ref_topic=4854193' target='_blank'>here</a>.</li>
					<li>Update your profile on this site by adding the name of your business.</li>
				</ol>
			</div>
	
			<?php }
			else { ?> <!-- If the business is on google maps -->
			
			<div class="row">
				<div class="six columns">
					<p><i class='material-icons app-menu md-18'>pin_drop</i><?php echo $place_details['result']['vicinity']; ?></p>
				<?php
				if(!isset($place_details['result']['opening_hours'])) {
					echo "<p style='color:#B71C1C'><i class='material-icons app-menu md-18'>access_time</i>No hours stated.</p>";
				}
				else {
					echo "<p><i class='material-icons app-menu md-18'>access_time</i>Hours:</p>";
					echo "<ul>";
					foreach ($place_details['result']['opening_hours']['weekday_text'] as $key => $value) {
						echo "<li style='padding-left:50px'><small>".$value."</small></li>";
					}
					echo "</ul>";
				}
				?>
				</div>
				<div class="six columns">
					<?php
					if (!isset($place_details['result']['formatted_phone_number'])) {
					echo "<p style='color:#B71C1C'><i class='material-icons app-menu md-18'>phone</i>No telephone number stated.</p>";
					}
					else {
						echo "<p><i class='material-icons app-menu md-18'>phone</i>".$place_details['result']['formatted_phone_number']."</p>";
					}
					if(!isset($place_details['result']['website'])) {
						echo '<p style="color:#B71C1C"><i class="material-icons app-menu md-18">public</i><span>No website stated.</span></p>';
					}
					else {
						echo '<p><i class="material-icons app-menu md-18">public</i><span>'.$place_details['result']['website'].'</span></p>';
					}
					if(!isset($place_details['result']['rating'])) {
						echo '<p style="color:#B71C1C"><i class="material-icons app-menu md-18">stars</i><span>No rating yet.</span></p>';
					}
					else {
						echo '<p><i class="material-icons app-menu md-18">stars</i><span>'.$place_details['result']['rating'].' out of 5</span></p>';
					}
					?>
					</span></p>
				</div>
				
			</div>
			
			<?php } ?>
			
		</div>
			
	</section>
		
</div>

<div id="scrollUpDiv" class="row">
			 <div id="scrollUp">
				 <a href="#top" class="smoothScroll">
					 <i class="material-icons">keyboard_arrow_up</i>
				 </a>
			 </div>
		 </div>

<script type="text/javascript">
	
	if(document.getElementsByClassName("mySlides")) {
		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
			showSlides(slideIndex += n);
		}

		function currentSlide(n) {
			showSlides(slideIndex = n);
		}

		function showSlides(n) {
			var i;
			var slides = document.getElementsByClassName("mySlides");
			var dots = document.getElementsByClassName("dot");
			if (n > slides.length) {slideIndex = 1} 
			if (n < 1) {slideIndex = slides.length}
			for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none"; 
			}
			for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" active", "");
			}
			slides[slideIndex-1].style.display = "block"; 
			dots[slideIndex-1].className += " active";
		}
	}
	
</script>

  
