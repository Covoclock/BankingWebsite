<?php
// Imports and executes the login to the SQL server
// allows you to use the database $dbc variable
session_start();
require "credentialCheck.php";
//require "logout.php";

// Verifying permission to be here
require "permissionCheck.php";

echo $_SESSION['user_id'];


?>


<html>
<body>

