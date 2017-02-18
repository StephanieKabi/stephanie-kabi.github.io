<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<div id="top"></div>

<div id="explorePageDiv">
	
	<div id="explorePageDivImg">

		<?php foreach($explore_item_pt1 as $row) { ?>
		<img class="exploreItemImg" src="<?php echo base_url() ?>uploadedImages/dish/<?php echo $row->imagename ?>">
		
		<section id="exploreImgText">

			<div id="backPrevPageIcon">
				<i class='material-icons app-menu md-36 white hover' onclick='history.go(-1)'>arrow_back</i>
			</div>
			
			<div id="dishDetails">
				<?php if(isset($row->dishtype)) { ?>
				<h5><?php echo $row->dishtype ?></h5>
				<?php } ?>
				<?php if(isset($row->dishdescription)) { ?>
				<h6 id="dishDescTitle"><?php echo $row->dishdescription ?><br></h6>
				<?php } ?>
				<h5><a href="<?php echo base_url(); ?>index.php/explore/restaurant?rid=<?php echo $row->restaurantid ?>"><?php echo $row->restaurantname.", ".$row->vicinity ?></a></h5>
				<h1><?php echo $row->dishname ?></h1>
			</div>
		
		</section>	
		
	</div>
	
	<div id="explorePageDivText">
		
		<div class="explorePageDivTextContainer container">

			<?php } ?>

			<section id="exploreItemComments">
				
				<ul id="filters" class="filters u-full-width">
					<li class="active"><a href="#" data-filter="*">All Comments</a></li>
					<li><a href="#" data-filter=".positive">Positive</a></li>
					<li><a href="#" data-filter=".negative">Negative</a></li>
				</ul>
				
				<div id="reviewItems">
				<?php foreach($explore_item_pt2 as $row) { ?>
					<p class="reviewItem <?php echo $row->sentimenttype ?>">
						<span class="exploreProfileImg">
							<img class="userlist-img" src="<?php echo base_url() ?>uploadedImages/profile/<?php echo $row->imagepath ?>">
						</span>
						<span class="exploreProfileText">
							<q>
								<?php echo $row->body ?>
							</q> - <b><?php echo $row->firstname." ".$row->lastname ?></b>, <small><?php echo date( 'M j, Y', strtotime($row->datevisit) ) ?></small>
								<?php if($row->sentimenttype == 'positive') { ?>
								<i class='material-icons app-menu md-18 green'>sentiment_very_satisfied</i>
								<?php } else if($row->sentimenttype == 'neutral') { ?>
								<i class='material-icons app-menu md-18 orange'>sentiment_neutral</i>
								<?php } else if($row->sentimenttype == 'negative') { ?>
								<i class='material-icons app-menu md-18 red'>sentiment_very_dissatisfied</i>
								<?php } ?>
						</span>
					</p><br>
				<?php } ?>
				</div>
			</section>
			
		</div>
			
			<?php if(isset($explore_item_similars)) { ?>
			
			<section id="exploreItemSimilars">
				<div class="explorePageDivTextContainer container">
				<h5 style="text-transform:none">You might like:</h5>
				
				<ul id="items" class="items isotope js-isotope u-cf">
				 
				 <?php foreach ($explore_item_similars as $row) { ?>
					
					<li class="four columns isotopeItem u-full-width <?php echo $row->dishtype ?>">
						 <div class="exploreListItem">
							 <figure>
								 <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo base_url() ?>uploadedImages/dish/<?php echo $row->imagename ?>" alt="" width="300" height="300">
								 <noscript>
									 <img src="<?php echo base_url() ?>uploadedImages/dish/<?php echo $row->imagename ?>">
								 </noscript>
							 </figure>
							 <div class="explore_stats">
								 <span>
									 <span class="comments"><?php echo $row->totalcomments ?></span>
									 <i class='material-icons app-menu md-18'>chat_bubble_outline</i>
								 </span>
								 <span>
									 <span class="likes"><?php echo $row->totallikes ?></span>
									 <i class='material-icons app-menu md-18'>sentiment_very_satisfied</i>
								 </span>
								 <span style="display:none" class="dislikes"><?php //echo $row->totaldislikes ?></span>
							 </div>
							 <div class="detail">
								 <h5 class="dish"<small><?php echo $row->dishname ?></small></h5>
								 <p class="restaurant"><?php echo $row->restaurantname ?>, <?php echo $row->vicinity ?></p>
								 <button type="button" onclick="location.href='<?php echo base_url(); ?>index.php/explore/item?did=<?php echo $row->dishlistingid ?>'">View</button>
							 </div>
						 </div>
					 </li>
				 
				 <?php } ?>
			 
			 </ul>
					
					
				</div>
				
			</section>
			
			<?php } ?>

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

<script src="<?php echo base_url(); ?>public/js/isotope.pkgd.min.js"></script> 
<!--<script src="https://unpkg.com/isotope-layout@3.0/dist/isotope.pkgd.min.js"></script>-->
<script type="text/javascript">
	 
	
	$(document).ready(function () {
		
		// Isotope filter
		$('#filters li').find('a').click(function(){
			$('#filters li').removeClass('active');
			$('#reviewItems').isotope({
				filter: $(this).attr('data-filter'),
				itemSelector: '.reviewItem',
				animationEngine : "best-available",
				masonry: {
					columnWidth: '.reviewItem'
				}
			});
			$('html, body').animate({
				scrollTop: $('#explorePageDiv').offset().top
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
						figure.classList.add( 'is-loaded' );
					}, 300 );
				});
			}
		});


	});
	

</script>