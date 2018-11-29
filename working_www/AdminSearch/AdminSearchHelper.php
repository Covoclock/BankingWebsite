<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/16/2018
 * Time: 2:39 PM
 */

//DATASETS USED TO GENERATE SEARCH FORMS
function setBranchSearch()
{
    return(array("branch_id","province","city","street", "phone","fax","opening_date","manager_id","isHeadOffice"));
}

function setEmployeeSearch()
{
    return(array("Employee_ID","Phone","address","start_date", "wage","email","firstname","lastname"));
}

function setClientSearch()
{
    return(array("client_id","firstname","lastname","city","province","dob","join_date","standing","email","phone","category","branch_id"));
}

function setScheduleSearch()
{
    return(array("employee_id", "work_date", "hour_begin", "hour_end", "isHoliday"));
}

function setAccountSearch()
{
    return(array("account_id", "client_id", "account_type", "chargePlan_id", "balance", "credit_limit","interest_rate","type","lvl","transactionLeft"));
}

function setServiceSearch()
{
    return(array("service_id", "service_name", "manager_id"));
}

function setChargePlanSearch()
{
    return(array("chargePlan_id", "option_name", "draw_limit", "charge_value"));
}

function setTransactionSearch()
{
    return(array("tid", "account1_id", "account2_id", "amount", "dt"));
}

function setBillSearch()
{
    return(array("bill_id","amount","account1_id","account2_id", "recurring"));
}


//Dispatch search
function SearchDispatcher($searchDomain)
{
    switch ($searchDomain) {
        case 'branch':
            setcookie('Domain', 'branch', time() + (86400 * 30), "/");
            return setBranchSearch();
            break;
        case 'employee':
            setcookie('Domain', 'employee', time() + (86400 * 30), "/");
            return setEmployeeSearch();
            break;
        case 'client':
            setcookie('Domain', 'client', time() + (86400 * 30), "/");
            return setClientSearch();
            break;
        case 'schedule':
            setcookie('Domain', 'schedule', time() + (86400 * 30), "/");
            return setScheduleSearch();
            break;
        case 'account':
            setcookie('Domain', 'account', time() + (86400 * 30), "/");
            return setAccountSearch();
            break;
        case 'services':
            setcookie('Domain', 'services', time() + (86400 * 30), "/");
            return setServiceSearch();
            break;
        case 'transactions':
            setcookie('Domain', 'transactions', time() + (86400 * 30), "/");
            return setTransactionSearch();
            break;
        case 'bills':
            setcookie('Domain', 'bills', time() + (86400 * 30), "/");
            return setBillSearch();
            break;
        default:
            echo "An error has occured.";
    }
    return "An error has occured.";
}

function generateDomainSpecificSearchForm($inputField)
{
    $ArrayLength = count($inputField);
    echo '<form action="TemplateResultView.php" method="post">
    <p><strong>Choose Search Type:</strong><br />
    <select name="searchBy">';

    for($i = 0; $i<$ArrayLength;$i++)
    {
        echo '<option value="' . $inputField[$i] . '">'. $inputField[$i]. '</option>';

    }

    echo'</select>
    </p>
        <p><strong>Enter Search Term:</strong><br />
        <input name="searchLike" type="text" size="40"></p>
        <p><input type="submit" name="submit" value="sub"></p>';
}
?>
