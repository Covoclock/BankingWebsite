<!DOCTYPE html>
<html>
<head>
    <title>Schedule Results</title>
</head>
<body>
<h1>Schedule Results</h1>
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
        $sql = "SELECT * FROM Schedule";
    }
    else{
        $sql = "SELECT * FROM Schedule WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>employee_id: </strong>" . $row[0];
        echo "<br />work_date: " . $row[1];
        echo "<br />hour_begin: " . $row[2];
        echo "<br />hour_end: " . $row[3];
        echo "<br />isHoliday: " . $row[4];
    }
}

if(!empty($_POST['submitUpdate'])) {


    $sql = "UPDATE Schedule SET ";

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

    if(isset($_POST['work_date_u']) && $_POST['work_date_u'] !== "")
    {
        $work_date = $_POST['work_date_u'];
        $work_date = date('Y-m-d', strtotime($work_date));
        $sql .= " work_date = " .'\''. $work_date.'\'' . ",";
    }

    if(isset($_POST['hour_begin_u']) && $_POST['hour_begin_u'] !== "")
    {
        $hour_begin = $_POST['hour_begin_u'];
        $hour_begin = intval($hour_begin);
        $sql .= " hour_begin = " . $hour_begin . ",";
    }

    if(isset($_POST['hour_end_u']) && $_POST['hour_end_u'] !== "")
    {
        $hour_end = $_POST['hour_end_u'];
        $hour_end = intval($hour_end);
        $sql .= " hour_end = " . $hour_end . ",";
    }

    if(isset($_POST['isHoliday_u']) && $_POST['isHoliday_u'] !== "")
    {
        $isHoliday = $_POST['isHoliday_u'];
        $isHoliday = boolval($isHoliday);
        $sql .= " isHoliday = " .'\''. $isHoliday.'\'' . ",";
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

    if (  !isset($_POST['hour_end_i'])
        || !isset($_POST['work_date_i']) || !isset($_POST['hour_begin_i'])
        || !isset($_POST['isHoliday_i'])) {
        echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
        exit;
    }

    // create short variable names

    $employee_id = $_POST['employee_id_i'];
    $work_date = $_POST['work_date_i'];
    $hour_begin = $_POST['hour_begin_i'];
    $isHoliday = $_POST['isHoliday_i'];

    $employee_id = intval($employee_id);
    $hour_begin = intval($hour_begin);
    $isHoliday = '\''. boolval($isHoliday) .'\'';
    $work_date = '\''. date('Y-m-d', strtotime($work_date)) . '\'';

    $sql = "INSERT INTO Schedule(employee_id,work_date, hour_begin, isHoliday) 
                  VALUES ($employee_id, $work_date, $hour_begin, $isHoliday)";

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

    $sql = "DELETE FROM Schedule WHERE employee_id = " . $employee_id;

    if(mysqli_query($conn,$sql)){
        echo "Deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

}

mysqli_close($conn);

echo "<p><a href='schedule_admin.html'>back to Schedule Admin.</a></p>";
?>
</body>
</html>
