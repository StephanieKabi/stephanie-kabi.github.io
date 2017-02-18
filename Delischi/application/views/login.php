<!-- Google Platform Library that integrates Google Sign-In -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

<div class="container">
	
	<section id="loginHeader"></section>
	
	<section id="login">
		
		<div class="container" style="max-width:600px">
		
			<h5 id="loginProjectName">Delischi</h5>

			<h2>It's <span style="color:#FF5722">great</span> to see you again!</h2>
			
			<?php 
			if( null!==$this->session->tempdata('emailAddressConfirmation') ) {
				echo $this->session->tempdata('emailAddressConfirmation');
			} 
			?>

			<div class="container"> <?php echo $this->session->flashdata('loginMsg'); ?> </div>
			
			<form action="<?php echo base_url() ?>index.php/login/check_login" method="POST" enctype="multipart/form-data">
				
				<div class="row">
					<div class="three columns">
						<?php
						echo form_label('Email', 'inputEmailLogin');
						?>
					</div>
					<div class="nine columns">
						<input id="inputEmailLogin" name="inputEmailLogin" type="email" placeholder="e.g. abc@mail.com" style="width:100%" value="<?php set_value('inputEmailLogin') ?>" maxlength="30" autofocus required >
						<?php 
						echo form_error('inputEmailLogin', '<div class="alert alert-danger">', '</div>'); 
						?>
					</div>
				</div>
				
				<div class="row">
					<div class="three columns">
						<?php
						echo form_label('Password', 'inputPasswordLogin');
						?>
					</div>
					<div class="nine columns">
						<?php
						$data = array(
							'id' => 'inputPasswordLogin',
							'name' => 'inputPasswordLogin',
							'placeholder' => 'Password &hellip;',
							'style' => 'width:100%',
							'value' => '',
							'maxlength' => '20',
							'required' => ''
						);
						echo form_password($data);
						?>
						<?php 
						echo form_error('inputPasswordLogin', 'div class="alert alert-danger">', '</div>'); 
						?>
					</div>
				</div>
				
				<div class="container">
					<div class="row button-row">
						<span class="align-right">
							<input class="button-primary" type="submit" value="Sign In" name="submit_login">
						</span>
					</div> 				
				</div>
				
				
				<p>
					Don't have an account?<b> <a href="<?php echo base_url(); ?>index.php/signup">Create yours here.</a></b>
				</p>
			
			</form>
		
		</div>
		
	</section>

</div>

<script type="text/javascript">
	
	/*
	
function onSignIn(googleUser) {
	
	// 1. To retrieve profile information for a user
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
	
	// 2. auth2 is initialized with gapi.auth2.init() and a user is signed in
	if (auth2.isSignedIn.get()) {
		var profile = auth2.currentUser.get().getBasicProfile();
		console.log('ID: ' + profile.getId());
		console.log('Full Name: ' + profile.getName());
		console.log('Given Name: ' + profile.getGivenName());
		console.log('Family Name: ' + profile.getFamilyName());
		console.log('Image URL: ' + profile.getImageUrl());
		console.log('Email: ' + profile.getEmail());
	}
	
	// 3. After a user successfully signs in, get the user's ID token, then send it to your server with a HTTPS POST request:
	var id_token = googleUser.getAuthResponse().id_token;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'https://www.delischi.com/login/loginWithGoogle');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.onload = function() {
		console.log('Signed in as: ' + xhr.responseText);
	};
	xhr.send('idtoken=' + id_token);
	window.location.href='<?php //echo base_url() ?>index.php/login/loginWithGoogle';
	
}

*/
	
</script>
