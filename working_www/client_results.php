<!DOCTYPE html>
<html>
<head>
    <title>Client Results</title>
</head>
<body>
<h1>Client Results</h1>
<?php

$conn = mysqli_connect('tdc353.encs.concordia.ca', 'tdc353_2', '1yfja853','tdc353_2');

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
        $sql = "SELECT * FROM client";
    }
    else{
        $sql = "SELECT * FROM client WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>client_id: </strong>" . $row[0];
        echo "<br />firstName: " . $row[1];
        echo "<br />lastName: " . $row[2];
        echo "<br />city: " . $row[3];
        echo "<br />province: " . $row[4];
        echo "<br />dob: " . $row[5];
        echo "<br />join_date: " . $row[6];
        echo "<br />standing: " . $row[7];
        echo "<br />email: " . $row[8];
        echo "<br />phone: " . $row[9];
        echo "<br />category: " . $row[10];
        echo "<br />branch_id: " . $row[11];

    }
}

if(!empty($_POST['submitUpdate'])) {


    $sql = "UPDATE client SET ";

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

    if(isset($_POST['firstName_u']) && $_POST['firstName_u'] !== "") $sql .= " firstName = " .'\'' . $_POST['firstName_u'].'\'' . ",";
    if(isset($_POST['lastName_u']) && $_POST['lastName_u'] !== "") $sql .= " lastName = " .'\'' . $_POST['lastName_u'].'\''. ",";
    if(isset($_POST['phone_u']) && $_POST['phone_u'] !== "") $sql .= " phone = " . '\'' . $_POST['phone_u'] .'\''. ",";
    if(isset($_POST['city_u']) && $_POST['city_u'] !== "") $sql .= " city = " .'\''.$_POST['city_u'].'\''. ",";
    if(isset($_POST['province_u']) && $_POST['province_u'] !== "") $sql .= " province = " .'\''.$_POST['province_u'].'\''. ",";
    if(isset($_POST['email_u']) && $_POST['email_u'] !== "") $sql .= " email = " .'\''.$_POST['email_u'].'\''. ",";

    if(isset($_POST['dob_u']) && $_POST['dob_u'] !== "")
    {
        $dob = $_POST['dob_u'];
        $dob = date('Y-m-d', strtotime($dob));
        $sql .= " dob = " .'\''. $dob .'\''. ",";
    }
    
    if(isset($_POST['join_date_u']) && $_POST['join_date_u'] !== "")
    {
        $join_date = $_POST['join_date_u'];
        $join_date = date('Y-m-d', strtotime($join_date));
        $sql .= " join_date = " .'\''. $join_date.'\''. ",";
    }

    if(isset($_POST['category_u']) && $_POST['category_u'] !== "") $sql .= " category = " .'\'' . $_POST['category_u'].'\'' . ",";

    if(isset($_POST['branch_id_u']) && $_POST['branch_id_u'] !== "")
    {
        $branch_id = $_POST['branch_id_u'];
        $branch_id = intval($branch_id);
        $sql .= " branch_id = " . $branch_id . ",";
    }

    if(isset($_POST['standing_u']) && $_POST['standing_u'] !== "")
    {
        $standing = $_POST['standing_u'];
        $standing = boolval($standing);
        $sql .= " standing = " .'\''. $standing.'\'' . ",";
    }

    $sql = rtrim($sql, ",");
    if($client_id_cond) $sql .= " WHERE client_id = " . $client_id;

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(!empty($_POST['submitInsert'])){

    if ( !isset($_POST['firstName_i'])
        || !isset($_POST['lastName_i']) || !isset($_POST['city_i']) || !isset($_POST['province_i'])
        || !isset($_POST['phone_i']) || !isset($_POST['email_i']) || !isset($_POST['dob_i'])
        || !isset($_POST['join_date_i']) || !isset($_POST['category_i']) || !isset($_POST['branch_id_i'])
        || !isset($_POST['standing_i'])) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    // create short variable names
    $firstName='\''. $_POST['firstName_i'].'\'';
    $lastName='\''. $_POST['lastName_i'].'\'';
    $city='\''. $_POST['city_i'].'\'';
    $province='\''. $_POST['province_i'].'\'';
    $phone ='\''. $_POST['phone_i'] . '\'';
    $email = '\''. $_POST['email_i'] . '\'';
    $dob = $_POST['dob_i'];
    $join_date = $_POST['join_date_i'];
    $branch_id = $_POST['category_i'];
    $branch_id = $_POST['branch_id_i'];
    $standing = $_POST['standing_i'];

    $branch_id = intval($branch_id);
    $standing = '\''. boolval($standing) .'\'';
    $dob = '\''. date('Y-m-d', strtotime($dob)) . '\'';
    $join_date = '\''. date('Y-m-d', strtotime($join_date)) . '\'';

    $sql = "INSERT INTO client(firstName, lastName, city, province, dob, join_date, standing, email, phone, branch_id) 
                  VALUES ($firstName,$lastName, $city, $province, $dob, $join_date,  $standing, $email, $phone, $branch_id)";

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

    $sql = "DELETE FROM Client WHERE client_id = " . $client_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

}

mysqli_close($conn);

echo "<p><a href='client_admin.html'>back to Client Admin.</a></p>";
?>
</body>
</html>
