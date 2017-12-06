<?php 
session_start();
include('registration.php'); 
//include('login.php'); 
?>

<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="main.css">
	<!--Custom Font stuff-->
	<link href="https://fonts.googleapis.com/css?family=Corben" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nobile" rel="stylesheet">
		</head>
	
	<body>
		<?php if(isset($_SESSION['success'])): ?>
			<p style="color:white; float:right; margin-right: 115px;"> Welcome, <?php echo $_SESSION['username'];?>&nbsp&nbsp<a class="logout" href="logout.php">Logout</a></p>
		<?php else: ?>
			<button class="log" onclick="document.getElementById('id01').style.display='block'">Login</button>
			<!--Modal-->
			<div id="id01" class="modal">
			<span onclick="document.getElementById('id01').style.display='none'"
					class ="close" title="Close">&times;</span>
					
				<form class="modal-content" action="login.php" method="POST">
				
					<div class="container">
						<h1 style="font-size:200%;text-align:left;margin-top:0;margin-left:0;margin-bottom:20px;">The Samos<span style="color:#70dbdb">App</span></h1>
						<label><b>Username</b></label>
						<input type="text" placeholder="Enter Username" name="uname" required> <br/>

						<label><b>Password</b></label>
						<input type="password" placeholder="Enter Password" name="psw" required> &nbsp &nbsp

						<button type="submit">Login</button>
					</div>

					<div class="container">
						<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Close</button>
						<span class="psw"><a class = "top" href="Register.html">Register</a></span>

					</div>
				</form>
			</div>
		<?php endif; ?>
		
	<!--Title-->
		<h1>
		the Samos<span style="color:#70dbdb;">App</span>
		</h1>
		
	<!--NavBar-->
		<ul class="navbar" style="color:white;">
			<li><a class="active" href="#">Map</a></li>
			
			<li><a href="Schedule.php">Scheddy</a></li>
			
			<?php if(isset($_SESSION['success'])): ?>
				<li><a href="Report.php">Report Sale</a></li>
			<?php endif; ?>
		</ul>
		
	
	<!--Map-->
		<div class = "sidebar">
		<h3 class="head">Welcome to the samos<span style="color:#70dbdb;">App</span></p>
		<h3 class="info">This map displays all ongoing sales on the McGill campus. Click on a marker to see additional information.</h3>
		</div>
		
		<div id="map"></div>
		<script>
		
		function initMap(){
			var mcEng = {lat:45.506164,lng:-73.576461};
			
			var map = new google.maps.Map(document.getElementById('map'),{
				zoom: 16, center:{lat:45.505247,lng:-73.577337}
			});

			var infoWindow = new google.maps.InfoWindow;
			
			downloadUrl('getSales.php?&type=map', function(data){
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName('marker');
				Array.prototype.forEach.call(markers, function(markerElem){
					var id = markerElem.getAttribute('id');
					var name = markerElem.getAttribute('name');
					var location = markerElem.getAttribute('location');
					var start = markerElem.getAttribute('start');
					var end = markerElem.getAttribute('end');
					
					var point = new google.maps.LatLng(
						parseFloat(markerElem.getAttribute('lat')),
						parseFloat(markerElem.getAttribute('lng')));
					
					var infoWindowContent = document.createElement('div');
					var strong = document.createElement('strong');
					strong.textContent = name;
					infoWindowContent.appendChild(strong);
					infoWindowContent.appendChild(document.createElement('br'));
					
					var text = document.createElement('text');
					
					text.textContent = location;
					infoWindowContent.appendChild(text);
					infoWindowContent.appendChild(document.createElement('br'));

					var text2 = document.createElement('text');
					text2.textContent = start.slice(11,16) + '-' + end.slice(11,16);
					infoWindowContent.appendChild(text2);

					var marker = new google.maps.Marker({
						position: point,
						map: map
					});
					marker.addListener('click', function(){
						infoWindow.setContent(infoWindowContent);
						infoWindow.open(map, marker);
					
					});
				
				
				});
	
			});	
		}
		
		function downloadUrl(url, callback){
			var request = window.ActiveXObject ?
				new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;
				
			request.onreadystatechange = function(){
				if(request.readyState == 4){
					callback(request);
				}
			};
			request.open('GET', url, true);
			request.send(null);
		}
		
		
		</script>
		<script async defer 
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtjGZoOnPsz1k1NTW-Um5oaCTmPn5_3QM&callback=initMap">
		</script>
		
		
	
		
		
	<!--Info/Credit Section-->
	<div style="margin-top:600px;">
		<table class = "main">
			
			<tr>
				<th><span >
				The SamosApp is a revolutionary piece of software that
				helps brings samosas to the people. TO YOU.
				
				The creators take no responsibility for false information
				reported on this website. Use at your own risk.</span></th>
				
			</tr>
			<tr>
				<th><span style="font-size:100%" >Created By: <span style="color:#70dbdb"><a class = "bot" href="#" target="_blank" style="text-decoration:none">Kelly Agnew</a>, <a class = "bot" href="#" target="_blank" style="text-decoration:none">Kalin Otto</a></span></span></th>
				
			</tr>
		</table>
	</div>
	</body>
	
</html>
