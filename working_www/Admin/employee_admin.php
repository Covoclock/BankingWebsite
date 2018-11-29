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
    <title>Employee Admin</title>

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

<h1>Employee Catalog Search</h1>

<form action="employee_results.php" method="post">

    <fieldset>
        <p><strong>Choose Search Type:</strong><br />
            <select name="searchtype">
                <option value="employee_id">employee_id</option>
                <option value="firstName">firstName</option>
                <option value="lastName">lastName</option>
                <option value="addr">addr</option>
                <option value="start_date>=">start_date>=</option>
		<option value="start_date<=">start_date<=</option>
                <option value="wage>=">wage>=</option>
		<option value="wage<=">wage<=</option>
                <option value="email">email</option>
                <option value="phone">phone</option>
                <option value="branch_id">branch_id</option>
            </select>
        </p>
        <p><strong>Enter Search Term:</strong><br />
            <input name="searchterm" type="text" size="40"></p>
        <p><input type="submit" name="submitSearch" value="Search"></p>
    </fieldset>
</form>



<h1>Insert Bank Employee Information</h1>

<form action="employee_results.php" method="post">
    <fieldset>
        <p><label for="firstName_i">firstName</label>
            <input type="text" id="firstName_i" name="firstName_i" maxlength="15" size="15" /></p>
        <p><label for="lastName_i">lastName</label>
            <input type="text" id="lastName_i" name="lastName_i" maxlength="15" size="15" /></p>
        <p><label for="addr_i">addr</label>
            <input type="text" id="addr_i" name="addr_i" maxlength="15" size="15" /></p>
        <p><label for="start_date_i">start_date</label>
            <input type="text" id="start_date_i" name="start_date_i" maxlength="15" size="15" /></p>
        <p><label for="wage_i">wage</label>
            <input type="text" id="wage_i" name="wage_i" maxlength="15" size="15" /></p>
        <p><label for="email_i">email</label>
            <input type="text" id="email_i" name="email_i" maxlength="15" size="15" /></p>
        <p><label for="phone_i">phone</label>
            <input type="text" id="phone_i" name="phone_i" maxlength="15" size="15" /></p>
        <p><label for="branch_id_i">branch_id</label>
            <input type="text" id="branch_id_i" name="branch_id_i" maxlength="15" size="15" /></p>


    </fieldset>
    <p><input type="submit" name = "submitInsert" value="Add New employee" /></p>
</form>



<h1>Update Bank employee Information</h1>

<form action="employee_results.php" method="post">
    <fieldset>
        <p><label for="employee_id_u">employee_id</label>
            <input type="text" id="employee_id_u" name="employee_id_u" maxlength="15" size="15" /></p>
        <p><label for="firstName_u">firstName</label>
            <input type="text" id="firstName_u" name="firstName_u" maxlength="15" size="15" /></p>
        <p><label for="lastName_u">lastName</label>
            <input type="text" id="lastName_u" name="lastName_u" maxlength="15" size="15" /></p>
        <p><label for="addr_u">addr</label>
            <input type="text" id="addr_u" name="addr_u" maxlength="15" size="15" /></p>
        <p><label for="start_date_u">start_date</label>
            <input type="text" id="start_date_u" name="start_date_u" maxlength="15" size="15" /></p>
        <p><label for="wage_u">wage</label>
            <input type="text" id="wage_u" name="wage_u" maxlength="15" size="15" /></p>
        <p><label for="email_u">email</label>
            <input type="text" id="email_u" name="email_u" maxlength="15" size="15" /></p>
        <p><label for="phone_u">phone</label>
            <input type="text" id="phone_u" name="phone_u" maxlength="15" size="15" /></p>
        <p><label for="branch_id_u">branch_id</label>
            <input type="text" id="branch_id_u" name="branch_id_u" maxlength="15" size="15" /></p>


        <br>
        <p><input type="submit" name = "submitUpdate" value="Update employee Information" /></p>
    </fieldset>
</form>



<h1>Delete Bank employee Information</h1>

<form action="employee_results.php" method="post">
    <fieldset>
        <p><label for="employee_id_d">employee_id</label>
            <input type="text" id="employee_id_d" name="employee_id_d" maxlength="15" size="15" /></p>
        <br>
        <p><input type="submit" name = "submitDelete" value="Delete employee Information" /></p>
    </fieldset>
</form>

</br>
</br>
<p><a href='admin_hub.php'>back to Admin hub.</a></p>


</body>
</html>
