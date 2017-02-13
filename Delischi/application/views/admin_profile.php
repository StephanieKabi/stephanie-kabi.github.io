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
		
		<section id="adminFixedImage">
	 <div id="adminHeading">
		 <h1>Admin</h1>
	 </div>
	</section>

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
						<div id='restaurantTextFooter' class='blue'>
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
              <span>
								<i class="material-icons red">restaurant_menu</i> <br> <small><h7>CUISINES</h7></small> <h4>'.$number_cuisines_eaten.'</h4>
              </span>
            </div>
            ';
          }
          ?>

        </div>

      </div>

<div class="nine columns">

	<section class="panel" id="usersPanel">
					
		<h2>Users</h2>
		<div class="adminUserCards">
			<?php 
			$users_per_group = (array) $users_per_group;
			for($p=0; $p<count($users_per_group); $p++) {
				$users_per_group[$p] = (array) $users_per_group[$p];
			?>
			<div class="four columns">
				<div class="card card-blue">
					<span class="card-number"><?php echo $users_per_group[$p]['totalusers'] ?></span>
					<span class="card-title">
					<?php 
					echo $users_per_group[$p]['usertype']; 
					if ($users_per_group[$p]['totalusers']>1){
						echo "s";
					} 
					?>
					</span>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		
		<br>

		<table class="u-full-width">
			<thead>
				<tr>
					<th></th>
					<th>Name</th>
					<th>Email</th>
					<th>Account</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($allusers as $row) { ?>
				<tr>
					<td><img class="userlist-img" src='<?php echo base_url() ?>uploadedImages/profile/<?php echo $row->imagepath ?>'></td>
					<td><?php echo $row->firstname ?> <?php echo $row->lastname ?></td>
					<td><?php echo $row->emailaddress ?></td>
					<td><?php echo $row->usertype ?></td>
					<td>
						<a id="<?php echo $row->userid ?>" onclick="javascript:deleteConfirm('<?php echo base_url() ?>index.php/user/admin_delete_user?uid=<?php echo $row->userid ?>')"><i class="material-icons not-menu red md-24">delete_forever</i></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
	</section>
	
	
	
	<div id="scrollUpDiv" class="row">
		<div id="scrollUp">
			<a href="#top" class="smoothScroll">
				<i class="material-icons">keyboard_arrow_up</i>
			</a>
		</div>
	</div>

</div>

</div>

</div>

<script type="text/javascript">
	
	// confirm delete record
	function deleteConfirm(url) {
    if(confirm('Do you want to delete this user?')) {
			window.location.href=url; 
		}
	}
	
</script>

