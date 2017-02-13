<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<div id="top"></div>

<div class="pageWrap">

  <div class="container">
		
		<section id="menuFixedImage">
		 <div id="menuHeading">
			 <h1>Menu</h1>
		 </div>
	 </section>
	
				<section class="panel">

          <div class="panel-body">
						
						<div class="container">
						
							<form id="menuForm" method="post" action="<?php echo base_url() ?>index.php/restaurant/menu">
								
								<div class="row">
									
									<div class="six columns">
										
										<div class="row">

											<?php
											echo form_label('Dish Name', 'dishNameMenu');
											$data = array(
												'id' => 'dishNameMenu',
												'name' => 'dishNameMenu',
												'placeholder' => 'Dish Name &hellip;',
												'style' => 'width:100%',
												'value' => set_value('dishNameMenu'),
												'maxlength' => '30',
												'autofocus' => '',
												'required' => ''
											);
											echo form_input($data);
											echo form_error('dishNameMenu', '<div class="alert alert-danger">', '</div>');
											?>

										</div>

										<div class="row">

											<?php
											echo form_label('Cuisine Name', 'dishTypeMenuField');
											$data = array(
												'id' => 'dishTypeMenuField',
												'name' => 'dishTypeMenuField',
												'placeholder' => 'e.g. European',
												'style' => 'width:100%',
												'value' => set_value('dishTypeMenuField'),
												'spellcheck' => '',
												'maxlength' => '20'
											);
											echo form_input($data);
											echo form_error('dishTypeMenuField', '<div class="alert alert-danger">', '</div>');
											?>

										</div>
										
									</div>
								
									<div class="six columns">

										<div class="row">

										<?php
										echo form_label('Description', 'dishDescMenu');
										$data = array(
											'id' => 'dishDescMenu',
											'name' => 'dishDescMenu',
											'placeholder' => 'Description &hellip;',
											'style' => 'width:100%;min-height:100px',
											'value' => set_value('dishDescMenu'),
											'maxlength' => '100',
											'spellcheck' => '',
											'required' => ''
										);
										echo form_textarea($data);
										echo form_error('dishDescMenu', '<div class="alert alert-danger">', '</div>');
										?>

									</div>

									</div>
									
								</div>
								
                <div class="row button-row">
									<span class="align-right">
										<input class="button-primary" type="submit" value="Add" name="submit_menu">
									</span>
                </div>            

            </form>
						
						</div>
					
					</div>



              <?php if(!isset($menuItems)) { ?>
                <div class='row'>
                  <div class='six columns'>
                    <center>
                      <img id='no_comment_img' src='<?php echo base_url() ?>public/images/discovery.png' alt='".$imagename."' style='width:200px;height:200px;object-fit:cover;border-radius:50%;clear:both;float:right;'>
                    </center>
                  </div>
                  <div class='six columns'>
                    <br><br>
                    <h4>Nothing to see here.</h4>
                  </div>
                </div>
              <?php } else { ?>
                <table class="u-full-width">
                  <thead>
                    <tr>
                      <th>Dish</th>
                      <th>Cuisine</th>
                      <th>Description</th>
											<th><th>
											<th><th>
                    </tr>
                  </thead>
                  <tbody>
                <?php foreach ($menuItems as $row) { ?>
                  <tr>
                    <td><?php echo $row->dishname ?></td>
                    <td><?php echo $row->dishtype ?></td>
                    <td><?php echo $row->dishdescription ?></td>
										<td>
											<a href="<?php echo base_url() ?>index.php/comment/update_comment?did=<?php echo $row->dishlistingid ?>"><i class="material-icons not-menu red md-24">mode_edit</i></a>
										</td>
										<td>
											<a id="<?php echo $row->dishlistingid ?>" onclick="javascript:deleteConfirm('<?php echo base_url() ?>index.php/restaurant/delete_menu_item?dlid=<?php echo $row->dishlistingid ?>')"><i class="material-icons not-menu red md-24">delete_forever</i></a>
										</td>
											
											
											
											
											
                  </tr>
                <?php } ?>
                </tbody>
              </table>
              <?php } ?>

          

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

<div id="deleteModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <p>Do you really want to delete Matoke??</p>
		<p>This action is irreversible.</p>
		<button class="button-primary" onclick="closeModal()">Cancel</button>
		<button>Delete</button>
  </div>
</div>


<script src="<?php echo base_url(); ?>public/js/jquery-ui.js"></script>
<script type="text/javascript">
	
	// confirm delete record
	function deleteConfirm(url) {
    if(confirm('Do you want to delete this dish?')) {
			window.location.href=url; 
		}
	}

	// Autocomplete
	$(function() {
		$( "#dishTypeMenuField" ).autocomplete({
			source: 'get_dishtypes_c'
		});
	});

		
		
</script>
