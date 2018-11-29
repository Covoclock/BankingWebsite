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
    <title>Account Results</title>
</head>
<body>
<h1>Account Results</h1>
<?php

/*$conn = mysqli_connect('localhost', 'root', '', 'bank');*/

$conn = mysqli_connect('tdc353.encs.concordia.ca', 'tdc353_2', '1yfja853', 'tdc353_2');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); echo "<p><a href='account_admin.php'>back to account Admin.</a></p>";
}

if(!empty($_POST['submitSearch'])){

// create short variable names
    $searchtype = $_POST['searchtype'];
    $searchterm = $_POST['searchterm'];

    if (!$searchtype || (!$searchterm && ('0' !== $searchterm))) {
        echo '<p>You have not entered search details, the result will show all the information.<br/></p>';
    }

    if(empty($searchtype) || empty($searchterm) && ('0' !== $searchterm)) {
        $sql = "SELECT * FROM Account";
    }
    else{
	if(($searchtype == "balance<") || ($searchtype == "credit_limit<") || ($searchtype == "interest_rate<")) 
	{
	  $temp = rtrim($searchtype, "<");
	  $sql = "SELECT * FROM Account WHERE " .$temp . " < " . floatval($searchterm);
	}
	  
	elseif(($searchtype == "balance>") || ($searchtype == "credit_limit>") || ($searchtype == "interest_rate>")) 
	{
	  $temp = rtrim($searchtype, ">");
	  $sql = "SELECT * FROM Account WHERE " .$temp . " > " . floatval($searchterm);	
	}
	elseif(($searchtype == "account_type")  || ($searchtype == "lvl")){
	  $sql = "SELECT * FROM Account WHERE " .$searchtype . " = " . "\"" . $searchterm ."\"";
	}
	else
        $sql = "SELECT * FROM Account WHERE " .$searchtype . " = " . $searchterm;
    }

     echo "$sql";
    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>account_id: </strong>" . $row[0];
        echo "<br />client_id: " . $row[1];
        echo "<br />account_type: " . $row[2];
        echo "<br />chargePlan_id: " . $row[3];
        echo "<br />balance: " . $row[4];
        echo "<br />credit_limit: " . $row[5];
        echo "<br />interest_rate: " . $row[6];
        echo "<br />lvl: " . $row[7];
        echo "<br />transactionLeft: " . $row[8];

    }
}

if(!empty($_POST['submitUpdate'])) {


    $sql = "UPDATE Account SET ";

    if((!isset($_POST['account_id_u'])) ||( $_POST['account_id_u'] == ""))
    {
        echo "error, account id not input! "; echo "<p><a href='account_admin.php'>back to account Admin.</a></p>";
        $account_id = "";
        $account_id_cond = false;
        exit;
    }
    else{
        $account_id = $_POST['account_id_u'];
        $account_id = intval($account_id);
        $account_id_cond = true;
    }

    if(isset($_POST['client_id_u']) && $_POST['client_id_u'] !== "")
    {
        $client_id = $_POST['client_id_u'];
        $client_id = intval($client_id);
        $sql .= " client_id = " . $client_id . ",";
    }
    
    if(isset($_POST['account_type_u']) && $_POST['account_type_u'] !== "") $sql .= " account_type = " .'\'' . $_POST['account_type_u'].'\'' . ",";
    if(isset($_POST['lvl_u']) && $_POST['lvl_u'] !== "") $sql .= " lvl = " .'\''.$_POST['lvl_u'].'\''. ",";

    if(isset($_POST['chargePlan_id_u']) && $_POST['chargePlan_id_u'] !== "")
    {
        $chargePlan_id = $_POST['chargePlan_id_u'];
        $chargePlan_id = intval($chargePlan_id);
        $sql .= " chargePlan_id = " . $chargePlan_id . ",";
    }

    if(isset($_POST['balance_u']) && $_POST['balance_u'] !== "")
    {
        $balance = $_POST['balance_u'];
        $balance = floatval($balance);
        $sql .= " balance = " . $balance . ",";
    }

    if(isset($_POST['credit_limit_u']) && $_POST['credit_limit_u'] !== "")
    {
        $credit_limit = $_POST['credit_limit_u'];
        $credit_limit = floatval($credit_limit);
        $sql .= " credit_limit = " . $credit_limit . ",";
    }

    if(isset($_POST['interest_rate_u']) && $_POST['interest_rate_u'] !== "")
    {
        $interest_rate = $_POST['interest_rate_u'];
        $interest_rate = floatval($interest_rate);
        $sql .= " interest_rate = " . $interest_rate . ",";
    }


    if(isset($_POST['transactionLeft_u']) && $_POST['transactionLeft_u'] !== "")
    {
        $transactionLeft = $_POST['transactionLeft_u'];
        $transactionLeft = intval($transactionLeft);
        $sql .= " transactionLeft = " . $transactionLeft . ",";
    }


    $sql = rtrim($sql, ",");
    if($account_id_cond) $sql .= " WHERE account_id = " . $account_id;

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn); echo "<p><a href='account_admin.php'>back to account Admin.</a></p>";
    }
}

if(!empty($_POST['submitInsert'])){

    if ( !isset($_POST['client_id_i']) || !isset($_POST['account_type_i']) || ( $_POST['client_id_i'] == "") || ( $_POST['account_type_i'] == "")
        || !isset($_POST['lvl_i']) || ( $_POST['lvl_i'] == "")
        || !isset($_POST['chargePlan_id_i']) || !isset($_POST['transactionLeft_i']) || ( $_POST['chargePlan_id_i'] == "") || ( $_POST['transactionLeft_i'] == "")
        || !isset($_POST['balance_i']) || !isset($_POST['credit_limit_i']) || !isset($_POST['interest_rate_i']) || ( $_POST['balance_i'] == "") || ( $_POST['credit_limit_i'] == "") || ( $_POST['interest_rate_i'] == "")
) {
        echo "<p>You have not entered all of the required details.<br />
             Please go back and try again.</p>";
	echo "<p><a href='account_admin.php'>back to account Admin.</a></p>";
        exit;
    }

    // create short variable names
    $client_id= $_POST['client_id_i'];
    $account_type='\''. $_POST['account_type_i'].'\'';
    $lvl='\''. $_POST['lvl_i'].'\'';
    $chargePlan_id = $_POST['chargePlan_id_i'];
    $transactionLeft = $_POST['transactionLeft_i'];
    $balance = $_POST['balance_i'];
    $credit_limit = $_POST['credit_limit_i'];
    $interest_rate = $_POST['interest_rate_i'];

    $chargePlan_id = intval($chargePlan_id);
    $transactionLeft = intval($transactionLeft);
    $client_id = intval($client_id);
    $balance = '\''. floatval($balance) .'\'';
    $credit_limit = '\''. floatval($credit_limit) .'\'';
    $interest_rate = '\''. floatval($interest_rate) .'\'';



    $sql = "INSERT INTO Account(client_id, account_type, lvl,  balance, credit_limit, interest_rate, chargePlan_id) 
                  VALUES ($client_id, $account_type,$lvl, $balance, $credit_limit, $interest_rate, $chargePlan_id)";

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);  echo "<p><a href='account_admin.php'>back to account Admin.</a></p>";
    }

}

if(!empty($_POST['submitDelete'])){


    if (!isset($_POST['account_id_d']) || ($_POST['account_id_d'] == "")){
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
	echo "<p><a href='account_admin.php'>back to account Admin.</a></p>";
        exit;
    }

    $account_id = $_POST['account_id_d'];
    $account_id = intval($account_id);

    $sql = "DELETE FROM Account WHERE account_id = " . $account_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);  echo "<p><a href='account_admin.php'>back to account Admin.</a></p>";

    }

}

mysqli_close($conn);

echo "<p><a href='account_admin.php'>back to account Admin.</a></p>";
?>
</body>
</html>
