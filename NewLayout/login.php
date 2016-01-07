<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: index.php");
}

if(isset($_POST['btn-login']))
{
	$email = mysql_real_escape_string($_POST['email']);
	$upass = mysql_real_escape_string($_POST['pass']);
	$res=mysql_query("SELECT * FROM users WHERE email='$email'");
	$row=mysql_fetch_array($res);
	
	if($row['password']==md5($upass))
	{
		$_SESSION['user'] = $row['user_id'];
		header("Location: enterscores.php");
	}
	else
	{
		?>
        <script>alert('wrong details');</script>
        <?php
	}
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" class="no-js">
	<head>
		<meta name="theme-color" content="#a31929">
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Login | Ping Pong Rankings</title>
		<link rel="stylesheet" media="(min-width: 1000px)" href="css/defaultview.css" />
		<link rel="stylesheet" media="(max-width: 999px)" href="css/mobileview.css" />
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="icon" sizes="192x192" href="images/highres.png">
		<script src="js/modernizr.custom.js"></script>
	</head>
	<body class="cbp-spmenu-push">
	<div id="mobile-wrapper">
		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<a href="index.php">Home</a>
			<a href="rankings.php">Rankings</a>
			<a href="enterscores.php">Enter Scores</a>
			<a href="aboutus.php">About Us</a>
		</nav>
		
		<div class="container">
			<div id="top-bar"><div id="shownav"><img src="images/menu-icon.png" width="35" height="35"></div></div>
			<div id="header">
				<div id="center-header">
				    <div class="logo">
					<img src="images/logo.png"  alt="Ping Ping logo">
				    </div>
				    <div id="logo-text">
					Ping Pong Rankings
				    </div>
				    <div class="logo">
					<img src="images/logo.png"  alt="Ping Ping logo">
				    </div>
				</div>
			</div>
			<div class="main">
				<div id="headline"><h3 style="font-size: .9em;">Welcome to Ping Pong Rankings</h3></div>
				        <form method="post">
					<table align="center" width="100%" border="0">
					<tr>
					<td><input type="text" name="email" placeholder="Your Email" required /></td>
					</tr>
					<tr>
					<td><input type="password" name="pass" placeholder="Your Password" required /></td>
					</tr>
					<tr>
					<td><button type="submit" name="btn-login">Sign In</button></td>
					</tr>
					<tr>
					<td style="text-align:center;"><a href="register.php">Not registered? Sign Up Here</a></td>
					</tr>
					</table>
				</form>
			    </div>
			    <div id="footer">
				<div id="footer-content">
				    <h4>Dunwoody Ping Pong</h4>
				    818 Dunwoody Blvd | Minneapolis, MN 55403
				    <br>
				    Email: kinmatw@dunwoody.edu | kinandd@dunwoody.edu
				</div>
			    </div>
			</div>
		</div>
		<!-- Classie - class helper functions by @desandro https://github.com/desandro/classie -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'shownav' ),	
				body = document.body;

			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
		</script>
		
		
        </div>
<!-- MOBILE CONTENT ENDS HERE -->		
<!-- MAIN CONTENT STARTS HERE -->
    <div id="main-wrapper">
        <div id="top-bar">
            
        </div>
        <div id="main-layout">
            <div id="header">
                <div id="center-header">
                    <div class="logo">
                        <img src="images/logo.png"  alt="Ping Ping logo">
                    </div>
                    <div id="logo-text">
                        Ping Pong Rankings
                    </div>
                    <div class="logo">
                        <img src="images/logo.png"  alt="Ping Ping logo">
                    </div>
                </div>
            </div>
            <div id="nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="rankings.php">Ranking</a></li>
                    <li><a href="enterscores.php">Enter Scores</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                </ul>
            </div>
            <div id="main">
                <div id="headline"><h3 style="font-size: .9em; margin-top: -15px;">Enter your login information</h3></div>
                <form method="post">
			<table align="center" width="30%" border="0">
			<tr>
			<td><input type="text" name="email" placeholder="Your Email" required /></td>
			</tr>
			<tr>
			<td><input type="password" name="pass" placeholder="Your Password" required /></td>
			</tr>
			<tr>
			<td><button type="submit" name="btn-login">Sign In</button></td>
			</tr>
			<tr>
			<td style="text-align:center;"><a href="register.php">Not registered? Sign Up Here</a></td>
			</tr>
			</table>
		</form>
            </div>
            <div id="footer">
                <div id="footer-content">
                    <h4>Dunwoody Ping Pong</h4>
                    818 Dunwoody Blvd | Minneapolis, MN 55403
                    <br>
                    Email: kinmatw@dunwoody.edu | kinandd@dunwoody.edu
                </div>
            </div>
        </div>
        
    </div>
<!-- MAIN CONTENT ENDS HERE -->
	</body>
</html>
