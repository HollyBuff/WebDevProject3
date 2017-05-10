<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <title>Create_New_User</title>

  <link rel="stylesheet" href="css/CNU.css">
 <script src="js/jquery-3.1.1.js"></script>
</head>

<body>
	<header>
    	<h1 id="CNU_header_Title">Registration Information</h1>
  	</header>
  	<div id="loginBox">
	<form action="userProcess.php" method="post" id="myForm">

		<p id="userName">Username: <input title="Username must not be blank and contain only letters, numbers and underscores." type="text" required pattern="\w+" name="userName"></p>

		<p id="email">Email: <input type="text" name='emailAddress' required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" /></p>

		<p id="passwd">Password: <input title="Password must contain at least 6 characters, including UPPER/lowercase and numbers." type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="userPassword" onchange="
		  this.setCustomValidity(this.validity.patternMismatch ? this.title : '');
		  if(this.checkValidity()) form.pwd2.pattern = this.value;"></p>

		<p id="cpwrd">Confirm Password: <input id="field_pwd2" title="Please enter the same Password as above." type="password"  required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="pwd2" onchange="
  		this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"></p>
		<p><input type="submit" id="submit" value="Submit"></p>
	</form>

	<form action="loginRegister.php" method="post" id="myForm">
		<p><input type="submit" id="submit" value="Back"></p>
	</form>

	</div>
	<script>
	
	</script>
</body>
</html>