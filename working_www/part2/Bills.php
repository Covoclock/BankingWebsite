<?php
require dirname(__FILE__)."/../credentialCheck.php";
require_once "Accounts.php";
require_once "Domain_Logic.php";
/* Bill Class */
class Bill{
    private $bill_id;
    private $amount;
    private $account1_id;
    private $account2_id;
    private $recurring;

    /* Constructor
     * @param $id
     * @param $amount
     * @param $account1_id
     * @param $account2_id
     * @param $dt
     */
    public function __construct($bill_id, $amount, $account1_id, $account2_id, $recurring)
    {
        $this->bill_id = $bill_id;
        $this->recurring = $recurring;
        $this->amount = $amount;
        $this->account1_id = $account1_id;
        $this->account2_id = $account2_id;
    }

    public static function billFromID($dbc, $id)
    {
        $query = "SELECT * from Bills WHERE bill_id = $id";
        $result = $dbc->query($query);
        if ($row = $result->fetch_assoc()) {
            $amount = $row['amount'];
            $account1_id = $row['account1_id'];
            $account2_id = $row['account2_id'];
            $recurring = $row['recurring'];
            return new self($id, $amount, $account1_id, $account1_id, $recurring);
        }
    }

    public function duplicateBill($dbc)
    {
        $query = "INSERT INTO Bills(amount, account1_id, account2_id, recurring) VALUES ($this->amount, $this->account1_id, $this->account2_id, 0 )";
        return $dbc->query($query);
    }
    public static function addNewBill($dbc, $from, $to, $amount, $recurring){
	$query = "INSERT INTO Bills(account1_id, account2_id, amount, recurring) VALUES ($from, $to, $amount, $recurring)";
	return $dbc->query($query);
    }

    public static function singleBill($dbc, Bill $bill)
    {
        $bill_fee = 2;
        $account1 = generateInstancedAccountByID($dbc, $bill->getAccount1ID());
        $account2 = generateInstancedAccountByID($dbc, $bill->getAccount2ID());
        $amount = floatval($bill->getAmount());
        $balance1 = floatval($account1->getBalance());
        // If they can be paid, server transfers the money and creates a transaction
        if ($balance1 >= $amount + $bill_fee) {
            //$branchAccount = generateInstancedAccountByID($account1->findBranchID($dbc));
            transferAccountUpdate($dbc, $account1, $account2, $amount);
            createTransaction($dbc, $account1, $account2, $amount);
            // Check if recurring bill
            if ($bill->getRecurring() != '1') {
                self::deleteBill($dbc, $bill->getID());
            }
            return true;
        } else {
            // Can't pay, duplicate bill
            $bill->duplicateBill($dbc);
        }
        return false;
    }

    public static function deleteBill($dbc, $id)
    {
        //Remove entry in bills
        $query = "DELETE FROM Bills WHERE bill_id = $id";
        $dbc->query($query);
    }

    public function getID()
    {
        return $this->bill_id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getAccount1ID()
    {
        return $this->account1_id;
    }

    public function getAccount2ID()
    {
        return $this->account2_id;
    }

    public function getRecurring()
    {
        return $this->recurring;
    }

    public function setID($id)
    {
        $this->bill_id = $id;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setAccount1ID($account1_id)
    {
        $this->account1_id = $account1_id;
    }

    public function setAccount2ID($account2_id)
    {
        $this->account2_id = $account2_id;
    }

    public function setRecurring($recurring)
    {
        $this->recurring = $recurring;
    }

}
