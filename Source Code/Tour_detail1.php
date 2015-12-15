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
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
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
			#logo{
				position:relative;
				margin:auto;
			}
			#container {
			  height: 190px;
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
			.poomlangkwa{
				position:relative;
				margin:10px auto;
				width:0px;
			}
			
			div.stars {
				position:absolute;
				left:50%;
				margin-left:-135px;
				width: 270px;
				display: inline-block;
			}

			input.star { display: none; }

			label.star {
			  float: right;
			  padding: 10px;
			  font-size: 36px;
			  color: #444;
			  transition: all .2s;
			}

			input.star:checked ~ label.star:before {
			  content: '\f005';
			  color: #FD4;
			  transition: all .25s;
			}

			input.star-5:checked ~ label.star:before {
			  color: #FE7;
			  text-shadow: 0 0 20px #952;
			}

			input.star-1:checked ~ label.star:before { color: #F62; }

			label.star:hover { transform: rotate(-15deg) scale(1.3); }

			label.star:before {
			  content: '\f006';
			  font-family: FontAwesome;
			}
		</style>
	</head>
	<body>
		<div id="container">
		  <img class="logo" src="Images/LogoLight.png"/>
		</div>
		<div class="packageDetail">
			<h1><?PHP echo $packageno; ?></h1>
			<h2><?PHP echo $packagename; ?></h1>
			<hr>
			<strong style="text-align:left;">Price: </strong><span><?PHP echo $price; ?></span><br><br><br><br>
			<strong style="text-align:left;">Start:</strong><span><?PHP echo $start_time; ?> </span>
			<strong style="text-align:left;">End:</strong><span><?PHP echo $end_time; ?> </span><br><br><br><br>
			<strong style="text-align:left;">Manager:</strong><span style="margin-left:10px;"><?PHP echo $managername; ?></span><span style="margin-left:10px;"><?PHP echo $managertel; ?></span>
		</div>
		
		<div id="googleMap" style = 'float:center'></div>

<?PHP
	$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
	$ppno = $_SESSION['PASSPORTNO'];
	$query = "SELECT * FROM ex_tour where package_no = $packageno and passport_no = $ppno";
	$parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	if($row)
	{
		$rate  = $row['RATING'];
		
		if($rate == '5')
			$rate5 = "checked";
		else
			$rate5 = "unchecked";
		if($rate == '4')
			$rate4 = "checked";
		else
			$rate4 = "unchecked";
		if($rate == '3')
			$rate3 = "checked";
		else
			$rate3 = "unchecked";
		if($rate == '2')
			$rate2 = "checked";
		else
			$rate2 = "unchecked";
		if($rate == '1')
			$rate1 = "checked";
		else
			$rate1 = "unchecked";
	}
if(isset($_POST['submit']))
{
	$rating = trim($_POST['rating']);
	if($rating != '')
	{
		$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
		$query = "update ex_tour set rating = '$rating' where package_no = $packageno and passport_no = $ppno";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		echo '<script>window.location = "Tour_detail1.php?id=' . $id . '";</script>';
	}
}				
		

?>
<?PHP
		echo '<div class="stars">
		  <form action="" method="post">
			<input class="star star-5" id="star-5" type="radio" name="star" ' .$rate5 .'/>
			<label class="star star-5" for="star-5"></label>
			<input class="star star-4" id="star-4" type="radio" name="star"' .$rate4 .'/>
			<label class="star star-4" for="star-4"></label>
			<input class="star star-3" id="star-3" type="radio" name="star"' .$rate3 .'/>
			<label class="star star-3" for="star-3"></label>
			<input class="star star-2" id="star-2" type="radio" name="star"' .$rate2 .'/>
			<label class="star star-2" for="star-2"></label>
			<input class="star star-1" id="star-1" type="radio" name="star"' .$rate1 .'/>
			<label class="star star-1" for="star-1"></label>
			<input type = "textbox" name="rating" value = "">
			<input type = "submit" name="submit" value = "Submit">
		  </form>
		</div>'; ?>
	</body>
</html>