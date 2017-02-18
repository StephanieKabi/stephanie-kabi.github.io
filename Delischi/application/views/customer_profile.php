<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<div class="nine columns">
	
	<div class="row">
		
		<section class="panel comment-list-section">
			
			<div class="panel-body">
				
				<div class="container">
					<br>
					<h2><?php echo $panel_title_1; ?></h2>
					
					<div class="row" style="clear:both;">
						
						<div class="container">
							<?php
							if (isset($personal_comments)) {
								echo "<button style='margin: 30px 0;float:right;' class='button-primary' type='button' onclick=";echo 'location.href="'.base_url().'index.php/comment" value="true" id="add_discovery_customer" name="add_discovery_customer">Add a discovery</button>';
							}
							?>
						</div>
					</div>
					
					<?php
					if (!isset($personal_comments)) {
						echo "
					<div class='row'>
						<div class='six columns'>
            	<center>
              	<img id='no_comment_img' src='".base_url()."public/images/discovery.png' alt='".$imagename."' style='width:200px;height:200px;object-fit:cover;border-radius:50%;clear:both;float:right;'>
              </center>
						</div>
						<div class='six columns'>
							<br><br>
							<div class='row'> <h4>Nothing to see here.</h4> </div>
							<div class='row'> 
								<button class='button-primary' type='button' onclick=";echo 'location.href="'.base_url().'index.php/comment" value="true" id="add_discovery_customer" name="add_discovery_customer">Add a discovery</button>
							</div>
						</div>
					</div>
						';
					}
					else {
					?>
					
					<div class="row">
						
						<ul id="commentListItems" class="comment-list-items">

            	<?php foreach($personal_comments as $row) { ?>

              <li>
              	<div class="row">
                	<div class="figure">
										<img class="review-panel-image" src="<?php echo base_url() ?>uploadedImages/dish/<?php echo $row->imagename ?>" alt="<?php echo $row->imagename ?>">
										<div class="figcaption">
											<div class="row" style="width:100%">
												<h4>
													<span class="align-left"><?php echo $row->dishname ?></span>
													<span class="align-right">
														<a style="cursor:pointer;float:right" id="<?php echo $row->commentid ?>" onclick="javascript:deleteConfirm('<?php echo base_url() ?>index.php/comment/delete_comment?cid=<?php echo $row->commentid ?>')"><i class="material-icons not-menu white md-18">delete_forever</i></a>
														<a style="float:right" href="<?php echo base_url(); ?>index.php/comment/update_comment?cid=<?php echo $row->commentid; ?>"><i class="material-icons not-menu white md-18">mode_edit</i></a>
													</span>
												</h4>
											</div>
										</div>
									</div>
								</div>
								<?php
								if(isset($row->dishtype)) {
								?>
								<div class="row">
									<small> <span> <i class="material-icons md-18">restaurant_menu</i> &nbsp; <?php echo $row->dishtype ?> </span> </small>
								</div>
								<?php 
								}
								?>
								<div class="row">
									<small> <span> <i class="material-icons md-18">store</i> &nbsp; <?php echo $row->restaurantname.", ".$row->vicinity ?> </span> </small>
								</div>
								<div class="row">
									<small> <span> <i class="material-icons md-18">date_range</i> &nbsp; <?php echo date( 'M j, Y', strtotime($row->datevisit) ) ?> </span> </small>
								</div>
								<div class="row">
									<p><?php echo $row->body ?></p>
								</div>
							</li>
							
							<?php } ?>
						
						</ul>
						
						<?php }?>
					
					</div>
				
				</div>
				
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
	
	// confirm delete record
	function deleteConfirm(url) {
    if(confirm('Do you want to delete this comment?')) {
			window.location.href=url; 
		}
	}
		
	</script>
		
