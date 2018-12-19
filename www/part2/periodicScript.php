<?php
// Runs script at a given frequency (defined by the cron job)
// #crontab -l   to see jobs
require_once "credentialCheck.php";
require_once "permissionCheck.php";
require_once "part2/Accounts.php";
require_once "part2/Domain_Logic.php";
require_once "part2/Bills.php";
//verifySession("client");
// Check all the bills to be paid
function loopBills($dbc){
    $query = "SELECT * FROM Bills";
    if($result = $dbc->query($query)){
        while($row = $result->fetch_assoc()){
            $bill_id = $row['bill_id'];
            $amount = $row['amount'];
            $account1_id = $row['account1_id'];
            $account2_id = $row['account2_id'];
            $recurring = $row['recurring'];
            $bill = new Bill($bill_id, $amount,$account1_id, $account2_id, $recurring);
            if(isset($account1_id) && isset($account2_id) && isset($amount)){
                $status = singleBill($dbc, $bill);
            }
        }
    }
}
loopBills($dbc);
$dbc->close();
?>