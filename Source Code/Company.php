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
			Company page
		</title>
		<style>
			body 
			{  	
				background-image: url("Images/cp_bg.jpg");
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-size: cover;
				font-family:"Perpetua Titling MT";
				color:#FFFFFF;
				font-size: 12px;
			}
			img.logo{
				width:300px;
			}
			#logo{
				position:relative;
				margin: 10px auto;
				width:300px;
			}
			img.avatar{
				width:150px;
			}
			#avatar{
				position:relative;
				margin: 10px auto;
				width:150px;
			}
			font_head{
				font-size: 60px;
				text-shadow: 10px 10px 10px black, 0 0 25px blue, 0 0 5px yellow;
			}
			.blackBox{
				position:relative;
				margin: 35px auto;
				background-color: rgba(0, 0, 0, 0.5);
				width:650px;
				height:745px;
				border-radius:25px;
			}
			.blackBox2{
				position:absolute;
				right:50px;
				top:400px;
				background-color: rgba(0, 0, 0, 0.5);
				width:260px;
				height:200px;
				border-radius:25px;
			}
			img.icon{
				width:100px;
				margin-left:85px;
			}
			.roundBtn{
				border-radius:12px;
			}
			#parent {
				position:relative;
				width:630px;
				margin: 20px auto;
				height:330px;
			}
			#first{
				margin-left:20px;
				float:left; 
				width:190px;
			}
			#second {
				margin-left:20px;
				float:left; 
				width:190px;
			}
			#third {
				margin-left:20px;
				float:left; 
				width:190px;
			}
			.attractionBox{
				position:relative;
				margin: -30px auto;
				width:250px;
			}
			#parent2 {
				position:relative;
				width:630px;
				margin: auto;
				height:200px;
			}
			#first2{
				margin-left:20px;
				float:left; 
				width:290px;
			}
			#second2 {
				margin-left:20px;
				float:left; 
				width:290px;
			}
			
			select {
				width:200px;
			}
			.informations{
				position:relative;
				margin:auto;
				width:400px;
				font-size:13px;
				line-height:1.4;
				text-align:center;
				background-color: rgba(255, 255, 255, 0.5);
				color:black;
				margin-bottom:30px;
				border-radius:25px;
				box-shadow: 10px 10px 10px black, 0 0 25px blue, 0 0 5px yellow;
			}
			#parent3 {
				position:relative;
				width:400px;
				margin: auto;
				height:200px;
			}
			#first3{
				margin-left:5px;
				float:left; 
				width:180px;
			}
			#second3 {
				margin-left:5px;
				float:left; 
				width:180px;
			}
		</style>
	</head>
	<body>
		<div id="logo">
			<img class="logo" src="Images/LogoLight.png"/>
		</div>
		
		<div align="center" style="margin-top:-50px;"><font_head>COMPANY Control</font_head></div>
		<tr>
		<form class="blackBox2" method="post" action="Company.php" >
			<br>
			<img class="icon" src="Images/admin_icon.png"/><br>
			<span style="position:absolute;right:70px">ยินดีต้อนรับตัวแทนบริษัท</span><br><br>
			<input style="margin-left:40px;" class="roundBtn" name='editinformation' type='submit' value='Edit Information'>
			<input class="roundBtn" name='logout' type='submit' value='Logout'>
		</form>
		</tr>
	

<?PHP
	if(isset($_POST['editinformation'])){
		echo '<script>window.location = "EditInformation.php";</script>';
	};
	if(isset($_POST['logout'])){
		echo '<script>window.location = "Logout.php";</script>';
	};
	
?>

<hr>
<?PHP
	if(isset($_SESSION['Time']) && $_SESSION['ROLE'] == 'Company'){
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
		
		
	$comid = $_SESSION['PASSPORTNO'];
		
	if(isset($_POST['addpackage']))
	{	
		$stime = strtotime($_POST['starttime']);
		$etime = strtotime($_POST['endtime']);
		
		$stime1 = date('d-M-Y g.i.s A', strtotime(str_replace('-', '/', $_POST['starttime'])));
		$etime1 = date('d-M-Y h.i.s A', strtotime(str_replace('-', '/', $_POST['endtime'])));
		
		$packagename = trim($_POST['packagename']);
		$price = trim($_POST['price']);
		
		if($packagename != "" && $price != "" && $stime < $etime)
		{
			$query = "select max(package_no) from package";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			$maxpn = $row['MAX(PACKAGE_NO)'] + 1;
			
			$query = "Insert Into package values ('$maxpn', '$packagename' ,'$price', '$stime1', '$etime1' , '$comid')";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
		}
		
	};
	
	if(isset($_POST['addguide']))
	{	
		$guidename = trim($_POST['guidename']);
		$guidepassport = trim($_POST['guidepassport']);
		$guideaddress = trim($_POST['guideaddress']);
		$guidetel = trim($_POST['guidetel']);
		$guideusername = trim($_POST['guideusername']);
		$guidepassword = trim($_POST['guidepassword']);
		$guideconfirmpassword = trim($_POST['guideconfirmpassword']);
		
		if($guidename != "" && $guidepassport != "" && $guideaddress != "" && $guidetel != "" && $guideusername != "" && $guidepassword != "" && 
		$guideconfirmpassword != "" && $guidepassword = $guideconfirmpassword)
		{
			$query = "Insert into guide values ('$guidename','$guidepassport','$guideaddress','$guidetel','$comid' , 'Active')";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			
			$query = "Insert into member values ('$guidepassport','$guideusername','$guidepassword','Guide')";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			
		}
		//echo '<script>window.location = "Admin.php";</script>';
	};
	
	if(isset($_POST['addmanager']))
	{	
		$managername = trim($_POST['managername']);
		$managerpassport = trim($_POST['managerpassport']);
		$manageraddress = trim($_POST['manageraddress']);
		$managertel = trim($_POST['managertel']);
		$managerusername = trim($_POST['managerusername']);
		$managerpassword = trim($_POST['managerpassword']);
		$managerconfirmpassword = trim($_POST['managerconfirmpassword']);
		
		if($managername != "" && $managerpassport != "" && $manageraddress != "" && $managertel != "")
		{
			$query = "Insert into manager values ('$managername','$managerpassport','$manageraddress','$managertel','$comid' , 'Active')";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			
			$query = "Insert into member values ('$managerpassport','$managerusername','$managerpassword','Manager')";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
		}
		//echo '<script>window.location = "Admin.php";</script>';
	};
	
	
	if(isset($_POST['guideview']))
	{	
		$guidename = $_POST['guide'];
		$query = "select * from guide where company_id = '$comid' and name = '$guidename'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		echo '<div id="parent3" class="informations">
		<div id="first3">
			<div id="avatar">
				<img class="avatar" src="Images/cp_profile.png"/>
			</div>
		</div>
		<div id="second3">
			<br><br>
			<strong style="font-size:18px">' . $row['NAME'] . '</strong><br>
			<span>Pass.No :</span><strong>'. $row['PASSPORT_NO'] . '</strong><br>
			<span>Addr. :</span><strong>' . $row['ADDRESS'] . '</strong><br>
			<span>Tel. :</span><strong> ' . $row['TEL'] . '</strong><br>
			<span>Status :</span><strong>' .$row['STATUS'] . '</strong><br><br>
		</div>
		</div>';

		$selectguide = $_POST['guide'];
	};

	if(isset($_POST['managerview']))
	{	
		$managername = $_POST['manager'];
		$query = "select * from manager where company_id = '$comid' and name = '$managername'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		echo '<div id="parent3" class="informations">
		<div id="first3">
			<div id="avatar">
				<img class="avatar" src="Images/cp_profile.png"/>
			</div>
		</div>
		<div id="second3">
			<br><br>
			<strong style="font-size:18px">' . $row['NAME'] . '</strong><br>
			<span>Pass.No :</span><strong>'. $row['PASSPORT_NO'] . '</strong><br>
			<span>Addr. :</span><strong>' . $row['ADDRESS'] . '</strong><br>
			<span>Tel. :</span><strong> ' . $row['TEL'] . '</strong><br>
			<span>Status :</span><strong>' .$row['STATUS'] . '</strong><br><br>
		</div>
		</div>';
		
		$selectmanager = $_POST['manager'];
	};
	
	if(isset($_POST['addlocation']))
	{	
		$location1 = trim($_POST['location1']);
		$tag = trim($_POST['tag']);
		if($location1 != "" && $tag != "")
		{
			$packname = $_POST['packagename1'];
			$query = "select * from package where company_id = '$comid' and package_name = '$packname'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			
			$packno = $row['PACKAGE_NO'];
			
			$query = "select max(id) from attraction where package_no = '$packno'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			
			if($row['MAX(ID)'] < 5)
			{
				$maxpackno = $row['MAX(ID)'] + 1;
			
				$query = "Insert Into attraction values('$packno', '$maxpackno', '$location1','$tag')";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
			}
		}
	};
	
	if(isset($_POST['deletelocation']))
	{	
		$packname = $_POST['packagename1'];
		$query = "select * from package where company_id = '$comid' and package_name = '$packname'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		
		$packno = $row['PACKAGE_NO'];
		$query = "Delete attraction where package_no = '$packno'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		
	};
	
	
	if(isset($_POST['deletepackagefromguide']))
	{	
		$pk1 = $_POST['pkno'];
		$guidename1 = $_POST['guide'];
		$query = "select * from guide where name = '$guidename1'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		$guidepp = $row['PASSPORT_NO'];
		
		$query = "Delete from current_tour where passport_no = '$guidepp' and package_no = '$pk1'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		
	};
	
	if(isset($_POST['deletepackagefrommanager']))
	{	
		$pk2 = $_POST['pkno1'];
		$managername1 = $_POST['manager'];
		$query = "select * from manager where name = '$managername1'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		$managerpp = $row['PASSPORT_NO'];
		
		$query = "Delete from current_tour where passport_no = '$managerpp' and package_no = '$pk2'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		
	};

	
	if(isset($_POST['addpackagetoguide']))
	{	
			$pknoo1 = $_POST['addpktoguide'];
			$ppname1 = $_POST['guide'];
			
			$query = "select * from guide where name = '$ppname1' and company_id = '$comid'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			$ppnoo1 = $row['PASSPORT_NO'];

			$query = "insert into current_tour values('$ppnoo1','$pknoo1')";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
	};
	
	if(isset($_POST['addpackagetomanager']))
	{	
			$pknoo1 = $_POST['addpktomanager'];
			$ppname1 = $_POST['manager'];

			$query = "select * from manager where name = '$ppname1' and company_id = '$comid'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			$ppnoo1 = $row['PASSPORT_NO'];
			
			$query = "insert into current_tour values('$ppnoo1','$pknoo1')";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
	};
	
	if(isset($_POST['deletepackage']))
	{	
			$packageno2 = $_POST['selectdeletepackage'];

			$query = "delete package where package_no = '$packageno2' and company_id = '$comid'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
	};

?>
	<?PHP

		$query = "SELECT * FROM GUIDE where COMPANY_ID = '$comid'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	?>
	
	<br></br>
	<!--
	<div id="parent3" class="informations">
		<div id="first3">
			<div id="avatar">
				<img class="avatar" src="Images/cp_profile.png"/>
			</div>
		</div>
		<div id="second3">
			<br><br>
			<strong style="font-size:18px">Johny Walkers</strong><br>
			<span>Pass.No :</span><strong>9921832293241</strong><br>
			<span>Addr. :</span><strong>21 breakfast road Los Angeles U.S.A.</strong><br>
			<span>Tel. :</span><strong>0908842912</strong><br>
			<span>Status :</span><strong>Active</strong><br><br>
		</div>
	</div> -->
	<div class="blackBox">
	<br>
	<div id="parent2">
		<form id="first2" method="post" action="Company.php" >
	
	<select name="guide" style="margin-top:10px;">
	<?PHP
		while($row)
		{
		 echo '<option value="'.$row['NAME'].'">'.$row['NAME'].'</option>';
		 $row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		}
	echo "</select> ";
	?>

			<input class="roundBtn" name='guideview' type='submit' value='More Information' style="margin-top:10px;">

	<?PHP
		if(isset($_POST['guideview'])){
		$query = "SELECT * FROM guide where company_id = '$comid' and name = '$selectguide'";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		$ppno = $row['PASSPORT_NO'];
		
		$query = "SELECT * FROM package where package_no in (select package_no FROM current_tour where passport_no = '$ppno' ) and start_time > (select sysdate from dual) order by package_no";
		$parseRequest = oci_parse($conn, $query);
		oci_execute($parseRequest);
		$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		}
	?>

			<select name="pkno" value='' style="margin-top:10px;">
<?PHP
    while($row)
    {
     echo '<option value="'.$row['PACKAGE_NO'].'">'.$row['PACKAGE_NO'].' '.$row['PACKAGE_NAME'].'</option>';
	 $row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
    }
echo "</select> ";
?>

<input class="roundBtn" name='deletepackagefromguide' type='submit' value='Delete Package From Guide' style="margin-top:10px;">

<?PHP
	if(isset($_POST['guideview'])){
	$gname = $_POST['guide'];
	$query = "SELECT * FROM guide where company_id = '$comid' and name = '$gname'";
    $parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	$ppno1 = $row['PASSPORT_NO'];
	
    $query = "SELECT * FROM package where package_no not in (select package_no from current_tour where passport_no = '$ppno1' ) and company_id = '$comid' and start_time > (select sysdate from dual) order by package_no";
    $parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);

	}
?>
	

<select name="addpktoguide" value='' style="margin-top:10px;">
<?PHP
    while($row)
    {
     echo '<option value="'.$row['PACKAGE_NO'].'">'.$row['PACKAGE_NO'].' '.$row['PACKAGE_NAME'].'</option>';
	 $row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
    }
echo "</select> ";
?>

<input class="roundBtn" name='addpackagetoguide' type='submit' value='Add Package To Guide' style="margin-top:10px;">
		</form>
		<form id="second2" method="post" action="Company.php" >
		<?PHP
			$query = "SELECT * FROM MANAGER where COMPANY_ID = '$comid'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		?>
		<select name="manager" style="margin-top:10px;">

<?PHP
    while($row)
    {
     echo '<option value="'.$row['NAME'].'">'.$row['NAME'].'</option>';
	 $row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
    }
echo "</select> ";
?>
	<input class="roundBtn" name='managerview' type='submit' value='More Information' style="margin-top:10px;">
</td>

<?PHP
	if(isset($_POST['managerview'])){
	$query = "SELECT * FROM manager where company_id = '$comid' and name = '$selectmanager'";
    $parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	$ppno = $row['PASSPORT_NO'];
	
	$query = "SELECT * FROM package where package_no in (select package_no FROM current_tour where passport_no = '$ppno' ) and start_time > (select sysdate from dual) order by package_no";
    $parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	}
?>

<select name="pkno1" value='' style="margin-top:10px;">
<?PHP
    while($row)
    {
     echo '<option value="'.$row['PACKAGE_NO'].'">'.$row['PACKAGE_NO'].' '.$row['PACKAGE_NAME'].'</option>';
	 $row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
    }
echo "</select> ";
?>

<?PHP
    $query = "SELECT * FROM MANAGER where COMPANY_ID = '$comid'";
    $parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
?>

<input class="roundBtn" name='deletepackagefrommanager' type='submit' value='Delete Package From Manager' style="margin-top:10px;"><br>

<?PHP
	if(isset($_POST['managerview'])){
	$mname = $_POST['manager'];
	$query = "SELECT * FROM manager where company_id = '$comid' and name = '$mname'";
    $parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
	$ppno1 = $row['PASSPORT_NO'];
	
    $query = "SELECT * FROM package where package_no not in (select c.package_no from CURRENT_TOUR c ,MEMBER m where 
	c.passport_no = m.passport_no and (m.role = 'Manager' or m.passport_no = '$ppno1')) and company_id = '$comid' and 
	start_time > (select sysdate from dual) order by package_no";
    $parseRequest = oci_parse($conn, $query);
	oci_execute($parseRequest);
	$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);

	}
?>

<select name="addpktomanager" value='' style="margin-top:10px;">
<?PHP
    while($row)
    {
     echo '<option value="'.$row['PACKAGE_NO'].'">'.$row['PACKAGE_NO'].' '.$row['PACKAGE_NAME'].'</option>';
	 $row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
    }
echo "</select> ";
?>


<input class="roundBtn" name='addpackagetomanager' type='submit' value='Add Package To Manager' style="margin-top:10px;">

</form>
</div>
<?PHP 
	$currenttime = date("Y-m-d", mktime()) . 'T' . ((time()/ 3600 % 24) + 7) . ":" . time() / 60 % 60 . ":" ."00";
?>
<div id="parent">
	<div id="first">
		<form action='Company.php' method='post'>
		package name <br>
		<input name='packagename' type='name'><br>
		price<br>
		<input name='price' type='addr'><br>
		Start time <br>
		<input name = 'starttime' type="datetime-local" value='<?PHP echo $currenttime;?>'/><br>
		End time<br>
		<input name = 'endtime' type="datetime-local" value='<?PHP echo $currenttime;?>'/><br><br>
		<input class="roundBtn" name='addpackage' type='submit' value='Add Package'>
		
		<?PHP
			$query = "SELECT * FROM package where company_id = '$comid' and start_time > (select sysdate from dual) order by package_no";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
		?>

			<select name="selectdeletepackage" value='' style="margin-top:10px;">
		<?PHP
			while($row)
			{
			echo '<option value="'.$row['PACKAGE_NO'].'">'.$row['PACKAGE_NO'].' '.$row['PACKAGE_NAME'].'</option>';
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			}
			echo "</select> ";
		?>
		
		<input class="roundBtn" name='deletepackage' type='submit' value='Delete Package'>
		</form>
	</div>
	<div id="second">
		<form action='Company.php' method='post'>
		Guide name <br>
		<input name='guidename' type='name'><br>
		Guide passport <br>
		<input name='guidepassport' type='name'><br>
		Guide Address<br>
		<input name='guideaddress' type='addr'><br>
		Guide Tel <br>
		<input name='guidetel' type='tel'><br>
		Guide Username<br>
		<input name='guideusername' type='addr'><br>
		Guide Password<br>
		<input name='guidepassword' type='password'><br>
		Guide Confirm Password<br>
		<input name='guideconfirmpassword' type='password'><br><br>
		<input class="roundBtn" name='addguide' type='submit' value='Add Guide'>
		</form>
	</div>
	<div id="third">
		<form action='Company.php' method='post'>
		Manager name <br>
		<input name='managername' type='name'><br>
		Manager passport <br>
		<input name='managerpassport' type='name'><br>
		Manager Address<br>
		<input name='manageraddress' type='addr'><br>
		Manager Tel <br>
		<input name='managertel' type='tel'><br>
		Manager Username<br>
		<input name='managerusername' type='addr'><br>
		Manager Password<br>
		<input name='managerpassword' type='password'><br>
		Manager Confirm Password<br>
		<input name='managerconfirmpassword' type='password'><br><br>
		<input class="roundBtn" name='addmanager' type='submit' value='Add Manager'>
		</form>
	</div>
</div>
			<form action='Company.php' method='post' class="attractionBox">
				<br> <span style="margin-left:48px;">Package Name</span> <br>
			
			<?PHP
				$query = "SELECT * FROM package where COMPANY_ID = '$comid' and start_time > (select sysdate from dual) order by package_no";
				$parseRequest = oci_parse($conn, $query);
				oci_execute($parseRequest);
				$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			?>

			<select style="margin-left:48px;" name="packagename1" value='' >
			
			<?PHP
				while($row)
				{
				 echo '<option value="'.$row['PACKAGE_NAME'].'">'.$row['PACKAGE_NO'].' '.$row['PACKAGE_NAME'].'</option>';
				 $row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
				}
			echo "</select> ";
			?>

			
			<br>
			<span style="margin-left:48px;">Location</span>
			<br>
			<input style="margin-left:48px;" name = 'location1' type="textbox" />
			<br>
			<span style="margin-left:48px;">Tag of package</span>
			<br>
			<input style="margin-left:48px;" name = 'tag' type="textbox" />
			<br>
			<br>
			<input class="roundBtn" name='addlocation' type='submit' value='Add Location'>
			<input class="roundBtn" name='deletelocation' type='submit' value='Delete All Location'>
			</form>
	</body>
</html>
	