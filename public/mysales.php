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
		<ul class="navbar">
			<li><a href="index.php">Map</a></li>
			<li><a class="active" href="#">Scheddy</a></li>
			<?php if(isset($_SESSION['success'])): ?>
				<li><a href="Report.php">Report Sale</a></li>
			<?php endif; ?>
		</ul>
		
		<table class="sched" id="mainTable"></table>
		
	<script>
		//call a php file to create an xml file with all the marker information
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
		//create xml file, retrieve marker info
		var url = 'getSales.php?&type=created&uid=' + <?php echo $uid ?>;
		downloadUrl(url, function(data){
				var xml = data.responseXML;
				var markers = xml.documentElement.getElementsByTagName('marker');
				var i;
				var table="<tr><th onclick=\"sortTable(0)\">Seller Name</th><th onclick=\"sortTable(1)\">Location</th><th onclick=\"sortTable(2)\">Start Time</th><th onclick=\"sortTable(3)\">End Time</th><th>Notes</th>";
				Array.prototype.forEach.call(markers, function(markerElem){
					//load values into table rows
					var name = markerElem.getAttribute('name');
					var location = markerElem.getAttribute('location');
					var start = markerElem.getAttribute('start');
					var end = markerElem.getAttribute('end');
					var note = markerElem.getAttribute('notes');
					table += "<tr><td>" + name + "</td><td>" +
						location + "</td><td>" + start.slice(0,16) + "</td><td>"
						+ end.slice(0,16) + "</td><td>" + note + "</td></tr>";
				});
				document.getElementById("mainTable").innerHTML = table;	
		});
		
		function sortTable(n){
			var table, rows, switching, i, x, y, switchBool, dir, switchcount = 0;
			table = document.getElementById("mainTable");
			switching = true;
			dir = "asc";
			while(switching){
				switching=false;
				rows = table.getElementsByTagName("TR");
				//loop through all rows
				for(i = 1; i < (rows.length -1); i++){
					switchBool = false;
					x = rows[i].getElementsByTagName("TD")[n];
					y = rows[i+1].getElementsByTagName("TD")[n];
					//bubble sort lol
					if(dir=="asc"){
						if(x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase() ){
							switchBool = true;
							break;
						}
					
					}
					else if( dir == "desc"){
						if(x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase() ) {
							switchBool = true;
							break;
						}
					}
				}
				if(switchBool){
					//make a fliparoo
					rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
					switching = true;
					switchcount++;
				}
				else{ //since no switch was done, switch the sorting direction to by descending
					if(switchcount == 0 && dir == "asc"){
						dir = "desc";
						switching = true;
					}
				}
			}
		}
		
	</script>
	
	<!--Info/Credit Section-->
	<div>
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