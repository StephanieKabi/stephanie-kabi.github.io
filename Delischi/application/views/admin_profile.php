<?php
if(isset($_SESSION['logged_in_user_id'])) {
  $userid = $this->session->userdata('logged_in_user_id');
  $usertype = $this->session->userdata('usertype');
  $imagename = $this->session->userdata('profile_image');
}
?>

<!-- Load the library -->

<script>
(function(w,d,s,g,js,fjs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));
</script>


	<div id="top"></div>

  <div class="container">
		
		<section id="adminFixedImage">
		 <div id="adminHeading">
			 <h1>Admin</h1>
		 </div>
		</section>
		
		<h3>Summary</h3>
		
		<header>
			<div class="row">
				<div id="embed-api-auth-container"></div>
			</div>
			<div class="row">
				<div class="four columns">
					<div id="view-selector-container"></div>
				</div>
				<div class="four columns">
					<div id="view-name"></div>
				</div>
				<div class="four columns">
					<div id="active-users-container"></div>
				</div>
			</div>
		</header>
		
		
		<?php 
		$totaldishes = (array) $totaldishes;
		for($p=0; $p<count($totaldishes); $p++) {
			$totaldishes[$p] = (array) $totaldishes[$p];
		}
		$totalrestaurants = (array) $totalrestaurants;
		for($p=0; $p<count($totalrestaurants); $p++) {
			$totalrestaurants[$p] = (array) $totalrestaurants[$p];
		}
		$totalusers = (array) $totalusers;
		for($p=0; $p<count($totalusers); $p++) {
			$totalusers[$p] = (array) $totalusers[$p];
		}
		$totalcomments = (array) $totalcomments;
		for($p=0; $p<count($totalcomments); $p++) {
			$totalcomments[$p] = (array) $totalcomments[$p];
		}
		?>
		
		
		<section id="adminStatsSummary">
			<div class="row">
				<div class="three columns">
					<div class="card card-black">
						<span class="card-number"><?php echo $totaldishes[0]['totaldishes'] ?></span>
						<span class="card-title">
						<?php 
						echo "Dish";
						if ($totaldishes[0]['totaldishes']>1){
							echo "es";
						} 
						?>
						</span>
					</div>
				</div>
				<div class="three columns">
					<div class="card card-black">
						<span class="card-number"><?php echo $totalrestaurants[0]['totalrestaurants'] ?></span>
						<span class="card-title">
						<?php 
						echo "Business";
						if ($totalrestaurants[0]['totalrestaurants']>1){
							echo "es";
						} 
						?>
						</span>
					</div>
				</div>
				<div class="three columns">
					<div class="card card-black">
						<span class="card-number"><?php echo $totalusers[0]['totalusers'] ?></span>
						<span class="card-title">
						<?php 
						echo "User";
						if ($totalusers[0]['totalusers']>1){
							echo "s";
						} 
						?>
						</span>
					</div>
				</div>
				<div class="three columns">
					<div class="card card-black">
						<span class="card-number"><?php echo $totalcomments[0]['totalcomments'] ?></span>
						<span class="card-title">
						<?php 
						echo "Comment";
						if ($totalcomments[0]['totalcomments']>1){
							echo "s";
						} 
						?>
						</span>
					</div>
				</div>
			</div>
			<br>
		</section>
		
		<section id="sessionSummary">
			
			<div class="row">
				<div class="four columns">
					<div class="Chartjs">
						<h4>Types of Visitors</h4>
						<figure class="Chartjs-figure" id="totalUsersContainer"></figure>
						<ol class="Chartjs-legend" id="legend-1-container"></ol>
					</div>
				</div>
				<div class="four columns">
					<div class="Chartjs">
						<h4>Total Sessions</h4>
						<h6>This year</h6>
						<figure class="Chartjs-figure" id="totalSessionsContainer"></figure>
						<ol class="Chartjs-legend" id="legend-2-container"></ol>
					</div>
				</div>
				<div class="four columns">
					<div class="Chartjs">
						<h4>New Sessions</h4>
						<h6>This year</h6>
						<figure class="Chartjs-figure" id="newSessionsContainer"></figure>
						<ol class="Chartjs-legend" id="legend-3-container"></ol>
					</div>
				</div>
			</div>
			
			<br>
			
		</section>
		
		<section id="otherSummary">
			
			<div class="row">
				<div class="six columns">
					<div class="Chartjs">
						<h4>Top Browsers</h4>
						<figure class="Chartjs-figure" id="topBrowsersContainer"></figure>
						<ol class="Chartjs-legend" id="legend-4-container"></ol>
					</div>
				</div>
				<div class="six columns">
					<div class="Chartjs">
						<h4>Top User Locations</h4>
						<figure class="Chartjs-figure" id="topLocationsContainer"></figure>
						<ol class="Chartjs-legend" id="legend-5-container"></ol>
					</div>
				</div>
			</div>
			
			<br>
			
			<div class="row">
				<div class="six columns">
					<div class="Chartjs">
						<h4>Most Visited Pages</h4>
						<figure class="Chartjs-figure" id="mostViewedPagesContainer"></figure>
						<ol class="Chartjs-legend" id="legend-6-container"></ol>
					</div>
				</div>
				<div class="six columns">
					<div class="Chartjs">
						<h4>Least Visited Pages</h4>
						<figure class="Chartjs-figure" id="leastViewedPagesContainer"></figure>
						<ol class="Chartjs-legend" id="legend-7-container"></ol>
					</div>
				</div>
			</div>
			
			<br>
			
		</section>
		
		<section id="fullReport" style="display:none">
			<div id="adminReport" class="card card-black">
				<p>For more information, visit <a target="_blank" href="https://analytics.google.com/analytics/web/">Google Analytics</a>.</p>
			</div>
		</section>


	<script>
	gapi.analytics.ready(function() {

		/**
		 * Authorize the user immediately if the user has already granted access.
		 * If no access has been created, render an authorize button inside the
		 * element with the ID "embed-api-auth-container".
		 */
		var CLIENT_ID = '280179834253-p6cqjqoa4tqndrh8hm6k863valkqthhd.apps.googleusercontent.com';
		gapi.analytics.auth.authorize({
			container: 'embed-api-auth-container',
			clientid: CLIENT_ID
		});


		/**
		 * Create a new ViewSelector instance to be rendered inside of an
		 * element with the id "view-selector-container".
		 */
		var viewSelector = new gapi.analytics.ViewSelector({
			container: 'view-selector-container'
		});

		// Render the view selector to the page.
		viewSelector.execute();

		
		

		/**
		 * Create a new DataChart instance with the given query parameters
		 * and Google chart options. It will be rendered inside an element
		 * with the id "chart-container".
		 */
		var allUsersChart = new gapi.analytics.googleCharts.DataChart({
			query: {
				metrics: 'ga:users',
				dimensions: 'ga:userType',
				'start-date': '2016-11-01',
				'end-date': 'today'
			},
			chart: {
				container: 'totalUsersContainer',
				type: 'PIE',
				options: {
					width: '100%'
				}
			}
		});


		/**
		 * Create a new DataChart instance with the given query parameters
		 * and Google chart options. It will be rendered inside an element
		 * with the id "chart-container".
		 */
		var sessionsChart = new gapi.analytics.googleCharts.DataChart({
			query: {
				metrics: 'ga:sessions',
				dimensions: 'ga:date',
				'start-date': '2017-01-01',
				'end-date': 'today'
			},
			chart: {
				container: 'totalSessionsContainer',
				type: 'LINE',
				options: {
					width: '100%'
				}
			}
		});


		/**
		 * Create a new DataChart instance with the given query parameters
		 * and Google chart options. It will be rendered inside an element
		 * with the id "chart-container".
		 */
		var newSessionsChart = new gapi.analytics.googleCharts.DataChart({
			query: {
				metrics: 'ga:percentNewSessions',
				dimensions: 'ga:date',
				'start-date': '2017-01-01',
				'end-date': 'today'
			},
			chart: {
				container: 'newSessionsContainer',
				type: 'LINE',
				options: {
					width: '100%'
				}
			}
		});


		/**
		 * Create a new DataChart instance with the given query parameters
		 * and Google chart options. It will be rendered inside an element
		 * with the id "chart-container".
		 */
		var mostViewedPagesChart = new gapi.analytics.googleCharts.DataChart({
			query: {
				metrics: 'ga:pageviews',
				dimensions: 'ga:pagePath',
				'start-date': '2016-11-01',
				'end-date': 'today',
				'sort': '-ga:pageviews',
				'max-results': 5
			},
			chart: {
				container: 'mostViewedPagesContainer',
				type: 'TABLE',
				options: {
					width: '100%'
				}
			}
		});
		var leastViewedPagesChart = new gapi.analytics.googleCharts.DataChart({
			query: {
				metrics: 'ga:pageviews',
				dimensions: 'ga:pagePath',
				'start-date': '2016-11-01',
				'end-date': 'today',
				'sort': 'ga:pageviews',
				'max-results': 5
			},
			chart: {
				container: 'leastViewedPagesContainer',
				type: 'TABLE',
				options: {
					width: '100%'
				}
			}
		});


		/**
		 * Create a new DataChart instance with the given query parameters
		 * and Google chart options. It will be rendered inside an element
		 * with the id "chart-container".
		 */
		var browsersChart = new gapi.analytics.googleCharts.DataChart({
			query: {
				metrics: 'ga:pageviews',
				dimensions: 'ga:browser',
				'start-date': '2016-11-01',
				'end-date': 'today',
				'sort': '-ga:pageviews',
				'max-results': 5
			},
			chart: {
				container: 'topBrowsersContainer',
				type: 'PIE',
				options: {
					width: '100%'
				}
			}
		});


		/**
		 * Create a new DataChart instance with the given query parameters
		 * and Google chart options. It will be rendered inside an element
		 * with the id "chart-container".
		 */
		var locationsChart = new gapi.analytics.googleCharts.DataChart({
			query: {
				//'max-results': 10,
				metrics: 'ga:sessions',
				dimensions: 'ga:city',
				'start-date': '2016-11-01',
				'end-date': 'today',
				'sort': '-ga:sessions'
			},
			chart: {
				container: 'topLocationsContainer',
				type: 'BAR',
				options: {
					width: '100%'
				}
			}
		});
		
		
        


		/**
		 * Render the dataChart on the page whenever a new view is selected.
		 */
		viewSelector.on('change', function(ids) {
			allUsersChart.set({query: {ids: ids}}).execute();
			sessionsChart.set({query: {ids: ids}}).execute();
			newSessionsChart.set({query: {ids: ids}}).execute();
			mostViewedPagesChart.set({query: {ids: ids}}).execute();
			leastViewedPagesChart.set({query: {ids: ids}}).execute();
			browsersChart.set({query: {ids: ids}}).execute();
			locationsChart.set({query: {ids: ids}}).execute();
		});

	});
	</script>
	
	<div id="scrollUpDiv" class="row">
		<div id="scrollUp">
			<a href="#top" class="smoothScroll">
				<i class="material-icons">keyboard_arrow_up</i>
			</a>
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

