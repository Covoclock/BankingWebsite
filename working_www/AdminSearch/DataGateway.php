<?php
/**
 * Created by PhpStorm.
 * User: joedu
 * Date: 11/16/2018
 * Time: 5:41 PM
 */

function getDBConnection ()
{

    $conn = mysqli_connect('localhost', 'root', '', 'tdc353_2');
    if (!$conn) {

        die("Connection failed: " . mysqli_connect_error());

    }

    return $conn;
}

function delete()
{

}

function update()
{

}

?>