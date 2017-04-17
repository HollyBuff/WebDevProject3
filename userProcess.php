<?php include 'database.php'; ?>
 
<?php

// create a variable
$emailAddress=$_POST['emailAddress'];
$userName=$_POST['userName'];
$userPassword=$_POST['userPassword'];

 
//Execute the query
 
 
$result = mysqli_query($connect,"INSERT INTO user_data (User_Email,User_Name,User_Password)
		        VALUES ('$emailAddress','$userName','$userPassword')");
				
	if(mysqli_affected_rows($connect) > 0){
	echo "<p>User Added</p>";
	header("Location:loginRegister.php"); 
	
	//echo "<a href="index.html"> Go Back </a>";
	} else {
		echo "User NOT Added<br />";
		echo mysqli_error ($connect);
	}