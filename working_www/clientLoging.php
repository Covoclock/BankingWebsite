<?php
session_start();
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable
require "credentialCheck.php";

$uname       = $_POST["userInfo"];
$psw         = $_POST["password"];
$client_type = $_POST["type"];


// Something is missing/empty
if (empty($_POST["userInfo"]) || empty($_POST["password"])) {
    	header("Location: index.php");
    	exit();
}else{
	$clientQuery   = "SELECT psw FROM ClientLogin WHERE client_id = {$uname} ;";
    	$employeeQuery = "SELECT psw FROM EmployeeLogin WHERE employee_id= {$uname};";
    	if ($client_type == 'client') {
    	    login($clientQuery);
    	} else if ($client_type == 'employee') {
    	    login($employeeQuery);
    	} else {
    	    // handle other option; shouldn't happen
    	    //echo "<script> window.location.replace('index.php')</script>";    
	    header("Location: index.php");
    	}
}

function login($query) {
	global $dbc, $uname, $psw, $client_type;
    	if ($result = $dbc->query($query)) {
    	    $row = $result->fetch_row();
    	    $pswFound = $row[0];
    	} else {
    	    $error = $dbc->errno . "<br>" . $dbc->error;
    	    header("Location: index.php");
    	    exit();
    	}
    	
    	// Compare result with given password
    	// Found a result
    	if (isset($pswFound) && $pswFound == $psw) {
    	    $_SESSION['user_id'] = $uname;
    	    $_SESSION['type']    = $client_type;
	    if($client_type == 'client') header("Location: /client_hub.php");
	    else header("Location: /Admin/admin_hub.php");
	    exit();
    	}
    	// No result
    	else {
    	    //echo "<script> window.location.replace('index.php')</script>";
	    header("Location: index.php");
    	}
}
// Close mysql connection
?> 
