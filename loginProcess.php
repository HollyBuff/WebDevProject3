<?php include 'database.php'; ?>
 
<?php
        session_start();  
        $myUsername = $_POST["myUsername"]; 
        $myPassword = $_POST["myPassword"]; 

        $_SESSION["pass_userName"] = $myUsername;

        $result1 = mysqli_query($connect,"SELECT User_Name, User_Password FROM user_data WHERE User_Name = '".$myUsername."' AND  User_Password = '".$myPassword."'");

        if(mysqli_num_rows($result1) > 0 )
        { 
        	$result2 = mysqli_query($connect,"SELECT User_Name, User_Password FROM user_data WHERE User_Name = '".$myUsername."' AND  User_Password = '".$myPassword."'");
        	if (mysqli_num_rows($result2) > 0 )
        	{
        		echo "Welcome back $myUsername";
                header("Location:game.php");
        	}
            
        }
        else
        {
            header("Location:LoginFail.php");
           
        }
?>