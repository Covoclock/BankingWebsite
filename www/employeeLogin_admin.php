<?php
session_start();
include_once dirname(__DIR__)."/credentialCheck.php";
include_once dirname(__DIR__)."/permissionCheck.php";
include_once dirname(__DIR__)."/navbar.php";
verifySession($dbc, "employee");
?>

<!DOCTYPE html>
<html>
<head>
    <title>EmployeeLogin Admin</title>

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

<h1>EmployeeLogin Catalog Search</h1>

<form action="employeeLogin_results.php" method="post">

    <fieldset>
        <p><strong>Choose Search Type:</strong><br />
            <select name="searchtype">
                <option value="employee_id">employee_id</option>
                <option value="psw">psw</option>
            </select>
        </p>
        <p><strong>Enter Search Term:</strong><br />
            <input name="searchterm" type="text" size="40"></p>
        <p><input type="submit" name="submitSearch" value="Search"></p>
    </fieldset>
</form>



<h1>Insert Bank EmployeeLogin Information</h1>

<form action="employeeLogin_results.php" method="post">
    <fieldset>
        <p><label for="employee_id_i">employee_id</label>
            <input type="text" id="employee_id_i" name="employee_id_i" maxlength="15" size="15" /></p>
        <p><label for="psw_i">psw</label>
            <input type="text" id="psw_i" name="psw_i" maxlength="15" size="15" /></p>
    </fieldset>
    <p><input type="submit" name = "submitInsert" value="Add New EmployeeLogin" /></p>
</form>



<h1>Update Bank EmployeeLogin Information</h1>

<form action="employeeLogin_results.php" method="post">
    <fieldset>
        <p><label for="employee_id_u">employee_id</label>
            <input type="text" id="employee_id_u" name="employee_id_u" maxlength="15" size="15" /></p>
        <p><label for="psw_u">psw</label>
            <input type="text" id="psw_u" name="psw_u" maxlength="15" size="15" /></p>
        <br>
        <p><input type="submit" name = "submitUpdate" value="Update EmployeeLogin Information" /></p>
    </fieldset>
</form>



<h1>Delete Bank EmployeeLogin Information</h1>

<form action="employeeLogin_results.php" method="post">
    <fieldset>
        <p><label for="employee_id_d">employee_id</label>
            <input type="text" id="employee_id_d" name="employee_id_d" maxlength="15" size="15" /></p>
        <br>
        <p><input type="submit" name = "submitDelete" value="Delete EmployeeLogin Information" /></p>
    </fieldset>
</form>

</br>
</br>
<p><a href='admin_hub.php'>back to Admin hub.</a></p>


</body>
</html>
