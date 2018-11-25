<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/22/2018
 * Time: 4:08 PM
 */

include "..\AdminSearch\DataGateway.php";
include "Accounts.php";

/*
    $chargePlanIDs = array(0,1,2,3,4);
    $optionNames = array ('PERFORMANCE', 'PREMIUM', 'PLUS', 'AIRMILES', 'PRACTICAL');
    $drawLimits = array (20,200,50,40,5);
    $chargeVals = array (10,50,20,25,0);
    */

function calculateBranchProfits($BranchID)
{


}

//execute transfers
function transferTo($account1ID, $account2ID, $amount)
{

    if(!doesAccountExists($account1ID) || !doesAccountExists($account2ID))
    {
        echo "One of the accounts do not exists";
    }

    else {
        $conn = getDBConnection();
        $instancedAcc1 = generateInstancedAccountByID($conn, $account1ID);
        $instancedAcc2 = generateInstancedAccountByID($conn, $account2ID);

        if($instancedAcc1->getTransactionMade() >= $instancedAcc1->getTransactionMade())
        {

        }




        $sql = "";

        if ($conn->query($sql) === TRUE) {
            echo "transaction successful";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
}


/**
 * @param \BankingApp\Accounts $account1
 * @param \BankingApp\Accounts $account2
 * @param $amount
 *
 * update the 2 accounts balance to reflect the nature of the transfer
 */
function transferAccountUpdate($conn, \BankingApp\Accounts $account1 , \BankingApp\Accounts $account2, $amount)
{
    if($account1->getAccountType() == "credit")
    {
        $account1->setBalance($account1->getBalance() + $amount);
    }
    else
    {
        $account1->setBalance($account1->getBalance() - $amount);
    }

    if($account2->getAccountType() == "credit")
    {
        $account2->setBalance($account2->getBalance() - $amount);
    }
    else
    {
        $account2->setBalance($account2->getBalance() + $amount);
    }

    $account1->UpdateByID($conn);
    $account2->UpdateByID($conn);
}





/**
 * @param $conn
 * @param $accountID
 * @return \BankingApp\Accounts|null
 */
function generateInstancedAccountByID($conn, $accountID)
{

    $chargePlanAtt = generateChargePlanArrays($conn);

    $chargePlanIDs = $chargePlanAtt[0];
    $optionNames = $chargePlanAtt[1];
    $drawLimits = $chargePlanAtt[2];
    $chargeVals = $chargePlanAtt[3];

    $sql = "SELECT * FROM account WHERE account_id = '$accountID'";
    $result = $conn->query($sql);
    $optionIndex = 0;
    $Account = null;

    while ($row = mysqli_fetch_row($result)) {

        for($i = 0; $i < count($chargePlanIDs) ; $i++ )
        {
            if($row[3] == $chargePlanIDs[$i])
            {
                $optionIndex = $i;
            }
        }
        $Account = new \BankingApp\Accounts($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$drawLimits[$optionIndex],$chargeVals[$optionIndex]);
    }
    return $Account;
}

/**
 * @param $conn
 * @param $clientID
 * @return array
 *
 * Return all the Accounts owned by a given client.
 */
function generateAccountListByClientID($conn, $clientID)
{
    $chargePlanAtt = generateChargePlanArrays($conn);

    $chargePlanIDs = $chargePlanAtt[0];
    $optionNames = $chargePlanAtt[1];
    $drawLimits = $chargePlanAtt[2];
    $chargeVals = $chargePlanAtt[3];

    $sql = "SELECT * FROM account WHERE client_id = '$clientID'";
    $result = $conn->query($sql);

    $optionIndex = 0;
    $Account = null;
    $AccountList = array();
    $listIndex = 0;

    while ($row = mysqli_fetch_row($result)) {

        for($i = 0; $i < count($chargePlanIDs) ; $i++ )
        {
            if($row[3] == $chargePlanIDs[$i])
            {
                $optionIndex = $i;
            }
        }
        $Account = new \BankingApp\Accounts($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$drawLimits[$optionIndex],$chargeVals[$optionIndex]);
        $AccountList[$listIndex] = $Account;
        $listIndex++;
    }
    return $AccountList;
}


/**
 * @param $conn
 * @return array
 */
function generateChargePlanArrays($conn)
{
    $chargePlansIDArray = array();
    $optionNamesArray = array();
    $drawLimitsArray = array();
    $chargeValsArray = array();

    $sql = "SELECT * FROM chargeplan";
    $result = $conn->query($sql);
    $i =0;

    while ($row = mysqli_fetch_row($result)) {
        $chargePlansIDArray[$i] = $row[0];
        $optionNamesArray[$i] = $row[1];
        $drawLimitsArray[$i] = $row[2];
        $chargeValsArray[$i] = $row[3];
        $i++;
    }

    $arrayOfAttributes = array($chargePlansIDArray, $optionNamesArray, $drawLimitsArray, $chargeValsArray);
    return $arrayOfAttributes;
}

/**
 * @param $accountID
 * @return mixed
 */
function getAvailableFunds($accountID)
{
    $conn = getDBConnection();
    $sql = "SELECT * FROM account WHERE account_id = '$accountID'";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    if($row["account_type"] === "chequing" || $row["account_type"] === "saving") {
        $conn->close();
        return $row["balance"];
    }

    else {
        $conn->close();
        return $row["credit_limit"] - $row["balance"];
    }
}

function getAccountType($accountID)
{
    $conn = getDBConnection();
    $sql = "SELECT * FROM account WHERE account_id = '$accountID'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    return $row["account_type"];
}

//check if account exists
function doesAccountExists($accountID)
{
    $conn = getDBConnection();
    $sql = "SELECT * FROM account WHERE account_id = '$accountID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        return true;
    }
    else{
        return false;
    }
}

?>