<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/18/2018
 * Time: 2:43 PM
 */

include "AdminSearchHelper.php";
include "DataGateway.php";

function GenerateDBQuery()
{
    $domain = $_COOKIE["Domain"];
    $SearchAttribute = $_POST["searchBy"];
    $searchLike = $_POST["searchLike"];
    $searchLike = '%'. $searchLike . '%';
    $conn = getDBConnection();
    //$sql = "SELECT * FROM branch";
    $sql = "SELECT * FROM $domain WHERE '$SearchAttribute' LIKE '$searchLike'";
    $result = mysqli_query($conn, $sql);

    //echo $sql;

    return $result;
}

function GenerateList($result)
{
    $attribArray = SearchDispatcher($_COOKIE["Domain"]);
    $attribCount = count($attribArray);

    while ($row = mysqli_fetch_row($result)) {

        echo "<br /><p>";
        for($i = 0; $i<$attribCount;$i++)
        {
            echo "&emsp;" .$attribArray[i].": ".$row[i];
        }
        echo"</p>";
    }
}