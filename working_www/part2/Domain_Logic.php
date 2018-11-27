<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/22/2018
 * Time: 4:08 PM
 */

include "Branch.php";
//require dirname(__FILE__)."/../credentialCheck.php";

//TODO VERIFY THIS WORKS PROPERLY
//execute transfers
function transferTo($dbc, $account1ID, $account2ID, $amount)
{
    if(!doesAccountExists($account1ID) || !doesAccountExists($account2ID))
    {
        echo "One of the accounts do not exists </br>";
    }

    else if ($account1ID == $account2ID)
    {
        echo "cant transfer to same account </br>";
    }

    else {
        $instancedAcc1 = generateInstancedAccountByID($dbc, $account1ID);
        $instancedAcc2 = generateInstancedAccountByID($dbc, $account2ID);

        if($instancedAcc1->getTransactionLeft() <= 0)
        {
            //2$ charges per transactions
            //TODO iT DOES NOT REMOVE A TRANSACTIONLEFT AT THIS POINT, DUNNO IF WE WANT TO CHANGE IT
            if ($instancedAcc1->getBalance() > $amount + 2)
            {
                $instancedBranch = new Branch($dbc, $instancedAcc1->findBranchID($dbc));
                $instancedBranch->instantiateOwnBankAcc($dbc);

                $instancedBranchAccount1 = $instancedBranch->getBranchAccount();
                transferAccountUpdate($dbc, $instancedAcc1,$instancedAcc2, $amount);
                transferAccountUpdate($dbc, $instancedAcc1,$instancedBranchAccount1, 2);
                transferInstanciation($dbc, $instancedAcc1,$instancedAcc2, $amount);
                transferInstanciation($dbc, $instancedAcc1,$instancedBranchAccount1, 2);
            }

            else
            {
                echo "Insuficient funds to pay the transaction fee";
            }
        }

        else {

            if ($instancedAcc1->getBalance() > $amount)
            {
                $instancedAcc1->setTransactionLeft($instancedAcc1->getTransactionLeft() -1);
                transferAccountUpdate($dbc, $instancedAcc1,$instancedAcc2, $amount);
                transferInstanciation($dbc, $instancedAcc1,$instancedAcc2, $amount);
            }
            else
            {
                echo "Insufficient funds to transfer:$amount";
            }

        }
    }
}

/**
 * @param Accounts $account1
 * @param Accounts $account2
 * @param $amount
 *
 * update the 2 accounts balance to reflect the nature of the transfer
 */
function transferAccountUpdate($dbc, Accounts $account1 , Accounts $account2, $amount)
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
    $account1->UpdateByID($dbc);
    $account2->UpdateByID($dbc);
}

function transferInstanciation($dbc, Accounts $account1 , Accounts $account2, $amount)
{
    $Account1ID = $account1->getID();
    $Account2ID = $account2->getID();
    $transactionDateTime = date("y-m-d h:i:sa");
    $sql = "INSERT INTO transactions(account1_id, account2_id, amount, dt)
            VALUES ('$Account1ID', '$Account2ID ', '$amount', '$transactionDateTime')";
    if ($dbc->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $dbc->error;
    }

}

/**
 * @param $conn
 * @param $accountID
 * @return Accounts|null
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
    if ($row = mysqli_fetch_row($result)) {
        for($i = 0; $i < count($chargePlanIDs) ; $i++ )
        {
            if($row[3] == $chargePlanIDs[$i])
            {
                $optionIndex = $i;
                break;
            }
        }
        $Account = new Accounts($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$drawLimits[$optionIndex],$chargeVals[$optionIndex]);
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
        $Account = new Accounts($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$drawLimits[$optionIndex],$chargeVals[$optionIndex]);
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