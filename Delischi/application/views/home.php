<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<script src="<?php echo base_url(); ?>public/js/nl-form.js"></script>

<div id="heroImageHome">
	
	<div class="container homeForm">
	
		<form id="nl-form" class="nl-form" action="<?php echo base_url() ?>index.php/home" method="POST">
			
			<h1>Delischi</h1>
			
			<p>Find the best dishes to eat in any location in Kenya.</p>
			
			<div class="row" style="min-width:100%;max-width:100%;">
				<div class="ten columns">
					<input id="homePlace" name="homePlace" type="search" value="" placeholder="Enter a place to search in ..." required autofocus/>
				</div>
				<div class="two columns">
					<button name="homeSubmit" class="nl-submit" type="submit"><i id="homeBtnTxt" class="material-icons">search</i></button>
				</div>
			</div>
			
			
			
			<!--
			<div class="nl-submit-wrap">
				<button name="homeSubmit" class="nl-submit" type="submit">Find recommendations</button>
			</div>
			<div class="nl-overlay"></div>

-->
			
			<?php if (null !== $this->session->flashdata('homeResultsErr')) { ?>
			<div class="alert alert-warning"><?php echo $this->session->flashdata('homeResultsErr'); ?></div>
			<?php } ?>
			
		</form>
		
	</div>

</div>



<?php if (isset($homeResultsFlash)) { ?>

 <section data-sr id="items-grid" class="u-full-width" style="margin: 50px 0;">
	 
	 <div class="container">
	 
		<div class="filters-section">
		 
		<br>
		 <div class="separator">
			 <h3 class="separator">Recommended in <?php echo $homePlace ?></h3>
		 </div>
	
      <ul id="filters" class="filters u-full-width">
				<li class="active"><a href="#" data-filter="*">All</a></li>
				<?php foreach($homeDishTypes as $row) { ?>
				<li><a href="#" data-filter=".<?php echo $row->dishtype ?>"><?php echo $row->dishtype ?></a></li>
				<?php } ?>
      </ul>
		 
		 </div>

		 <div class="items-section">

			 <div class="row">

				 <ul id="items" class="items isotope js-isotope u-cf"  style="margin: 50px 0;">

					 <?php 
					 $homeResultsFlash = (array) $homeResultsFlash;
					 for($p=0; $p<count($homeResultsFlash); $p++) {
						 $homeResultsFlash[$p] = (array) $homeResultsFlash[$p];
					 ?>

					 <li class="four columns isotopeItem u-full-width <?php echo $homeResultsFlash[$p]['dishtype'] ?>">
						 <div class="exploreListItem">
							 <figure>
								 <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo base_url() ?>uploadedImages/dish/<?php echo $homeResultsFlash[$p]['imagename'] ?>" alt="" width="300" height="300">
								 <noscript>
									 <img src="<?php echo base_url() ?>uploadedImages/dish/<?php echo $homeResultsFlash[$p]['imagename'] ?>">
								 </noscript>
							 </figure>
							 <div class="explore_stats">
								 <span>
									 <span class="comments"><?php echo $homeResultsFlash[$p]['totalcomments'] ?></span>
									 <i class='material-icons app-menu md-18'>chat_bubble_outline</i>
								 </span>
								 <span>
									 <span class="likes"><?php echo $homeResultsFlash[$p]['totallikes'] ?></span>
									 <i class='material-icons app-menu md-18'>sentiment_very_satisfied</i>
								 </span>
								 <span style="display:none" class="dislikes"><?php //echo $explore_dishes[$p]['totaldislikes'] ?></span>
							 </div>
							 <div class="detail">
								 <h5 class="dish"><?php echo $homeResultsFlash[$p]['dishname'] ?></h5>
								 <p class="restaurant"><?php echo $homeResultsFlash[$p]['restaurantname'] ?>, <?php echo $homeResultsFlash[$p]['vicinity'] ?></p>
								 <button type="button" onclick="location.href='<?php echo base_url(); ?>index.php/explore/item?did=<?php echo $homeResultsFlash[$p]['dishlistingid'] ?>'">View</button>
							 </div>
						 </div>
					 </li>

					 <?php } ?>

				 </ul>

			 </div>  <!-- row -->	 

		 </div>
		 
	 </div>

</section>


<script src="<?php echo base_url(); ?>public/js/isotope.pkgd.min.js"></script> 
<script type="text/javascript">
	
	$(document).ready(function () {
		

    $('html, body').animate({
			scrollTop: $('#items-grid').offset().top
    }, 800);
		
		
		// Isotope filter
		$('#filters li').find('a').click(function(){
			$('#filters li').removeClass('active');
			$('#items').isotope({
				filter: $(this).attr('data-filter'),
				itemSelector: '.isotopeItem',
				animationEngine : "best-available",
				masonry: {
					columnWidth: '.isotopeItem'
				}
			});
			$('html, body').animate({
				scrollTop: $('#items-grid').offset().top
			}, 800);
			$(this).parent().addClass('active');
			return false;
		});
		

		// Lazy image loading
		inView( '.isotopeItem figure' ).on( 'enter', function( figure ) {
			var img = figure.querySelector( 'img' ); 
			if ( 'undefined' !== typeof img.dataset.src ) {
				figure.classList.add( 'is-loading' );
				newImg = new Image();
				newImg.src = img.dataset.src;
				newImg.addEventListener( 'load', function() {
					figure.innerHTML = '';
					figure.appendChild( this );
					setTimeout( function() {
						figure.classList.remove( 'is-loading' );
						//figure.classList.add( 'is-loaded' );
					}, 300 );
				});
			}
		});
		
	
	});

</script>

<?php } ?>

