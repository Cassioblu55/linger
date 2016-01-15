<?php 
	include_once '../../config/config.php';
	session_start();
	 // We remove the user's data from the session 
    unset($_SESSION['user']); 
     
    // We redirect them to the login page 
    header("Location: ".$baseURL."admin/login/");
    die("Redirecting to: login");   
?>