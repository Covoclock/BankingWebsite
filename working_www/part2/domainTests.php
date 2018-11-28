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
    <title>TEST</title>
</head>

<body>
<h1>TEST PAGE</h1>

<?php
$conn = getDBConnection();
$testACC = Accounts::generateInstancedAccountByID($conn, 1);

$testACC->toString();

echo "</br>";

$testACCList = Accounts::generateAccountListByClientID($conn, 1);

for($i = 0; $i<count($testACCList); $i++)
{
    $testACCList[$i]->toString();
    echo "</br>";
}

$testChargeplan = Accounts::generateChargePlanArrays($conn);
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
$testAcc3 = Accounts::generateInstancedAccountByID($conn, 3);
$testAcc3->toString();
$testACC->setChargePlanID(0);
$testACC->UpdateByID($conn);
echo "</br>";




echo "<h3>Second round of tests</h3>";
echo "</br>";
$testAccBranchID = $testACC->findBranchID($conn);
echo "</br>";
echo "$testAccBranchID";
$branchInstance = new Branch($conn, $testAccBranchID);
echo "</br>";
$branchInstance->instantiateOwnBankAcc($conn);
echo "</br>";
transferto($conn, $testACC->getID(), $testAcc3->getID(), 10);
echo "</br>";
$branchACC = $branchInstance->getBranchAccount();
$testACC->toString();
echo "</br>";
$testAcc3->toString();
echo "</br>";
$branchACC->toString();
echo "</br>";
$EmailACCfind = Accounts::findAccountByEmail($conn, 'trdhge@gmail.com');
echo "</br>";
$EmailACCfind->toString();
echo "</br>";
$PhoneACCfind = Accounts::findAccountByPhone($conn, '514-222-3456');
echo "</br>";
$PhoneACCfind->toString();
echo "</br>";
echo "</br>";
$conn->close();
?>

</body>
</html>


