<!DOCTYPE html>
<html>
<head>
    <title>Branch Results</title>
</head>
<body>
<h1>Branch Results</h1>
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
        $sql = "SELECT * FROM branch";
    }
    else{
        $sql = "SELECT * FROM branch WHERE " .$searchtype . " = " . $searchterm;
    }

    $result = mysqli_query($conn, $sql);

    echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

    while ($row=mysqli_fetch_row($result)) {
        echo "<p><strong>branch_id: </strong>" . $row[0];
        echo "<br />province: " . $row[1];
        echo "<br />city: " . $row[2];
        echo "<br />street: " . $row[3];
        echo "<br />phone: " . $row[4];
        echo "<br />fax: " . $row[5];
        echo "<br />opening_date: " . $row[6];
        echo "<br />manager_id: " . $row[7];
        echo "<br />isHeadOffice: " . $row[8];
    }
}

    if(!empty($_POST['submitUpdate'])) {


        $sql = "UPDATE branch SET ";

        if(!isset($_POST['branch_id_u']))
        {
            $branch_id = "";
            $branch_id_cond = false;
        }
        else{
            $branch_id = $_POST['branch_id_u'];
            $branch_id = intval($branch_id);
            $branch_id_cond = true;
        }

        if(isset($_POST['province_u']) && $_POST['province_u'] !== "") $sql .= " province = " .'\'' . $_POST['province_u'].'\'' . ",";
        if(isset($_POST['city_u']) && $_POST['city_u'] !== "") $sql .= " city = " .'\'' . $_POST['city_u'].'\'' . ",";
        if(isset($_POST['phone_u']) && $_POST['phone_u'] !== "") $sql .= " phone = " . '\'' . $_POST['phone_u'] .'\'' . ",";
        if(isset($_POST['street_u']) && $_POST['street_u'] !== "") $sql .= " street = " .'\''.$_POST['street_u'].'\'' . ",";
        if(isset($_POST['fax_u']) && $_POST['fax_u'] !== "") $sql .= " fax = " .'\''.$_POST['fax_u'].'\'' . ",";
        if(isset($_POST['opening_date_u']) && $_POST['opening_date_u'] !== "")
        {
            $opening_date = $_POST['opening_date_u'];
            $opening_date = date('Y-m-d', strtotime($opening_date));
            $sql .= " opening_date = " .'\''. $opening_date.'\'' . ",";
        }

        if(isset($_POST['manager_id_u']) && $_POST['manager_id_u'] !== "")
        {
            $manager_id = $_POST['manager_id_u'];
            $manager_id = intval($manager_id);
            $sql .= " manager_id = " . $manager_id . ",";
        }

        if(isset($_POST['isHeadOffice_u']) && $_POST['isHeadOffice_u'] !== "")
        {
            $isHeadOffice = $_POST['isHeadOffice_u'];
            $isHeadOffice = boolval($isHeadOffice);
            $sql .= " isHeadOffice = " .'\''. $isHeadOffice.'\'' . ",";
        }

        $sql = rtrim($sql, ",");
        if($branch_id_cond) $sql .= " WHERE branch_id = " . $branch_id;

        echo $sql;

        if(mysqli_query($conn,$sql)){
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    if(!empty($_POST['submitInsert'])){

        if ( !isset($_POST['province_i'])
            || !isset($_POST['city_i']) || !isset($_POST['street_i'])
            || !isset($_POST['phone_i']) || !isset($_POST['fax_i'])
            || !isset($_POST['opening_date_i']) || !isset($_POST['manager_id_i'])
            || !isset($_POST['isHeadOffice_i'])) {
            echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
            exit;
        }

        // create short variable names
        $province='\''. $_POST['province_i'].'\'';
        $city='\''. $_POST['city_i'].'\'';
        $street='\''. $_POST['street_i'].'\'';
        $phone ='\''. $_POST['phone_i'] . '\'';
        $fax = '\''. $_POST['fax_i'] . '\'';
        $opening_date = $_POST['opening_date_i'];
        $manager_id = $_POST['manager_id_i'];
        $isHeadOffice = $_POST['isHeadOffice_i'];

        $manager_id = intval($manager_id);
        $isHeadOffice = '\''. boolval($isHeadOffice) .'\'';
        $opening_date = '\''. date('Y-m-d', strtotime($opening_date)) . '\'';

        $sql = "INSERT INTO Branch(province, city, street, phone, fax, opening_date, manager_id, isHeadOffice) 
                  VALUES ($province,$city, $street, $phone, $fax, $opening_date, $manager_id, $isHeadOffice)";

        if(mysqli_query($conn,$sql)){
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }

    }

    if(!empty($_POST['submitDelete'])){


        if (!isset($_POST['branch_id_d'])){
            echo "<p>You have not entered any of the required details.<br />
             Please go back and try again.</p>";
            exit;
        }

        $branch_id = $_POST['branch_id_d'];
        $branch_id = intval($branch_id);

        $sql = "DELETE FROM branch WHERE branch_id = " . $branch_id;

        if(mysqli_query($conn,$sql)){
            echo "Deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

    }

mysqli_close($conn);

echo "<p><a href='branch_admin.html'>back to Branch Admin.</a></p>";
?>
</body>
</html>
