<?PHP
	session_start();
	if(isset($_SESSION['Time'])){
		if(time() - $_SESSION['Time'] > 1800)
		{
			session_unset();
			session_destroy();
			echo '<script>window.location = "Login.php";</script>';
		}
		$conn = oci_connect("system", "123456", "//localhost/XE", "UTF8");
		if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
		}
	}
	else
	{
		echo '<script>window.location = "Login.php";</script>';
	}	
?> 


<?PHP

$role = $_SESSION['ROLE'];
	if(isset($_POST['submit1'])){
		$name = trim($_POST['name']);
		$address = trim($_POST['address']);
		$tel = trim($_POST['tel']);
		$confirmpassword = trim($_POST['confirmpassword']);
		$username = $_SESSION['USERNAME'];
		$ppno = $_SESSION['PASSPORTNO'];
		
		$query = "SELECT * FROM Member WHERE USERNAME = '$username' and Password='$confirmpassword'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row)
		{
			if($role == 'Guide')
				$query1 = "UPDATE Guide SET name = '$name' , address = '$address' , tel = '$tel' where passport_no = '$ppno'";
			if($role == 'Manager')
				$query1 = "UPDATE Manager SET name = '$name' , address = '$address' , tel = '$tel' where passport_no = '$ppno'";
			if($role == 'Traveller')
				$query1 = "UPDATE Traveller SET name = '$name' , address = '$address' , tel = '$tel' where passport_no = '$ppno'";
			if($role =='Company')
				$query1 = "UPDATE Company SET name = '$name' , address = '$address' , tel = '$tel' where id = '$ppno'";

			$parseRequest1 = oci_parse($conn, $query1);
			oci_execute($parseRequest1);
			echo '<script>window.location = "' . $_SESSION['ROLE'] . '.php";</script>';
	}};
	
	
	if(isset($_POST['submit2'])){
		$oldpassword = trim($_POST['oldpassword']);
		$newpassword = trim($_POST['newpassword']);
		$confirmnewpassword = trim($_POST['confirmnewpassword']);
		$username = $_SESSION['USERNAME'];
		if($newpassword == $confirmnewpassword){
		$query = "SELECT * FROM Member WHERE USERNAME = '$username' and Password='$oldpassword'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		// Fetch each row in an associative array
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
			$query1 = "UPDATE Member SET Password = '$newpassword' where USERNAME = '$username'";
			$parseRequest1 = oci_parse($conn, $query1);
			oci_execute($parseRequest1);
			//echo '<script>window.location = "' . $_SESSION['ROLE'] . '.php";</script>';
		}else{
			echo "Old Password was wrong";
		}
		}else{
			echo "New password not match";
		}
	};
?>


<?PHP
	if(isset($_POST['back'])){
		echo '<script>window.location = "' . $_SESSION['ROLE'] . '.php";</script>';
	};
?>




<html>
<head>
	<title>
		General Account Settings
	</title>
	<style>
		body 
		{  	
			background-image: url("Images/pw_bg.jpg");
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
			font-family:"Perpetua Titling MT";
			color:#FFFFFF;
		}
		font_head{
			font-size: 60px;
			text-shadow: 10px 10px 10px black, 0 0 25px blue, 0 0 5px yellow;
		}
		font_post{
			font-size: 15px;
		}
		.block {
			border:2px solid #456879;
			border-radius:5px;
			height: 30px;
			width: 180px;
		}
		img.logo{
			width:300px;
		}
		#logo{
			position:relative;
			margin: 10px auto;
			width:300px;
		}
		.blackBox{
			position:relative;
			margin: -150px auto;
			background-color: rgba(0, 0, 0, 0.5);
			width:300px;
			border-radius:25px;
		}
		.hangleft{
			margin-left:20px;
		}
		#parent {
			position:relative;
			width:650px;
			margin: 200px auto;
		}
		#labels{
			float:left; width:300px;
		}
		#controls {
			margin-left:50px;
			float:left; 
			width:300px;
		}
	</style>
</head>
<body>
	<div id="logo">
			<img class="logo" src="Images/LogoLight.png"/>
	</div>
	<div align="center" style="margin-top:-50px;"><font_head>General Account Settings</font_head></div>
	<hr>
<div id="parent">
<?PHP
		$ppno1 = $_SESSION['PASSPORTNO'];
		$role1 = $_SESSION['ROLE'];
		if($role1 == 'Guide')
			$query = "SELECT * FROM guide WHERE passport_no ='$ppno1'";
		if($role1 == 'Manager')
			$query = "SELECT * FROM manager WHERE passport_no ='$ppno1'";
		if($role1 == 'Traveller')
			$query = "SELECT * FROM traveller WHERE passport_no ='$ppno1'";
		if($role1 == 'Company')
			$query = "SELECT * FROM company WHERE id ='$ppno1'";

			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			
		if($role1 == 'Company')
			$passportno = $row['ID'];
		else
			$passportno = $row['PASSPORT_NO'];
			$name = $row['NAME'];
			$addr = $row['ADDRESS'];
			$tel = $row['TEL'];
		
		
	?>
	<form id="labels" class="blackBox" action='EditInformation.php' method='post'>
		<br>
		<div class="hangleft" ><font_post>Name:</font_post></div><br>
		<div align="center"><input name='name' type='textbox'class ="block" value = '<?PHP echo $name; ?>'></div><br>
		<div class="hangleft"><font_post>Passport number:</font_post></div><br>
		<div align="center"><input name='passportno' type='textbox'class ="block" value = '<?PHP echo $passportno; ?>' disabled></div><br>
		<div class="hangleft"><font_post>Address:</font_post></div><br>
		<div align="center"><input name='address' type='textbox'class ="block" value = '<?PHP echo $addr; ?>'></div><br>
		<div class="hangleft"><font_post>Telephone:</font_post></div><br>
		<div align="center"><input name='tel' type='textbox'class ="block" value = '<?PHP echo $tel; ?>' maxlength = '15'></div><br>
		<div class="hangleft"><font_post>Enter Password</font_post></div><br>
		<div align="center"><input name='confirmpassword' type='password'class ="block"></div><br><br>
		<div align="center"><input style="border-radius:12px;" name='submit1' type='submit' value='Submit' class="button">&nbsp;&nbsp;
		<input style="border-radius:12px;" name='back' type='submit' value='Back' class ="button"> </div>
		<br>
	</form>
	<form id="controls" class="blackBox" action='EditInformation.php' method='post'>
		<br>
		<div class="hangleft"><font_post>Old Password</font_post></div><br>
		<div align="center"><input placeholder=" Old Password" name='oldpassword' type='password'class ="block"></div><br>
		<div class="hangleft"><font_post>New Password</font_post></div><br>
		<div align="center"><input placeholder=" New Password"name='newpassword' type='password'class ="block"></div><br>
		<div class="hangleft"><font_post>Comfirm New Password</font_post></div><br>
		<div align="center"><input placeholder=" Comfirm New Password" name='confirmnewpassword' type='password'class ="block"></div><br><br>
		<div align="center"><input style="border-radius:12px;" name='submit2' type='submit' value='Submit' class="button">&nbsp;&nbsp;
		<input style="border-radius:12px;"  name='back' type='submit' value='Back' class ="button"> </div>
		<br>
	</form>
</div>
</body>
</html>