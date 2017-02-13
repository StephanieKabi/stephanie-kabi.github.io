<div id="top"></div>

<div class="pageWrap">

  <div class="container">

    <section class="panel">

      <div class="panel-heading">
        <h1><?php echo $panel_title_1; ?></h1>
      </div>

      <div class="panel-body">

        <form action="<?php echo base_url() ?>index.php/comment/<?php if(isset($comment)){echo 'update_comment';}else{echo 'new_comment';} ?>" method="post" enctype="multipart/form-data">

          <div class="row">

            <div class="five columns">

              <div class="container">
                <center>
									<div class="row">
										<img id="blah" src="<?php if(isset($comment)) { echo base_url().'uploadedImages/dish/'.$comment->imagename; } else { echo '#'; } ?>" alt="<?php if(isset($comment)) { echo $comment->imagename; } else { echo 'your image'; } ?>"/>
									</div>
									<br>
									<div class="row">
										<div class="input-group"> <!-- File input -->
											<div class="row">
												<label for="imageUpload">
													<span class="button" style="line-height:38px">
														Upload image of dish
														<?php
														$data = array(
															'id' => 'imageUpload',
															'name' => 'image',
															'style' => 'display: none; cursor: pointer;',
															'accept' => 'image/jpeg, image/png'
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
								</center>
              </div>

            </div>

            <div class="seven columns">

              <div class="container">

                <div class="row">

                  <?php
									
                  echo form_label('Restaurant Name', 'restaurantName');
                  $data = array(
                    'id' => 'restaurantName',
                    'name' => 'restaurantName',
                    'placeholder' => 'Restaurant Name &hellip;',
                    'style' => 'width:100%',
                    'value' => set_value('restaurantName'),
                    'maxlength' => '30',
                    'autofocus' => '',
                    'required' => ''
                  );
                  if(isset($comment)) { $data['value']=$comment->restaurantname.", ".$comment->vicinity; }
                  echo form_input($data);
                  $data = array(
                    'id' => 'newPlaceName',
                    'name' => 'newPlaceName',
                    'style' => 'display:none',
                    'value' => set_value('newPlaceName')
                  );
                  if(isset($comment)) { $data['value']=$comment->restaurantname; }
                  echo form_input($data);
									
									$data = array(
                    'id' => 'newPlaceVicinity',
                    'name' => 'newPlaceVicinity',
                    'style' => 'display:none',
                    'value' => set_value('newPlaceVicinity')
                  );
                  if(isset($comment)) { $data['value']=$comment->vicinity; }
                  echo form_input($data);
									
									$data = array(
                    'id' => 'newPlaceID',
                    'name' => 'newPlaceID',
                    'style' => 'display:none',
                    'value' => ''
                  );
                  if(isset($comment)) { $data['value']=$comment->placeid; }
                  echo form_input($data);
									
                  $data = array(
                    'id' => 'newPlaceLng',
                    'name' => 'newPlaceLng',
                    'style' => 'display:none',
                    'value' => ''
                  );
                  if(isset($comment)) { $data['value']=$comment->longitude; }
                  echo form_input($data);
                  $data = array(
                    'id' => 'newPlaceLat',
                    'name' => 'newPlaceLat',
                    'style' => 'display:none',
                    'value' => ''
                  );
                  if(isset($comment)) { $data['value']=$comment->latitude; }
                  echo form_input($data);

									
                  ?>
                  <?php echo form_error('restaurantName', '<div class="alert alert-danger">', '</div>'); ?>

                </div>

                <div class="row">

                  <?php
                  echo form_label('Dish Name', 'dishName');
                  $data = array(
                    'id' => 'dishName',
                    'name' => 'dishName',
                    'placeholder' => 'Dish Name &hellip;',
                    'style' => 'width:100%',
                    'value' => '',
                    'maxlength' => '30',
                    'autofocus' => '',
                    'required' => ''
                  );
                  if(isset($comment)) { $data['value']=$comment->dishname; }
                  echo form_input($data);
                  ?>
                  <?php echo form_error('dishName', '<div class="alert alert-danger">', '</div>'); ?>

                </div>

                <div class="row">

                  <label for="visitDate">When did you visit?</label>
                  <input type="date" id="visitDate" name="visitDate" style="width:100%" required="" value="<?php if(isset($comment)) { echo $comment->datevisit; } else {echo ''; } ?>">
                  <?php echo form_error('visitDate', '<div class="alert alert-danger">', '</div>'); ?>

                </div>

                <div class="row">

                  <?php
                  echo form_label('Comment', 'dishComment');
                  $data = array(
                    'id' => 'dishComment',
                    'name' => 'dishComment',
                    'placeholder' => 'Comment &hellip;',
                    'style' => 'max-width:100%;min-width:100%;height:200px',
                    'value' => '',
                    'maxlength' => '1000',
                    'required' => ''
                  );
                  if(isset($comment)) { $data['value']=$comment->body; }
                  echo form_textarea($data);
                  ?>
                  <div class="comment-counter">
                    <small><span id="commentCounter">1000</span> characters remaining</small>
                  </div>
                  <?php echo form_error('dishComment', '<div class="alert alert-danger">', '</div>'); ?>

                </div>

              </div>
            </div>

          </div>

          <br>

          <?php
          if(isset($comment)) {
            $data = array(
              'id' => 'commentid_txt',
              'name' => 'commentid_txt',
              'style' => 'display:none',
              'value' => $comment->commentid
            );
            echo form_input($data);
          }
          ?>
					
					<div class="container">
						<div class="row button-row">
							<span class="align-left">
								<input class="button" type="reset" value="Cancel">
							</span>
							<span class="align-right">
								<input
                class="button-primary button-right"
                type="submit"
                value="<?php if(isset($comment)) { echo 'Update Comment'; } else { echo 'Submit'; } ?>"
                name="<?php if(isset($comment)) { echo 'submit_comment_update'; } else { echo 'submit_comment_new'; } ?>"
              >
							</span>
						</div> 
					</div>
					
					<div class="container">
						<div class="row button-row">
							<span class="align-left">
								<?php
								if(isset($_SESSION['logged_in_user_id'])) {
									$data = array(
										'id'=> 'update_comment_back',
										'name'=> 'update_comment_back',
										'class' => 'button button-left',
										'value' => 'true',
										'type'=> 'button',
										'content'=> 'Back to Account',
										'onclick'=> "location.href='".base_url()."index.php/user/profilec'"
									);
									echo form_button($data);
								}
								?>
							</span>
						</div> 
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
		// Google Places location autocomplete for new comment
		var input = document.getElementById('restaurantName');
		var options = {
			types: ["establishment"],
			componentRestrictions: {country:"ke"},
			language: ["en"]
		};
		var autocomplete2 = new google.maps.places.Autocomplete(input, options);
		google.maps.event.addListener(autocomplete2, 'place_changed', function () {
			var place2 = autocomplete2.getPlace();
			document.getElementById('newPlaceName').value = place2.name;
			document.getElementById('newPlaceLng').value = place2.geometry.location.lng();
			document.getElementById('newPlaceLat').value = place2.geometry.location.lat();
			document.getElementById('newPlaceID').value = place2.place_id;
			document.getElementById('newPlaceVicinity').value = place2.vicinity;
		});
	}

</script>

