<?php
// Starting Session
session_start();
require "credentialCheck.php";

function searchUser($uname, $type){
	global $dbc;
	
	if ($type == 'client'){
		$query = "SELECT count(1) FROM Client WHERE client_id =". $uname.";" ;
	}
	if ($type == 'employee'){
		$query = "SELECT COUNT(1) FROM Employee WHERE employee_id ='". $uname ."'";
	}
	// If result found
	try{
		$result = $dbc->query($query);
		$row =$result->fetch_row();
		if (!$row[0] ) throw new Exception("Didn't find the id");
		
	}catch (Exception $e){
		header("Location: /index.php");
	}
}

function verifySession($desired_type){
	// Verifies that session user_id and type are set
	if(isset($_SESSION['user_id']) && isset($_SESSION['type']) && $_SESSION['type'] == $desired_type){
		// Passes them to searchUser()
		searchUser($_SESSION['user_id'], $_SESSION['type']);
	} else{
		header("Location: /index.php");
	}
}

?>
