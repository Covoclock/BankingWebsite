<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/24/2018
 * Time: 6:34 PM
 */

include "Domain_Logic.php";

?>
<!DOCTYPE html>
<html>
<head>
    <title>Branch Catalog Search</title>
</head>

<body>
<h1>TEST PAGE</h1>

<?php
$conn = getDBConnection();
$testACC = generateInstancedAccountByID($conn, 1);

$testACC->toString();

echo "</br>";

$testACCList = generateAccountListByClientID($conn, 1);

for($i = 0; $i<count($testACCList); $i++)
{
    $testACCList[$i]->toString();
    echo "</br>";
}

$testChargeplan = generateChargePlanArrays($conn);
$test0 = $testChargeplan[0];
$test1 = $testChargeplan[1];
$test2 = $testChargeplan[2];
$test3 = $testChargeplan[3];

for($i = 0; $i<count($test0); $i++)
{
    echo "$test0[$i], $test1[$i], $test2[$i], $test3[$i] <br/>";
    echo "<br/>";
}

$testACC->setChargePlanID(3);
echo "</br>";
$testACC->UpdateByID($conn);
echo "</br>";
$testACC->toString();
echo "</br>";
$testAcc3 = generateInstancedAccountByID($conn, 1);
$testAcc3->toString();
$testACC->setChargePlanID(0);
$testACC->UpdateByID($conn);
$conn->close();
?>

</body>
</html>


