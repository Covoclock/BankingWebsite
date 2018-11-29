<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/25/2018
 * Time: 1:13 AM
 */

include_once "Client.php";
include_once "Employee.php";

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
    private $EmployeeObjList;

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
            $this->generateEmployeeIDList($conn);
            $this->instantiateEmployeeObjList($conn);
        }
        else{
            echo"No valid branch";
        }
    }

    public static function generateListAllBranch($conn)
    {
        $BranchList = array();
        $sql = "SELECT * FROM Branch";
        $result = $conn->query($sql);
        $i = 0;
        while($row = mysqli_fetch_assoc($result))
        {
            $BranchList[$i] = new Branch($conn, $row['branch_id']);
            $i++;
        }
        return $BranchList;
    }

    public static function generateListBranchByCity($conn, $cityName)
    {
        $BranchList = array();
        $sql = "SELECT * FROM Branch WHERE city='$cityName'";
        $result = $conn->query($sql);
        $i = 0;
        while($row = mysqli_fetch_assoc($result))
        {
            $BranchList[$i] = new Branch($conn, $row['branch_id']);
            $i++;
        }
        return $BranchList;
    }

    public static function calculateBranchListProfits($conn, $date1, $date2, $instancedList)
    {
        $branchListProfits = 0;
        for($index = 0; $index < count($instancedList); $index++)
        {
            $tempvar = $instancedList[$index]->calculateProfit($conn, $date1, $date2);
            $branchListProfits += $tempvar;
        }
        return $branchListProfits;
    }



    /*
     *
     * -----------------------------Revenues related methods-----------------------------------------------------------
     *
     */

    public function calculateRevenuesFromChargePlans()
    {
        $revenue = 0;
        for($i =0; $i<count($this->AccountOBJList) ;$i++)
        {
            $revenue += $this->AccountOBJList[$i]->getChargePrice();
        }

        return $revenue;
    }

    public function calculateRevenuesFromTransactions()
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

    public function calculateRevenuesFromCredit()
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


    public function calculateBranchRevenues()
    {
        $totalRevenues = $this->calculateRevenuesFromChargePlans();
        $totalRevenues += $this->calculateRevenuesFromTransactions();
        $totalRevenues += $this->calculateRevenuesFromCredit();
        return $totalRevenues;
    }

    /*
     *
     * -----------------------------cost related methods-----------------------------------------------------------
     *
     */

    public function calculateInterestCost()
    {
        $costs = 0;
        for($i =0; $i<count($this->AccountOBJList) ;$i++)
        {
            if($this->AccountOBJList[$i]->getAccountType() != 'credit')
            {
                $tempBal = $this->AccountOBJList[$i]->getBalance();
                $tempInt = $this->AccountOBJList[$i]->getInterests();
                $tempResults = $tempBal*$tempInt;
                $costs += $tempResults;
            }
        }
        return $costs;
    }

    public function calculateEmployeeCosts($dbc, $date1, $date2)
    {
        $costs = 0;
        $employeeNum = count($this->EmployeeIDList);
        for($i =0; $i< $employeeNum ;$i++)
        {
            $costs += $this->EmployeeObjList[$i]->getPayedInterval($dbc, $date1, $date2);
        }
        return $costs;
    }

    public function calculateCosts($dbc, $date1, $date2)
    {
        $interestCosts = $this->calculateInterestCost();
        $employeeCosts = $this->calculateEmployeeCosts($dbc, $date1, $date2);
        return ($interestCosts + $employeeCosts);
    }


    /*
     *
     * -----------PROFIT CALC--------------
     *
     */

    public function calculateProfit($dbc, $date1, $date2)
    {
        $revenues = $this->calculateBranchRevenues();
        $expanses = $this->calculateCosts($dbc, $date1, $date2);
        return ($revenues - $expanses);
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

    Public function  instantiateOwnBankAcc($conn)
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

    function instantiateEmployeeObjList($conn)
    {
        $employeeNum = count($this->EmployeeIDList);
        for($i =0; $i < $employeeNum ;$i++)
        {
            $this->EmployeeObjList[$i] = new Employee($conn, $this->EmployeeIDList[$i]);
        }
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

    /**
     * @return mixed
     */
    public function getEmployeeObjList()
    {
        return $this->EmployeeObjList;
    }

    /**
     * @param mixed $EmployeeObjList
     */
    public function setEmployeeObjList($EmployeeObjList)
    {
        $this->EmployeeObjList = $EmployeeObjList;
    }






}