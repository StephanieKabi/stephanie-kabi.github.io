<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<script src="<?php echo base_url(); ?>public/js/chartist.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/chartist-plugin-axistitle.js"></script>
<script src="<?php echo base_url(); ?>public/js/chartist-plugin-fill-donut.min.js"></script>

<div id="top"></div>
		
<div class="container">
	
	<section id="exploreRestaurantFixedImage">
				
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
		
		<div id="backPrevPageIcon"><i class='material-icons app-menu md-36 white hover' onclick='history.go(-1)'>arrow_back</i></div>
		
	 </section>
	
	<div class="row">
		
		<div class="five columns">
			
			<div class="restaurantText">
				
				<h4>General Information</h4>
				<p><i class='material-icons app-menu md-18'>store</i><?php echo $restaurant->restaurantname; ?></p>
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
				?>
				</span></p>

			</div>
			
		</div>
		
		<div class="seven columns">
			
			<h4>Overall Opinion</h4>
			
			<div class="row">
				
				<div class="six columns">
					
					<label style="display:none" id="opinionChartJson"><?php echo $opinion_stats; ?></label>
					<div class="container">
						<div class="ct-chart ct-square" id="gaugeChart"></div>
					</div>
					
				</div>
				
				<div class="six columns">
					
					<?php 
					$popularity_short = (array) $popularity_short;
					for($p=0; $p<count($popularity_short); $p++) {
						$popularity_short[$p] = (array) $popularity_short[$p];
					}
					$comments_short = (array) $comments_short;
					for($p=0; $p<count($comments_short); $p++) {
						$comments_short[$p] = (array) $comments_short[$p];
					}
					?>
					
					<div class="card good">
						<div class="panel-body">
							<br>
							<center>
								<h5><i class='material-icons app-menu md-24'>thumb_up</i><br>
									<?php
									for($p=0; $p<count($popularity_short); $p++) {
										if ($p == 0) {
											echo $popularity_short[$p]['dishname']."<br>";
										}
									}
									?>
								</h5>
								<span>Most Popular</span>
							</center>
						</div>
					</div>
					
					<div class="card good">
						<div class="panel-body">
							<br>
							<center>
								<h5><i class='material-icons app-menu md-24'>trending_up</i><br>
									<?php
									for($p=0; $p<count($comments_short); $p++) {
										if ($p == 0) {
											echo $comments_short[$p]['dishname']."<br>";
										}
									}
									?>
								</h5>
								<span>Most Talked About</span>
							</center>
						</div>
					</div>	
					
				</div>
				
			</div>
			
		</div>

		<div class="row">
			
			<h4>Dishes Served</h4>
			
			<?php if(!isset($menuItems)) { ?>
			
			<p><?php echo $restaurant->restaurantname; ?> has not recorded dishes here yet.</p>
			
			<?php } else { ?>
			
			<table class="u-full-width">
        <thead>
					<tr>
						<th>Dish</th>
						<th>Cuisine</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($menuItems as $row) { ?>
          <tr>
						<td><?php echo $row->dishname ?></td>
						<td><?php echo $row->dishtype ?></td>
						<td><?php echo $row->dishdescription ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
				
			<?php } ?>
			
		</div>

			<div class="row" style="margin-bottom:100px">
				
				<br>
				
				<h4>What Customers Said</h4>
				
				<?php foreach($reviews as $row) { ?>
					<div class="customerReviews">
						<h5 class="dish"><?php echo $row->dishname ?></h5>
						<span>
							<p>
								<span class="exploreProfileImg">
									<img class="userlist-img" src="<?php echo base_url() ?>uploadedImages/profile/<?php echo $row->imagepath ?>">
								</span>
								<span class="exploreProfileText">
									<q>
										<?php echo $row->body ?>
									</q> - <b><?php echo $row->firstname." ".$row->lastname ?></b>, <small><?php echo date( 'M j, Y', strtotime($row->datevisit) ) ?></small>
										<?php if($row->sentimenttype == 'positive') { ?>
										<i class='material-icons app-menu md-18 green'>sentiment_very_satisfied</i>
										<?php } else if($row->sentimenttype == 'neutral') { ?>
										<i class='material-icons app-menu md-18 orange'>sentiment_neutral</i>
										<?php } else if($row->sentimenttype == 'negative') { ?>
										<i class='material-icons app-menu md-18 red'>sentiment_very_dissatisfied</i>
										<?php } ?>
								</span>
							</p>
						</span>
					</div>
				<?php } ?>
				
			</div>
		
	</div>

</div>

<div class="container">
	<div id="scrollUpDiv" class="row">
		<div id="scrollUp">
			<a href="#top" class="smoothScroll">
				<i class="material-icons">keyboard_arrow_up</i>
			</a>
		</div>
	</div>
</div>


<script type="text/javascript">
	
	var jsonText = document.getElementById("opinionChartJson").textContent;
	var obj = JSON.parse(jsonText);
	var totalLikes = parseInt(obj.stats[0].sumlikes); 
	var totalNeutrals = parseInt(obj.stats[0].sumneutrals); 
	var totalDislikes = parseInt(obj.stats[0].sumdislikes); 
	var totalValue = totalLikes + totalNeutrals + totalDislikes;
	var positivePercent = Math.round(totalLikes / totalValue * 100) + '%';
	var chart = new Chartist.Pie('#gaugeChart', {
		labels: ['Positive', 'Neutral', 'Negative'],
		series: [totalLikes, totalNeutrals, totalDislikes]
	}, {
		donut: true,
		donutWidth: 10,
		startAngle: 0,
		showLabel: false,
		plugins: [
			Chartist.plugins.fillDonut({
				items: [{
					content: '<p><center>' + positivePercent + '<br>positive</center></p>'
				}]
			})
		]
	});
	
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