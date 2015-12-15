<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>

<?PHP
	if(isset($_SESSION['Time']) && $_SESSION['ROLE'] == 'Traveller'){
		if(time() - $_SESSION['Time'] > 1800)
		{
			session_unset();
			session_destroy();
			echo '<script>window.location = "Login.php";</script>';
		}
	}
	else
	{
		echo '<script>window.location = "Login.php";</script>';
	}
	
?>



<html>
	<head>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<title>MEMBER PAGE</title>
		<style>
			body{
				background-image: url("Images/member_bg.jpg");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-size: cover;
				color: #FFFFFF;
				font-family: "BSRU BANSOMDEJ";
				font-size:20px;
				line-height:1.1;
			}
			.tabs {
				max-width: 90%;
				float: none;
				list-style: none;
				padding: 0;
				margin: 75px auto;
				border-bottom: 4px solid #ccc;
				border-radius: 25px;
			}
			 
			.tabs:after {
				content: '';
				display: table;
				clear: both;
			}
			 
			.tabs input[type=radio] {
				display:none;
			}
			 
			.tabs label.fortabs {
				display: block;
				float: left;
				width: 25%;
			 
				color: #ccc;
				font-size: 18px;
				font-weight: normal;
				text-decoration: none;
				text-align: center;
				line-height: 2;
			 
				cursor: pointer;
				box-shadow: inset 0 4px #ccc;
				border-bottom: 4px solid #ccc;
			 
				-webkit-transition: all 0.5s; /* Safari 3.1 to 6.0 */
				transition: all 0.5s;
			}
			  
			.tabs label span {
				display: none;
			}
			 
			.tabs label i {
				padding: 5px;
				margin-right: 0;
			}
			 
			<--!.tabs label:hover {
				color: #FFB266;
				box-shadow: inset 0 4px #FFB266;
				border-bottom: 4px solid #FFB266;
			}-->
			 
			.tab-content {
				display: none;
				width: 100%;
				float: left;
				padding: 15px;
				box-sizing: border-box;
			  
				/*background-color:#ffffff;*/
			}
			
			.tab-content * {
				-webkit-animation: scale 0.7s ease-in-out;
				-moz-animation: scale 0.7s ease-in-out;
				animation: scale 0.7s ease-in-out;
			}

			@keyframes scale {
			  0% { 
				transform: scale(0.9);
				opacity: 0;
				} 
			  50% {
				transform: scale(1.01);
				opacity: 0.5;
				}
			  100% { 
				transform: scale(1);
				opacity: 1;
			  }
			}
			
			.tabs [id^="tab"]:checked + label {
				/*background: #FFF;*/
				box-shadow: inset 0 4px #FF8000;
				border-bottom: 4px solid #FF8000;
				color: #FF8000;
				border-radius: 25px;
			}
			 
			#tab1:checked ~ #tab-content1,
			#tab2:checked ~ #tab-content2,
			#tab3:checked ~ #tab-content3,
			#tab4:checked ~ #tab-content4 {
				display: block;
			}
			
			@media (min-width: 768px) {   
				.tabs i {
					padding: 5px;
					margin-right: 10px;
				}
			 
				.tabs label span {
					display: inline-block;
				}
			 
				.tabs {
				   max-width: 750px;
				   margin: 0px auto;
				}
			}
			
			.thumbnail {
				height: 80px;
			}

			.image {
				width: 100%;
				height: 100%;    
			}

			.image img {
				-webkit-transition: all 0.3s ease; /* Safari and Chrome */
				-moz-transition: all 0.3s ease; /* Firefox */
				-ms-transition: all 0.3s ease; /* IE 9 */
				-o-transition: all 0.3s ease; /* Opera */
				transition: all 0.3s ease;
			}

			.image:hover img {
				-webkit-transform:scale(1.25); /* Safari and Chrome */
				-moz-transform:scale(1.25); /* Firefox */
				-ms-transform:scale(1.25); /* IE 9 */
				-o-transform:scale(1.25); /* Opera */
				 transform:scale(1.25);
			}
			
			img.curtour{
				height:80px;
			}
			img.extour{
				height:80px;
				margin-left:-10px;
				margin-top:-5px;
			}
			img.registour{
				height:80px;
				margin-left:25px;
				margin-top:-5px;
			}
			img.payment{
				height:80px;
				margin-left:-5px;
				margin-top:21px;
			}	
			#cover{
				position:relative;
				margin:auto;	
				background-color: rgba(0, 0, 0, 0.9);
				width: 55%;
				min-width: 750px;
				height:90%;
			}
			.packageBox{
				border-style: solid;
				border-width: 2px;
				padding: 10px;
				padding-left:20px;
				margin-bottom:10px;
				min-width:680;
			}
			a{
				color:#FFFFFF;
			}
			img.logo{
				width:300px;
			}
			#parent {
				position:relative;
				width:800px;
				margin: auto;
			}
			#labels{
				float:left; width:300px;
			}
			#controls {
				float:left; width:500px;
				background-color: rgba(0, 0, 0, 0.6);
				border-radius: 25px;
			}
			#parent p {clear:both;}
			
			.recommend{
				position:absolute;
				right:55px;
				margin-top:-32px;
				width:100px;
				min-width:100px;
				max-width:100px;
			}
			
	</style>
	</head>
	<body>
		
	<?PHP
		$ppno = $_SESSION['PASSPORTNO'];
		$query = "SELECT * FROM traveller WHERE passport_no ='$ppno'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		$name = $row['NAME'];
		$passportno = $row['PASSPORT_NO'];
		$addr = $row['ADDRESS'];
		$tel = $row['TEL'];
	?>

	<?PHP	
		if(isset($_POST['edit'])){
		echo '<script>window.location = "EditInformation.php";</script>';
		};
	
		if(isset($_POST['logout'])){
		echo '<script>window.location = "Logout.php";</script>';
		};
	
		oci_close($conn);
	?>
		
		<div id="parent">
			<div id="labels">
				<img class="logo" src="Images/LogoLight.png"/>
			</div>
			<div id="controls">
				<ul>
					<br><br>
					<span style="font-size:50px;">ยินดีต้อนรับ <br>คุณ </span><span style="font-size:50px;"><?PHP echo $name; ?></span><br>
					<strong>Passport Number: </strong>  <span><?PHP echo $passportno; ?></span><br>
					<strong>Adress: </strong>  <span><?PHP echo $addr; ?></span><br>
					<strong>Telephone Number: </strong>  <span><?PHP echo $tel; ?></span><br>
					<strong>Member: </strong>  <span><?PHP echo $_SESSION['ROLE']; ?></span><br>
					<form action='Traveller.php' method='post'>
					<span><input name='edit' type='submit' value='Edit Information'></span>
					<input name='logout' type='submit' value='Logout'>
					</form>
				</ul>
			</div>
			<p></p>
		</div>
		
		<nav id="cover">
		<div class="tabs">
		 
		   <!-- Radio button and lable for #tab-content1 -->
		   <input type="radio" name="tabs" id="tab1" checked >
		   <label class="fortabs" for="tab1">
				<div style="height:30px;"></div>
				<div class="thumbnail">
					<div class="image">
						<img class="curtour" src="Images/curr_tour2.png"/>
					</div>
				</div>
			   <span>Current Tour</span>
		   </label>
		 
		   <!-- Radio button and lable for #tab-content2 -->
		   <input type="radio" name="tabs" id="tab2">
		   <label class="fortabs" for="tab2">
				<div style="height:30px;"></div>
				<div class="thumbnail">
					<div class="image">
						<img class="curtour" src="Images/ex_tour2.png"/>
					</div>
				</div>
				<span>Ex-Tour</span>
		   </label>
		 
		   <!-- Radio button and lable for #tab-content3 -->
		   <input type="radio" name="tabs" id="tab3">
		   <label class="fortabs" for="tab3">
				<div style="height:30px;"></div>
				<div class="thumbnail">
					<div class="image">
						<img class="curtour" src="Images/register_tour2.png"/>
					</div>
				</div>
				<span>Register Tour</span>
		   </label>
		   
		   <input type="radio" name="tabs" id="tab4">
		   <label class="fortabs" for="tab4">
				<div style="height:30px;"></div>
				<div class="thumbnail">
					<div class="image">
						<img class="curtour" src="Images/money2.png"/>
					</div>
				</div>
				<span>Payment</span>
		   </label>
			   <div id="tab-content1" class="tab-content">
					<h3>CURRENT TOUR</h3> 
					<hr>
					<?php
					$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
					$query = "SELECT * FROM package where package_no in (select package_no from current_tour where passport_no = '$ppno') order by package_no";
					$parseRequest = oci_parse($conn, $query);
					oci_execute($parseRequest);

					while($row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC))
					{
						$packageno = $row['PACKAGE_NO'];
						$packagename = $row['PACKAGE_NAME'];
					echo	'<a href=" " onclick="window.open(' . "'Tour_detail.php?id=" . $packageno. " ','','Toolbar=0,Location=auto,Directories=0,Status=0,Menubar=0,Scrollbars=0,Resizable=0,Width=1400,Height=750,left=50');" .'">
					<ul class="packageBox">
						<strong>Package Number : </strong><span>' . $packageno . '</span><br>
						<strong>Package Name : </strong><span>' . $packagename . '</span>
					</ul>
					</a>';
					}?>
			   </div> <!-- #tab-content1 -->
			   <div id="tab-content2" class="tab-content">
					<h3>Ex-TOUR</h3> 
					<hr>
					<?php
						$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
						$query = "SELECT * FROM package where package_no in (select package_no from ex_tour where passport_no = '$ppno') order by package_no";
						$parseRequest = oci_parse($conn, $query);
						oci_execute($parseRequest);

						while($row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC))
						{
							$packageno = $row['PACKAGE_NO'];
							$packagename = $row['PACKAGE_NAME'];
						echo	'<a href=" " onclick="window.open(' . "'Tour_detail1.php?id=" . $packageno. " ','','Toolbar=0,Location=auto,Directories=0,Status=0,Menubar=0,Scrollbars=0,Resizable=0,Width=1400,Height=750,left=50');" .'">
						<ul class="packageBox">
							<strong>Package Number : </strong><span>' . $packageno . '</span><br>
							<strong>Package Name : </strong><span>' . $packagename . '</span>
						</ul>
						</a>';
						}?>
			   </div> <!-- #tab-content2 -->
			   <div id="tab-content3" class="tab-content">
					<h3>Register Tour</h3>  
					<hr>
					<?php
						$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
						$timestamp = date('d-M-Y h.i.s A',time());
						$query = "SELECT * FROM package where package_no not in (select package_no from current_tour where passport_no = '$passportno') and
						start_time > (select sysdate from dual) order by package_no";
						$parseRequest = oci_parse($conn, $query);
						oci_execute($parseRequest);

					while($row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC))
					{
						$packageno = $row['PACKAGE_NO'];
						$packagename = $row['PACKAGE_NAME'];
					echo '<a href="" onclick="window.open(' . "'Tour_detail2.php?id=" . $packageno. " ','','Toolbar=0,Location=auto,Directories=0,Status=0,Menubar=0,Scrollbars=0,Resizable=0,Width=1400,Height=750,left=50');" .'">
					<ul class="packageBox">
							<strong>Package Number : </strong><span>' . $packageno . '</span><br>
							<strong>Package Name : </strong><span>' . $packagename . '</span>
									<img class="recommend" src="Images/Recommended.png"/>
					</ul>
					</a>';
					}
					?>
					
			   </div> <!-- #tab-content3 -->
			   <div id="tab-content4" class="tab-content">
					<h3>Payment</h3>
					<hr>
					<?php
						$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
						$query = "SELECT * FROM package where package_no in (select package_no from take_service where TRAVELLER_PASSPORT = '$ppno') order by package_no";
						$parseRequest = oci_parse($conn, $query);
						oci_execute($parseRequest);

						while($row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC))
						{
							$packageno = $row['PACKAGE_NO'];
							$packagename = $row['PACKAGE_NAME'];
						echo	'<a href=" " onclick="window.open(' . "'Tour_detail1.php?id=" . $packageno. " ','','Toolbar=0,Location=auto,Directories=0,Status=0,Menubar=0,Scrollbars=0,Resizable=0,Width=1400,Height=750,left=50');" .'">
						<ul class="packageBox">
							<strong>Package Number : </strong><span>' . $packageno . '</span><br>
							<strong>Package Name : </strong><span>' . $packagename . '</span>
						</ul>
						</a>';
						}?>
			   </div> <!-- #tab-content3 -->
			</div>
		</nav>
		
	</body>
</html>