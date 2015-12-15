<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "123456", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>

<?PHP
	if(isset($_SESSION['Time'])){
		if(time() - $_SESSION['Time'] > 1800)
		{
			session_unset();
			session_destroy();
			echo '<script>window.location = "Login.php";</script>';
		}
		echo '<script>window.location = "' . $_SESSION['ROLE'] . '.php";</script>';
	}
?>

<?PHP
	$query = "SELECT * FROM current_tour c, package p WHERE c.package_no = p.package_no and end_time <= (select sysdate from dual)";
	$parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	while($row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC))
	{
		$passportno = $row['PASSPORT_NO'];
		$packageno = $row['PACKAGE_NO'];
		
		$query = "insert into ex_tour values('$passportno' , '$packageno', '')";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);

		$query = "delete current_tour where passport_no = '$passportno' and package_no = '$packageno'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		
	}
?>

<?PHP
	if(isset($_POST['submit'])){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		$query = "SELECT * FROM Member WHERE USERNAME ='$username' and PASSWORD='$password'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		if($row){
		$_SESSION['Time'] = time();
		$_SESSION['PASSPORTNO'] = $row['PASSPORT_NO'];
		$_SESSION['USERNAME'] = $row['USERNAME'];
		$_SESSION['ROLE'] = $row['ROLE'];
			
		echo '<script>window.location = "' . $_SESSION['ROLE'] . '.php";</script>';
		
	}}else{
			//echo "Login fail.";
		}
		
	if(isset($_POST['signup'])){
		
			echo '<script>window.location = "Register.php";</script>';
		};
	oci_close($conn);
?>
	

<html>
<head>

<title>
</title>
<style>
body 
{  	background-image: url("/Images/LoginPAGE.jpg");
	background-size : cover;
	background-repeat: no-repeat;
}
font_head{
	font-size: 60px;
	font-family: "Pristina Regular",Rage Italic;
	color: white;
}
font_post{
	font-size: 20px;
	font-family: "Pristina Regular",Rage Italic;
	color: white;
}
.block {
	border:2px solid #456879;
	border-radius:8px;
	height: 30px;
	width: 230px;
}
.button {
    background-color: #357EC7;
    border: none;
    padding: 2px 30px;
	border-radius:5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
	font-family: "DilleniaUPC",AngsanaUPC;
    font-size: 22px;
	font-style: Bold;
	color:white;
    cursor: pointer;
}

	.eiei {
		position: relative;
		width:300px;
		height:300px;
		margin:auto;
		bottom:-300px;
	}

</style>
</head>
<body>

<hr>
<form action='Login.php' method='post' >
	<br>
	<div class="eiei">
  <div align="center" style="margin-left:50px;"><font_post>Username</font_post>&nbsp;&nbsp;&nbsp;<input name='username' type='input' size = "15" maxlength ="15" class="block"></div>
  <br>
	
  <div align="center" style="margin-left:50px;"><font_post>Password</font_post>&nbsp;&nbsp;&nbsp;<input name='password' type='password' size = "15" maxlength ="15" class="block"></div>
  <p><br>
  
   <div align="center" style="margin-left:50px;">
   <input name='submit' type='submit' value='Login' onclick="myFunction()" class="button" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input name='signup' type='submit' value='Sign up' onclick="myFunction()" class="button" /></div>
  </p>
 <p>
  
  </p>
  </p>
  <p>&nbsp;</p>
	<p><br>
	  <br>
  </p>
  </div>
</form>

</body>
</html>