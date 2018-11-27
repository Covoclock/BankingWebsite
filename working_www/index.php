<?php
	session_start();
	include "navbar.php";

?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>COMP 353 - Database</title>
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


		<?php echo navbar();?>

            <div class="container">

                <form class="form-signin" method='post' action='clientLoging.php'>
                    <h2 class="form-signin-heading">Bank Signin Page</h2>
                    <input type="text" class="input-block-level" name='userInfo' placeholder="User ID">
                    <input type="password" class="input-block-level" name='password' placeholder="Password">
                    <fieldset class='from-group'>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type='radio' class='form-check-input' name='type' value='client' checked='checked'>Client</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type='radio' class='form-check-input' name='type' value='employee'>Employee</label>
                        </div>
                    </fieldset>
                    <button class="btn btn-large btn-primary" type="submit">Sign in</button>
                </form>
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

        </body>

    </html>
