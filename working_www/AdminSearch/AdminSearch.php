<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/16/2018
 * Time: 4:44 PM
 */
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Branch Catalog Search</title>
</head>

<body>
<h1>Branch Catalog Search</h1>

<form action="AdminDomainSearchResults.php" method="post">
    <p><strong>Choose Search Domain:</strong><br />
        <select name="searchDomain">
            <option value="branch">branch</option>
            <option value="employee">employee</option>
            <option value="client">client</option>
            <option value="schedule">schedule</option>
            <option value="account">account</option>
            <option value="services">service</option>
            <option value="transactions">transaction</option>
            <option value="bills">bill</option>
        </select>
    </p>
    <p><input type="submit" name="submit" value="searchTopic"></p>
</form>
</body>
</html>
