<div id="top"></div>

<div class="pageWrap">

  <div class="container">

    <section class="panel">

      <div class="panel-heading">
				<br>
        <h2><?php echo $panel_title_1; ?></h2>
      </div>

      <div class="panel-body">

        <form action="<?php echo base_url() ?>index.php/user/update_profile" method="post" enctype="multipart/form-data">

          <div class="row">

            <div class="five columns">

              <div class="container">
                <center>
									<div class="row">
										<img id="blah" src="<?php if(isset($user)) { echo base_url().'uploadedImages/profile/'.$user->imagepath; } else { echo '#'; } ?>" alt="<?php if(isset($user)) { echo $user->imagepath; } else { echo 'your image'; } ?>"/>
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
                      echo form_label('First Name', 'firstNameUpdate');
                      $data = array(
                        'id' => 'firstNameUpdate',
                        'name' => 'firstNameUpdate',
                        'placeholder' => 'First Name &hellip;',
                        'style' => 'width:100%',
                        'value' => $user->firstname,
                        'maxlength' => '20',
                        'autofocus' => '',
                        'required' => ''
                      );
                      echo form_input($data);
                      echo form_error('firstNameUpdate', '<div class="alert alert-danger">', '</div>');
                      ?>
                    </div>

                  </div>

                  <div class="six columns">

                    <div class="row">
                      <?php
                      echo form_label('Last Name', 'lastNameUpdate');
                      $data = array(
                        'id' => 'lastNameUpdate',
                        'name' => 'lastNameUpdate',
                        'placeholder' => 'Last Name &hellip;',
                        'style' => 'width:100%',
                        'value' => $user->lastname,
                        'maxlength' => '20',
                        'required' => ''
                      );
                      echo form_input($data);
                      echo form_error('lastNameUpdate', '<div class="alert alert-danger">', '</div>');
                      ?>
                    </div>

                  </div>

                </div>

                <div class="row">
                  <?php echo form_label('Email', 'inputEmailUpdate'); ?>
                  <input id="inputEmailUpdate" name="inputEmailUpdate" type="email" placeholder="e.g. abc@mail.com" style="width:100%" value="<?php echo $user->emailaddress; ?>" maxlength="30" autofocus="" required="" readonly >
                  <?php echo form_error('inputEmailUpdate', '<div class="alert alert-danger">', '</div>'); ?>
                </div>
								
								<?php if (null !== $this->session->flashdata('passMatchErr')) { ?>
								<div class="alert alert-danger"><?php echo $this->session->flashdata('passMatchErr'); ?></div>
								<?php } ?>

                <div class="row">
                  <?php
                  echo form_label('Password', 'inputPasswordUpdate');
                  $data = array(
                    'id' => 'inputPasswordUpdate',
                    'name' => 'inputPasswordUpdate',
                    'placeholder' => 'Password &hellip;',
                    'style' => 'width:100%',
                    'value' => '',
                    'maxlength' => '20',
                    'required' => ''
                  );
                  echo form_password($data);
                  echo form_error('inputPasswordUpdate', '<div class="alert alert-danger">', '</div>'); ?>
                </div>

                <div class="row">
                  <?php
                  echo form_label('Confirm Password', 'confirmPasswordUpdate');
                  $data = array(
                    'id' => 'confirmPasswordUpdate',
                    'name' => 'confirmPasswordUpdate',
                    'placeholder' => 'Confirm Password &hellip;',
                    'style' => 'width:100%',
                    'value' => '',
                    'maxlength' => '50',
                    'required' => ''
                  );
                  echo form_password($data);
                  echo form_error('confirmPasswordUpdate', '<div class="alert alert-danger">', '</div>');
                  ?>
                </div>

								<div class="row">
									<?php 
									if($this->session->userdata('usertype')=="Restaurant Owner") { ?>
										<?php if (null !== $this->session->flashdata('restClaimErr')) { ?>
										<div class="alert alert-danger"><?php echo $this->session->flashdata('restClaimErr'); ?></div>
										<?php } ?>
									<?php
										echo form_label('Restaurant Name', 'restaurantNameUpdate');
										$data = array(
											'id' => 'restaurantNameUpdate',
											'name' => 'restaurantNameUpdate',
											'placeholder' => 'Restaurant Name &hellip;',
											'style' => 'width:100%',
											'maxlength' => '30'
										);
										if(isset($restaurant)) {
											$data['value'] = $restaurant->restaurantname.", ".$restaurant->vicinity;
										}
										echo form_input($data);
										$data = array(
											'id' => 'newPlaceNameUpdate',
											'name' => 'newPlaceNameUpdate',
											'style' => 'display:none'
										);
										if(isset($restaurant)) {
											$data['value'] = $restaurant->restaurantname;
										}
										echo form_input($data);
										$data = array(
											'id' => 'newPlaceLngUpdate',
											'name' => 'newPlaceLngUpdate',
											'style' => 'display:none',
											'value' => ''
										);
										if(isset($restaurant)) {
											$data['value'] = $restaurant->longitude;
										}
										echo form_input($data);
										$data = array(
											'id' => 'newPlaceLatUpdate',
											'name' => 'newPlaceLatUpdate',
											'style' => 'display:none',
											'value' => ''
										);
										if(isset($restaurant)) {
											$data['value'] = $restaurant->latitude;
										}
										echo form_input($data);
										$data = array(
											'id' => 'newPlaceIDUpdate',
											'name' => 'newPlaceIDUpdate',
											'style' => 'display:none',
											'value' => ''
										);
										if(isset($restaurant)) {
											$data['value'] = $restaurant->placeid;
										}
										echo form_input($data);
										$data = array(
											'id' => 'newPlaceVicinityUpdate',
											'name' => 'newPlaceVicinityUpdate',
											'style' => 'display:none'
										);
										if(isset($restaurant)) {
											$data['value'] = $restaurant->vicinity;
										}
										echo form_input($data);
										echo form_error('restaurantNameUpdate', '<div class="alert alert-danger">', '</div>');
									}
									?>

              </div>

              </div>

            </div>

          </div>

          
          </div>
				
				<div class="container">
						<div class="row button-row">
							<span class="align-left">
								<input class="button" type="reset" value="Cancel">
							</span>
							<span class="align-right">
								<input class="button-primary button-right" type="submit" value="<?php if(isset($user)) { echo 'Update'; } else { echo 'Submit'; } ?>" name="submit_user_update">
							</span>
						</div> 
					</div>

          <div class="row button-row">
            <div class="container">
              <?php
              $data = array(
                'id'=> 'update_user_back',
                'name'=> 'update_user_back',
                'class' => 'button button-left',
                'value' => 'true',
                'type'=> 'button',
                'content'=> 'Back to Account'
              );
              if($this->session->userdata('usertype')=="Administrator") {
                $data['onclick'] = "location.href='".base_url()."index.php/user/profilea'";
              }
              elseif ($this->session->userdata('usertype')=="Restaurant Owner") {
                $data['onclick'] = "location.href='".base_url()."index.php/restaurant/info'";
              }
              else {
                $data['onclick'] = "location.href='".base_url()."index.php/user/profilec'";
              }
              echo form_button($data);
              ?>
            </div>
          </div>

          </form>

        </div>
		
			<div id="scrollUpDiv" class="row">
		<div id="scrollUp">
			<a href="#top" class="smoothScroll">
				<i class="material-icons">keyboard_arrow_up</i>
			</a>
		</div>
	</div>

      </section>

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
		// Google Places location autocomplete for profile update
		var inputUpdate = document.getElementById('restaurantNameUpdate');
		var optionsUpdate = {
			types: ["establishment"],
			componentRestrictions: {country:"ke"},
			language: ["en"]
		};
		var autocompleteUpdate = new google.maps.places.Autocomplete(inputUpdate, optionsUpdate);
		google.maps.event.addListener(autocompleteUpdate, 'place_changed', function () {
			var placeUpdate = autocompleteUpdate.getPlace();
			document.getElementById('newPlaceNameUpdate').value = placeUpdate.name;
			document.getElementById('newPlaceLngUpdate').value = placeUpdate.geometry.location.lng();
			document.getElementById('newPlaceLatUpdate').value = placeUpdate.geometry.location.lat();
			document.getElementById('newPlaceIDUpdate').value = placeUpdate.place_id;
			document.getElementById('newPlaceVicinityUpdate').value = placeUpdate.vicinity;
		});
	}

</script>
