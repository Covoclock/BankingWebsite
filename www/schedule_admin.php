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
    <title>Schedule Admin</title>

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

<h1>Schedule Catalog Search</h1>

<form action="schedule_results.php" method="post">

    <fieldset>
        <p><strong>Choose Search Type:</strong><br />
            <select name="searchtype">
                <option value="employee_id">employee_id</option>
                <option value="work_date">work_date</option>
                <option value="hour_begin">hour_begin</option>
                <option value="hour_end">hour_begin</option>
                <option value="isHoliday">isHoliday</option>
            </select>
        </p>
        <p><strong>Enter Search Term:</strong><br />
            <input name="searchterm" type="text" size="40"></p>
        <p><input type="submit" name="submitSearch" value="Search"></p>
    </fieldset>
</form>



<h1>Insert Bank Schedule Information</h1>

<form action="schedule_results.php" method="post">
    <fieldset>
        <p><label for="employee_id_i">employee_id</label>
            <input type="text" id="employee_id_i" name="employee_id_i" maxlength="15" size="15" /></p>
        <p><label for="work_date_i">work_date</label>
            <input type="text" id="work_date_i" name="work_date_i" maxlength="15" size="15" /></p>
        <p><label for="hour_begin_i">hour_begin</label>
            <input type="text" id="hour_begin_i" name="hour_begin_i" maxlength="15" size="15" /></p>
        <p><label for="hour_end_i">hour_end</label>
            <input type="text" id="hour_end_i" name="hour_end_i" maxlength="15" size="15" /></p>

        <label>isHoliday</label>
        <select name="isHoliday_i" id="isHoliday_i">
            <option value="1">yes</option>
            <option value="0">no</option>
        </select></br></br>

<!--        <p><label for="isHoliday_i">isHoliday</label>
            <input type="text" id="isHoliday_i" name="isHoliday_i" maxlength="15" size="15" /></p>-->
    </fieldset>
    <p><input type="submit" name = "submitInsert" value="Add New Schedule" /></p>
</form>



<h1>Update Bank Schedule Information</h1>

<form action="schedule_results.php" method="post">
    <fieldset>
        <p><label for="employee_id_u">employee_id</label>
            <input type="text" id="employee_id_u" name="employee_id_u" maxlength="15" size="15" /></p>
        <p><label for="work_date_u">work_date</label>
            <input type="text" id="work_date_u" name="work_date_u" maxlength="15" size="15" /></p>
        <p><label for="hour_begin_u">hour_begin</label>
            <input type="text" id="hour_begin_u" name="hour_begin_u" maxlength="15" size="15" /></p>
        <p><label for="hour_end_u">hour_end</label>
            <input type="text" id="hour_end_u" name="hour_end_u" maxlength="15" size="15" /></p>

        <label>isHoliday</label>
        <select name="isHoliday_u" id="isHoliday_u">
            <option value="1">yes</option>
            <option value="0">no</option>
        </select></br></br>

<!--        <p><label for="isHoliday_u">isHoliday</label>
            <input type="text" id="isHoliday_u" name="isHoliday_u" maxlength="15" size="15" /></p>-->
        <br>
        <p><input type="submit" name = "submitUpdate" value="Update Schedule Information" /></p>
    </fieldset>
</form>



<h1>Delete Bank Schedule Information</h1>

<form action="schedule_results.php" method="post">
    <fieldset>
        <p><label for="employee_id_d">employee_id</label>
            <input type="text" id="employee_id_d" name="employee_id_d" maxlength="15" size="15" /></p>
        <br>
        <p><input type="submit" name = "submitDelete" value="Delete Schedule Information" /></p>
    </fieldset>
</form>

</br>
</br>
<p><a href='admin_hub.php'>back to Admin hub.</a></p>


</body>
</html>
