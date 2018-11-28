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
    if(!Accounts::doesAccountExists($account1ID) || !Accounts::doesAccountExists($account2ID))
    {
        echo "One of the accounts do not exists </br>";
    }

    else if ($account1ID == $account2ID)
    {
        echo "can't transfer to same account </br>";
    }

    else {
        $instancedAcc1 = Accounts::generateInstancedAccountByID($dbc, $account1ID);
        $instancedAcc2 = Accounts::generateInstancedAccountByID($dbc, $account2ID);

        if($instancedAcc2->getAccountType() == 'credit')
        {
            echo "can't transfer to credit account </br>";
        }

        else if($instancedAcc1->getTransactionLeft() <= 0)
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
