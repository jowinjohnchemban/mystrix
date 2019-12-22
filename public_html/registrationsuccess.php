<?php
   include('config.php');
   session_start();
   
   $reg_id_check = $_SESSION['reg_id'];
   
   $ses_sql = mysqli_query($db,"SELECT reg_id, full_name FROM registration WHERE reg_id = '".$reg_id_check."'") or die("ERROR @session : " . mysqli_error($db));
   
   $row = mysqli_fetch_array($ses_sql);
   
   $uregid = $row['reg_id'];
   $uname = $row['full_name'];
   
   if(!isset($_SESSION['reg_id'])){ 
      header("location:oops.html");
   }
   
   //session_destroy(); // Don't uncomment : will cause oops.php when reload - SESSION DESTROYED
   // Don't HOST HAS BUGS SESSION_START : Under Development Purposes.. 
   
   
?>



<html>
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
	  <h1> Registration Successfull </h1>
      <h2>Welcome <?php echo $uname; ?></h2> 
	  <h2>Your Registration ID : <?php echo $uregid; ?></h2>
	  <h3>Please present this QR Code at registration at event<h3>
	  <img src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=<?php echo $uregid ?>" alt="QR" height="500" width="500">
	  
	  
	  <button> <a href = "printpdf.php">Download PDF</a></button>
	  <h2><a href = "close.php">Close</a></h2>
   </body>
 </html>