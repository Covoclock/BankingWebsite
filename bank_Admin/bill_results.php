<!DOCTYPE html>
<html>
<head>
    <title>Bill Results</title>
</head>
<body>
<h1>Bill Results</h1>
<?php

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
        $sql = "SELECT * FROM Bills";
    }
    else{
        $sql = "SELECT * FROM Bills WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>bill_id: </strong>" . $row[0];
        echo "<br />amount: " . $row[1];
        echo "<br />account1_id: " . $row[2];
        echo "<br />account2_id: " . $row[3];
        echo "<br />recurring: " . $row[4];
    }
}

if(!empty($_POST['submitUpdate'])) {


    $sql = "UPDATE Bills SET ";

    if(!isset($_POST['bill_id_u']))
    {
        $bill_id = "";
        $bill_id_cond = false;
    }
    else{
        $bill_id = $_POST['bill_id_u'];
        $bill_id = intval($bill_id);
        $bill_id_cond = true;
    }

    if(isset($_POST['amount_u']) && $_POST['amount_u'] !== "")
    {
        $amount = $_POST['amount_u'];
        $amount = floatval($amount);
        $sql .= " amount = " .'\''. $amount.'\'' . ",";
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

    if(isset($_POST['recurring_u']) && $_POST['recurring_u'] !== "")
    {
        $recurring = $_POST['recurring_u'];
        $recurring = boolval($recurring);
        $sql .= " recurring = " .'\''. $recurring.'\'' . ",";
    }

    $sql = rtrim($sql, ",");
    if($bill_id_cond) $sql .= " WHERE bill_id = " . $bill_id;

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(!empty($_POST['submitInsert'])){

    if (  !isset($_POST['account2_id_i'])
        || !isset($_POST['amount_i']) || !isset($_POST['account1_id_i'])
        || !isset($_POST['recurring_i'])) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    // create short variable names

    $amount = $_POST['amount_i'];
    $account1_id = $_POST['account1_id_i'];
    $recurring = $_POST['recurring_i'];

    $account1_id = intval($account1_id);
    $recurring = '\''. boolval($recurring) .'\'';
    $amount = floatval($amount);

    $sql = "INSERT INTO Bills(amount, account1_id, recurring) 
                  VALUES ($amount, $account1_id, $recurring)";

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(!empty($_POST['submitDelete'])){
    if (!isset($_POST['bill_id_d'])){
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    $bill_id = $_POST['bill_id_d'];
    $bill_id = intval($bill_id);

    $sql = "DELETE FROM Bills WHERE bill_id = " . $bill_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

}

mysqli_close($conn);

echo "<p><a href='bill_admin.html'>back to Bill Admin.</a></p>";
?>
</body>
</html>
