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
    <title>Transaction Results</title>
</head>
<body>
<h1>Transaction Results</h1>
<?php

/*$conn = mysqli_connect('localhost', 'root', '', 'bank');*/

$conn = mysqli_connect('tdc353.encs.concordia.ca', 'tdc353_2', '1yfja853', 'tdc353_2');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!empty($_POST['submitSearch'])){

// create short variable names
    $searchtype = $_POST['searchtype'];
    $searchterm = $_POST['searchterm'];

    if (!$searchtype || (!$searchterm && ('0' !== $searchterm))) {
        echo '<p>You have not entered search details, the result will show all the information.<br/></p>';
    }

    if(empty($searchtype) || empty($searchterm) && ('0' !== $searchterm)) {
        $sql = "SELECT * FROM Transactions";
    }
    else{
	if(($searchtype == "amount>="))
	{
	$searchtype = rtrim($searchtype,">=");
	$sql = "SELECT * FROM Transactions WHERE " .$searchtype . " >= " . "\"" . $searchterm ."\"";
	}
	elseif(($searchtype == "amount<="))
	{
	$searchtype = rtrim($searchtype,"<=");
	$sql = "SELECT * FROM Transactions WHERE " .$searchtype . " <= " . "\"" . $searchterm ."\"";
	}
	else
	$sql = "SELECT * FROM Transactions WHERE " .$searchtype . " = " . "\"" . $searchterm ."\"";
	//else
        //$sql = "SELECT * FROM Transactions WHERE " .$searchtype . " = " . $searchterm;
    }
	echo $sql;
    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>tid: </strong>" . $row[0];
        echo "<br />account1_id: " . $row[1];
        echo "<br />account2_id: " . $row[2];
        echo "<br />amount: " . $row[3];
        echo "<br />dt: " . $row[4];
    }
}

if(!empty($_POST['submitUpdate'])) {


    $sql = "UPDATE Transactions SET ";

    if((!isset($_POST['tid_u'])) ||($_POST['tid_u'] == ""))
    {
        echo "tid is not set, error";
        exit;
        $tid = "";
        $tid_cond = false;
    }
    else{
        $tid = $_POST['tid_u'];
        $tid = intval($tid);
        $tid_cond = true;
    }

    if(isset($_POST['dt_u']) && $_POST['dt_u'] !== "")
    {
        $dt = $_POST['dt_u'];
        $dt = date('Y-m-d h:i:s', strtotime($dt));


        $sql .= " dt = " .'\''. $dt.'\''. ",";
    }

    if(isset($_POST['account1_id_u']) && $_POST['account1_id_u'] !== "")
    {
        $account1_id = $_POST['account1_id_u'];
        $account1_id = intval($account1_id);
        $sql .= " account1_id = " . $account1_id . ",";
    }

    if(isset($_POST['account2_id_u']) && $_POST['account2_id_u'] !== "")
    {
        $account2_id = $_POST['account2_id_u'];
        $account2_id = intval($account2_id);
        $sql .= " account2_id = " . $account2_id . ",";
    }

    if(isset($_POST['amount_u']) && $_POST['amount_u'] !== "")
    {
        $amount = $_POST['amount_u'];
        $amount = floatval($amount);
        $sql .= " amount = " . $amount . ",";
    }

    $sql = rtrim($sql, ",");
    if($tid_cond) $sql .= " WHERE tid = " . $tid;

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(!empty($_POST['submitInsert'])){

    if (
         !isset($_POST['dt_i']) || !isset($_POST['account2_id_i']) || !isset($_POST['account1_id_i'])
	||($_POST['dt_i'] == "") || ($_POST['account2_id_i'] == "") || ($_POST['account1_id_i'] == "")
        || !isset($_POST['amount_i']) || ($_POST['amount_i'] == "")) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    // create short variable names
    $dt = $_POST['dt_i'];
    $account1_id = $_POST['account1_id_i'];
    $account2_id = $_POST['account2_id_i'];
    $amount = $_POST['amount_i'];

    $account1_id = intval($account1_id);
    $account2_id = intval($account2_id);
    $amount = '\''. floatval($amount) .'\'';
    $dt = '\''. date('Y-m-d h:i:s', strtotime($dt)) . '\'';


    $sql = "INSERT INTO Transactions(dt, amount, account1_id, account2_id) 
                  VALUES (  $dt,  $amount,   $account1_id, $account2_id)";

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}

if(!empty($_POST['submitDelete'])){


    if (!isset($_POST['tid_d']) || ($_POST['tid_d'] == "")){
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    $tid = $_POST['tid_d'];
    $tid = intval($tid);

    $sql = "DELETE FROM Transactions WHERE tid = " . $tid;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

echo "<p><a href='transaction_admin.php'>back to Transactions Admin.</a></p>";
?>
</body>
</html>
