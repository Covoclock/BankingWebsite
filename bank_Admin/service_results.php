<!DOCTYPE html>
<html>
<head>
    <title>Services Results</title>
</head>
<body>
<h1>Services Results</h1>
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
        $sql = "SELECT * FROM services";
    }
    else{
        $sql = "SELECT * FROM services WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>service_id: </strong>" . $row[0];
        echo "<br />service_name: " . $row[1];
        echo "<br />manager_id: " . $row[2];
    }
}

if(!empty($_POST['submitUpdate'])) {


    $sql = "UPDATE services SET ";

    if(!isset($_POST['service_id_u']))
    {
        $service_id = "";
        $service_id_cond = false;
    }
    else{
        $service_id = $_POST['service_id_u'];
        $service_id = intval($service_id);
        $service_id_cond = true;
    }

    if(isset($_POST['service_name_u']) && $_POST['service_name_u'] !== "") $sql .= " service_name = " .'\'' . $_POST['service_name_u'].'\'' . ",";

    if(isset($_POST['manager_id_u']) && $_POST['manager_id_u'] !== "")
    {
        $manager_id = $_POST['manager_id_u'];
        $manager_id = intval($manager_id);
        $sql .= " manager_id = " . $manager_id . ",";
    }

    $sql = rtrim($sql, ",");
    if($service_id_cond) $sql .= " WHERE service_id = " . $service_id;

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(!empty($_POST['submitInsert'])){

    if ( !isset($_POST['service_name_i']) || !isset($_POST['manager_id_i']) || !isset($_POST['service_id_i'])) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    // create short variable names
    $service_name='\''. $_POST['service_name_i'].'\'';
    $manager_id = $_POST['manager_id_i'];
    $manager_id = intval($manager_id);

    $service_id = $_POST['service_id_i'];
    $service_id = intval('$service_id');

    $sql = "INSERT INTO Services(service_id, service_name, manager_id) 
                  VALUES ($service_id, $service_name, $manager_id)";

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}

if(!empty($_POST['submitDelete'])){


    if (!isset($_POST['service_id_d'])){
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    $service_id = $_POST['service_id_d'];
    $service_id = intval($service_id);

    $sql = "DELETE FROM services WHERE service_id = " . $service_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

}

mysqli_close($conn);

echo "<p><a href='service_admin.html'>back to Services Admin.</a></p>";
?>
</body>
</html>
