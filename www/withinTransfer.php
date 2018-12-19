<?php
session_start();
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable
include_once "credentialCheck.php";
include_once "permissionCheck.php";
include_once "part2/Accounts.php";
include_once "part2/Domain_Logic.php";
verifySession($dbc, "client");

function typeOfTransfer($dbc){
	if($_POST['transferType']=='id') $account2 = $_POST['account2'];
	elseif ($_POST['transferType']=='email') $account2 = Accounts::findAccountByEmail($dbc, $_POST['account2']);
	elseif ($_POST['transferType']=='phone') $account2 = Accounts::findAccountByPhone($dbc, $_POST['account2']);

	moveMoney($dbc, $_POST['account1'],$account2 ,$_POST['amount']);
}

function possibleTransaction($from, $amount){

	$balance = floatval($from->getBalance());
	$amount = abs(floatval($amount));
	
	if($balance >= $amount) return true;
	return false;
}

function moveMoney($conn, $from, $to, $amount){
	$amount = floatval($amount);
	if(isset($from) && isset($to) && isset($amount) && !empty($amount)){
		$amount = floatval($amount);
		$from = Accounts::accountFromID($conn,$from);
		$to = Accounts::accountFromID($conn,$to);

		if(possibleTransaction($from, $amount)){
			transferAccountUpdate($conn,$from, $to, $amount);
			echo "<script>window.location.replace('client_hub.php')</script>";
		}else{
			echo "<script>window.location.replace('client_hub.php')</script>";
			echo "<script type='text/javascript'>alert('The amount asked is larger than the balance for that account')</script>";
		}
	}else{ echo "<script>window.location.replace('client_hub.php')</script>";
			echo "<script>alert('Not a valid amount.')</script>";
	}
}
typeOfTransfer($dbc);
//moveMoney($dbc, $_POST['account1'],$_POST['account2'],$_POST['amount']);

//$dbc->close();
?>
