<?php
/**
 * Short description for Client.php
 *
 * @package Client
 * @author Sebastien Bah <sebastien.bah@mail.mcgill.ca>
 * @version 0.1
 * @copyright (C) 2018 Sebastien Bah <sebastien.bah@mail.mcgill.ca>
 * @license MIT
 */
require dirname(__FILE__)."/../credentialCheck.php";
require "Accounts.php";


/* Client Class */
class Client{
	private $id;
	private $fName;
	private $lName;
	private $city;
	private $province;
	private $dob;
	private $join_date;
	private $standing;
	private $email;
	private $phone;
	private $category;
	private $branch_id;

	// Holds all the accounts associated with this client
	private $AccountList;
	/* Class constructor 
	 * @param $id
	 */
	public function __construct($id){
		global $dbc;
		// Search Client table to find the rest
		$query = "SELECT * FROM Client WHERE client_id = $id";
		if($result = $dbc->query($query)){
			$row = $result->fetch_assoc();
			if($row){
				$this->id	 = $id;
				$this->fName    = $row['firstName'];
				$this->lName    = $row['lastName'];
				$this->city     = $row['city'];
				$this->province = $row['province'];
				$this->dob      = $row['dob'];
				$this->join_date= $row['join_date'];
				$this->standing = $row['standing'];
				$this->email    = $row['email'];
				$this->phone    = $row['phone'];
				$this->category = $row['category'];
                	      	$this->branch_id= $row['branch_id'];
				$this->generateAccountList($dbc);
			}
		}
	}

	/* Finds all the accounts associated with said client
	 */
	public function generateAccountList($dbc){
		$query = "SELECT * FROM Account WHERE client_id = $this->id";
		$result = $dbc->query($query);

		$i = 0;
		while($row = $result->fetch_assoc()){
			$this->AccountList[$i] = \BankingApp\Accounts::accountFromID($dbc,$row['account_id']);
			$i++;
		}
	}


    	public function __toString(){
	    $s = "";
    	    $s .= "<strong>Client ID</strong>: $this->id <br>";
    	    $s .= "Associated with <strong>Branch</strong> # {$this->branch_id}<br>";
    	    $s .= "<strong>Name</strong>: {$this->fName} {$this->lName} <br>";
    	    $s .= "<strong>Location</strong>: {$this->city}, {$this->province} <br>";
    	    $s .= "<strong>Date of Birth</strong>: {$this->dob} <br>";
    	    $s .= "<strong>Joined </strong>on {$this->join_date} <br>";
    	    $s .= "Standing is ";
	    if ($this->standing == '1') $s .= "<em>good</em>"; // if '0' then bad standing, cant get credit card
            else $s .= "<em>not good yet</em>";
    	    $s .= "<br><strong>Email</strong>: {$this->email} <br>";
    	    $s .= "<strong>Phone</strong>: {$this->phone} <br>";
	    return $s;
    	}

	/*
    	 *  -----------GETTERS AND SETTERS --------------
    	 */

	/* Get Array of Accounts
	*/
	public function getAccounts(){return $this->AccountList;}

    	/**
    	 * @return mixed
    	 */
    	public function getID()
    	{
    	    return $this->id;
    	}

    	/**
    	 * @param mixed $ID
    	 */
    	public function setID($ID)
    	{
    	    $this->id = $ID;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getFirstName()
    	{
    	    return $this->fName;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setFirstName($fName)
    	{
    	    $this->fName = $fName;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getLastName()
    	{
    	    return $this->lName;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setLastName($lName)
    	{
    	    $this->lName = $lName;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getCity()
    	{
    	    return $this->city;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setCity($city)
    	{
    	    $this->city = $city;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getProvince()
    	{
    	    return $this->province;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setProvince($province)
    	{
    	    $this->province = $province;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getDOB()
    	{
    	    return $this->dob;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setDOB($dob)
    	{
    	    $this->dob = $dob;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getJoinDate()
    	{
    	    return $this->join_date;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setJoinDate($join)
    	{
    	    $this->join_date = $join;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getStanding()
    	{
    	    return $this->standing;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setStanding($standing)
    	{
    	    $this->standing = $standing;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getEmail()
    	{
    	    return $this->email;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setEmail($email)
    	{
    	    $this->email = $email;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getPhone()
    	{
    	    return $this->phone;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setPhone($phone)
    	{
    	    $this->phone = $phone;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getCategory()
    	{
    	    return $this->category;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setCategory($TransactionLimit)
    	{
    	    $this->category = $category;
    	}

    	/**
    	 * @return mixed
    	 */
    	public function getBranchID()
    	{
    	    return $this->branch_id;
    	}

    	/**
    	 * @param mixed 
    	 */
    	public function setBranchID($id)
    	{
    	    $this->branch_id = $id;
    	}
}



/* List all accounts linked */
