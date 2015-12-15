<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
	
	$id = intval($_GET['id']);
	$query = "SELECT * FROM package WHERE package_no=$id";
	$parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);    
	$row = oci_fetch_array($parseRequest);
    $packageno = $row['PACKAGE_NO'];
	$packagename = $row['PACKAGE_NAME'];
	$price = $row['PRICE'];
	$start_time = substr($row['START_TIME'],0,18) . substr($row['START_TIME'],26,2);
	$end_time = substr($row['END_TIME'],0,18) . substr($row['END_TIME'],26,2);
	$companyid = $row['COMPANY_ID'];

	$query = "SELECT * FROM manager m ,current_tour c WHERE m.passport_no = c.passport_no and c.package_no = '$packageno'";
	$parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);    
	$row = oci_fetch_array($parseRequest);
	$managername = $row['NAME'];
	$managertel = $row['TEL'];
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<title>Package Number : Package Name</title>
		<script
			src="http://maps.googleapis.com/maps/api/js">
		</script>
		<script>
		var a = [];
		var x;
		</script>
		<?PHP 
			$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
			$query = "SELECT * FROM attraction WHERE package_no=$id order by id";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);    
				while($row = oci_fetch_array($parseRequest))
				{
					if($row['ID'] == 1)
					{
						echo '<script> x = new google.maps.LatLng('.$row['LOCATION'].')</script>';
					}
					echo '<script> a['.$row['ID'].'] = new google.maps.LatLng('.$row['LOCATION'].')</script>';
				}
				?>

		<script>
			//var x=new google.maps.LatLng(18.7904015,98.9657652);
			//var third=new google.maps.LatLng(18.7898415,98.9739713);
			//var second=new google.maps.LatLng(18.7904015,98.9657652);
			//var first=new google.maps.LatLng(18.7955486,98.9529775);

			function initialize()
			{
			var mapProp = {
			  center:x,
			  zoom:14,
			  mapTypeId:google.maps.MapTypeId.ROADMAP
			  };
			  
			var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

			if(a.length == 3)
				var myTrip=[a[1],a[2]];
			if(a.length == 4)
				var myTrip=[a[1],a[2],a[3]];
			if(a.length == 5)
				var myTrip=[a[1],a[2],a[3],a[4]];
			if(a.length == 6)
				var myTrip=[a[1],a[2],a[3],a[4],a[5]];
			//var myTrip=[a[1],a[2],a[3]];
			var flightPath=new google.maps.Polyline({
			  path:myTrip,
			  strokeColor:"#0000FF",
			  strokeOpacity:0.8,
			  strokeWeight:2
			  });

				var marker=new google.maps.Marker({
				  position:x,
					animation:google.maps.Animation.BOUNCE
				  });

				marker.setMap(map);
				flightPath.setMap(map);
				
			}

			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
		<style>
			body {
				background-image: url("Images/detail_bg.jpg");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-size: cover;
				font-family: "BSRU BANSOMDEJ";
				font-size:15px;
				min-width:700;
				min-height:600;
			}
			.packageDetail{
				color:#FFFFFF;
				position:relative;
				margin:auto;
				margin-top:auto;
				width:500;
				height: 135px;
				max-width:750;
				line-height: 0.3;
				text-align:center;
				padding-top:1px;
				border-radius: 25px;
			}
			#googleMap{
				margin:auto; 
				margin-top:5px;
				width:500;
				height:350;
				border-radius: 25px;
				opacity:0.8;
			}
			#abc{
				margin:auto; 
				margin-top:5px;
				width:500;
				height:350;
				border-radius: 25px;
				opacity:0.8;
			}
			img.logo{
				width:250px;
			}
			.logo{
				position:relative;
				margin:auto;
			}
			#logo {
			  height: 200px;
			  width: 250px;
			  position: relative;
			  margin:auto;
			}
			#image {
			  position: absolute;
			  left: 50%;
			  top: 50%;
			}
			#text {
			  z-index: 100;
			  position: absolute;
			  color: white;
			  font-size: 24px;
			  font-weight: bold;
			  left: 150px;
			  top: 350px;
			}
			.memberBox{
				background-color:black;
				border-radius: 25px;
				opacity:0.6;
				color:white;
				height:350px;
				margin-top:5px;
			}
			.memberBox span{
				text-align:left;
				margin-left:20px;
			}
			#parent {
				position:relative;
				width:850px;
				margin: auto;
			}
			#labels{
				float:left; width:500px;
			}
			#controls {
				margin-left:50px;
				float:left; 
				width:300px;
				height:350px;
			}
			#parent2 {
				position:relative;
				width:300px;
				margin: auto;
			}
			#labels2{
				float:left; width:150px;
			}
			#controls2{
				margin-left:10px;
				float:left; 
				width:100px;
			}
		</style>
	</head>
	<body>
		<div id="logo">
		  <img class="logo" src="Images/LogoLight.png"/>
		</div>
		<div class="packageDetail">
			<h1><?PHP echo $packageno; ?></h1>
			<h2><?PHP echo $packagename; ?></h1>
			<hr>
			<strong style="text-align:left;">Price:</strong><span style="margin-left:10px;"><?PHP echo $price; ?></span><br><br><br><br>
			<strong style="text-align:left;">Start:</strong><span style="margin-left:10px;"><?PHP echo $start_time; ?> </span>
			<strong style="text-align:left;">End:</strong><span style="margin-left:10px;"><?PHP echo $end_time; ?> </span><br><br><br><br>
			<strong style="text-align:left;">Manager:</strong><span style="margin-left:10px;"><?PHP echo $managername; ?></span><span style="margin-left:10px;"><?PHP echo $managertel; ?></span>
		</div>
		<div id="parent">
			<div id="labels">
				<div id="googleMap" style = 'float:center'></div>
			</div>
			<div id="controls">
				<div class="memberBox">
					<br>
					<h2 style="text-align:center; margin-top:-10px;">TOURIST</h2>
					<div id="parent2">
						<div id="labels2">
						<?PHP
							$query = "SELECT * FROM traveller t, ex_tour c WHERE t.passport_no = c.passport_no and c.package_no = '$id'";
							$parseRequest = oci_parse($conn, $query);
							oci_execute($parseRequest);    
							while($row = oci_fetch_array($parseRequest))
							{
								echo '<span>' . $row['NAME'] . '</span><br>';
							}
						?>
						</div>
						<div id="controls2">
						<?PHP
							$query = "SELECT * FROM traveller t, ex_tour c WHERE t.passport_no = c.passport_no and c.package_no = '$id'";
							$parseRequest = oci_parse($conn, $query);
							oci_execute($parseRequest);    
							while($row = oci_fetch_array($parseRequest))
							{
								echo '<span>' . $row['TEL'] . '</span><br>';
							}
						?>
						</div>
					</div>
				</div>
			</div>	
		</div>
		<!--<input name='buypackage' type='submit' value = 'Buy Package'>-->
	</body>
</html>