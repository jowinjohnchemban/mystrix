
<?php

   include("config.php");
   session_start();
   
   global $error;
   $error = "  ";
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
	   
      // Data send from registration form
      $uname = mysqli_real_escape_string($db,$_POST['name']);           // Full Name
      $ubranch = mysqli_real_escape_string($db,$_POST['branch']);       // Branch
      $uyear = mysqli_real_escape_string($db,$_POST['year']);           // Year
	  $ucollege = mysqli_real_escape_string($db,$_POST['college']);     // College Name
	  $umailid = mysqli_real_escape_string($db,$_POST['mailid']);       // Email ID
	  $ucontactno = mysqli_real_escape_string($db,$_POST['contactno']);     // Phone Number
	  
	  // Checking for registration duplication
	  $sql = "SELECT COUNT(*) as cntusr FROM registration WHERE mail_id = '".$umailid."' and full_name = '".$uname."'";
      $result = mysqli_query($db,$sql) or die("ERROR @sql-check: " . mysqli_error($db));
      $row = mysqli_fetch_array($result);
      $count = $row['cntusr'];
      // If result matched $umailid and $uname, $count>0
      if($count > 0) { 
         $error = " ERROR : Already Registered";
      }
	  else {
		  
		  // Register
		$sql = "INSERT INTO registration (`full_name`, `branch`, `year`, `college`, `mail_id`, `contact_no`) VALUES ('".$uname."', '".$ubranch."', '".$uyear."', '".$ucollege."', '".$umailid."', '".$ucontactno."')";
		$result = mysqli_query($db,$sql) or die("Error @sql-insert: " . mysqli_error($db));
		
		 // Fetching Registration ID 
		$sql = "SELECT reg_id FROM registration WHERE full_name = '".$uname."' AND mail_id = '".$umailid."'";
		$result = mysqli_query($db,$sql) or die("ERROR @sql-reg_id : " . mysqli_error($db));
		$row = mysqli_fetch_array($result);      
		$uregid = $row['reg_id'];  
		  // Check whether registration successfull or not	
		if($uregid) {
			$_SESSION['reg_id'] = $uregid;
			header("location: registrationsuccess.php");
		}else {
			$error = "ERROR : Registration Failed ";
		}
	  }
   }
?>

<html>
   
	<head>
		<title>MYSTRIX</title>
		<link rel="icon" href="mystrix.png" type="image/gif" sizes="22x22">

	 </head>
	 <body bgcolor = "#0277bd">
		<div class="container">
			<form action="#" method="post" id="participant-reg-form" method="post" accept-charset="UTF-8">

				<div> <input id="name" name="name" type="text" size="18" required>				Full Name	</div>
				<div> <input id="branch" name="branch" type="text" size="18" required>			Branch		</div>
				<div> <input id="year" name="year" type="text" size="18" required>				Year		</div>
				<div> <input id="college" name="college" type="text" size="18" required>		College		</div>
				<div> <input id="mailid" name="mailid" type="text" size="18" required>			Mail ID		</div>
				<div> <input id="contactno" name="contactno" type="text" size="18" required>	Phone no.	</div>
				
				<div> <button type="submit" value = "Submit" name="Submit">Submit</button>  				</div>

				<div id="form-login-err-msg" class="err-msg">
					
					<?php echo $error; ?>
				</div>
		
		  	</form>
		</div>
	</body>
</html>
