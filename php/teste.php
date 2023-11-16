<?php
require 'connect.php';

	$username =  "admin"; //$_POST['username'];
	$pass = 'admin';//$_POST['password'];
	$email = 'admin@gmail.com';
	$type = 'admin';
	
	$password = sha1($pass);
 echo $password;

$sql = "INSERT INTO users(`username`, `email`, `user_type`, `password`) VALUES ($username,$email,$type, $password);";
