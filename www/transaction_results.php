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

    //added part-------------------------------------------------------------------------------------------------------
    $account1_id_ = 0;
    $account2_id_ = 0;
    $amount_ = 0.0;
    $existing_amount = 0.0;
    $tid_ = 0;
    //added part-------------------------------------------------------------------------------------------------------


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
	//added part-------------------------------------------------------------------------------------------------------
        $tid_ = $tid;
        //added part-------------------------------------------------------------------------------------------------------
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
        //added part-------------------------------------------------------------------------------------------------------
        $amount_ = $amount;
        //added part-------------------------------------------------------------------------------------------------------
        $sql .= " amount = " . $amount . ",";
    }


    //added part-------------------------------------------------------------------------------------------------------
    $sql_get_existing_transfer_amount = "SELECT * FROM Transactions WHERE tid = " . $tid;

    $result = mysqli_query($conn, $sql_get_existing_transfer_amount);
    $row=mysqli_fetch_row($result);
    $existing_amount = floatval($row[3]);

    if (($existing_amount - $amount_) < 0.0){
        echo "error, the input amount bigger than the existing amount!";
        exit;
    }


    $account1_id_ = intval($row[1]);
    $account2_id_ = intval($row[2]);

    //added part-------------------------------------------------------------------------------------------------------


    $sql = rtrim($sql, ",");
    if($tid_cond) $sql .= " WHERE tid = " . $tid;

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }


    //added part-------------------------------------------------------------------------------------------------------

    //$sql = rtrim($sql, ",");
    $amount = $amount_ - $existing_amount;
    $account1_id = $account1_id_;
    $account2_id = $account2_id_;

    //update sender account balance
    $update_sender_amount = 0.0;
    $sql_get_sender_balance = "SELECT * FROM Account WHERE account_id = " . $account1_id;

    $result = mysqli_query($conn, $sql_get_sender_balance);
    $row=mysqli_fetch_row($result);
    $update_sender_amount = floatval($row[4]) - $amount;

    if($update_sender_amount < 0.0)
    {
        echo "sender not enough balance! ";
        exit;
    }




    $sql_set_sender_balance = "UPDATE Account SET balance = " . $update_sender_amount . " WHERE account_id = " . $account1_id;
    $result = mysqli_query($conn, $sql_set_sender_balance);

    echo "Sender account balance update " . $result;
    echo "</br>";


    //update receiver account balance
    $update_receiver_amount = 0.0;
    $sql_get_receiver_balance = "SELECT * FROM Account WHERE account_id = " . $account2_id;
    $result = mysqli_query($conn, $sql_get_receiver_balance);
    $row=mysqli_fetch_row($result);
    $update_receiver_amount = $amount + floatval($row[4]);


    $sql_set_receiver_balance = "UPDATE Account SET balance = " . $update_receiver_amount . " WHERE account_id = " . $account2_id;
    $result = mysqli_query($conn, $sql_set_receiver_balance);

    echo "Receiver account balance update " . $result;
    echo "</br>";



    //added part-------------------------------------------------------------------------------------------------------

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

    //added part-------------------------------------------------------------------------------------------------------

    $sql = rtrim($sql, ",");
    $amount = ltrim($amount, "\'");
    $amount = rtrim($amount, "\'");

    //update sender account balance
    $update_sender_amount = 0.0;
    $sql_get_sender_balance = "SELECT * FROM Account WHERE account_id = " . $account1_id;

    $result = mysqli_query($conn, $sql_get_sender_balance);
    $row=mysqli_fetch_row($result);
    $update_sender_amount = floatval($row[4]) - $amount;

    if($update_sender_amount < 0.0)
    {
        echo "sender not enough balance! ";
        exit;
    }




    $sql_set_sender_balance = "UPDATE Account SET balance = " . $update_sender_amount . " WHERE account_id = " . $account1_id;
    $result = mysqli_query($conn, $sql_set_sender_balance);

    echo "Sender account balance update " . $result;
    echo "</br>";


    //update receiver account balance
    $update_receiver_amount = 0.0;
    $sql_get_receiver_balance = "SELECT * FROM Account WHERE account_id = " . $account2_id;
    $result = mysqli_query($conn, $sql_get_receiver_balance);
    $row=mysqli_fetch_row($result);
    $update_receiver_amount = $amount + floatval($row[4]);


    $sql_set_receiver_balance = "UPDATE Account SET balance = " . $update_receiver_amount . " WHERE account_id = " . $account2_id;
    $result = mysqli_query($conn, $sql_set_receiver_balance);

    echo "Receiver account balance update " . $result;
    echo "</br>";

//added part-------------------------------------------------------------------------------------------------------


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
