<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/24/2018
 * Time: 4:18 PM
 */
//require dirname(__FILE__)."/../credentialCheck.php";
include "..\AdminSearch\DataGateway.php";

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
    private $transactionLeft;
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
    public function __construct($ID, $clientID, $accountType, $chargePlan_ID, $balance, $credit_limit, $interests, $level, $transactionLeft, $TransactionCost, $chargePrice)
    {
        $this->ID = $ID;
        $this->clientID = $clientID;
        $this->accountType = $accountType;
        $this->chargePlan_ID = $chargePlan_ID;
        $this->balance = $balance;
        $this->credit_limit = $credit_limit;
        $this->interests = $interests;
        $this->level = $level;
        // To change (shoudl be transactionsLeft) and
        // add maxTransaction in ChargePlan to replace transactionLimit
        $this->transactionLeft = $transactionLeft;
        $this->TransactionLimit = $TransactionCost;
        $this->chargePrice = $chargePrice;
    }

    /* Generates object from account_id
     * @param id Account_id
     */
    public static function accountFromID($dbc, $id){
        //global $dbc; //TODO UNCOMMENT FOR MERGE OR DONT
        $query = "SELECT * FROM Account WHERE account_id = $id";
        $result = $dbc->query($query);
        if ($row =  $result->fetch_assoc()){
            $clientID = $row['client_id'];
            $accountType = $row['account_type'];
            $chargePlan_id= $row['chargePlan_id'];
            $balance = $row['balance'];
            $credit_limit = $row['credit_limit'];
            $interest_rate = $row['interest_rate'];
            $lvl = $row['lvl'];
            $transactionLeft = $row['transactionLeft'];
            $instance = new self($id, $clientID, $accountType, $chargePlan_id, $balance, $credit_limit, $interest_rate, $lvl, $transactionLeft, 0, 0);
            return $instance;
        }
        else{
            echo "Error selecting record: " . $dbc->error;
        }
    }

    public static function findAccountByEmail ($dbc, $inputMail)
    {
        $query = "SELECT client_id FROM Client WHERE email = '$inputMail'";
        $result = $dbc->query($query);
        if ($row = $result->fetch_assoc())
        {
            $tempClientID = $row['client_id'];
            $clientAccList = Accounts::generateAccountListByClientID($dbc, $tempClientID);
            for($i = 0; count($clientAccList); $i++)
            {
                if($clientAccList[$i]->getAccountType() == 'chequing') //TODO did we really spell it like that?
                {
                    return($clientAccList[$i]);
                }
            }

            echo"This Email Address in not linked to any Checking account";
        }

        else {
            echo"Problem finding Account linked to this Email Address";
        }
    }

    public static function findAccountByPhone ($dbc, $inputPhone)
    {
        $query = "SELECT client_id FROM Client WHERE phone = '$inputPhone'";
        $result = $dbc->query($query);
        if ($row = $result->fetch_assoc())
        {
            $tempClientID = $row['client_id'];
            $clientAccList = Accounts::generateAccountListByClientID($dbc, $tempClientID);
            for($i = 0; count($clientAccList); $i++)
            {
                if($clientAccList[$i]->getAccountType() == 'chequing') //TODO did we really spell it like that?
                {
                    return($clientAccList[$i]);
                }
            }

            echo"This Phone number in not linked to any Checking account";
        }

        else {
            echo"Problem finding Account linked to this Phone number";
        }
    }

    /*
     * ------------CUSTOM METHODS -------------------
     */
    public function UpdateByID($dbc) {
        $sql = "UPDATE Account SET client_id='$this->clientID', account_type = '$this->accountType', chargePlan_id = '$this->chargePlan_ID',
        balance = '$this->balance', credit_limit = '$this->credit_limit', interest_rate = '$this->interests', lvl = '$this->level',
        transactionLeft ='$this->transactionLeft' WHERE account_id=$this->ID";
        if ($dbc->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $dbc->error;
        }
    }

    public function findBranchID($dbc)
    {
        $branchID = 0;
        $sql = "SELECT * FROM Client WHERE client_id='$this->clientID'";
        $result = $dbc->query($sql);
        if($row = mysqli_fetch_assoc($result))
        {
            $branchID = $row['branch_id'];
        }

        return $branchID;
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
        echo "transactionLeft: $this->transactionLeft </br>";
        echo "TransactionLimit: $this->TransactionLimit </br>";
        echo "chargePrice: $this->chargePrice </br>";
    }

    public static function transferInstanciation($dbc, Accounts $account1 , Accounts $account2, $amount)
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

    public static function generateInstancedAccountByID($conn, $accountID)
    {
        $chargePlanAtt = Accounts::generateChargePlanArrays($conn);
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
    public static function generateAccountListByClientID($conn, $clientID)
    {
        $chargePlanAtt = Accounts::generateChargePlanArrays($conn);
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

    public static function generateChargePlanArrays($conn)
    {
        $chargePlansIDArray = array();
        $optionNamesArray = array();
        $drawLimitsArray = array();
        $chargeValsArray = array();
        $sql = "SELECT * FROM Chargeplan";
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

    public static function getAvailableFunds($accountID)
    {
        $conn = getDBConnection();
        $sql = "SELECT * FROM Account WHERE account_id = '$accountID'";
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

    public static function getStaticAccountType($accountID)
    {
        $conn = getDBConnection();
        $sql = "SELECT * FROM Account WHERE account_id = '$accountID'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $conn->close();
        return $row["account_type"];
    }

//check if account exists
    public static function doesAccountExists($accountID)
    {
        $conn = getDBConnection();
        $sql = "SELECT * FROM Account WHERE account_id = '$accountID'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
        {
            return true;
        }
        else{
            return false;
        }
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
    public function getTransactionLeft()
    {
        return $this->transactionLeft;
    }
    /**
     * @param mixed $transactionLeft
     */
    public function setTransactionLeft($transactionLeft)
    {
        $this->transactionLeft = $transactionLeft;
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