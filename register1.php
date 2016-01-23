<?php
require_once 'connect.php';
session_start();
	if(count($_POST)>0) {
	/* Form Required Field Validation */
	foreach($_POST as $key=>$value) {
	if(empty($_POST[$key])) {
	$message = ucwords($key) . " field is required";
	break;
	}
	if (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 4)
	{
    	$message = 'username should be minimum 4 characters';
	} 
	$username = $_POST['username'];
	$stmt = $db->prepare("SELECT * FROM users WHERE username= :username");
	$stmt->execute(array(":username"=>$username));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if(($userRow['username'] === $username)){
	$message ='username already exists,enter another username';
	}
	}
	
	/* Password Matching Validation */
	if(!isset($message)) {
	if($_POST['password'] != $_POST['confirm_password']){ 
	$message = 'Passwords should be same<br>'; 
	}
	if (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 7)
	{
    	$message = 'Incorrect Length for Password';
	}
	
	if (ctype_alnum($_POST['password']) != true)
	{
        $message = "Password must be alpha numeric";
	}
	}
	
	

	/* Email Validation */
	if(!isset($message)) {
	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
	$message = "Invalid email";
	}
	}
	
	

	
	
	
	if(!isset($message)) {

			
		$result = "INSERT INTO users (username,email,password,gender) VALUES('" . $_POST["username"] . "', '" . $_POST["email"] . "','" . md5($_POST["password"]) . "', '" . $_POST["gender"] . "')";
		
		$db->exec($result);
		if(!empty($result)) {
			$message = "You have registered successfully!";	
			unset($_POST);
			
		} else {
			$message = "Problem in registration. Try Again!";	
		}
	}
}
?>
<html>
<head>
<title>PHP User Registration Form</title>

<style>
.message {color: #FF0000;font-weight: bold;text-align: center;width: 100%;padding: 10;}
body{width:610px;}
.demo-table {background:#FFDFAF;width: 100%;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
.demo-table td {padding: 20px 15px 10px 15px;}
.demoInputBox {padding: 7px;border: #F0F0F0 1px solid;border-radius: 4px;}
.btnRegister {padding: 10px;background-color: #19F;border: 0;color: #FFF;cursor: pointer;}
</style>

</head>
<body>
<a class="btn btn-large btn-success" href="login.php">HOME</a>
     

<form name="myform" method="post" action="register1.php">

<table border="0" width="500" align="center" class="demo-table">
<div class="message"><?php if(isset($message)) echo $message; ?></div>

<td>Username*</td>
<td><input type="text" class="demoInputBox" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>"></td>
</tr>
<tr>
<td>email*</td>

<td><input type="text" class="demoInputBox" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"></td>
</tr>

<tr>
<td>Password*</td>
<td><input type="password" class="demoInputBox" name="password" value=""></td>
</tr>
<tr>
<td>Confirm Password*</td>
<td><input type="password" class="demoInputBox" name="confirm_password" value=""></td>
</tr>

<tr>
<td>Gender*</td>
<td><input type="radio" name="gender" value="Male" <?php if(isset($_POST['gender']) && $_POST['gender']=="Male") { ?>checked<?php  } ?>> Male
<input type="radio" name="gender" value="Female" <?php if(isset($_POST['gender']) && $_POST['gender']=="Female") { ?>checked<?php  } ?>> Female
</td>
</tr>
<tr><td><center>
<input type="submit" name="submit" value="Register" class="btnRegister"></td></tr></center>

</form>

</body></html>

