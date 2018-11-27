<?php
session_start();
require "credentialCheck.php";
require "permissionCheck.php";
include "part2/Client.php";
verifySession("client");

if (isset($_SESSION['user_id'])){
	$client =  new Client($dbc, $_SESSION['user_id']);
}else{
	//client id not set in session properly
	header("Location: index.php");
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

        </head>

        <body>
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
			$accounts = $client->getAccounts();
		
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
		<div class='col-2'>
		<label>From</label>
		<select class='form-control' name='account1'>
		<?php
			$accounts = $client->getAccounts();
			for ($i=0; $i<count($accounts); $i++){
				echo "<option>{$accounts[$i]->getID()}";
				echo "</option>";	
			}
		?>
		</select>
		</div>
		<div class='col-2'>
		<label>To</label>
		<select class='form-control' name='account2'>
		<?php
			$accounts = $client->getAccounts();
			for ($i=0; $i<count($accounts); $i++){
				echo "<option>{$accounts[$i]->getID()}";
				echo "</option>";	
			}
		?>
		</select>
		</div>
		<div class='col-3'>
		<label>Amount</label>
		<input type='text' name='amount' placeholder='XXX.XX$'>
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
				$accounts = $client->getAccounts();
		
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

	</div>
	
	<hr>
	<!-- Need to list all client accounts -->

            <div class="container">
                <!-- Testing part -->
                <a href="branch-search.html">Branch Search</a>
                <br>
                <a href="accountPage.php">Account Page</a>
                <br>
                <a href="account_results.php">Account Results</a>
                <br>
                <a href="Admin/account_admin.php">Account Admin</a>
                <br>
                <a href="Admin/admin_hub.php">Admin Hub</a>
                <br>
                <a href="Specific_Account_Page.php">Specific Account</a>
                <br>

            </div>
            <!-- /container -->

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

