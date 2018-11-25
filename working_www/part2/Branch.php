<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/25/2018
 * Time: 1:13 AM
 */

namespace BankingApp;
include "Accounts.php";

class Branch
{
    private $ID;
    private $province;
    private $city;
    private $street;
    private $phone;
    private $fax;
    private $opening_date;
    private $manager_id;
    private $isHeadOffice;

    private $EmployeeIDList;
    private $ClientIDList;
    private $AccountIDList;


    //TODO NEED A FUNCITON TO GENERATE THIS ONE, USING THE GENERATE ClientIDList + AccountIDList is prolly a good idea
    private $AccountOBJList;

    /**
     * Branch constructor.
     * @param $ID
     * @param $province
     * @param $city
     * @param $street
     * @param $phone
     * @param $fax
     * @param $opening_date
     * @param $manager_id
     * @param $isHeadOffice
     */
    public function __construct($ID, $province, $city, $street, $phone, $fax, $opening_date, $manager_id, $isHeadOffice)
    {
        $this->ID = $ID;
        $this->province = $province;
        $this->city = $city;
        $this->street = $street;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->opening_date = $opening_date;
        $this->manager_id = $manager_id;
        $this->isHeadOffice = $isHeadOffice;
    }

    /*
     * ------------CUSTOM METHODS -------------------
     */

    public function generateEmployeeIDList($conn)
    {
        $sql = "SELECT * FROM employee WHERE branch_id = '$this->ID'";
        $result = $conn->query($sql);

        $EmployeeList = array();
        $i = 0;
        while ($row = mysqli_fetch_row($result)) {

            $EmployeeList[$i] = $row[0];
            $i++;
        }

        $this->setEmployeeIDList($EmployeeList);
    }

    public function generateClientIDList($conn)
    {
        $sql = "SELECT * FROM Client WHERE branch_id = '$this->ID'";
        $result = $conn->query($sql);

        $ClientList = array();
        $i = 0;
        while ($row = mysqli_fetch_row($result)) {

            $ClientList[$i] = $row[0];
            $i++;
        }

        $this->setClientIDList($ClientList);
    }


    public function generateAccountIDList($conn)
    {
        $clientList = $this->getClientIDList($conn);
        $tempAccList = array();
        $accListIndex = 0;
        for($i = 0; $i < count($clientList); $i++)
        {
            $sql = "SELECT * FROM account WHERE client_id = '$clientList[$i]'";
            $result = $conn->query($sql);

            while ($row = mysqli_fetch_row($result)) {

                $tempAccList[$accListIndex] = $row[0];
                $accListIndex++;
            }
        }

        $this->setAccountIDList($tempAccList);
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
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getOpeningDate()
    {
        return $this->opening_date;
    }

    /**
     * @param mixed $opening_date
     */
    public function setOpeningDate($opening_date)
    {
        $this->opening_date = $opening_date;
    }

    /**
     * @return mixed
     */
    public function getManagerId()
    {
        return $this->manager_id;
    }

    /**
     * @param mixed $manager_id
     */
    public function setManagerId($manager_id)
    {
        $this->manager_id = $manager_id;
    }

    /**
     * @return mixed
     */
    public function getisHeadOffice()
    {
        return $this->isHeadOffice;
    }

    /**
     * @param mixed $isHeadOffice
     */
    public function setIsHeadOffice($isHeadOffice)
    {
        $this->isHeadOffice = $isHeadOffice;
    }

    /**
     * @return mixed
     */
    public function getEmployeeIDList()
    {
        return $this->EmployeeIDList;
    }

    /**
     * @param mixed $EmployeeIDList
     */
    public function setEmployeeIDList($EmployeeIDList)
    {
        $this->EmployeeIDList = $EmployeeIDList;
    }

    /**
     * @return mixed
     */
    public function getClientIDList()
    {
        return $this->ClientIDList;
    }

    /**
     * @param mixed $ClientIDList
     */
    public function setClientIDList($ClientIDList)
    {
        $this->ClientIDList = $ClientIDList;
    }

    /**
     * @return mixed
     */
    public function getAccountIDList()
    {
        return $this->AccountIDList;
    }

    /**
     * @param mixed $AccountIDList
     */
    public function setAccountIDList($AccountIDList)
    {
        $this->AccountIDList = $AccountIDList;
    }






}