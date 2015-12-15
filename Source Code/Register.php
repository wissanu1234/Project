<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "123456", "//10.10.184.43/XE", "UTF8");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	}
?>


<?PHP
	$passportno = "";
	$firstname = "";
	$lastname = "";
	$address = "";
	$tel = "";
	$username = "";
	$password = "";
	$confirmPassword = "";
	
	if(isset($_POST['submit'])){
		
		$passportno = trim($_POST['PassportNo']);
		$firstname = trim($_POST['Firstname']);
		$lastname = trim($_POST['Lastname']);
		$address = trim($_POST['Address']);
		$tel = trim($_POST['Tel']);
		$username = trim($_POST['Username']);
		$password = trim($_POST['Password']);
		$confirmPassword = trim($_POST['ConfirmPassword']);
		if($passportno != "" && $firstname != "" && $lastname != "" && $address != "" && $username  != "" && $password != "" && $confirmPassword != "" )
		{
		if($confirmPassword == $password)
		{
			$query = "SELECT * FROM Member WHERE USERNAME ='$username'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			
			if($row)
			{
				$_SESSION['ID'] = $row['ID'];
				$_SESSION['NAME'] = $row['FIRST_NAME'];
				$_SESSION['SURNAME'] = $row['LAST_NAME'];
				echo "Exists Username , Please use another";
			}
			else
			{				
				$fullname = $firstname . " " . $lastname;
				$query = "INSERT INTO Traveller(NAME, Passport_No, ADDRESS, TEL) values ('$fullname', '$passportno', '$address', '$tel')";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
				
				$query = "INSERT INTO Member(Passport_No, USERNAME, PASSWORD, ROLE) values ('$passportno', '$username', '$password' ,'Traveller')";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
				echo "successfull";
				
				$passportno = "";
				$firstname = "";
				$lastname = "";
				$address = "";
				$tel = "";
				$username = "";
				$password = "";
				$confirmPassword = "";
			}
		}
		else
		{
			//echo "Password not match.";
		}
		}
		else
		{
			//echo "Some blank not fill.";
		}
	};
	//oci_close($conn);
?>

<?PHP
	if(isset($_POST['cancel'])){
		echo '<script>window.location = "Login.php";</script>';
	};
?>

<html>
<head>
<title>
	Register page
</title>
<style>
body 
{  	background-image: url("Images/admin_bg.jpg");
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
	font-size: 22px;
}
.block {
	border:2px solid #456879;
	border-radius:8px;
	height: 30px;
	width: 230px;
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
		margin: 50px auto;
		background-color: rgba(0, 0, 0, 0.5);
		width:400px;
	}
</style>
</head>
<body>
	<div id="logo">
			<img class="logo" src="Images/LogoLight.png"/>
	</div>
    <div align="center" style="margin-top:-50px;"><font_head>MEMBERSHIP</font_head><div>
<hr>
<form class="blackBox" action='Register.php' method='post'>
	<br>
  <div align="left" style="margin-left:20px;"><font_post>Passport No</font_post></div><br>
  <div align="center"><input name='PassportNo' type='input' size = "40" maxlength ="20" value = '<?php echo $passportno; ?>'></div> 
  <br>
	
  <div align="left" style="margin-left:20px;"><font_post>Firstname</font_post></div><br>
  <div align="center"><input name='Firstname' type='input' size = "40" maxlength="20" value = '<?php echo $firstname; ?>' ></div>
  <br>
	  
  <div align="left" style="margin-left:20px;"><font_post>Lastname</font_post></div><br>
  <div align="center"><input name='Lastname' type='input' size = "40" maxlength ="20" value = '<?php echo $lastname; ?>' ></div> 
  <br>
  
  <div align="left" style="margin-left:20px;"><font_post>Address</font_post></div><br>
  <div align="center"><input name='Address' type='input' size = "40" maxlength ="100" height = "20" value = '<?php echo $address; ?>' ></div> 
  <br>
 
  <div align="left" style="margin-left:20px;"><font_post>Tel.</font_post></div><br>
  <div align="center"><input name='Tel' type='input' size = "40" maxlength ="10" value = '<?php echo $tel; ?>' ></div> 
  <br>
  
  <div align="left" style="margin-left:20px;"><font_post>Username</font_post></div><br>
  <div align="center"><input name='Username' type='input' size = "40" maxlength ="15" value = '<?php echo $username; ?>' ></div> 
  <br>
 
  <div align="left" style="margin-left:20px;"><font_post>Password</font_post></div><br>
  <div align="center"><input name='Password' type='password' size = "40" maxlength ="15"  ></div> 
  <br>
  
  <div align="left" style="margin-left:20px;"><font_post>ConfirmPassword</font_post></div><br>
  <div align="center"><input name='ConfirmPassword' type='password' size = "40" maxlength ="15"  ></div> 
  <br>
    
  <input name='submit' type='submit' value='Submit' style="border-radius:8px;"/>
  
  &nbsp;&nbsp;&nbsp;&nbsp;<input name='cancel' type='submit' value='Cancel' style="border-radius:8px;"/>
  <br><br><br>
</form>
</body>
</html>

