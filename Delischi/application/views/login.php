<div class="container">
	
	<section id="loginHeader"></section>
	
	<section id="login">
		
		<div class="container" style="max-width:600px">
		
			<h5>Delischi</h5>

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
