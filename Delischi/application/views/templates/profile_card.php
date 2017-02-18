<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

	<div id="top"></div>

  <div class="container">

    <div class="row">

      <div class="three columns">

        <div class="row">

          <section id="accountPanel" class="panel">

            <?php
            echo " <img class='account-panel-avatar' src='".base_url()."uploadedImages/profile/".$user->imagepath."'alt='".$user->imagepath."'> ";
						
						
            ?>
						
						<div id="accountPanelImgBlur"></div>

            <div class="account-panel-text">
							
							<div id="accPanelDiv">

								<div class="container">

									<br>
									<div class="row">
										<center>
											<div class="row"><h5><?php echo $user->firstname." ".$user->lastname; ?></h5></div>
										<center>
									</div>

									<div class="row">
										<center>
											<button class="button-default" type="button" onclick='location.href="<?php echo base_url(); ?>index.php/user/update_profile"' value="<?php echo $user->userid; ?>" id="update_profile_btn" name="update_profile_btn">Update</button>
										</center>
									</div>

								</div>

							</div>

            </div>

          </section>

          <?php 
					if($this->session->userdata('usertype')=='Restaurant Owner'){
						echo "
						<div id='restaurantTextFooter' class='black'>
							<i class='material-icons md-18 app-menu' style='padding-right:5px'>error_outline</i>
							<p>To update your business information, please visit Google Maps.<br>Find out more <a href='https://support.google.com/business/answer/6174435?hl=en' target='_blank'>here</a>.</p>
						</div>
						";
					}
					else if($this->session->userdata('usertype')=='Food Writer'){
            echo '
            <div class="card">
              <br>
              <span>
                <i class="material-icons red">restaurant</i> <br> <small><h7>EATEN</h7></small> <h4>'.$number_dishes_eaten.'</h4>
              </span>
              <span>
								<i class="material-icons red">place</i> <br> <small><h7>VISITED</h7></small> <h4>'.$number_places_visited.'</h4>
              </span>
							';
						if ( ( ($number_dishes_eaten==0)and($number_places_visited==0)and($number_cuisines_eaten==0) ) or ($number_cuisines_eaten>0) ) {
							echo '
              <span>
								<i class="material-icons red">restaurant_menu</i> <br> <small><h7>CUISINES</h7></small> <h4>'.$number_cuisines_eaten.'</h4>
              </span>
            	';
						}
						
						echo '
            </div>
						';
          }
          ?>

        </div>

      </div>
