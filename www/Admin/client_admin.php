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

<h1>Client Catalog Search</h1>

<form action="client_results.php" method="post">

    <fieldset>
        <p><strong>Choose Search Type:</strong><br />
            <select name="searchtype">
                <option value="client_id">client_id</option>
                <option value="firstName">firstName</option>
                <option value="lastName">lastName</option>
                <option value="city">city</option>
                <option value="province">province</option>
                <option value="dob>=">dob>=</option>
		<option value="dob<=">dob<=</option>
                <option value="join_date>=">join_date>=</option>
		<option value="join_date<=">join_date<=</option>
                <option value="standing">standing</option>
                <option value="email">email</option>
                <option value="phone">phone</option>
                <option value="category">category</option>
                <option value="branch_id">branch_id</option>
            </select>
        </p>
        <p><strong>Enter Search Term:</strong><br />
            <input name="searchterm" type="text" size="40"></p>
        <p><input type="submit" name="submitSearch" value="Search"></p>
    </fieldset>
</form>



<h1>Insert Bank Client Information</h1>

<form action="client_results.php" method="post">
    <fieldset>
        <p><label for="firstName_i">firstName</label>
            <input type="text" id="firstName_i" name="firstName_i" maxlength="15" size="15" /></p>
        <p><label for="lastName_i">lastName</label>
            <input type="text" id="lastName_i" name="lastName_i" maxlength="15" size="15" /></p>
        <p><label for="city_i">city</label>
            <input type="text" id="city_i" name="city_i" maxlength="15" size="15" /></p>
        <p><label for="province_i">province</label>
            <input type="text" id="province_i" name="province_i" maxlength="15" size="15" /></p>
        <p><label for="dob_i">dob</label>
            <input type="text" id="dob_i" name="dob_i" maxlength="15" size="15" /></p>
        <p><label for="join_date_i">join_date</label>
            <input type="text" id="join_date_i" name="join_date_i" maxlength="15" size="15" /></p>
        <p><label for="standing_i">standing</label>
            <input type="text" id="standing_i" name="standing_i" maxlength="15" size="15" /></p>
        <p><label for="email_i">email</label>
            <input type="text" id="email_i" name="email_i" maxlength="15" size="15" /></p>
        <p><label for="phone_i">phone</label>
            <input type="text" id="phone_i" name="phone_i" maxlength="15" size="15" /></p>

        <label>category</label>
        <select name="category_i" id="category_i">
            <option value="regular">regular</option>
            <option value="student">student</option>
            <option value="senior">senior</option>
        </select></br></br>


<!--        <p><label for="category_i">category</label>
            <input type="text" id="category_i" name="category_i" maxlength="15" size="15" /></p>-->
        <p><label for="branch_id_i">branch_id</label>
            <input type="text" id="branch_id_i" name="branch_id_i" maxlength="15" size="15" /></p>


    </fieldset>
    <p><input type="submit" name = "submitInsert" value="Add New client" /></p>
</form>



<h1>Update Bank client Information</h1>

<form action="client_results.php" method="post">
    <fieldset>
        <p><label for="client_id_u">client_id</label>
            <input type="text" id="client_id_u" name="client_id_u" maxlength="15" size="15" /></p>
        <p><label for="firstName_u">firstName</label>
            <input type="text" id="firstName_u" name="firstName_u" maxlength="15" size="15" /></p>
        <p><label for="lastName_u">lastName</label>
            <input type="text" id="lastName_u" name="lastName_u" maxlength="15" size="15" /></p>
        <p><label for="city_u">city</label>
            <input type="text" id="city_u" name="city_u" maxlength="15" size="15" /></p>
        <p><label for="province_u">province</label>
            <input type="text" id="province_u" name="province_u" maxlength="15" size="15" /></p>
        <p><label for="dob_u">dob</label>
            <input type="text" id="dob_u" name="dob_u" maxlength="15" size="15" /></p>
        <p><label for="join_date_u">join_date</label>
            <input type="text" id="join_date_u" name="join_date_u" maxlength="15" size="15" /></p>
        <p><label for="standing_u">standing</label>
            <input type="text" id="standing_u" name="standing_u" maxlength="15" size="15" /></p>
        <p><label for="email_u">email</label>
            <input type="text" id="email_u" name="email_u" maxlength="15" size="15" /></p>
        <p><label for="phone_u">phone</label>
            <input type="text" id="phone_u" name="phone_u" maxlength="15" size="15" /></p>

        <label>category</label>
        <select name="category_u" id="category_u">
            <option value="regular">regular</option>
            <option value="student">student</option>
            <option value="senior">senior</option>
        </select></br></br>


<!--        <p><label for="category_u">category</label>
            <input type="text" id="category_u" name="category_u" maxlength="15" size="15" /></p>-->
        <p><label for="branch_id_u">branch_id</label>
            <input type="text" id="branch_id_u" name="branch_id_u" maxlength="15" size="15" /></p>


        <br>
        <p><input type="submit" name = "submitUpdate" value="Update client Information" /></p>
    </fieldset>
</form>



<h1>Delete Bank client Information</h1>

<form action="client_results.php" method="post">
    <fieldset>
        <p><label for="client_id_d">client_id</label>
            <input type="text" id="client_id_d" name="client_id_d" maxlength="15" size="15" /></p>
        <br>
        <p><input type="submit" name = "submitDelete" value="Delete Client Information" /></p>
    </fieldset>
</form>

</br>
</br>
<p><a href='admin_hub.php'>back to Admin hub.</a></p>


</body>
</html>
