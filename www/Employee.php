<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/28/2018
 * Time: 2:39 PM
 */

class Employee
{
    private $employee_id;
    private $firstName;
    private $lastName;
    private $addr;
    private $start_date;
    private $wage;
    private $email;
    private $branch_id;

    /**
     * Employee constructor.
     * @param $employee_id
     */
    public function __construct($dbc, $employee_id)
    {
        $sql = "SELECT * FROM Employee WHERE employee_id = '$employee_id'";
        if($result = $dbc->query($sql)) {
            $row = $result->fetch_assoc();
            if ($row) {
                $this->employee_id = $employee_id;
                $this->firstName = $row['firstName'];
                $this->lastName = $row['lastName'];
                $this->addr = $row['addr'];
                $this->start_date = $row['start_date'];
                $this->wage = $row['wage'];
                $this->email = $row['email'];
                $this->branch_id = $row['branch_id'];
            }
        }
    }

    public function getPayedSince($dbc, $aPreviousDate)
    {
        $currentDate = strtotime(Date("y-m-d"));
        $aPreviousDate = strtotime($aPreviousDate);
        $wageSince = 0;
        if( $currentDate < $aPreviousDate )
        {
            echo "Invalid date";
        }
        else {
            $emID = $this->getEmployeeId();
            $sql = "SELECT * FROM Schedule WHERE employee_id = '$emID'";
            $result = $dbc->query($sql);
            while($row = $result->fetch_assoc())
            {
                $workDate = strtotime(date($row['work_date']));
                if($workDate < $currentDate && $workDate > $aPreviousDate )
                {
                    if($row["isHoliday"] == 0)
                    {
                        $wageSince += $this->getWage() * ($row['hour_end'] - $row['hour_begin'])*2;
                    }
                    else {
                        $wageSince += $this->getWage() * ($row['hour_end'] - $row['hour_begin']);
                    }
                }
            }
            return $wageSince;
        }
    }

    public function getPayedInterval($dbc, $aPreviousDate, $aLessPreviousDate)
    {
        $aPreviousDate = strtotime($aPreviousDate);
        $aLessPreviousDate = strtotime($aLessPreviousDate);
        $wageSince = 0;
        if( $aLessPreviousDate < $aPreviousDate )
        {
            echo "Invalid date";
        }
        else {
            $emID = $this->getEmployeeId();
            $sql = "SELECT * FROM Schedule WHERE employee_id = '$emID'";
            $result = $dbc->query($sql);
            while($row = $result->fetch_assoc())
            {
                $workDate = strtotime(date($row['work_date']));
                if($workDate < $aLessPreviousDate && $workDate > $aPreviousDate )
                {
                    if($row["isHoliday"] == 0)
                    {
                        $wageSince += $this->getWage() * ($row['hour_end'] - $row['hour_begin'])*2;
                    }
                    else {
                        $wageSince += $this->getWage() * ($row['hour_end'] - $row['hour_begin']);
                    }
                }
            }
            return $wageSince;
        }
    }



    /**
     * @return mixed
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * @param mixed $employee_id
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getAddr()
    {
        return $this->addr;
    }

    /**
     * @param mixed $addr
     */
    public function setAddr($addr)
    {
        $this->addr = $addr;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getWage()
    {
        return $this->wage;
    }

    /**
     * @param mixed $wage
     */
    public function setWage($wage)
    {
        $this->wage = $wage;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getBranchId()
    {
        return $this->branch_id;
    }

    /**
     * @param mixed $branch_id
     */
    public function setBranchId($branch_id)
    {
        $this->branch_id = $branch_id;
    }








}