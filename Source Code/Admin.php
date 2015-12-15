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

	
<html>

	<head>
		<title>
			Administrator
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
		font_post1{
			font-size: 18px;
		}
		font_post2{
			font-size: 16px;
		}
		font_post{
			font-size: 12px;
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
		.roundBtn{
			border-radius:12px;
		}
		.roundBtn.hang{
			position:absolute;
			right:100px;
			top:157px;
		}
		.roundBtn.hang2{
			position:absolute;
			right:100px;
		}
		.blackBox{
			position:relative;
			margin: -80px auto;
			background-color: rgba(0, 0, 0, 0.5);
			width:400px;
		}
		.blackBox2{
			position:absolute;
			right:100px;
			background-color: rgba(0, 0, 0, 0.5);
			width:260px;
			height:200px;
		}
		.hangleft{
			margin-left:20px;
		}
		img.icon{
			width:100px;
			margin-left:85px;
		}
	</style>
</head>
<body>
	<div id="logo">
			<img class="logo" src="Images/LogoLight.png"/>
	</div>
	<div align="center" style="margin-top:-50px;"><font_head>administrator</font_head></div>
	<hr>
	<br></br>
</body>
</html>

<html>
<tr>
<form class="blackBox2" method="post" action="Admin.php" >
	<br>
	<img class="icon" src="Images/admin_icon.png"/><br>
	<span style="position:absolute;right:50px">ยินดีต้อนรับผู้ดูแลระบบ</span><br><br>
	<td><input class="roundBtn hang2" name='logout' type='submit' value='Logout'></td>
</form>
</tr>
</html>

<?PHP
	if(isset($_POST['changepass'])){
		echo '<script>window.location = "EditInformation.php";</script>';
	};
	if(isset($_POST['logout'])){
		echo '<script>window.location = "Logout.php";</script>';
	};
?>

<?PHP
	if(isset($_SESSION['Time']) && $_SESSION['ROLE'] == 'Admin'){
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
		
	if(isset($_POST['submit']))
	{	
		$name = trim($_POST['name']);
		$addr = trim($_POST['addr']);
		$tel = trim($_POST['tel']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$confirmpassword = trim($_POST['confirmpassword']);
		
		if($password == $confirmpassword)
		{
			if($name != "" || $addr != "" || $tel != "" || $username != "" || $password != "")
			{
				$query = "select max(id) from company";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
				$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
				$maxid = $row['MAX(ID)'] + 1;
			
				$query = "Insert into company values ('$maxid','$name','$addr','$tel')";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
			
				$query = "Insert into member values ('$maxid','$username','$password','Company')";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
			}
			echo '<script>window.location = "Admin.php";</script>';
		}
		else
		{
			echo "Password not match.";
		}
	};
	

	if(isset($_POST['Delete']))
	{	
		$companyname = $_POST['company'];
		
		$query = "Select * from company where name = '$companyname'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		$id = $row['ID'];
		
		$query = "Delete from company where name = '$companyname'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		
		$query = "Delete from member where Passport_No = '$id'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		echo '<script>window.location = "Admin.php";</script>';
		
		
	};
?>


<?PHP
    $query = "SELECT * FROM COMPANY";
    $parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
?>

<html>
<br></br><br></br>
<form action='Admin.php' method='post' class="blackBox">
	<br>	
	<h2 class="hangleft">Add Company</h2>
	<br>
	<div class="hangleft"><font_post1>Company name</font_post><input name='name' type='name' style="margin-left:20px;"></div> <br>
	<div class="hangleft"><font_post1>Company Address</font_post><input name='addr' type='addr' style="margin-left:20px;"></div><br>
    <div class="hangleft"><font_post1>Company Tel</font_post><input name='tel' type='tel' style="margin-left:20px;"></div><br>
	<div class="hangleft"><font_post1>Username</font_post><input name='username' type='username' style="margin-left:20px;"></div><br>
	<div class="hangleft"><font_post1>Password</font_post><input name='password' type='password' style="margin-left:20px;"></div><br>
	<div class="hangleft"><font_post2>Confirm Password</font_post><input name='confirmpassword' type='password' style="margin-left:20px;"></div><br>
	<div class="hangleft"><input class="roundBtn" name='submit' type='submit' value='Add Company'></div><br>
	<h2 class="hangleft" >Delete Company</h2>
	
	<form  method="post" action="Admin.php" >
	<select class="hangleft" name="company">

	<?PHP
		while($row)
		{
		 echo '<option value="'.$row['NAME'].'">'.$row['NAME'].'</option>';
		 $row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		}
	echo "</select> ";
	?>
	<input class="hangleft" class="roundBtn" name='Delete' type='submit' value='Delete Company' style="margin-top:20px; border-radius:12px;"><br><br>
	<font_post class="hangleft">NOTE: when delete company,  Guide, Maneger,</font_post> <br>
	<font_post class="hangleft">Package and transactions on that company </font_post> <br>
	<font_post class="hangleft" style="margin-bottom:10px;">will be deleted.</font_post><br><br>
	</form> 
	
</form>
	

</html>
