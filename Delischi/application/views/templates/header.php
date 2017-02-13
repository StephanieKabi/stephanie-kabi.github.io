<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">

    <title><?php echo $page_heading; ?></title>
		
    <script src="<?php echo base_url(); ?>public/js/pace.min.js"></script>

		<script src="<?php echo base_url(); ?>public/js/jquery-3.1.0.min.js"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
		<script src="<?php echo base_url(); ?>public/js/parallax.min.js"></script>
		<script src="<?php echo base_url(); ?>public/js/in-view.min.js"></script>


    <link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" />

    <link href="<?php echo base_url(); ?>public/css/normalize.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>public/css/skeleton.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>public/css/chartist.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Cabin|Raleway:400,600,700" rel="stylesheet">
		
		
		<!-- Autocomplete -->
    <link href="<?php echo base_url(); ?>public/css/jquery-ui.css" rel="stylesheet" />
		<!--<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />-->
		
		

  </head>

  <body> 
		
    <?php
    if(isset($_SESSION['logged_in_user_id'])) {
      $userid = $this->session->userdata('logged_in_user_id');
      $usertype = $this->session->userdata('usertype');
      $imagename = $this->session->userdata('profile_image');
    }
    ?>

		<div class="menuIcon">
			<div class="bar <?php if($currentPage=='home') { echo 'white'; } else { echo 'black'; } ?>"></div>
			<div class="bar <?php if($currentPage=='home') { echo 'white'; } else { echo 'black'; } ?>"></div>
			<div class="bar <?php if($currentPage=='home') { echo 'white'; } else { echo 'black'; } ?>"></div>
		</div>
    <nav class="navigation">
			<?php  if(isset($_SESSION['logged_in_user_id'])) { ?>
			<div id="navProfileImageDiv"><img id="navProfileImg" src="<?php echo base_url() ?>uploadedImages/profile/<?php echo $this->session->userdata('profile_image') ?>"></div>
			<?php } ?>
      <ul class="main-navigation" role="navigation">
        <?php if(!(isset($_SESSION['logged_in_user_id']))) { ?>
        <li><a href='<?php echo base_url() ?>' class="<?php if($currentPage=='home'){ echo 'current'; } ?>"> <span class='app-menu-name'>Home</span></a></li>
        <li><a href='<?php echo base_url() ?>index.php/explore' class="<?php if($currentPage=='explore'){ echo'current'; } ?>"> <span class='app-menu-name'>Explore</span></a></li>
        <li><a href='<?php echo base_url() ?>index.php/login' class="<?php if($currentPage=='login'){ echo'current'; } ?>"> <span class='app-menu-name'>Log In</span></a></li>
        <li><a href='<?php echo base_url() ?>index.php/about' class="<?php if($currentPage=='about'){ echo'current'; } ?>"> <span class='app-menu-name'>About</span></a></li>
        <li><a href='<?php echo base_url() ?>index.php/comment'> <span class='app-menu-name'>Rate a Dish</span></a></li>
        <?php }
        elseif(isset($_SESSION['logged_in_user_id'])) {
          if($usertype=="Food Writer") { ?>
            <li><a href='<?php echo base_url() ?>index.php/user/profilec' class="<?php if($currentPage=='account'){ echo'current'; } ?>"> <span class='app-menu-name'>Account</span></a></li>
            <li><a href='<?php echo base_url() ?>' class="<?php if($currentPage=='home'){ echo'current'; } ?>"> <span class='app-menu-name'>Home</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/explore' class="<?php if($currentPage=='explore'){echo'current';} ?>"> <span class='app-menu-name'>Explore</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/about' class="<?php if($currentPage=='about'){echo'current';} ?>"><span class='app-menu-name'>About</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/user/logout'><span class='app-menu-name'>Log out</span></a></li>
          <?php }
          elseif ($usertype=="Restaurant Owner") { ?>
            <li><a href='<?php echo base_url() ?>index.php/restaurant/dashboard' class="<?php if($currentPage=='business_dashboard'){echo'current';} ?>"> <span class='app-menu-name'>Dashboard</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/restaurant/reviews' class="<?php if($currentPage=='business_reviews'){echo'current';} ?>"> <span class='app-menu-name'>Reviews</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/restaurant/menu' class="<?php if($currentPage=='menu'){echo'current';} ?>"> <span class='app-menu-name'>Menu</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/restaurant/info' class="<?php if($currentPage=='info'){echo'current';} ?>"> <span class='app-menu-name'>Info</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/user/logout'><span class='app-menu-name'>Log out</span></a></li>
          <?php }
          else { ?>
            <li><a href='<?php echo base_url() ?>index.php/user/profilea' class="<?php if($currentPage=='admin_profile'){echo'current';} ?>"> <span class='app-menu-name'>Account</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/about' class="<?php if($currentPage=='about'){echo'current';} ?>"> <span class='app-menu-name'>About</span></a></li>
            <li><a href='<?php echo base_url() ?>index.php/user/logout'><span class='app-menu-name'>Log out</span></a></li>
          <?php }
        }

        ?>

      </ul>

    </nav>
		
		<div class="pageWrap">

