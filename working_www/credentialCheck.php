<?php
// Constant values for DB
DEFINE( 'DB_HOST', 'tdc353.encs.concordia.ca');
DEFINE( 'DB_USER', 'tdc353_2');
DEFINE( 'DB_PASSWORD', '1yfja853');
DEFINE( 'DB_NAME', 'tdc353_2');

// Attempt to make connection with SQL server
try{
	$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
}catch(PDOException $e){
	die("Connection failed: " + $e->getMessage());
}
 

//$result = mysqli_query($dbc, 'SELECT * FROM Client;');
//
//if ($result->num_rows > 0) {
//    while ($row = mysqli_fetch_row($result)){
//        printf("%s\t%s\t%s\t%s\t%s<br>", $row[0], $row[1], $row[2], $row[3], $row[4]);
//    }
//}
?>

