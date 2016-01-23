<?php
	require_once 'connect.php';
	
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$stmt = $db->prepare("SELECT * FROM users WHERE username= :username");
		$stmt->execute(array(":username"=>$username));
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if(($userRow['username'] === $username)&&($userRow['password'] === $password))
		{
			header('location:index.php');
			$_SESSION['username']= $username;
			
		}
		else
		{
			header('location:login.php');
		}
		   $db->execute(['username' => $_SESSION['username']]);
		
?>

# myRepository
