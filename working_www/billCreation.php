<?php
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable
session_start();
include_once "credentialCheck.php"; // $dbc object

include_once "permissionCheck.php"; // Verify proper user info
verifySession($dbc, "client");

include_once "billCreationConstant.php"; // Defines the number of max bills to be created at the same time
include_once "part2/Client.php";
include_once "part2/Bills.php";
include_once "part2/Domain_Logic.php";


// Not logged in
if(!isset($_SESSION['user_id'])){
	// Redirect to login page
	header('Location: /login.php');
}

//$account_id = $_COOKIE['UsedAccount'];
// Take this from post
$account_id = '1';

// Verifies content before new bill
function processSingleNewBill($dbc, $from, $to, $amount, $recurring){
	if(!(empty($from) || !doesAccountExists($dbc, $to) || empty($amount) || empty($recurring))){
		Bill::addNewBill($dbc, $from, $to, $amount, $recurring);
	}
}

// Loop through all the possible entries in the new bill section
function loopProcessBills($dbc){
	global $account_d; // Needs to be set to post or change the from to select which account it comes from
	$from = $account_id;	

	$recurring = $_POST["recurringBills"];
	for ($i=1; $i<=MAX_BILLS; $i++){
		$to = $_POST["recipientAccount_{$i}"];
		$amount = floatval($_POST["billAmount_{$i}"]);
		processSingleNewBill($dbc, $from, $to, $amount, $recurring);
	}	
	echo "<script>window.location.replace('client_hub.php')</script>";
}
loopProcessBills($dbc);

/* Moved to client_hub
// Creates all the inputs for the bills
function loopCreationBills(){
	for ($=1; $i<=MAX_BILLS; $i++){
    		echo "<p>Recepient Account ID: <input type='text' name='recipientAccount_$i'> Bill Amount: <input type='number' step="0.01" min='0' name='billAmount_$i'></p>";
	}
}
*/





// Will only be checked once, and that's at the beginning when the page is created.
/*
if(isset($_POST['submitBills'])) {
    if(isset($_POST['recipientAccount_1'], $_POST['recipientAccount_2'], $_POST['recipientAccount_3'])) {
        $recipientAccountArray = array($_POST['recipientAccount_1'], $_POST['recipientAccount_2'], $_POST['recipientAccount_3']);
        $billAmountArray = array($_POST['billAmount_1'], $_POST['billAmount_2'], $_POST['billAmount_3']);
        if(isset($_POST['recurringBills'])) {
            makeNewBill($recipientAccountArray[0], $billAmountArray[0], 1);
            makeNewBill($recipientAccountArray[1], $billAmountArray[1], 1);
            makeNewBill($recipientAccountArray[2], $billAmountArray[2], 1);
        } else {
            makeNewBill($recipientAccountArray[0], $billAmountArray[0], 0);
            makeNewBill($recipientAccountArray[1], $billAmountArray[1], 0);
            makeNewBill($recipientAccountArray[2], $billAmountArray[2], 0);
        }
	// Section that changes the balance
        $retrieveCurrentAccountBalance = "SELECT balance FROM Account WHERE account_d = $account_id";
        $billAmountAddition = $billAmountArray[0] + $billAmountArray[1] + $billAmountArray[2];
        if($billAmountAddition < $retrieveCurrentAccountBalance) {
            $newBalance = $retrieveCurrentAccountBalance - $billAmountAddition;
            $newBalanceQuery = "UPDATE Account SET balance=$newBalance WHERE account_id=$account_id";
            mysql_query($newBalanceQuery);
        }
    }
    elseif(isset($_POST['recipientAccount_1'], $_POST['recipientAccount_2'])) {
        $recipientAccountArray = array($_POST['recipientAccount_1'], $_POST['recipientAccount_2']);
        $billAmountArray = array($_POST['billAmount_1'], $_POST['billAmount_2']);
        if(isset($_POST['recurringBills'])) {
            makeNewBill($recipientAccountArray[0], $billAmountArray[0], 1);
            makeNewBill($recipientAccountArray[1], $billAmountArray[1], 1);
        }
        else {
            makeNewBill($recipientAccountArray[0], $billAmountArray[0], 0);
            makeNewBill($recipientAccountArray[1], $billAmountArray[1], 0);
        }
        $retrieveCurrentAccountBalance = "SELECT balance FROM Account WHERE account_d = $account_id";
        $billAmountAddition = $billAmountArray[0] + $billAmountArray[1];
        if($billAmountAddition < $retrieveCurrentAccountBalance) {
            $newBalance = $retrieveCurrentAccountBalance - $billAmountAddition;
            $newBalanceQuery = "UPDATE Account SET balance=$newBalance WHERE account_id=$account_id";
            mysql_query($newBalanceQuery);
        }
    }
    else {
        $recipientAccount = $_POST['recipientAccount_1'];
        $billAmount = $_POST['billAmount_1'];
        if(isset($_POST['recurringBills'])) {
            makeNewBill($recipientAccount, $billAmount, 1);
        }
        else {
            makeNewBill($recipientAccount, $billAmount, 0);
        }
        $retrieveCurrentAccountBalance = "SELECT balance FROM Account WHERE account_d = $account_id";
        if($billAmount < $retrieveCurrentAccountBalance) {
            $newBalance = $retrieveCurrentAccountBalance - $billAmount;
            $newBalanceQuery = "UPDATE Account SET balance=$newBalance WHERE account_id=$account_id";
            mysql_query($newBalanceQuery);
        }
    }
}

function makeNewBill ($recipientAccount, $billAmount, $recurrence) {
    $newBillQuery = "INSERT INTO Bills (amount, account1_id, account2_id, recurring) VALUES ('$billAmount', '$account_id', '$recipientAccount', '$recurrence')";
}
*/
?>
