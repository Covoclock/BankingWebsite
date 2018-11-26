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

$account_id = $_COOKIE['UsedAccount'];

if(isset($_POST['submitBills'])) {
    if(isset($_POST['recipientAccount_1'], $_POST['recipientAccount_2'], $_POST['recipientAccount_3'])) {
        $recipientAccountArray = array($_POST['recipientAccount_1'], $_POST['recipientAccount_2'], $_POST['recipientAccount_3']);
        $billAmountArray = array($_POST['billAmount_1'], $_POST['billAmount_2'], $_POST['billAmount_3']);
        if(isset($_POST['recurringBills'])) {
            makeNewBill($recipientAccountArray[0], $billAmountArray[0], 1);
            makeNewBill($recipientAccountArray[1], $billAmountArray[1], 1);
            makeNewBill($recipientAccountArray[2], $billAmountArray[2], 1);
        }
        else {
            makeNewBill($recipientAccountArray[0], $billAmountArray[0], 0);
            makeNewBill($recipientAccountArray[1], $billAmountArray[1], 0);
            makeNewBill($recipientAccountArray[2], $billAmountArray[2], 0);
        }
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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Specific Account</title>

    <style type="text/css">

        fieldset {
            width: 75%;
            border: 2px solid #cccccc;
        }

        label {
            width: 175px;
            float: left;
            text-align: left;
            font-weight: bold;
        }

        input {
            border: 1px solid #000;
            padding: 6px;
        }

    </style>

</head>

<body>
<h1>Create New Bills</h1>
    <h4>For multiple bills, please fill the additional lines provided.</h4>
    <form action="template.php" method="post">
    <p>Recepient Account ID: <input type="text" name="recipientAccount_1"> Bill Amount: <input type="number" step="0.01" name="billAmount_1"></p>
    <p>Recepient Account ID: <input type="text" name="recipientAccount_2"> Bill Amount: <input type="number" step="0.01" name="billAmount_2"></p>
    <p>Recepient Account ID: <input type="text" name="recipientAccount_3"> Bill Amount: <input type="number" step="0.01" name="billAmount_3"></p>
    <p><input type="checkbox" name="recurringBills" value="recurringBills">Bill(s) Recurring</p>
    <p><input type="submit" name="submitBills" value="Submit New Bill"></p>
    </form>
</body>
</html>
