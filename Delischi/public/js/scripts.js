$('#heroImageHome').parallax({ imageSrc: 'public/images/homeBoard2.jpg' });

$(document).ready(function(){

	
	$(".navigation").hover(function() {
		$(this).toggleClass('active');
		$(".navigation").toggleClass("changeNavigation");
	});
	
	
	jQuery.scrollSpeed(75, 500); /* scrollSpeed(step, speed, easing); */
	// Add smooth scrolling to all links
  $("a").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();
      // Store hash
      var hash = this.hash;
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
	
	
	// Make down arrow appear when screen scrolls down
	$('#scrollUpDiv').hide();
	$(window).scroll(function() {
		//$totalDocHeight = $(document).height();
		$visibleDocHeight = $(window).height();
		$scrollHeight = $(window).scrollTop();
		$minimalScrollable = $visibleDocHeight * 0.5;
		if($scrollHeight >= $minimalScrollable) {
			$('#scrollUpDiv').show();
		}
		else {
			$('#scrollUpDiv').hide();
		}
	});
	// Make down arrow appear when screen scrolls down
	$('#scrollUpDivHome').hide();
	$(window).scroll(function() {
		//$totalDocHeight = $(document).height();
		$visibleDocHeight = $("#items-grid").height();
		$scrollHeight = $("#items-grid").scrollTop();
		$minimalScrollable = $visibleDocHeight * 0.5;
		if($scrollHeight >= $minimalScrollable) {
			$('#scrollUpDivHome').show();
		}
		else {
			$('#scrollUpDivHome').hide();
		}
	});
	
	
	// Preview image before upload
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#blah').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload").change(function(){
		readURL(this);
	});
	
	
	// Textarea character counter
	var maxLength = 1000;
	$('#dishComment').keyup(function() {
			var length = $(this).val().replace(/\n/g, "\n\r").length; //change carriage return count from 1 to 2
			length = maxLength - length;
			$('#commentCounter').text(length);
	});
	
	
	// Password check on Sign-up
	$('#inputPassword,#confirmPassword').keyup(function() {
		var inputPassword = document.getElementById("inputPassword");
		var confirmPassword = document.getElementById("confirmPassword");
		if(inputPassword.length == confirmPassword.length) {
			if(confirmPassword.value.length>0) {
				if(inputPassword.value == confirmPassword.value) {
					inputPassword.style.background = "#AED581";
					confirmPassword.style.background = "#AED581";
				}
				else {
					inputPassword.style.background = "#E57373";
					confirmPassword.style.background = "#E57373";
				}
			}
			else {
				inputPassword.style.background = "transparent";
				confirmPassword.style.background = "transparent";
			}
		}
		else {
			if(inputPassword.length > confirmPassword.length) {
				confirmPassMsg.innerHTML = "";
			}
		}
	});
	
	
	// Password check on profile update
	$('#inputPasswordUpdate,#confirmPasswordUpdate').keyup(function() {
		var inputPassword = document.getElementById("inputPasswordUpdate");
		var confirmPassword = document.getElementById("confirmPasswordUpdate");
		if(inputPassword.length == confirmPassword.length) {
			if(confirmPassword.value.length>0) {
				if(inputPassword.value == confirmPassword.value) {
					inputPassword.style.background = "#AED581";
					confirmPassword.style.background = "#AED581";
				}
				else {
					inputPassword.style.background = "#E57373";
					confirmPassword.style.background = "#E57373";
				}
			}
			else {
				inputPassword.style.background = "transparent";
				confirmPassword.style.background = "transparent";
			}
		}
		else {
			if(inputPassword.length > confirmPassword.length) {
				confirmPassMsg.innerHTML = "";
			}
		}
	});
	
	
	// Show restaurant registration div when user selects "Restaurant Owner" account type
	$("#accountType").change(function() {
		var accTypeDrop = document.getElementById("accountType"); // account type dropdown button
		var selUserType = accTypeDrop.options[accTypeDrop.selectedIndex].value;
		document.getElementById('accTypeValue').value = selUserType;
		if (selUserType=='2') { // if account is "Restaurant Owner"
			$("#restaurantSignupDiv").show(400);
		}
		else if (selUserType=='3') { // if account is "Food Writer"
			$("#restaurantSignupDiv").hide(400);
		}
	});
	
	
	// New Comment: Limit datepicker's maximum value to today
  var dtToday = new Date();
  var month = dtToday.getMonth() + 1;
  var day = dtToday.getDate();
  var year = dtToday.getFullYear();
  if(month < 10) {
    month = '0' + month.toString();
  }
  if(day < 10) {
    day = '0' + day.toString();
  }
  var maxDate = year + '-' + month + '-' + day;
  $('#visitDate').attr('max', maxDate);
	
	
});


  // geolocation API for user's location
  /*if (navigator.geolocation) {
    console.log('Geolocation is supported!');
    alert('Geolocation is supported!');
    var startPos;
    var geoSuccess = function(position) {
      startPos = position;
      //document.getElementById('startLat').innerHTML = startPos.coords.latitude;
      //document.getElementById('startLon').innerHTML = startPos.coords.longitude;
      alert(startPos.coords.longitude);
    };
    navigator.geolocation.getCurrentPosition(geoSuccess);
  }
  else {
    alert('Geolocation is not supported for this Browser/OS version yet.');
  }*/
