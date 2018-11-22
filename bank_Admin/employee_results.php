<!DOCTYPE html>
<html>
<head>
    <title>Employee Results</title>
</head>
<body>
<h1>Employee Results</h1>
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
        $sql = "SELECT * FROM employee";
    }
    else{
        $sql = "SELECT * FROM employee WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>employee_id: </strong>" . $row[0];
        echo "<br />firstName: " . $row[1];
        echo "<br />lastName: " . $row[2];
        echo "<br />addr: " . $row[3];
        echo "<br />start_date: " . $row[4];
        echo "<br />wage: " . $row[5];
        echo "<br />email: " . $row[6];
        echo "<br />phone: " . $row[7];
        echo "<br />branch_id: " . $row[8];

    }
}

if(!empty($_POST['submitUpdate'])) {


    $sql = "UPDATE employee SET ";

    if(!isset($_POST['employee_id_u']))
    {
        $employee_id = "";
        $employee_id_cond = false;
    }
    else{
        $employee_id = $_POST['employee_id_u'];
        $employee_id = intval($employee_id);
        $employee_id_cond = true;
    }

    if(isset($_POST['firstName_u']) && $_POST['firstName_u'] !== "") $sql .= " firstName = " .'\'' . $_POST['firstName_u'].'\'' . ",";
    if(isset($_POST['lastName_u']) && $_POST['lastName_u'] !== "") $sql .= " lastName = " .'\'' . $_POST['lastName_u'].'\''. ",";
    if(isset($_POST['phone_u']) && $_POST['phone_u'] !== "") $sql .= " phone = " . '\'' . $_POST['phone_u'] .'\''. ",";
    if(isset($_POST['addr_u']) && $_POST['addr_u'] !== "") $sql .= " addr = " .'\''.$_POST['addr_u'].'\''. ",";
    if(isset($_POST['email_u']) && $_POST['email_u'] !== "") $sql .= " email = " .'\''.$_POST['email_u'].'\''. ",";
    if(isset($_POST['start_date_u']) && $_POST['start_date_u'] !== "")
    {
        $start_date = $_POST['start_date_u'];
        $start_date = date('Y-m-d', strtotime($start_date));
        $sql .= " start_date = " .'\''. $start_date.'\''. ",";
    }

    if(isset($_POST['branch_id_u']) && $_POST['branch_id_u'] !== "")
    {
        $branch_id = $_POST['branch_id_u'];
        $branch_id = intval($branch_id);
        $sql .= " branch_id = " . $branch_id . ",";
    }

    if(isset($_POST['wage_u']) && $_POST['wage_u'] !== "")
    {
        $wage = $_POST['wage_u'];
        $wage = floatval($wage);
        $sql .= " wage = " . $wage . ",";
    }

    $sql = rtrim($sql, ",");
    if($employee_id_cond) $sql .= " WHERE employee_id = " . $employee_id;

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(!empty($_POST['submitInsert'])){

    if ( !isset($_POST['firstName_i'])
        || !isset($_POST['lastName_i']) || !isset($_POST['addr_i'])
        || !isset($_POST['phone_i']) || !isset($_POST['email_i'])
        || !isset($_POST['start_date_i']) || !isset($_POST['branch_id_i'])
        || !isset($_POST['wage_i'])) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    // create short variable names
    $firstName='\''. $_POST['firstName_i'].'\'';
    $lastName='\''. $_POST['lastName_i'].'\'';
    $addr='\''. $_POST['addr_i'].'\'';
    $phone ='\''. $_POST['phone_i'] . '\'';
    $email = '\''. $_POST['email_i'] . '\'';
    $start_date = $_POST['start_date_i'];
    $branch_id = $_POST['branch_id_i'];
    $wage = $_POST['wage_i'];

    $branch_id = intval($branch_id);
    $wage = '\''. floatval($wage) .'\'';
    $start_date = '\''. date('Y-m-d', strtotime($start_date)) . '\'';

    $sql = "INSERT INTO employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id) 
                  VALUES ($firstName,$lastName, $addr, $start_date,  $wage, $email, $phone, $branch_id)";

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}

if(!empty($_POST['submitDelete'])){


    if (!isset($_POST['employee_id_d'])){
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    $employee_id = $_POST['employee_id_d'];
    $employee_id = intval($employee_id);

    $sql = "DELETE FROM Employee WHERE employee_id = " . $employee_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

}

mysqli_close($conn);

echo "<p><a href='employee_admin.html'>back to Employee Admin.</a></p>";
?>
</body>
</html>
