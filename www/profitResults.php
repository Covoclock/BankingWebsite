<?php
/* Created by PhpStorm.
 * User: joedu
 * Date: 11/29/2018
 * Time: 2:08 PM
 */
session_start();
include_once dirname(__DIR__)."/credentialCheck.php";
include_once dirname(__DIR__)."/permissionCheck.php";
include_once dirname(__DIR__)."/navbar.php";
verifySession($dbc, "employee");

include_once dirname(__DIR__)."/part2/Domain_Logic.php";

$startDate = $_POST['From'];
$endDate = $_POST['To'];
$searchType = $_POST['ListType'];
$searchWord = $_POST['SearchTerms'];
$profits = 0;
if($searchType == 'one')
{
    $branch = new Branch($dbc, $searchWord);
    $profits = $branch->calculateProfit($dbc, $startDate,$endDate);
}
else if($searchType == 'City')
{
    $branchList = Branch::generateListBranchByCity($dbc, $_POST['SearchTerms']);
    $profits = Branch::calculateBranchListProfits($dbc, $startDate,$endDate, $branchList );
}
else if($searchType == 'All')
{
    $branchList = Branch::generateListAllBranch($dbc);
    $profits = Branch::calculateBranchListProfits($dbc, $startDate,$endDate, $branchList );
}

echo "$profits";
?>
