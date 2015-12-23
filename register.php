<?php
session_start();
if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}
include_once 'dbconnect.php';

if(isset($_POST['btn-signup']))
{
	$uname = mysql_real_escape_string($_POST['uname']);
	$email = mysql_real_escape_string($_POST['email']);
	$upass = md5(mysql_real_escape_string($_POST['pass']));
	
	if(mysql_query("INSERT INTO users(username,email,password) VALUES('$uname','$email','$upass')"))
	{
		?>
        <script>alert('You successfully registered ');</script>
        <?php
	}
	else
	{
		?>
        <script>alert('There was an error while registering you...');</script>
        <?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1" runat="server">
    <title>Dunwoody Ping Pong Registration</title>
    <link rel="stylesheet" media="(min-width: 1000px)" href="main.css" />
	<link rel="stylesheet" media="(max-width: 999px)" href="mobile/style.css" />
    <link rel="shortcut icon" href="http://www.dunwoody.edu/wp-content/themes/dunwoody/images/favicon.ico">
	<style>
		#main
		{
			margin-top: -15px;
		}
	</style>
	
</head>
	<body>
		
<!-- MOBILE CONTENT STARTS HERE -->
<div class="mobile-view">
	<div class="header"></div> 
	<div class="menu">
	  
	  <!-- Menu icon -->
	  <div class="icon-close">
	    <img src="mobile/close-menu-icon.png" width="38" height="38" alt="menu icon">
	  </div>
    
	  <!-- Menu -->
	  <ul>
	    <li><a href="home.php">Home</a></li>
	    <li><a href="rankings.php">Ranking</a></li>
	    <li><a href="enterscores.php">Enter Scores</a></li>
	    <li><a href="aboutus.php">About Us</a></li>
	  </ul>
	</div>
    
	<!-- Top bar body -->
	<div class="jumbotron">
	  <div class="icon-menu-bar">
	    <div class="icon-menu">
	      <i class="fa fa-bars"></i>
	      <img src="mobile/menu-icon.png" width="38" height="38" alt="menu icon">
	    </div>
	    <div id="login">
		
	    </div>
	  </div>
	<script src="mobile/jquery-1.11.3.js"></script>
	<script src="mobile/app.js"></script>
	<!-- Top bar body -->
	
	<!-- Main body -->
		<div class="main" style="position: absolute;">
			<div id="headline"><h3>Sign up for the Offical Dunwoody Ping Pong site</h3></div>
			 <form method="post">
				    <table align="center" width="80%" border="0">
				    <tr>
				    <td><input class="login-index" type="text" name="uname" placeholder="User Name" required /></td>
				    </tr>
				    <tr>
				    <td><input class="login-index" type="email" name="email" placeholder="Your Email" required /></td>
				    </tr>
				    <tr>
				    <td><input class="login-index" type="password" name="pass" placeholder="Your Password" required /></td>
				    </tr>
				    <tr>
				    <td><input  class="login-button-index" name="btn-signup" type="submit" value="Sign Me Up"></td>
				    </tr>
				    <tr>
				    <td><a href="index.php">Sign In Here</a></td>
				    </tr>
				    </table>
			 </form>
		</div>
		
	<!-- Main body -->
	<div class="space">
		
	</div>
	</div>
</div>     
<!-- MOBILE CONTENT ENDS HERE -->  
		<div id="wrapper">
			<div id="login">
			<div id="loginfields"></div></div>
			<header></header>
			
			<!-- Navigation starts here -->
			<nav>
			    <ul class="navigation">
				<li><a href="home.php">Home</a></li>
				<li><a href="rankings.php">Rankings</a></li>
				<li><a href="enterscores.php">Enter Scores</a></li>
				<li><a href="aboutus.php">About</a></li>
			    </ul>
			</nav>
				    
			<!-- Navigation ends here -->
			
			<!-- Main content starts here -->
			<div id="main">
			    <br />
			    <div id="headline"><h3>Sign up for the Offical Dunwoody Ping Pong site</h3></div>
			    <center>
			    <div id="login-form">
				    <form method="post">
				    <table align="center" width="30%" border="0">
				    <tr>
				    <td><input type="text" name="uname" placeholder="User Name" required /></td>
				    </tr>
				    <tr>
				    <td><input type="email" name="email" placeholder="Your Email" required /></td>
				    </tr>
				    <tr>
				    <td><input type="password" name="pass" placeholder="Your Password" required /></td>
				    </tr>
				    <tr>
				    <td><button type="submit" name="btn-signup">Sign Me Up</button></td>
				    </tr>
				    <tr>
				    <td><a href="index.php">Sign In Here</a></td>
				    </tr>
				    </table>
				    </form>
			    </div>
			    </center>          
			</div>
			
			<!-- Main content ends here -->
		    
			<!-- footer starts here -->
			<footer>
			    <div id="footer">
				<h4>Dunwoody Ping Pong</h4>
				818 Dunwoody Blvd | Minneapolis, MN 55403
				<br>
				Email: kinmatw@dunwoody.edu | kinandd@dunwoody.edu
			    </div>
			</footer>
			<!-- footer ends here -->
		</div>
	</body>
</html>
