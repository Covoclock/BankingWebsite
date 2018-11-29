<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/25/2018
 * Time: 1:13 AM
 */

include_once "Client.php";

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
    private $BranchClient;
    private $BranchAccount;

    private $EmployeeIDList;
    private $ClientIDList;
    private $AccountIDList;

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

    public function __construct($conn, $ID)
    {
        $sql = "SELECT * FROM Branch WHERE branch_id='$ID'";
        $result = $conn->query($sql);
        if ($row = mysqli_fetch_row($result)) {
            $this->ID = $ID;
            $this->province = $row[1];
            $this->city = $row[2];
            $this->street = $row[3];
            $this->phone = $row[4];
            $this->fax = $row[5];
            $this->opening_date = $row[6];
            $this->manager_id = $row[7];
            $this->isHeadOffice = $row[8];
            $this->instantiateOwnBankAcc($conn);
            $this->generateClientIDList($conn);
            $this->generateAccountIDList($conn);
            $this->instantiateAccountObjList($conn);
        }
        else{
            echo"No Valid branch";
        }
    }

    /*
     * profit related methods
     */

    function calculateRevenuesFromChargePlans()
    {
        $revenue = 0;
        for($i =0; $i<count($this->AccountOBJList) ;$i++)
        {
            $revenue += $this->AccountOBJList[$i]->getChargePrice();
        }

        return $revenue;
    }

    function calculateRevenuesFromTransactions()
    {
        $revenue = 0;
        for($i =0; $i<count($this->AccountOBJList) ;$i++)
        {
            $transLeft = $this->AccountOBJList[$i]->getTransactionLeft();
                if($transLeft < 0)
                {
                    $revenue +=  $transLeft*-2;
                }
        }
        return $revenue;
    }

    function calculateRevenuesFromCredit()
    {
        $revenue = 0;
        for($i =0; $i<count($this->AccountOBJList) ;$i++)
        {
            if($this->AccountOBJList[$i]->getAccountType() == 'credit')
            {
                $revenue +=  $this->AccountOBJList[$i]->getBalance() * $this->AccountOBJList[$i]->getInterests();
            }
        }
        return $revenue;
    }


    function calculateBranchProfits()
    {
        $totalRevenues = $this->calculateRevenuesFromChargePlans();
        $totalRevenues += $this->calculateRevenuesFromTransactions();
        $totalRevenues += $this->calculateRevenuesFromCredit();
        return $totalRevenues;
    }

    /*
     * ------------CUSTOM METHODS -------------------
     */

    public function instantiateOwnClient($conn)
    {
        $sql = "SELECT * FROM Client WHERE firstname = '$this->ID' and lastName = 'Branch'";
        $result = $conn->query($sql);
        $clientID = 0;
        if ($row = mysqli_fetch_row($result)) {
            $clientID = $row[0];
        }
        $ClientOBJ = new Client($conn, $clientID); //TODO SEE THE OTHER TODO IN CLIENT THEY ARE LINKED, MIGHT WANT TO REMOVE $CONN IN HERE ON MERGE
        $this->BranchClient = $ClientOBJ;
    }

    public function  instantiateOwnBankAcc($conn)
    {
        $this->instantiateOwnClient($conn);
        $clientInstance = $this->BranchClient;
        $clientID = $clientInstance->getID();
        $sql = "SELECT * FROM Account WHERE client_id = '$clientID'";
        $result = $conn->query($sql);
        $ACCID = 0;
        if ($row = mysqli_fetch_row($result)) {
            $ACCID = $row[0];
        }
        $tempbranchACC = Accounts::generateInstancedAccountByID($conn,$ACCID);
        $this->BranchAccount = $tempbranchACC;
    }

    public function generateEmployeeIDList($conn)
    {
        $sql = "SELECT * FROM Employee WHERE branch_id = '$this->ID'";
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
        $sql = "SELECT * FROM Client WHERE branch_id = '$this->ID' and lastname <> 'Branch'";
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
            $sql = "SELECT * FROM Account WHERE client_id = '$clientList[$i]' and account_type <> 'Branch'";
            $result = $conn->query($sql);

            while ($row = mysqli_fetch_row($result)) {

                $tempAccList[$accListIndex] = $row[0];
                $accListIndex++;
            }
        }

        $this->setAccountIDList($tempAccList);
    }

    public function instantiateAccountObjList($conn)
    {
        $AccountIDList = $this->getAccountIDList();
        for($i = 0; $i < count($AccountIDList) ;$i++)
        {
            $this->AccountOBJList[$i] = Accounts::generateInstancedAccountByID($conn,$AccountIDList[$i]);
        }

    }

    /*
     *
     * ------------List Display for Accounts in Branch ----------
     *
     */

    public function displayAccountsOBJList()
    {
        for($i = 0; $i < count($this->AccountOBJList) ;$i++)
        {
            echo"</br>";
            $this->AccountOBJList[$i]->toString();
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

    /**
     * @return mixed
     */
    public function getBranchClient()
    {
        return $this->BranchClient;
    }

    /**
     * @param mixed $BranchClient
     */
    public function setBranchClient($BranchClient)
    {
        $this->BranchClient = $BranchClient;
    }

    /**
     * @return mixed
     */
    public function getBranchAccount()
    {
        return $this->BranchAccount;
    }

    /**
     * @param mixed $BranchAccount
     */
    public function setBranchAccount($BranchAccount)
    {
        $this->BranchAccount = $BranchAccount;
    }

    /**
     * @return mixed
     */
    public function getAccountOBJList()
    {
        return $this->AccountOBJList;
    }

    /**
     * @param mixed $AccountOBJList
     */
    public function setAccountOBJList($AccountOBJList)
    {
        $this->AccountOBJList = $AccountOBJList;
    }






}
