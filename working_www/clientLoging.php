<?php
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable

require "credentialCheck.php";

$name = $_POST["text"];
$psw  = $_POST["password"];

if (!isset($_POST["text"] || !isset($_POST["password"])){
	// Something is missing/empty
	header("Location: /");
}

// Prep query
$query = "SELECT psw FROM ClientLogin WHERE client_id='?' LIMIT 1";
if ($psw_query = $dbc->prepare($query)){
	$psw_query->bind_param("s", $name);
	$psw_query->execute();
}else{
	$error = $dbc->errno. "<br>". $dbc->error;
	echo $error;
	exit;
}

// Compare result with given password
$results = $psw_query->fetch();

$msg = "";
// Found a result
if(count($result) > 0  && $result['psw'] == $psw ){
	$_SESSION['user_id'] = $name;
	$_SESSION['type'] = "client";
} 
// No result
else{
	$msg = "Failed to login, please try again.";
	echo $msg;
	//header("Location: /login.php");
}
?>
