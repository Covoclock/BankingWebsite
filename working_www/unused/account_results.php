<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
<h1>Search Results</h1>
<?php

// create short variable names
$searchtype = $_POST['searchtype'];
$searchterm = $_POST['searchterm'];


if (!$searchtype || !$searchterm) {
    echo '<p>You have not entered search details.<br/>
       Please go back and try again2222222.</p>';
    exit;
}

// whitelist the searchtype
switch ($searchtype) {
    case 'account_id':
    case 'client_id':
    case 'account_type':
    case 'account_option':
    case 'balance':
    case 'credit_limit':
    case 'interest_rate':
        break;
    default:
        {echo '<p>That is not a valid search type. <br/>
        Please go back and try again11111111111111.</p>';
            exit;}
}

$db = new mysqli('tdc353.encs.concordia.ca', 'tdc353_2', '1yfja853');
if (mysqli_connect_errno()) {
    echo '<p>Error: Could not connect to database.<br/>
       Please try again later333333333333333.</p>';
    exit;
}

$query = "SELECT * FROM account WHERE $searchtype = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('s', $searchterm);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($account_id, $client_id, $account_type,
    $account_option, $balance, $credit_limit, $interest_rate);

echo "<p>Number of items found: " . $stmt->num_rows . "</p>";

while ($stmt->fetch()) {
    echo "<p><strong>account_id: " . $account_id . "</strong>";
    echo "<br />client_id: " . $client_id;
    echo "<br />account_type: " . $account_type;
    echo "<br />account_option: " . $account_option;
    echo "<br />balance: " . $balance;
    echo "<br />credit_limit: " . $credit_limit;
    echo "<br />interest_rate: " . $interest_rate;
}

$stmt->free_result();
$db->close();
?>
</body>
</html>
