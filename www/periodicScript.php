<?php
// Runs script at a given frequency (defined by the cron job)
// #crontab -l   to see jobs
include_once "credentialCheck.php";
include_once "permissionCheck.php";
include_once "part2/Accounts.php";
include_once "part2/Domain_Logic.php";
include_once "part2/Bills.php";
//verifySession("client");

// Check all the bills to be paid
function loopBills($dbc){
	$query = "SELECT * FROM Bills";
	if($result = $dbc->query($query)){
		$n_sucess = 0;
		while($row = $result->fetch_assoc()){
			$bill_id = $row['bill_id'];		
			$amount = $row['amount'];		
			$account1_id = $row['account1_id'];		
			$account2_id = $row['account2_id'];		
			$recurring = $row['recurring'];		

			$bill = new Bill($bill_id, $amount,$account1_id, $account2_id, $recurring);
			if(isset($account1_id) && isset($account2_id) && isset($amount)){
				$status = Bill::singleBill($dbc, $bill);
				if($status) $n_sucess++;
			}
		}
		echo "<br>Number of successful payments of bills: $n_sucess <br>";
		echo "<a href='Admin/admin_hub.php'>Time to go back to the hub</a>";
	}
}

loopBills($dbc);
?>
