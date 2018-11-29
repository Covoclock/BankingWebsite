<?php

function navbar(){
	$s = "<nav class='navbar'>
  		<div class='container-fluid'>
  		  <ul class='navbar-nav nav'>
  		    <li class='nav-item active'>
  		      <a class='nav-link' href='/index.php'>Home <span class='sr-only'></span></a>
  		    </li>
  		    <li class='nav-item'>
  		      <a class='nav-link' href='/client_hub.php'>Client Hub</a>
  		    </li>
  		    <li class='nav-item'>
  		      <a class='nav-link ' href='/Admin/admin_hub.php'>Admin Hub</a>
  		    </li>
  		  </ul>
  		</Div>
	     </nav>";
	return $s;
}

?>
