<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/18/2018
 * Time: 5:41 PM
 */

include "ResultListing.php";

if(!isset($_COOKIE['Domain']))
{
    header("AdminSearch.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title> <?php echo $_COOKIE['Domain']; ?> Catalog Search</title>
</head>
<body>

<?php
$domain = $_COOKIE["Domain"];
$SearchAttribute = $_POST["searchBy"];
$searchLike = $_POST["searchLike"];
$Qresult = GenerateDBQuery();

if (!$Qresult) {
    echo 'Could not run query';
    exit;
}

else{
    GenerateList($Qresult);
}

?>

</body>
