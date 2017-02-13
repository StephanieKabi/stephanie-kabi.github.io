 <?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<div id="top"></div>

<div class="pageWrap">

  <div class="container">
		
		<section id="reviewFixedImage">
		 <div id="reviewHeading">
			 <h1>Reviews</h1>
		 </div>
	 </section>
		
		<section class="panel">

			<div class="panel-body">

					<div class='row'>
						<?php 
						if(! isset($reviews)){
							echo "
							<div class='six columns'>
								<center>
									<img id='no_comment_img' src='".base_url()."public/images/discovery.png' style='width:200px;height:200px;object-fit:cover;border-radius:50%;clear:both;float:right;'>
								</center>
							</div>
							<div class='six columns'>
								<br><br>
								<h4>Nothing to see here.</h4>
							</div>
							";
						}
						else {
							?>
						<ul id="filters" class="filters u-full-width">
							<li class="active" data-sort-value="original-order"> <a href="#">Original&nbsp;Order</a> </li>
							<li data-sort-value="dish"> <a href="#">Dish</a> </li>
							<li data-sort-value="sentiment"> <a href="#">Sentiment</a> </li>
							<li data-sort-value="date"> <a href="#">Oldest</a> </li>
						</ul>
						
						<div id="isotopeReviews">
							<?php foreach($reviews as $row) { ?>
							<div class="customerReviews">
								<h5 class="dish"><?php echo $row->dishname ?></h5>
								<span>
									<p>
										<span class="exploreProfileImg">
											<img class="userlist-img" src="<?php echo base_url() ?>uploadedImages/profile/<?php echo $row->imagepath ?>">
										</span>
										<span class="exploreProfileText">
											<label class="sentiment" style="display:none"><?php echo $row->sentimenttype ?></label>
											<q> <?php echo $row->body ?> </q> - <b><?php echo $row->firstname." ".$row->lastname ?></b>, <small>
											<span class="date"><?php echo date( 'M j, Y', strtotime($row->datevisit) ) ?></span></small>
											<?php if($row->sentimenttype == 'positive') { ?>
											<i class='material-icons app-menu md-24 green'>sentiment_very_satisfied</i>
											<?php } else if($row->sentimenttype == 'neutral') { ?>
											<i class='material-icons app-menu md-24 orange'>sentiment_neutral</i>
											<?php } else if($row->sentimenttype == 'negative') { ?>
											<i class='material-icons app-menu md-24 red'>sentiment_very_dissatisfied</i>
											<?php } ?>
										</span>
									</p>
								</span>
							</div>
								<?php } ?>
						</div>
						<?php
							}
						?>
							
						</div>

					</div>

				</div>

		</section>

  </div> <!-- <div class="container"> -->
	
	<div id="scrollUpDiv" class="row">
			 <div id="scrollUp">
				 <a href="#top" class="smoothScroll">
					 <i class="material-icons">keyboard_arrow_up</i>
				 </a>
			 </div>
		 </div>

</div> <!-- <div class="pageWrap"> -->

<script src="<?php echo base_url(); ?>public/js/isotope.pkgd.min.js"></script>
<!--<script src="https://unpkg.com/isotope-layout@3.0/dist/isotope.pkgd.min.js"></script>-->
<script type="text/javascript">
$(document).ready(function () {
	// Isotope sort
	var iso = new Isotope( '#isotopeReviews', {
		itemSelector: '.customerReviews',
		layoutMode: 'vertical',
		getSortData: {
			dish: '.dish', 
			sentiment: '.sentiment',
			date: '.date'
		},
		sortAscending : true
	});
	$('[data-sort-value]').click( function( event ) {
		event.preventDefault();
		$('#filters li').removeClass('active');
		$(this).addClass('active');
		var sortValue = $(this).attr('data-sort-value');
		iso.arrange({
			sortBy: sortValue
		});
	 });
});

</script>
