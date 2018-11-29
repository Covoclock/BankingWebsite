<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/24/2018
 * Time: 6:34 PM
 */

include_once "Domain_Logic.php";

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
echo "<h3>Test round 3</h3>";
echo "</br>";
$branchInstance2 = new Branch($conn,5);
$branchInstance2->displayAccountsOBJList();
echo "</br>";
$chargePlanREV = $branchInstance2->calculateRevenuesFromChargePlans();
$interestREV = $branchInstance2->calculateRevenuesFromCredit();
$transactionREV = $branchInstance2->calculateRevenuesFromTransactions();
$interestCost = $branchInstance2->calculateInterestCost();
echo "</br>";
echo "$chargePlanREV";
echo "</br>";
echo "$interestREV";
echo "</br>";
echo "$transactionREV";
echo "</br>";
echo "$interestCost";
echo "</br>";
$currentDate = strtotime(Date("y-m-d"));
echo "$currentDate";
echo "</br>";
$employeeTest = new Employee($conn, 1);
$testDate1 = strtotime(Date("18-06-22"));
echo "$testDate1";
echo "</br>";
$testpayed = $employeeTest->getPayedSince($conn, $testDate1);
echo "</br>";
echo "$testpayed";
$testpayed = $employeeTest->getPayedInterval($conn, $testDate1,  strtotime(Date("y-m-d")));
echo "</br>";
echo "payed test: $testpayed";
echo "<h3>Test round 4</h3>";
echo "</br>";
$employeeCostsTest1 = $branchInstance2->calculateEmployeeCosts($conn, $testDate1, Date("y-m-d"));
$interestCostTest1 = $branchInstance2->calculateInterestCost();
$revenuesTest1 = $branchInstance2->calculateBranchRevenues();
$profitTest = $branchInstance2->calculateProfit($conn, $testDate1, Date("y-m-d"));
echo "revenues: $revenuesTest1";
echo "</br>";
echo "employees costs: $employeeCostsTest1";
echo "</br>";
echo "Interest costs :$interestCostTest1";
echo "</br>";
echo "Profits: $profitTest";
echo "</br>";
$branchList = Branch::generateListAllBranch($conn);
echo "</br>";

for($index = 0; $index < count($branchList); $index++)
{
    $tempvar = $branchList[$index]->calculateProfit($conn, $testDate1, Date("y-m-d"));
    echo "$tempvar </br>";
}

$MtlBranchList = Branch::generateListBranchByCity($conn, 'Montreal');

for($index = 0; $index < count($MtlBranchList); $index++)
{
    $tempvar = $MtlBranchList[$index]->calculateProfit($conn, $testDate1, Date("y-m-d"));
    echo "$tempvar </br>";
}


echo "</br>";
$conn->close();
?>

</body>
</html>


