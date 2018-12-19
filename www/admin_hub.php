<?php
session_start();
include_once "../credentialCheck.php";
include_once "../permissionCheck.php";
verifySession($dbc, "employee");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Administration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>

<h2>Bank Administration</h2>
<div class='container'>
	<div class='row align-items-center'>
		<div class='col-4'>
		<a href='account_admin.php'>Account Admin</a>
		</div>
		
		<div class='col-4'>
		<a href='branch_admin.php'>Branch Admin</a>
		</div>
		
		
		<div class='col-4'>
		<a href='chargePlan_admin.php'>Charge Plan Admin</a>
		</div>
	</div>

	<div class='row align-items-center'>
		<div class='col-4'>
		<a href='client_admin.php'>Client Admin</a>
		</div>
		
		<div class='col-4'>
		<a href='employee_admin.php'>Employee Admin</a>
		</div>
		
		
		<div class='col-4'>
		<a href='service_admin.php'>Service Admin</a>
		</div>
	</div>

	<div class='row align-items-center'>
		<div class='col-4'>
		<a href='transaction_admin.php'>Transaction Admin</a>
		</div>
		
		<div class='col-4'>
		<a href='bill_admin.php'>Bill Admin</a>
		</div>
		
		<div class='col-4'>
		<a href='clientLogin_admin.php'>Client Log in Admin</a>
		</div>
	</div>

	<div class='row align-items-center'>
		<div class='col-4'>
		<a href='employeeLogin_admin.php'>Employee Log in Admin</a>
		</div>
		
		<div class='col-4'>
		<a href='schedule_admin.php'>Schedule Admin</a>
		</div>
		
	</div>
</div>


</body>
</html>
