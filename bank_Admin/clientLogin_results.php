<!DOCTYPE html>
<html>
<head>
    <title>ClientLogin Results</title>
</head>
<body>
<h1>ClientLogin Results</h1>
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
        $sql = "SELECT * FROM ClientLogin";
    }
    else{
        $sql = "SELECT * FROM ClientLogin WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>client_id: </strong>" . $row[0];
        echo "<br />psw: " . $row[1];
    }
}

if(!empty($_POST['submitUpdate'])) {

    $sql = "UPDATE ClientLogin SET ";


    if(!isset($_POST['client_id_u']))
    {
        $client_id = "";
        $client_id_cond = false;
    }
    else{
        $client_id = $_POST['client_id_u'];
        $client_id = intval($client_id);
        $client_id_cond = true;
    }

    if(isset($_POST['psw_u']) && $_POST['psw_u'] !== "") $sql .= " psw = " .'\'' . $_POST['psw_u'].'\'' . ",";

    $sql = rtrim($sql, ",");
    if($client_id_cond) $sql .= " WHERE client_id = " . $client_id;



    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(!empty($_POST['submitInsert'])){

    if ( !isset($_POST['psw_i'])  || !isset($_POST['client_id_i'])) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    // create short variable names
    $psw='\''. $_POST['psw_i'].'\'';

    $client_id = $_POST['client_id_i'];
    $client_id = intval($client_id);


    $sql = "INSERT INTO ClientLogin(client_id, psw) 
                  VALUES ($client_id, $psw)";

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}

if(!empty($_POST['submitDelete'])){


    if (!isset($_POST['client_id_d'])){
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    $client_id = $_POST['client_id_d'];
    $client_id = intval($client_id);

    $sql = "DELETE FROM ClientLogin WHERE client_id = " . $client_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

}

mysqli_close($conn);

echo "<p><a href='clientLogin_admin.html'>back to ClientLogin Admin.</a></p>";
?>
</body>
</html>
