<?php
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable

require "credentialCheck.php";

$name = $_POST["userInfo"];
$psw  = $_POST["password"];

//print_r(array_values($_POST));
//echo("<br>");
//echo $name;
//echo("<br>");
//echo $psw;
//echo("<br>");

if (!isset($_POST["userInfo"]) || !isset($_POST["password"])){
	// Something is missing/empty
	header("Location: index.php");
	exit();
} 
else{
// Prep query
//$pswFound = "";
$query = "SELECT psw FROM ClientLogin WHERE client_id= ? LIMIT 1";
if ($psw_query = $dbc->prepare($query)){
	$psw_query->bind_param("s", $name);
	$psw_query->execute();
	$psw_query->bind_result($pswFound);
	$psw_query->fetch();
	$psw_query->close();
	echo $pswFound;
}else{
	$error = $dbc->errno. "<br>". $dbc->error;
	echo $error;
	header("Location: index.php");
	exit();
}

// Compare result with given password
$msg = "";
// Found a result
if( isset($pswFound)  && $pswFound == $psw ){
	$_SESSION['user_id'] = $name;
	$_SESSION['type'] = "client";
} 
// No result
else{
	$msg = "Failed to login, please try again.";
	echo $msg;
	header("Location: index.php");
}
}

// Close mysql connection
$dbc->close();
?>
