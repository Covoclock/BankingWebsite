<?php
session_start();
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable
include "credentialCheck.php";
include "permissionCheck.php";
verifySession("client");

//$account_id = $_COOKIE['UsedAccount'];
$account_id = '1'; 

if(isset($_POST['submitTransaction'])){
    $recipientAccountId = $_POST['recipientAccountId'];
    $transactionAmount = $_POST['transactionAmount'];
    $newTransactionQuery = "INSERT INTO Transactions (account1_id, account2_id, amount, dt) VALUES ('$account_id', '$recipientAccountId', '$transactionAmount', GETDATE())";
}

$retrieveAccount="SELECT * FROM Account WHERE account_id = {$account_id}";
$resultAccount=$dbc->query($retrieveAccount);
$fetchAccount = $resultAccount->fetch_assoc();
var_dump($fetchAccount);
$valAccountId=$fetchAccount['account_id'];
$valAccountType=$fetchAccount['account_type'];
$valAccountBalance=$fetchAccount['balance'];

// Need to double check this
$retrieveTransaction="SELECT * FROM Transactions WHERE (account1_id = $account_id OR account2_id = $account_id) AND dt > DATE_SUB(now(), INTERVAL 6 MONTH) ORDER BY dt DESC";
$resultTransaction=$dbc->query($retrieveTransaction);

$retrieveBill="SELECT * FROM Bills WHERE account1_id = $account_id";
$resultBill=$dbc->query($retrieveBill);
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

<h1>Account Details</h1>
    <p><label for="account_id">Account ID</label>
            <input type="text" id="account_id" name="account_id" value="<?php echo $valAccountId; ?>" maxlength="15" size="15" />
    </p>
    <p><label for="account_type">Account Type</label>
     	    <input type="text" id="account_type" name="account_type" value="<?php echo $valAccountType; ?>" maxlength="15" size="15" />
    </p>
    <p><label for="account_balance">Account Balance</label>
     	    <input type="text" id="account_type" name="account_type" value="<?php echo $valAccountBalance; ?>" maxlength="15" size="15" />
    </p>
            
<h1>Transactions History</h1>
	<table align="center" border="1px" style="width:600px; line-height:30px;">
        <tr>
        	<th>Transaction ID</th>
            <th>Sender Account ID</th>
            <th>Recipient Account ID</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <?php
	if($resultTransaction){
            while($transactions = $resultTransaction->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" .$transactions['tid']."</td>";
                echo "<td>" .$transactions['account1_id']."</td>";
                echo "<td>" .$transactions['account2_id']."</td>";
		// Arrange sign of amount
		if ($transactions['account1_id']== $account_id) $amount = "-".$transactions['amount'];
 		else $amount = $transactions['amount'];
                echo "<td>" .$amount."</td>";
                echo "<td>" .$transactions['dt']."</td>";
                echo "</tr>";
            }
	}
        ?>
    </table>

    <form action="template.php" method="post">
    <p><input type="text" name="recipientAccountId"></p>
    <p><input type="text" name="transactionAmount"></p>
    <p><input type="submit" name="submitTransaction" value="Submit New Transaction"></p>
    </form>

<h1>Bills</h1>
    <table align="center" border="1px" style="width:600px; line-height:30px;">
        <tr>
        	<th>Bill ID</th>
            <th>Sender Account ID</th>
            <th>Recepient Account ID</th>
            <th>Amount</th>
        </tr>
        <?php
            while($bills = $resultBill->fetch_assoc()) {
		var_dump($bills);
                echo "<tr>";
                echo "<td>" .$bills['bill_id']."</td>";
                echo "<td>" .$bills['account1_id']."</td>";
                echo "<td>" .$bills['account2_id']."</td>";
                echo "<td>" .$bills['amount']."</td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>
