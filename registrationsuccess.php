<?php
   include('config.php');
   session_start();
   
   $reg_id_check = $_SESSION['reg_id'];
   
   $ses_sql = mysqli_query($db,"SELECT reg_id, full_name FROM registration WHERE reg_id = '".$reg_id_check."'") or die("ERROR @session : " . mysqli_error($db));
   
   $row = mysqli_fetch_array($ses_sql);
   
   $uregid = $row['reg_id'];
   $uname = $row['full_name'];
   
   if(!isset($_SESSION['reg_id'])){ 
      header("location:oops.php");
   }
   
   session_destroy();
    
   
   
?>



<html>
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>

      <h1>Welcome <?php echo $uname; ?></h1> 
	  <h2>Your Registration ID : <?php echo $uregid; ?></h2>
	  <h3>Please present this QR Code at registration at event<h3>
	  <img src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=<?php echo $uregid ?>" alt="Smiley face" height="500" width="500">
	  
	  <h4><a href = "close.php">Close</a></h4>
   </body>
 </html>