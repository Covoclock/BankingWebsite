<?php
session_start();
include_once dirname(__DIR__)."/credentialCheck.php";
include_once dirname(__DIR__)."/permissionCheck.php";
include_once dirname(__DIR__)."/navbar.php";
verifySession($dbc, "employee");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Administration</title>
</head>
<body>

<h2>Band Administration</h2>
</br>
</br>

<p><a href='account_admin.html'>Account Admin</a></p>
</br>

<p><a href='branch_admin.html'>Branch Admin</a></p>
</br>

<p><a href='chargePlan_admin.html'>Charge Plan Admin</a></p>
</br>

<p><a href='client_admin.html'>Client Admin</a></p>
</br>

<p><a href='employee_admin.html'>Employee Admin</a></p>
</br>

<p><a href='service_admin.html'>Service Admin</a></p>
</br>

<p><a href='transaction_admin.html'>Transaction Admin</a></p>
</br>

<p><a href='bill_admin.html'>Bill Admin</a></p>
</br>

<p><a href='clientLogin_admin.html'>Client Log in Admin</a></p>
</br>

<p><a href='employeeLogin_admin.html'>Employee Log in Admin</a></p>
</br>

<p><a href='schedule_admin.html'>Schedule Admin</a></p>
</br>

</body>
</html>
