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
    <title>Account Admin</title>

    <style type="text/css">

        fieldset {
            width: 75%;
            border: 2px solid #cccccc;
        }

        label,select,option{
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
		<?php echo navbar();?>

<h1>Account Catalog Search</h1>

<form action="account_results.php" method="post">

    <fieldset>
        <p><strong>Choose Search Type:</strong><br />
            <select name="searchtype">
                <option value="account_id">account_id</option>
                <option value="client_id">client_id</option>
                <option value="account_type">account_type</option>
                <option value="lvl">lvl</option>
                <option value="balance<">balance<</option>
		<option value="balance>">balance></option>
                <option value="credit_limit<">credit_limit<</option>
		<option value="credit_limit>">credit_limit></option>
                <option value="interest_rate<">interest_rate<</option>
		<option value="interest_rate>">interest_rate></option>
                <option value="chargePlan_id">chargePlan_id</option>
                <option value="transactionLeft">transactionLeft</option>
            </select>
        </p>
        <p><strong>Enter Search Term:</strong><br />
            <input name="searchterm" type="text" size="40"></p>
        <p><input type="submit" name="submitSearch" value="Search"></p>
    </fieldset>
</form>



<h1>Insert Bank Account Information</h1>

<form action="account_results.php" method="post">
    <fieldset>
        <p><label for="client_id_i">client_id</label>
            <input type="text" id="client_id_i" name="client_id_i" maxlength="15" size="15" /></p>

        <label>account_type</label>
        <select name="account_type_i" id="account_type_i">
            <option value="saving">saving</option>
            <option value="checquing">checquing</option>
            <option value="usDollar">usDollar</option>
        </select></br></br>

        <label>lvl</label>
        <select name="lvl_i" id= "lvl_i">
            <option value="personal">personal</option>
            <option value="business">business</option>
            <option value="corporate">corporate</option>
        </select></br>

        <p><label for="balance_i">balance</label>
            <input type="text" id="balance_i" name="balance_i" maxlength="15" size="15" /></p>
        <p><label for="credit_limit_i">credit_limit</label>
            <input type="text" id="credit_limit_i" name="credit_limit_i" maxlength="15" size="15" /></p>
        <p><label for="interest_rate_i">interest_rate</label>
            <input type="text" id="interest_rate_i" name="interest_rate_i" maxlength="15" size="15" /></p>
        <p><label for="chargePlan_id_i">chargePlan_id</label>
            <input type="text" id="chargePlan_id_i" name="chargePlan_id_i" maxlength="15" size="15" /></p>
        <p><label for="transactionLeft_i">transactionLeft_id</label>
            <input type="text" id="transactionLeft_i" name="transactionLeft_i" maxlength="15" size="15" /></p>


    </fieldset>
    <p><input type="submit" name = "submitInsert" value="Add New account" /></p>
</form>



<h1>Update Bank account Information</h1>

<form action="account_results.php" method="post">
    <fieldset>
        <p><label for="account_id_u">account_id</label>
            <input type="text" id="account_id_u" name="account_id_u" maxlength="15" size="15" /></p>
        <p><label for="client_id_u">client_id</label>
            <input type="text" id="client_id_u" name="client_id_u" maxlength="15" size="15" /></p>

        <label>account_type</label>
        <select name="account_type_u" id="account_type_u">
	<?php
		//$query = "SELECT DISTINCT account_type FROM Account";
		//$result = $dbc->query($query);
		//while ($row = $result->fetch_assoc()){
		//	$lvl = $row['account_type'];
		//	echo "<option value='$lvl'>$lvl</option>";
		//}
	?>
            <option value="saving">saving</option>
            <option value="checquing">checquing</option>
            <option value="usDollar">usDollar</option>
        </select></br></br>

        <label>lvl</label>
        <select name="lvl_u" id= "lvl_u">
	<?php
		$query = "SELECT DISTINCT lvl FROM Account";
		$result = $dbc->query($query);
		while ($row = $result->fetch_assoc()){
			$lvl = $row['lvl'];
			echo "<option value='$lvl'>$lvl</option>";
		}
	?>
        </select></br>

        <p><label for="balance_u">balance</label>
            <input type="text" id="balance_u" name="balance_u" maxlength="15" size="15" /></p>
        <p><label for="credit_limit_u">credit_limit</label>
            <input type="text" id="credit_limit_u" name="credit_limit_u" maxlength="15" size="15" /></p>
        <p><label for="interest_rate_u">interest_rate</label>
            <input type="text" id="interest_rate_u" name="interest_rate_u" maxlength="15" size="15" /></p>
        <p><label for="chargePlan_id_u">chargePlan_id</label>
            <input type="text" id="chargePlan_id_u" name="chargePlan_id_u" maxlength="15" size="15" /></p>
        <p><label for="transactionLeft_u">transactionLeft_id</label>
            <input type="text" id="transactionLeft_u" name="transactionLeft_u" maxlength="15" size="15" /></p>


        <br>
        <p><input type="submit" name = "submitUpdate" value="Update Account Information" /></p>
    </fieldset>
</form>



<h1>Delete Bank Account Information</h1>

<form action="account_results.php" method="post">
    <fieldset>
        <p><label for="account_id_d">account_id</label>
            <input type="text" id="account_id_d" name="account_id_d" maxlength="15" size="15" /></p>
        <br>
        <p><input type="submit" name = "submitDelete" value="Delete Account Information" /></p>
    </fieldset>
</form>

</br>
</br>
<p><a href='admin_hub.php'>back to Admin hub.</a></p>
</body>
</html>
