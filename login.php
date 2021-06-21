<?php
//start session
session_start();
include_once('User.php');
$user = new User();
if(isset($_POST['login'])){
	$username = $user->escape_string($_POST['email']);
	$password = $user->escape_string($_POST['password']);
	$auth = $user->check_login($username, $password);

	if(!$auth){
		$_SESSION['message'] = 'Invalid username or password';
    	header('location:/');
	}
	else{
		$_SESSION['user'] = $auth;
		header('location:home');
	}
}
else{
	$_SESSION['message'] = 'You need to login first';
	header('location:/');
}
?>