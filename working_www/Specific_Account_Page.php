<?php
session_start();
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable
require_once "credentialCheck.php";
require_once "permissionCheck.php";
require_once "part2/Accounts.php";
verifySession("client");

$account_id = $_POST['accountID'];
$account_obj = \BankingApp\Accounts::accountFromID($dbc, $account_id);

if(isset($_POST['submitTransaction'])){
    $recipientAccountId = $_POST['recipientAccountId'];
    $transactionAmount = $_POST['transactionAmount'];
    $newTransactionQuery = "INSERT INTO Transactions (account1_id, account2_id, amount, dt) VALUES ('$account_id', '$recipientAccountId', '$transactionAmount', GETDATE())";
}

$retrieveAccount="SELECT * FROM Account WHERE account_id = {$account_id}";
$resultAccount=$dbc->query($retrieveAccount);
$fetchAccount = $resultAccount->fetch_assoc();
//var_dump($fetchAccount);
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">


</head>

<body>

        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
        </style>


<h1>Account Details</h1>
	<div class=''>
	<?php echo "<p> {$account_obj}</p>"; ?>
	</div>
	<hr>
            
<h1>Transactions History</h1>
	<table class='table' >
	<thead class='thead-dark'>
        <tr>
        	<th>Transaction ID</th>
            <th>Sender Account ID</th>
            <th>Recipient Account ID</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
	</thead>
	<tbody>
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
	</tbody>
    </table>


<h1>Bills</h1>
    <table class='table' align="center" border="1px" style="width:600px; line-height:30px;">
	<thead class='thead-dark'>
        <tr>
        	<th>Bill ID</th>
            <th>Sender Account ID</th>
            <th>Recepient Account ID</th>
            <th>Amount</th>
        </tr>
	</thead>
	<tbody>
        <?php
            while($bills = $resultBill->fetch_assoc()) {
		//var_dump($bills);
                echo "<tr>";
                echo "<td>" .$bills['bill_id']."</td>";
                echo "<td>" .$bills['account1_id']."</td>";
                echo "<td>" .$bills['account2_id']."</td>";
                echo "<td>" .$bills['amount']."</td>";
                echo "</tr>";
            }
        ?>
	</tbody>
    </table>
	<script src="js/jquery.js"></script>
	<?php $dbc->close();?>
</body>
</html>
