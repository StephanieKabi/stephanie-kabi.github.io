<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<script src="<?php echo base_url(); ?>public/js/chartist.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/chartist-plugin-fill-donut.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/chartist-plugin-axistitle.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/chartist-plugin-accessibility.min.js"></script>


<?php 
if(null!==$this->session->tempdata('updateRestaurantInfoWarning')) {}
else {}
?>


<div id="top"></div>

 <div class="container">
	 
	 <section id="dashboardFixedImage">
		 <div id="dashboardHeading">
			 <h5><?php echo $restaurant->restaurantname.", ".$restaurant->vicinity ?></h5>
			 <h1>Dashboard</h1>
		 </div>
	 </section>
	 
	 <div class="row">
		 <div class="container" style="text-align:right;">
		 	<button id="printDashboardBtn" class="button-primary"><i class="material-icons white">print</i>Print</button>
		 </div>
	 </div>
	 
	 <div id="printableDivDashboard">
	 
	 <div class="row">
		<h3>Overall Opinion</h3>
	 </div>

	<div class="row">
		
		<div class="six columns">
			<section class="panel">
				
				<div class="panel-body">
					
					<label style="display:none" id="opinionChartJson"><?php echo $opinion_stats; ?></label>
					
					<div class="container">
						<div class="ct-chart ct-minor-third" id="gaugeChart"></div>
					</div>
					
					<script>
						
						var jsonText = document.getElementById("opinionChartJson").textContent;
						var obj = JSON.parse(jsonText);
						var totalLikes = parseInt(obj.stats[0].sumlikes); 
						var totalNeutrals = parseInt(obj.stats[0].sumneutrals); 
						var totalDislikes = parseInt(obj.stats[0].sumdislikes); 
						var totalValue = totalLikes + totalNeutrals + totalDislikes;
						var positivePercent = Math.round(totalLikes / totalValue * 100) + '%';
						var chart = new Chartist.Pie('#gaugeChart', {
							labels: ['Positive', 'Neutral', 'Negative'],
							series: [totalLikes, totalNeutrals, totalDislikes]
						}, {
							donut: true,
							donutWidth: 10,
							startAngle: 0,
							showLabel: false,
							plugins: [
								Chartist.plugins.fillDonut({
									items: [{
										content: '<p><center>' + positivePercent + '<br>positive</center></p>'
									}]
								})
							]
						});
						</script>
				
					</div>

        </section>
			</div>
			
			<div class="six columns">
				
				<div class="row">
					<div class="six columns">
						<div class="card card-blue">
							<span class="card-number"><?php echo $comments_number ?></span>
							<span class="card-title"> Comment<?php if ($comments_number>1){echo "s";} ?></span>
						</div>
					</div>
					<div class="six columns">
						<div class="card card-blue">
							<span class="card-number"><?php echo $mentions ?></span>
							<span class="card-title">Dish<?php if ($mentions>1){echo "es";} ?> Mentioned</span>
						</div>
					</div>
				</div>
				
				<?php 
				$popularity_short = (array) $popularity_short;
				for($p=0; $p<count($popularity_short); $p++) {
					$popularity_short[$p] = (array) $popularity_short[$p];
				}
				$comments_short = (array) $comments_short;
				for($p=0; $p<count($comments_short); $p++) {
					$comments_short[$p] = (array) $comments_short[$p];
				}
				?>
				
				<div class="row">
					
					<div class="six columns">
						<div class="card good">
							<div class="panel-body">
								<br>
								<center>
									<h5><i class='material-icons app-menu md-24'>thumb_up</i><br>
										<?php
										for($p=0; $p<count($popularity_short); $p++) {
											if ($p == 0) {
												echo $popularity_short[$p]['dishname']."<br>";
											}
										}
										?>
									</h5>
									<span>Most Popular</span>
								</center>
							</div>
						</div>					
					</div>
					
					<div class="six columns">
						<div class="card good">
							<div class="panel-body">
								<br>
								<center>
									<h5><i class='material-icons app-menu md-24'>trending_up</i><br>
										<?php
										for($p=0; $p<count($comments_short); $p++) {
											if ($p == 0) {
												echo $comments_short[$p]['dishname']."<br>";
											}
										}
										?>
									</h5>
									<span>Most Talked About</span>
								</center>
							</div>
						</div>					
					</div>
					
				</div>
				
				<div class="row">
					
					<div class="six columns">
						<div class="card bad">
							<div class="panel-body">
								<br>
								<center>
									<h5><i class='material-icons app-menu md-24'>thumb_down</i><br>
										<?php
										$len = count($popularity_short);
										for($p=0; $p<count($popularity_short); $p++) {
											if ($p == $len - 1) {
												echo $popularity_short[$p]['dishname']."<br>";
											}
										}
										?>
									</h5>
									<span>Least Popular</span>
								</center>
							</div>
						</div>					
					</div>
					
					<div class="six columns">
						<div class="card bad">
							<div class="panel-body">
								<br>
								<center>
									<h5><i class='material-icons app-menu md-24'>trending_down</i><br>
										<?php
										$len = count($comments_short);
										for($p=0; $p<count($comments_short); $p++) {
											if ($p == $len - 1) {
												echo $comments_short[$p]['dishname']."<br>";
											}
										}
										?>
									</h5>
									<span>Least Talked About</span>
								</center>
							</div>
						</div>					
					</div>
				</div>
				
			</div>

    </div>
	 
	 <br>
	 
	 	<div class="row">
			
			<div class="twelve columns">
			
				<section class="panel">

					<div class="panel-heading">
						<h3>Dish Popularity</h3>
					</div>

					<div class="panel-body">
						
						<center>
							<div class="ct-chart ct-major-twelfth" id="barChart"></div>
						</center>

						<script>
							<?php 
							$menu_items_stats_php = (array) $menu_items_stats_php;
							for($p=0; $p<count($menu_items_stats_php); $p++) {
								$menu_items_stats_php[$p] = (array) $menu_items_stats_php[$p];
							}
							$dishes = array_column($menu_items_stats_php, 'dishname');
							$likes = array_column($menu_items_stats_php, 'sumlikes');
							$neutrals = array_column($menu_items_stats_php,"sumneutrals");
							$dislikes = array_column($menu_items_stats_php,"sumdislikes");
							?>							
							new Chartist.Bar('#barChart', {
								labels: [<?php echo "'".implode( "','",$dishes)."'" ?>],
								series: [ 
									{name: 'Positive', data: [<?php echo implode(',', $likes) ?>] },
									{name: 'Neutral', data: [<?php echo implode(',', $neutrals) ?>] },
									{name: 'Negative', data: [<?php echo implode(',', $dislikes) ?>] }
								]
							}, {
								stackBars: true,
								seriesBarDistance: 10,
								reverseData: false,
								horizontalBars: true,
								axisY: {
									offset: 70
								},
								plugins: [
									Chartist.plugins.ctAxisTitle({
										axisX: {
											axisTitle: 'Number of comments',
											axisClass: 'ct-axis-title',
											offset: {
												x: 0,
												y: 50
											},
											textAnchor: 'middle'
										}
									}),
									Chartist.plugins.ctAccessibility({
										caption: 'Dish Popularity Figures',
										seriesHeader: 'Comment Opinions',
										summary: 'A graphic that shows the dish popularity figures by opinion.',
										valueTransform: function(value) {
											return value;
										},
										// ONLY USE THIS IF YOU WANT TO MAKE YOUR ACCESSIBILITY TABLE ALSO VISIBLE!
										visuallyHiddenStyles: 'box-sizing: border-box; position: absolute; top: 100%; width: auto; max-width: 90%; font-size: 11px; overflow-x: scroll; background-color: rgba(150,150,150,0.1); margin: 20px 30px 100px 30px; padding: 30px;'
									})
								]
							});
						</script>
						
					</div>
					
				</section>
			
			</div> 
			
		</div>

						
					</div>
					
				</section>
			
			</div> 
			
		</div>

  </div>

</div>

<!--
<div id="scrollUpDiv" class="row">
			 <div id="scrollUp">
				 <a href="#top" class="smoothScroll">
					 <i class="material-icons">keyboard_arrow_up</i>
				 </a>
			 </div>
		 </div>
-->
