<?php
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable

require "credentialCheck.php";

$name = $_POST["userInfo"];
$psw  = $_POST["password"];
$client_type = $_POST["type"];


if (empty($_POST["userInfo"]) || empty($_POST["password"])){
	// Something is missing/empty
	//echo "<script type=\"text/javascript\">alert('Failed attempt to log in.')</script>";
	//echo "<script> window.location.replace('index.php')</script>";	
	header("Location: index.php");
	exit();
} 
else{

function login($query){

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
		//header("Location: index.php");
		exit();
	}

	// Compare result with given password
	// Found a result
	if( isset($pswFound)  && $pswFound == $psw ){
		$_SESSION['user_id'] = $name;
		$_SESSION['type'] = $client_type;
	} 
	// No result
	else{
		echo "<script> window.location.replace('index.php')</script>";
	}
}
// Prep query
//$pswFound = "";
$clientQuery = "SELECT psw FROM ClientLogin WHERE client_id= ? LIMIT 1";
$employeeQuery = "SELECT psw FROM EmployeeLogin WHERE employee_id= ? LIMIT 1";
if ($client_type == 'client'){
	$query = $clientQuery;
} else if ($client_type == 'employee'){
	$query = $employeeQuery;
} else{}

}

// Close mysql connection
$dbc->close();
?>
