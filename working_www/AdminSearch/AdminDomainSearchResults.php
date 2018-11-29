<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/16/2018
 * Time: 5:11 PM
 */
include "AdminSearchHelper.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title> <?php echo $_POST['searchDomain']; ?> Catalog Search</title>
</head>
<body>
<?php
$searchDomain = $_POST['searchDomain'];
$SearchOptionsArray = SearchDispatcher($searchDomain);
generateDomainSpecificSearchForm($SearchOptionsArray);
?>
</body>