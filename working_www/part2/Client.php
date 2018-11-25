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
include "../credentialCheck.php";
include "Accounts.php";


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
	private $dbc = $dbc;

	// Holds all the accounts associated with this client
	private $AccoundList;
	/* Class constructor 
	 * @param $id
	 */
	public function __construct($id){
		// Search Client table to find the rest
		$query = "SELECT * FROM CLient WHERE client_id = $id";
		$result = $this->dbc->query($query);
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
			this->generateAccountList();
		}
	}

	/* Finds all the accounts associated with said client
	 */
	public function generateAccountList(){
		$query = "SELECT * FROM Account WHERE client_id = $this->id";
		$result = $this->dbc->query($query);

		$i = 0;
		while($row = $result->fetch_assoc()){
			$this->AccoundList[$i] = Account::accountFromID($row['account_id']);
			$i++;
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
