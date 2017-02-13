<div id="top"></div>

<div class="container">

    <section class="panel" id="createAccPanel">

      <div class="panel-heading">
        <h2><?php echo $panel_title_1; ?></h2>
      </div>

      <div class="panel-body">

        <form action="<?php echo base_url() ?>index.php/signup/create_user" method="post" enctype="multipart/form-data" >

          <div class="row">

            <div class="five columns">

              <div class="container">
								<center>
									<div class="row">
										<img id="blah" src="#" alt="your image" />
									</div>
									<br>
									<div class="row">
										<div class="input-group"> <!-- File input -->
											<div class="row">
												<label for="imageUpload">
													<span class="button" style="line-height:38px">
														Upload Profile Image
														<?php
														$data = array(
															'id' => 'imageUpload',
															'name' => 'image',
															'style' => 'display: none; cursor: pointer;',
															'accept' => 'image/jpeg, image/png, image/gif'
														);
														echo form_upload($data);
														?>
													</span>
												</label>
											</div>
											<div class="row">
												<?php
												$data = array(
													'id' => 'image_name',
													'name' => 'image_name',
													'value' => set_value('image_name')
												);
												echo form_hidden($data);
												?>
											</div>
										</div>
										<?php echo form_error('image_name', '<div class="alert alert-danger">', '</div>'); ?>
									</div>
								</div>
							</center>
            </div>

            <div class="seven columns">

              <div class="container">

                <div class="row">

                  <div class="six columns">

                    <div class="row">
                      <?php
                      echo form_label('First Name', 'firstName');
                      $data = array(
                        'id' => 'firstName',
                        'name' => 'firstName',
                        'placeholder' => 'First Name &hellip;',
                        'style' => 'width:100%',
                        'value' => set_value('firstName'),
                        'maxlength' => '20',
                        'autofocus' => '',
                        'required' => ''
                      );
                      echo form_input($data);
                      echo form_error('firstName', '<div class="alert alert-danger">', '</div>');
                      ?>
                    </div>

                  </div>

                  <div class="six columns">

                    <div class="row">
                      <?php
                      echo form_label('Last Name', 'lastName');
                      $data = array(
                        'id' => 'lastName',
                        'name' => 'lastName',
                        'placeholder' => 'Last Name &hellip;',
                        'style' => 'width:100%',
                        'value' => set_value('lastName'),
                        'maxlength' => '20',
                        'required' => ''
                      );
                      echo form_input($data);
                      echo form_error('lastName', '<div class="alert alert-danger">', '</div>');
                      ?>
                    </div>

                  </div>

                </div>

                <div class="row">
                  <?php echo form_label('Email', 'inputEmail'); 
									echo form_error('inputEmail', '<div class="alert alert-danger">', '</div>');?>
                  <input id="inputEmail" name="inputEmail" type="email" placeholder="e.g. abc@mail.com" style="width:100%" value="<?php echo set_value('inputEmail'); ?>" maxlength="30" autofocus="" required="" >
                </div>
								
								<?php if (null !== $this->session->flashdata('passMatchErr')) { ?>
								<div class="alert alert-danger"><?php echo $this->session->flashdata('passMatchErr'); ?></div>
								<?php } ?>

                <div class="row">
                  <?php
                  echo form_label('Password', 'inputPassword');
                  $data = array(
                    'id' => 'inputPassword',
                    'name' => 'inputPassword',
                    'placeholder' => 'Password &hellip;',
                    'style' => 'width:100%',
                    'value' => set_value('inputPassword'),
                    'maxlength' => '20',
                    'required' => ''
                  );
                  echo form_password($data);
                  echo form_error('inputPassword', '<div class="alert alert-danger">', '</div>'); ?>
                </div>

                <div class="row">
                  <?php
                  echo form_label('Confirm Password', 'confirmPassword');
                  $data = array(
                    'id' => 'confirmPassword',
                    'name' => 'confirmPassword',
                    'placeholder' => 'Confirm Password &hellip;',
                    'style' => 'width:100%',
                    'value' => set_value('confirmPassword'),
                    'maxlength' => '20',
                    'required' => ''
                  );
                  echo form_password($data);
                  echo form_error('confirmPassword', '<div class="alert alert-danger">', '</div>');
                  ?>
                </div>

                <div class="row">

                  <div class="three columns">

                    <div class="row">
                      <?php echo form_label('Sign Up As:', 'accountType'); ?>

                    </div>

                  </div>

                  <div class="nine columns">

                    <div class="row">
											
                      <select id="accountType" name="accountType" style="width:100%" required>
                        <option value="" selected="selected" disabled>-- Select Account Type --</option>
                        <option value="3">Food Writer</option>
                        <option value="2">Restaurant Owner</option>
                      </select>
											<?php
											$data = array(
												'id' => 'accTypeValue',
												'name' => 'accTypeValue',
												'style' => 'display:none',
												'value' => set_value('accTypeValue')
											);
											echo form_input($data);
											?>
                      <?php echo form_error('accountType', '<div class="alert alert-danger">', '</div>'); ?>
                    </div>

                  </div>

                </div>


              </div>

            </div>

          </div>
					
					<?php
					if (null !== $this->session->flashdata('restClaimErr')) { ?>
					<div class="container">
						<div class="alert alert-danger"><?php echo $this->session->flashdata('restClaimErr'); ?></div>
						</div>
					<?php } ?>

          <div class="row" id="restaurantSignupDiv" style="display:none"> <!-- Restaurant details input if selected account is "Restaurant Owner" -->

            <div class="container">
              <br><br><h4><b>Restaurant Details</b></h4>
            </div>

            <div class="row">
								
								<div class="container">
								
								<?php
									echo form_label('Restaurant Name', 'restaurantNameSignup');
									$data = array(
										'id' => 'restaurantNameSignup',
										'name' => 'restaurantNameSignup',
										'placeholder' => 'Restaurant Name &hellip;',
										'style' => 'width:100%',
										'value' => set_value('restaurantName'),
										'maxlength' => '30'
									);
									echo form_input($data);
									$data = array(
										'id' => 'newPlaceNameSignup',
										'name' => 'newPlaceNameSignup',
										'style' => 'display:none',
										'value' => set_value('newPlaceNameSignup')
									);
									echo form_input($data);
									$data = array(
										'id' => 'newPlaceLngSignup',
										'name' => 'newPlaceLngSignup',
										'style' => 'display:none',
										'value' => set_value('newPlaceLngSignup')
                  );
                  echo form_input($data);
                  $data = array(
										'id' => 'newPlaceLatSignup',
                    'name' => 'newPlaceLatSignup',
                    'style' => 'display:none',
                    'value' => set_value('newPlaceLatSignup')
                  );
                  echo form_input($data);
                  $data = array(
                    'id' => 'newPlaceIDSignup',
                    'name' => 'newPlaceIDSignup',
                    'style' => 'display:none',
                    'value' => set_value('newPlaceIDSignup')
                  );
                  echo form_input($data);
									$data = array(
                    'id' => 'newPlaceVicinitySignup',
                    'name' => 'newPlaceVicinitySignup',
                    'style' => 'display:none',
                    'value' => set_value('newPlaceVicinitySignup')
                  );
                  echo form_input($data);
                  echo form_error('restaurantNameSignup', '<div class="alert alert-danger">', '</div>'); 
									?>

							</div>								
							
						</div>
						
					</div>
					
					<div class="container">
						<div class="row button-row">
							<span class="align-left">
								<input class="button button-left" type="reset" value="Cancel">
							</span>
							<span class="align-right">
								<input class="button-primary button-right" type="submit" value="Create Account" name="submit_new_user">
							</span>
						</div> 
					</div>
					
					<br>
					
					<div class="row button-row">
						<span class="align-left">
							<button class='button' type='button' onclick='location.href="<?php echo base_url() ?>index.php/login"' value="true" id="backToLogin" name="backToLogin">Back to Login</button>
						</span>
					</div> 
					

          </form>

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
	
	//Google Places API
  var myKey = "AIzaSyDKMVi4DHwSl1lbuXrSlZuuStzvQp00JJ4";
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src="https://www.google.com/jsapi";
  document.body.appendChild(script);
  var script2 = document.createElement('script');
  script2.type = 'text/javascript';
  script2.src = "https://maps.googleapis.com/maps/api/js?libraries=places&key=" + myKey + "&callback=initialize";
  document.body.appendChild(script2);
	
	function initialize() {
		// Google Places location autocomplete for new restaurant at signup
    var input = document.getElementById('restaurantNameSignup');
    var options = {
      types: ["establishment"],
      componentRestrictions: {country:"ke"},
      language: ["en"]
    };
    var autocomplete1 = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete1, 'place_changed', function () {
      var place = autocomplete1.getPlace();
      document.getElementById('newPlaceNameSignup').value = place.name;
      document.getElementById('newPlaceLngSignup').value = place.geometry.location.lng();
      document.getElementById('newPlaceLatSignup').value = place.geometry.location.lat();
      document.getElementById('newPlaceIDSignup').value = place.place_id;
      document.getElementById('newPlaceVicinitySignup').value = place.vicinity;
    });
	}

</script>
