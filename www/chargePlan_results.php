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
    <title>ChargePlan Results</title>
</head>
<body>
<h1>ChargePlan Results</h1>
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
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
    }

    if(empty($searchtype) || empty($searchterm) && ('0' !== $searchterm)) {
        $sql = "SELECT * FROM ChargePlan";
    }
    else{
	if(($searchtype == "draw_limit<=") || ($searchtype == "charge_value<="))
	{
		$searchtype = rtrim($searchtype, "<=");
		$sql = "SELECT * FROM ChargePlan WHERE " .$searchtype . " <= " . $searchterm;
	}
	elseif(($searchtype == "draw_limit>=") || ($searchtype == "charge_value>="))
	{
		$searchtype = rtrim($searchtype, ">=");
		$sql = "SELECT * FROM ChargePlan WHERE " .$searchtype . " >= " . $searchterm;
	}
	else
        $sql = "SELECT * FROM ChargePlan WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<br /><strong>chargePlan_id: </strong>" . $row[0];
        echo "<br />option_name: " . $row[1];
        echo "<br />draw_limit: " . $row[2];
        echo "<br />charge_value: " . $row[3];


    }
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
}

if(!empty($_POST['submitUpdate'])) {


    $sql = "UPDATE ChargePlan SET ";

    if((!isset($_POST['chargePlan_id_u'])) || ($_POST['chargePlan_id_u'] == ""))
    {
        echo "charge plan id not set, error！";
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
        exit;
        $chargePlan_id = "";
        $chargePlan_id_cond = false;
    }
    else{
        $chargePlan_id = $_POST['chargePlan_id_u'];
        $chargePlan_id = intval($chargePlan_id);
        $chargePlan_id_cond = true;
    }

    if(isset($_POST['option_name_u']) && $_POST['option_name_u'] !== "") $sql .= " option_name = " .'\'' . $_POST['option_name_u'].'\'' . ",";

    if(isset($_POST['draw_limit_u']) && $_POST['draw_limit_u'] !== "")
    {
        $draw_limit = $_POST['draw_limit_u'];
        $draw_limit = floatval($draw_limit);
        $sql .= " draw_limit = " . $draw_limit . ",";
    }

    if(isset($_POST['charge_value_u']) && $_POST['charge_value_u'] !== "")
    {
        $charge_value = $_POST['charge_value_u'];
        $charge_value = floatval($charge_value);
        $sql .= " charge_value = " . $charge_value . ",";
    }

    $sql = rtrim($sql, ",");
    if($chargePlan_id_cond) $sql .= " WHERE chargePlan_id = " . $chargePlan_id;

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
    }
}

if(!empty($_POST['submitInsert'])){

    if (  !isset($_POST['option_name_i']) || ($_POST['option_name_i'] == "")
        || !isset($_POST['chargePlan_id_i']) || ($_POST['chargePlan_id_i'] == "")
        || !isset($_POST['draw_limit_i']) || !isset($_POST['charge_value_i']) || ($_POST['draw_limit_i'] == "") || ($_POST['charge_value_i'] == "")) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
        exit;
    }

    // create short variable names

    $option_name='\''. $_POST['option_name_i'].'\'';
    $chargePlan_id = $_POST['chargePlan_id_i'];
    $draw_limit = $_POST['draw_limit_i'];
    $charge_value = $_POST['charge_value_i'];

    $chargePlan_id = intval($chargePlan_id);
    $draw_limit = '\''. floatval($draw_limit) .'\'';
    $charge_value = '\''. floatval($charge_value) .'\'';



    $sql = "INSERT INTO ChargePlan( option_name, draw_limit, charge_value, chargePlan_id) 
                  VALUES ($option_name,  $draw_limit, $charge_value, $chargePlan_id)";

    echo $sql;

    if(mysqli_query($conn,$sql)){
        echo "Record updated successfully";
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
    }

}

if(!empty($_POST['submitDelete'])){


    if (!isset($_POST['chargePlan_id_d'])){
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
        exit;
    }

    $chargePlan_id = $_POST['chargePlan_id_d'];
    $chargePlan_id = intval($chargePlan_id);

    $sql = "DELETE FROM ChargePlan WHERE chargePlan_id = " . $chargePlan_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
	echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
    }
}

mysqli_close($conn);

echo "<p><a href='chargePlan_admin.php'>back to ChargePlan Admin.</a></p>";
?>
</body>
</html>
