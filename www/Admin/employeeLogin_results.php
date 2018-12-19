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
    <title>EmployeeLogin Results</title>
</head>
<body>
<h1>EmployeeLogin Results</h1>
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
        $sql = "SELECT * FROM EmployeeLogin";
    }
    else{
        if($searchtype == "psw")
	{
	$sql = "SELECT * FROM EmployeeLogin WHERE " .$searchtype . " = " . "\"" . $searchterm ."\"";
	}
	else
        $sql = "SELECT * FROM EmployeeLogin WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>employee_id: </strong>" . $row[0];
        echo "<br />psw: " . $row[1];
    }
}

if(!empty($_POST['submitUpdate'])) {

    $sql = "UPDATE EmployeeLogin SET ";


    if(!isset($_POST['employee_id_u'])|| ($_POST['employee_id_u'] == ""))
    {
        echo "employee id not set, error! ";
        exit;
        $employee_id = "";
        $employee_id_cond = false;
    }
    else{
        $employee_id = $_POST['employee_id_u'];
        $employee_id = intval($employee_id);
        $employee_id_cond = true;
    }

    if(isset($_POST['psw_u']) && $_POST['psw_u'] !== "") $sql .= " psw = " .'\'' . $_POST['psw_u'].'\'' . ",";

    $sql = rtrim($sql, ",");
    if($employee_id_cond) $sql .= " WHERE employee_id = " . $employee_id;



    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(!empty($_POST['submitInsert']) || ($_POST['submitInsert'] == "")){

    if ( !isset($_POST['psw_i'])  || !isset($_POST['employee_id_i']) || ($_POST['psw_i'] == "") || ($_POST['employee_id_i'] == "")) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    // create short variable names
    $psw='\''. $_POST['psw_i'].'\'';

    $employee_id = $_POST['employee_id_i'];
    $employee_id = intval($employee_id);


    $sql = "INSERT INTO EmployeeLogin(employee_id, psw) 
                  VALUES ($employee_id, $psw)";

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}

if(!empty($_POST['submitDelete'])){


    if (!isset($_POST['employee_id_d']) || ($_POST['employee_id_d'] == "")){
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    $employee_id = $_POST['employee_id_d'];
    $employee_id = intval($employee_id);

    $sql = "DELETE FROM EmployeeLogin WHERE employee_id = " . $employee_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

}

mysqli_close($conn);

echo "<p><a href='employeeLogin_admin.html'>back to EmployeeLogin Admin.</a></p>";
?>
</body>
</html>
