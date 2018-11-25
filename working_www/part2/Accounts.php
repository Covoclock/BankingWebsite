<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/24/2018
 * Time: 4:18 PM
 */

namespace BankingApp;


class Accounts
{
    private $ID;
    private $clientID;
    private $accountType;
    private $chargePlan_ID;
    private $balance;
    private $credit_limit;
    private $interests;
    private $level;
    private $transactionMade;

    //chargePlan related Variables are stored here to ease process
    private $TransactionLimit;
    private $chargePrice;

    /**
     * Accounts constructor.
     * @param $ID
     * @param $clientID
     * @param $accountType
     * @param $chargePlan_ID
     * @param $balance
     * @param $credit_limit
     * @param $interests
     * @param $level
     * @param $transactionLeft
     * @param $TransactionCost
     * @param $chargePrice
     */
    public function __construct($ID, $clientID, $accountType, $chargePlan_ID, $balance, $credit_limit, $interests, $level, $transactionMade, $TransactionCost, $chargePrice)
    {
        $this->ID = $ID;
        $this->clientID = $clientID;
        $this->accountType = $accountType;
        $this->chargePlan_ID = $chargePlan_ID;
        $this->balance = $balance;
        $this->credit_limit = $credit_limit;
        $this->interests = $interests;
        $this->level = $level;
        $this->transactionMade = $transactionMade;
        $this->TransactionLimit = $TransactionCost;
        $this->chargePrice = $chargePrice;
    }

    /*
     * ------------CUSTOM METHODS -------------------
     */

    public function UpdateByID($conn)
    {
        $sql = "UPDATE account SET client_id='$this->clientID', account_type = '$this->accountType', chargePlan_id = '$this->chargePlan_ID',
        balance = '$this->balance', credit_limit = '$this->credit_limit', interest_rate = '$this->interests', lvl = '$this->level',
        transactionLeft ='$this->transactionMade' WHERE account_id=$this->ID";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

    }



    public function toString()
    {
        echo "</<br>";
        echo "ID: $this->ID </br>";
        echo "clientID: $this->clientID </br>";
        echo "accountType: $this->accountType </br>";
        echo "chargePlan_ID: $this->chargePlan_ID </br>";
        echo "balance: $this->balance </br>";
        echo "credit_limit: $this->credit_limit </br>";
        echo "interests: $this->interests </br>";
        echo "level: $this->level </br>";
        echo "transactionMade: $this->transactionMade </br>";
        echo "TransactionLimit: $this->TransactionLimit </br>";
        echo "chargePrice: $this->chargePrice </br>";
    }

    /*
     *  -----------GETTERS AND SETTERS --------------
     */

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * @param mixed $clientID
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
    }

    /**
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @param mixed $accountType
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return mixed
     */
    public function getCreditLimit()
    {
        return $this->credit_limit;
    }

    /**
     * @param mixed $credit_limit
     */
    public function setCreditLimit($credit_limit)
    {
        $this->credit_limit = $credit_limit;
    }

    /**
     * @return mixed
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * @param mixed $interests
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getTransactionMade()
    {
        return $this->transactionMade;
    }

    /**
     * @param mixed $transactionMade
     */
    public function setTransactionMade($transactionMade)
    {
        $this->transactionMade = $transactionMade;
    }

    /**
     * @return mixed
     */
    public function getChargePlanID()
    {
        return $this->chargePlan_ID;
    }

    /**
     * @param mixed $chargePlan_ID
     */
    public function setChargePlanID($chargePlan_ID)
    {
        $this->chargePlan_ID = $chargePlan_ID;
    }

    /**
     * @return mixed
     */
    public function getTransactionLimit()
    {
        return $this->TransactionLimit;
    }

    /**
     * @param mixed $TransactionLimit
     */
    public function setTransactionLimit($TransactionLimit)
    {
        $this->TransactionLimit = $TransactionLimit;
    }

    /**
     * @return mixed
     */
    public function getChargePrice()
    {
        return $this->chargePrice;
    }

    /**
     * @param mixed $chargePrice
     */
    public function setChargePrice($chargePrice)
    {
        $this->chargePrice = $chargePrice;
    }

}