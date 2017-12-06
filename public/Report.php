<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$uid = $_SESSION['uid'];
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
			the Samos<span style="color:#70dbdb">App</span>
		</h1>
		
	<!--NavBar-->
		<ul class="navbar" style="color:white;">
			<li><a href="index.php">Map</a></li>
			<li><a href="Schedule.php">Scheddy</a></li>
			<li><a class="active" href="#">Report Sale</a></li>
		</ul>
	
		<h2 class="side" style="margin-left: 50px;" >Click somewhere on the map to add a marker. Click on the marker to add sale information.</h2>
	
	<!--Map-->
	
		<div id="map" style="width:90%;"></div>
		<div id="form" style="display:None;">
			<table>
				<tr><td>Seller Name:</td> <td><input type='text' id='name'/> </td> </tr>
				<tr><td>Building Location:</td> <td><input type='text' id='location'/> </td> </tr>
				<tr><td>Start Time:</td> <td><input type='datetime-local' id='start'/> </td> </tr>
				<tr><td>End Time:</td> <td><input type='datetime-local' id='end'/> </td> </tr>
				<tr><td>Other Notes:</td><td><input type='text' id='notes'/></td></tr>
				<tr><td></td><td><input type='button' value='Save' onclick='saveData()'/></td></tr>
			</table>
		</div>
		<div id="message"></div>
		<script>
			var map;
			var marker;
			var infoWindow;
			var messageWindow;
			
			function initMap(){
				var mcEng = {lat:45.506164,lng:-73.576461};
				
				map = new google.maps.Map(document.getElementById('map'),{
				zoom: 16, center:{lat:45.505247,lng:-73.577337}
				});
				
				infoWindow = new google.maps.InfoWindow({
					content: document.getElementById('form')
				});
				
				messageWindow = new google.maps.InfoWindow({
					content: document.getElementById('message')
				});
				
				google.maps.event.addListener(map, 'click', function(event) {
					marker = new google.maps.Marker({
					position: event.latLng,
					map: map
				});
				
					google.maps.event.addListener(marker, 'click', function() {
						document.getElementById('form').style.display="block";
						infoWindow.open(map, marker);
					});
				});
			}
			
			function saveData(){
				var uid = <?php echo $uid ?>;
				var name = escape(document.getElementById('name').value);
				var location = escape(document.getElementById('location').value);
				var start = escape(document.getElementById('start').value);
				var end = escape(document.getElementById('end').value);
				var notes = escape(document.getElementById('notes').value)
				
				var latlng = marker.getPosition();
				var url = 'addSale.php?&uid='+ uid + '&name=' + name + '&location=' + location +
                  '&start=' + start + '&end=' + end + '&lat=' + latlng.lat() + '&lng=' + latlng.lng() + '&notes=' + notes;
				document.getElementById("test").innerHTML = url;
				downloadUrl(url, function(data, responseCode){
					if(responseCode == 200 && data.length <= 1){
						infoWindow.close();
						messageWindow.open(map,marker);
					}
				});
			}
			
			function downloadUrl(url, callback){
				var request =  window.ActiveXObject ?
					new ActiveXObject('Microsoft.XMLHTTP') :
					new XMLHttpRequest;
			
				request.onreadystatechange = function(){
					if(request.readyState == 4){
						request.onreadystatechange = doNothing;
						callback(request.responseText, request.status);
					}
				};
				
				request.open('GET', url, true);
				request.send(null);
			}
			
			function doNothing(){
			}
			
			
		</script>
		
		<script async defer 
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtjGZoOnPsz1k1NTW-Um5oaCTmPn5_3QM&callback=initMap">
		</script>
	<br/>
	<div style="margin-top:600px;">
		<p id="test"></p>
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