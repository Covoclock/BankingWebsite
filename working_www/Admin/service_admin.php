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
    <title>Service Admin</title>

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

<h1>Service Catalog Search</h1>

<form action="service_results.php" method="post">

    <fieldset>
        <p><strong>Choose Search Type:</strong><br />
            <select name="searchtype">
                <option value="service_id">service_id</option>
                <option value="service_name">service_name</option>
                <option value="manager_id">manager_id</option>
            </select>
        </p>
        <p><strong>Enter Search Term:</strong><br />
            <input name="searchterm" type="text" size="40"></p>
        <p><input type="submit" name="submitSearch" value="Search"></p>
    </fieldset>
</form>



<h1>Insert Bank Service Information</h1>

<form action="service_results.php" method="post">
    <fieldset>
        <p><label for="service_id_i">service_id</label>
            <input type="text" id="service_id_i" name="service_id_i" maxlength="15" size="15" /></p>

        <label>service_name</label>
        <select name="service_name_i" id="service_name_i">
            <option value="saving">saving</option>
            <option value="chequing">chequing</option>
            <option value="line of credit">line of credit</option>
            <option value="loan">loan</option>
            <option value="insurance">insurance</option>
        </select></br></br>

<!--        <p><label for="service_name_i">service_name</label>
            <input type="text" id="service_name_i" name="service_name_i" maxlength="15" size="15" /></p>-->
        <p><label for="manager_id_i">manager_id</label>
            <input type="text" id="manager_id_i" name="manager_id_i" maxlength="15" size="15" /></p>
    </fieldset>
    <p><input type="submit" name = "submitInsert" value="Add New Service" /></p>
</form>



<h1>Update Bank Service Information</h1>

<form action="service_results.php" method="post">
    <fieldset>
        <p><label for="service_id_u">service_id</label>
            <input type="text" id="service_id_u" name="service_id_u" maxlength="15" size="15" /></p>

        <label>service_name</label>
        <select name="service_name_u" id="service_name_u">
            <option value="saving">saving</option>
            <option value="chequing">chequing</option>
            <option value="line of credit">line of credit</option>
            <option value="loan">loan</option>
            <option value="insurance">insurance</option>
        </select></br></br>

<!--        <p><label for="service_name_u">service_name</label>
            <input type="text" id="service_name_u" name="service_name_u" maxlength="15" size="15" /></p>-->
        <p><label for="manager_id_u">manager_id</label>
            <input type="text" id="manager_id_u" name="manager_id_u" maxlength="15" size="15" /></p>
        <br>
        <p><input type="submit" name = "submitUpdate" value="Update Service Information" /></p>
    </fieldset>
</form>



<h1>Delete Bank Service Information</h1>

<form action="service_results.php" method="post">
    <fieldset>
        <p><label for="service_id_d">service_id</label>
            <input type="text" id="service_id_d" name="service_id_d" maxlength="15" size="15" /></p>
        <br>
        <p><input type="submit" name = "submitDelete" value="Delete Service Information" /></p>
    </fieldset>
</form>

</br>
</br>
<p><a href='admin_hub.php'>back to Admin hub.</a></p>

</body>
</html>
