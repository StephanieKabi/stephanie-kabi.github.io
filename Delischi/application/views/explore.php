<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<div id="top"></div>

<div id="exploreSearch">
	<div class="container">
		<form id="exploreSearchForm" action="<?php echo base_url() ?>index.php/explore/search" method="POST">
			<input id="exploreSearchInput" name="exploreSearchInput" type="search" value="" placeholder="Search" required/>
			<button id="exploreSearchSubmit" name="exploreSearchSubmit" class="button-primary" type="submit"><i class="material-icons md-18"></i></button>
		</form>
	</div>
</div>

 <section data-sr id="items-grid" class="u-full-width">
	 
	 <div class="container">
	 
	 <div class="filters-section">
		 
		<br>
		 <div class="separator">
			 <h3 class="separator">Featured</h3>
		 </div>
	
      <ul id="filters" class="filters u-full-width">
				<li class="active" data-sort-value="original-order"> <a href="#">Original&nbsp;Order</a> </li>
				<li data-sort-value="dish"> <a href="#">Dish</a> </li>
				<li data-sort-value="restaurant"> <a href="#">Restaurant</a> </li>
      </ul>
		 
		 </div>

		 <div class="items-section">

			 <div class="row">

				 <ul id="items" class="items isotope js-isotope u-cf">

					 <?php 
					 $explore_dishes = (array) $explore_dishes;
					 for($p=0; $p<count($explore_dishes); $p++) {
						 $explore_dishes[$p] = (array) $explore_dishes[$p];
					 ?>

					 <li class="four columns isotopeItem u-full-width <?php echo $explore_dishes[$p]['dishtype'] ?>">
						 <div class="exploreListItem">
							 <figure>
								 <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo base_url() ?>uploadedImages/dish/<?php echo $explore_dishes[$p]['imagename'] ?>" alt="" width="300" height="300">
								 <noscript>
									 <img src="<?php echo base_url() ?>uploadedImages/dish/<?php echo $explore_dishes[$p]['imagename'] ?>">
								 </noscript>
							 </figure>
							 <div class="explore_stats">
								 <span>
									 <span class="comments"><?php echo $explore_dishes[$p]['totalcomments'] ?></span>
									 <i class='material-icons app-menu md-18'>chat_bubble_outline</i>
								 </span>
								 <span>
									 <span class="likes"><?php echo $explore_dishes[$p]['totallikes'] ?></span>
									 <i class='material-icons app-menu md-18'>sentiment_very_satisfied</i>
								 </span>
								 <span style="display:none" class="dislikes"><?php //echo $explore_dishes[$p]['totaldislikes'] ?></span>
							 </div>
							 <div class="detail">
								 <h5 class="dish"<small><?php echo $explore_dishes[$p]['dishname'] ?></small></h5>
								 <p class="restaurant"><?php echo $explore_dishes[$p]['restaurantname'] ?>, <?php echo $explore_dishes[$p]['vicinity'] ?></p>
								 <button type="button" onclick="location.href='<?php echo base_url(); ?>index.php/explore/item?did=<?php echo $explore_dishes[$p]['dishlistingid'] ?>'">View</button>
							 </div>
						 </div>
					 </li>

					 <?php } ?>

				 </ul>

			 </div>  <!-- row -->

			 <div class="container">

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
	
	</section>


<script src="<?php echo base_url(); ?>public/js/isotope.pkgd.min.js"></script> 
<!--<script src="https://unpkg.com/isotope-layout@3.0/dist/isotope.pkgd.min.js"></script>-->
<script type="text/javascript">
	 
	
	$(document).ready(function () {
		
		// Isotope sort
		var iso = new Isotope( '#items', {
			itemSelector: '.isotopeItem',
			masonry: {
				columnWidth: '.isotopeItem'
			},
			getSortData: {
				dish: '.dish', 
				restaurant: '.restaurant'
			}
		});
		$('[data-sort-value]').click( function( event ) {
			event.preventDefault();
			$('#filters li').removeClass('active');
			$(this).addClass('active');
			var sortValue = $(this).attr('data-sort-value');
			iso.arrange({
				sortBy: sortValue
			});
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
