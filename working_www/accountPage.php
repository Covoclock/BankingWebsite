<?php
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable
session_start();
require "credentialCheck.php";
require "logout.php";

// Not logged in
if(!isset($_SESSION['user_id'])){
	// Redirect to login page
	header('Location: /login.php');
}

// Your code here
// ...

?>


<html>
<body>

<?php
// Logged In 
else{
}

