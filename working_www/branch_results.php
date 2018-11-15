<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
<h1>Search Results</h1>
<?php

// create short variable names
$searchtype = $_POST['searchtype'];
$searchterm = $_POST['searchterm'];


if (!$searchtype || !$searchterm) {
    echo '<p>You have not entered search details.<br/>
       Please go back and try again2222222.</p>';
    exit;
}

// whitelist the searchtype
switch ($searchtype) {
    case 'branch_id':
    case 'province':
    case 'city':
    case 'street':
    case 'phone':
    case 'fax':
    case 'opening_date':
    case 'manager_id':
    case 'isHeadOffice':
        break;
    default:
        {echo '<p>That is not a valid search type. <br/>
        Please go back and try again11111111111111.</p>';
            exit;}
}

$conn = new mysqli('tdc353.encs.concordia.ca', 'tdc353_2', '1yfja853');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM Employee";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0)  {
    
    echo "success!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

echo "<p>Number of items found: " . mysqli_num_rows($result) . "</p>";

mysqli_close($conn);




?>
</body>
</html>
