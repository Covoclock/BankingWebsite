<?php
session_start();
include_once "credentialCheck.php";
include_once "permissionCheck.php";
verifySession($dbc, "client");
include_once "part2/Client.php";
include_once "part2/Domain_Logic.php";
//var_dump($dbc);
include "navbar.php";

include_once "billCreationConstant.php"; // Defines the number of max bills to be created at the same time

if(isset($_SESSION['user_id'])){
	$client =  new Client($dbc, $_SESSION['user_id']);
	$accounts = $client->getAccountList();
}else{
	//client id not set in session properly
	header("Location: index.php");
}

// Creates all the inputs for the bills
function loopCreationBills(){
	global $accounts;
	for ($i=1; $i<=MAX_BILLS; $i++){
		echo "<div class='form-row'>";
		echo "<div class='col'>";
		echo "Sender Account ID: <select  name='senderAccount_{$i}'>";
		for ($x=0; $x<count($accounts); $x++){
			echo "<option>{$accounts[$x]->getID()}";
			echo "</option>";	
		}
		echo "</select>";
		echo "</div>";

		echo "<div class='col'>";
    		echo "Recepient Account ID: <input type='number' step='1' min='1' name='recipientAccount_$i'>";
		echo "</div>";

		echo "<div class='col'>";
		echo "Bill Amount: <input type='number' step='0.01' min='0' name='billAmount_$i'></p>";
		echo "</div>";

		echo "</div>";
	}
}

?>

 <!DOCTYPE html>
    <html>

    <head>
        <title>Client Hub</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    </head>

    <body>
		<?php echo navbar();?>

        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
            
            .form-signin {
                max-width: 300px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
                -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
                box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            }
            
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }
        </style>
        <link href="css/bootstrap-responsive.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
        <![endif]-->

	<h1 class='text-center'> Client Hub </h1>
	<div class='container'>
	<?php echo "<h2>Client Info</h2><p> {$client}</p>"; ?>
	</div>


	<hr>
	<div class='container'>
	<h2> Accounts Info </h2>

	<form method='post' action='Specific_Account_Page.php'>
		<table class="table">
		  <thead class='thead-dark'>
		    <tr>
		      <th scope="col">Select</th>
		      <th scope="col">Account Number</th>
		      <th scope="col">Level</th>
		      <th scope="col">Balance</th>
		    </tr>
		  </thead>
		  <tbody>
		<?php
		
			for ($i=0; $i<count($accounts); $i++){
				echo "<tr>";
				echo "<td style='text-align:center' scope='row'><input type='radio' class='form-check-input' name='accountID' value='{$accounts[$i]->getID()}'";
				if($i==0) echo " checked='checked'";
				echo "></td>";
				echo "<td>{$accounts[$i]->getID()}</td>";
				$accountLevel = ucwords($accounts[$i]->getLevel());
				echo "<td>{$accountLevel}</td>";
				echo "<td>{$accounts[$i]->getBalance()}$</td>";
				echo "</tr>";	
			}
		?>
		  </tbody>
		</table>
	<button type='submit' class='btn btn-primary'>See Account</button>
	</form>

	<br>
    	<h3>Transfer Money</h3>
	<div class='center-block'>
    	<form class='form-inline' action="withinTransfer.php" method="post">
	<div class='row'>
		<div class='col'>
		<label>From</label>
		<select class='form-control' name='account1'>
		<?php
			for ($i=0; $i<count($accounts); $i++){
				echo "<option>{$accounts[$i]->getID()}";
				echo "</option>";	
			}
		?>
		</select>
		</div>
		<div class='col'>
		<label>To</label>
		<input type='text' name='account2'>
		<!-- <select class='form-control' name='account2'>
		<?php
			//for ($i=0; $i<count($accounts); $i++){
			//	echo "<option>{$accounts[$i]->getID()}";
			//	echo "</option>";	
			//}
		?>
		</select>
		-->
		</div>

		<div class='col'>
		<label>Amount</label>
		<input type='number' step='0.01' min='0' name='amount' placeholder='XXX.XX$'>
		</div>

		<div class='col'>
		<label><input type='radio' class='form-check-input' checked name='transferType' value='id'>ID</label>
		<label><input type='radio' class='form-check-input' name='transferType' value='email'>Email</label>
		<label><input type='radio' class='form-check-input' name='transferType' value='phone'>Phone</label>
		</div>
	</div>
	<div class='row'>
		<button type='submit' class='btn btn-primary'>Move that dough</button>
	</div>
    	</form>
	</div>
	</div>

	<hr>
	<div class='container'>
	<h2>Bills</h2>
		<h3>View Bills</h3>
		  <table class="table">
		    <thead class='thead-dark'>
		      <tr>
		        <th scope="col">Bill ID</th>
		        <th scope="col">From</th>
		        <th scope="col">To</th>
		        <th scope="col">Amount</th>
		        <th scope="col">Recurring</th>
		      </tr>
		    </thead>
		    <tbody>
			<?php
				// For all accounts, search if bills tied to it
		
				for ($i=0; $i<count($accounts); $i++){
					// Search for bills
					$query = "SELECT * FROM Bills WHERE account1_id = {$accounts[$i]->getID()}";
					if($result = $dbc->query($query)){
						while($row = $result->fetch_assoc()){
							echo "<tr>";
							echo "<th scope='row'>{$row['bill_id']}</th>";
							echo "<td>{$row['account1_id']}</td>";
							echo "<td>{$row['account2_id']}</td>";
							echo "<td>{$row['amount']}$</td>";
							echo "<td>";
							if($row['recurring']=='1') echo "Yes";
							else echo "No";
							echo "</td></tr>";	
						}
					}	
				}
			?>
		   </tbody>
		</table>
		
	<h3>Setup Bills</h3>
    		<form action="billCreation.php" method="post">
    		<?php loopCreationBills(); ?>
    		<p><input type="checkbox" name="recurringBills" value="1">Bill(s) Recurring</p>
    		<button type="submit" class='btn btn-primary' >Submit New Bills</button>
    		</form>
	</div>
	
	<hr>
	<!-- Need to list all client accounts -->

            <!-- Le javascript
        ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
            <script src="js/jquery.js"></script>
            <!--
	<script src="js/bootstrap-transition.js"></script>
        <script src="js/bootstrap-alert.js"></script>
        <script src="js/bootstrap-modal.js"></script>
        <script src="js/bootstrap-dropdown.js"></script>
        <script src="js/bootstrap-scrollspy.js"></script>
        <script src="js/bootstrap-tab.js"></script>
        <script src="js/bootstrap-tooltip.js"></script>
        <script src="js/bootstrap-popover.js"></script>
        <script src="js/bootstrap-button.js"></script>
        <script src="js/bootstrap-collapse.js"></script>
        <script src="js/bootstrap-carousel.js"></script>
        <script src="js/bootstrap-typeahead.js"></script>
	-->

	<?php mysqli_close($dbc);?>
        </body>

    </html>

