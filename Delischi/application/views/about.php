<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<div class="container">
	
	<section id="aboutFixedImage">
		 <div id="aboutHeading">
			 <h1>About Delischi</h1>
		 </div>
	 </section>
	
	<div id="aboutSummary">
		<div class="row">
			<div class="six columns">
				<p>Delischi is a guide to good food and where to find it. Instead of reviewing restaurants, you can recommend great dishes and see what others recommend wherever you go.</p>
				<ul>
					<p>This is a kind of local guide that will let you:</p>
					<li>Find whatever you crave and see what's good at any restaurant.</li>
					<li>Browse photos of dishes as easily as looking in a bakery window.</li>
					<li>Share your taste and recommend what looks and tastes good.</li>
				</ul>
				<p>Delischi was created in 2016 as an easy way to find and rate dishes. There are many restaurant review applications and websites that already exist, but there is no easy way to find or rate specific dishes.</p>
			</div>
			<div class="six columns">
				<div class="container">
					<div id="aboutSummaryPicDiv"></div>
				</div>
				<!--<img id="aboutSummaryPic" src='<?php //echo base_url() ?>public/images/aboutHeader.jpg'>-->
			</div>
			
		</div>
		
	</div>
	
	<div id="aboutMission">
		<h3>Mission</h3>
		<p>We're a mission to cover Kenya with amazing food sightings.</p>
		<p>Represent your town by sharing your favorite local dishes!</p>
	</div>
	
	<div id="aboutContact">
		<h3>Contact</h3>
		<p>Have you got enquiries, suggestions or concerns? Running into trouble? We'd love to hear from you and we're here to help.</p>
		<p>Send an email to <a href="mailto:hello.foodie17@gmail.com">Support</a> with your message.</p>
	</div>

</div>
