<?php
session_start();
include_once 'dbconnect.php';
$config = parse_ini_file('config/config.ini'); 

// Try and connect to the database
$connection = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
if($connection === false) {
    mysqli_connect_error();
    echo "WHOOPS THERE WAS AN ERROR.";
}

if(!isset($_SESSION['user']))
{
	//header("Location: index.php");
	?>
	<style type="text/css">.loggedin-main,.loggedin-mobile{
	display:none;
	}</style>
	<?php
}
else
{
	?>
	<style type="text/css">.loggedout-main,.loggedout-mobile{
	display: none;
	}</style>
	<?php
}
if(isset($_POST['btn-login']))
{
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$upass = mysqli_real_escape_string($connection, $_POST['pass']);
	$res=mysqli_query($connection, "SELECT * FROM users WHERE email='$email'");
	$row=mysqli_fetch_array($res, MYSQLI_BOTH);
	
	if($row['password']==md5($upass))
	{
		$_SESSION['user'] = $row['user_id'];
		header("Location: index.php");
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
		<title>Home | Ping Pong Rankings</title>
		<link rel="stylesheet" media="(min-width: 1000px)" href="css/defaultview.css" />
		<link rel="stylesheet" media="(max-width: 999px)" href="css/mobileview.css" />
		<script src="js/modernizr.custom.js"></script>
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="icon" sizes="192x192" href="images/highres.png">
	</head>
	<body class="cbp-spmenu-push">
	<div id="mobile-wrapper">
		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<div class="loggedin-mobile">
				<?php
					$res=mysqli_query($connectino, "SELECT * FROM users WHERE user_id=".$_SESSION['user']);
					$userRow=mysqli_fetch_array($res, MYSQLI_BOTH);
				?>
				<h3><?php echo $userRow['username']; ?></h3>
			</div>
			<a href="index.php">Home</a>
			<a href="rankings.php">Rankings</a>
			<a href="enterscores.php">Enter Scores</a>
			<a href="aboutus.php">About Us</a>
			<div class="loggedin-mobile">
				<a href="logout.php?logout">Log Out</a>
			</div>
			<div class="loggedout-mobile">
				<a href="login.php">Log in/Sign up</a>
			</div>
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
				<p class="mainpara">
				   This is the official site to keep track of ping pong scores and rankings at
				   Dunwoody College of Technology. You can check the official player rankings
				   of every registered ping pong player at Dunwooody. Enter your scores to try
				   claim the number one ranking.
				   </p>
				   <p class="mainpara">
				   Overall ranking is dependent on wins and losses as well as quality of competition.
				   If you defeat a player ranked higher than you, you will move up. If you lose to
				   someone ranked higher than you, you will not lose rank. Your ranking will move up
				   more when defeating higher quality competition and only slightly when defeating
				   lower quality competition.
				</p>
				<div id="rules">
					<h1 style="font-weight: bold; text-align: center; font-weight: bold; font-size: 2.1em; margin: 5px auto -15px auto;">
						Official Dunwoody Ping Pong Rules
					</h1>
					<h1 style="font-weight: bold; margin-left: 10px;">Serving:</h1>
					<p class="mainpara">
					The ball  must be tossed up at least 6 inches and struck so the ball first bounces
					on the server's side and then the opponent's side.
					<br />
					<br />
					The ball can be served anywhere on the opponents side of the table, meaning it does
					not have to be served diagonally from opposite boxes. The ball can be served from
					any location and be hit straight, diagonally, etc.
					<br />
					<br />
					If the serve is legal except that it touches the net, it is called a let serve.
					Let serves are not scored and are re-served.
					<br />
					<br />
					To determine who serves the ball first, the two players will volly. The ball must be
					hit twice by each person for it to be a valid volly.
					
					<h1 style="font-weight: bold; margin-left: 10px;">Scoring:</h1>
					<p class="mainpara">
					A match is played best 2 of 3 games. For each game, the first player to reach 21
					points wins that game, however a game must be won by at least a two point margin.
					A point is scored after each ball is put into play (not just when the server
					wins the point as in volleyball).
					</p>
					<h1 style="font-weight: bold; margin-left: 10px;">Flow of game:</h1>
					<p class="mainpara">
					Each player serves five points in a row and then switch server. However, if a score
					of 20-20 is reached in any game, then each server serves only one point and then
					the server is switched.
					</p>	
				</div>
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
            <div class="loggedin-main">
		    <?php
			    $res=mysqli_query($connection, "SELECT * FROM users WHERE user_id=".$_SESSION['user']);
			    $userRow=mysqli_fetch_array($res, MYSQLI_BOTH);
		    ?>
		    <span id="loggedin">Hi <?php echo $userRow['username']; ?>: &nbsp;&nbsp;<span id="logout"><a href="logout.php?logout">Sign Out</a></span></span>
	    </div>
	    <div class="loggedout-main">
		    <form method="post">
			    <input type="text" name="email" placeholder="Your Email" required />&nbsp;&nbsp;
			    <input type="password" name="pass" placeholder="Your Password" required />&nbsp;&nbsp;
			    <input  class="login-button" name="btn-login" type="submit" value="LOG IN">
			    <br />
			    <span id="register" ><a href="register.php">Not a member yet? Sign up here!</a></span>
		    </form>
	    </div>
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
                <div id="headline"><h3 style="font-size: .9em; margin-top: -15px;">Welcome to the official Dunwoody Ping Pong Site</h3></div>
                <p class="mainpara">
                   This is the official site to keep track of ping pong scores and rankings at
                   Dunwoody College of Technology. You can check the official player rankings
                   of every registered ping pong player at Dunwooody. Enter your scores to try
                   claim the number one ranking.
                   </p>
                   <p class="mainpara">
                   Overall ranking is dependent on wins and losses as well as quality of competition.
                   If you defeat a player ranked higher than you, you will move up. If you lose to
                   someone ranked higher than you, you will not lose rank. Your ranking will move up
                   more when defeating higher quality competition and only slightly when defeating
                   lower quality competition.
                </p>
                <div id="rules">
                        <h1 style="font-weight: bold; text-align: center; font-weight: bold; font-size: 2.1em; margin: 5px auto -15px auto;">
                                Official Dunwoody Ping Pong Rules
                        </h1>
                        <h1 style="font-weight: bold; margin-left: 10px;">Serving:</h1>
                        <p class="mainpara">
                        The ball  must be tossed up at least 6 inches and struck so the ball first bounces
                        on the server's side and then the opponent's side.
                        <br />
                        <br />
                        The ball can be served anywhere on the opponents side of the table, meaning it does
                        not have to be served diagonally from opposite boxes. The ball can be served from
                        any location and be hit straight, diagonally, etc.
                        <br />
                        <br />
                        If the serve is legal except that it touches the net, it is called a let serve.
                        Let serves are not scored and are re-served.
                        <br />
                        <br />
                        To determine who serves the ball first, the two players will volly. The ball must be
                        hit twice by each person for it to be a valid volly.
                        
                        <h1 style="font-weight: bold; margin-left: 10px;">Scoring:</h1>
                        <p class="mainpara">
                        A match is played best 2 of 3 games. For each game, the first player to reach 21
                        points wins that game, however a game must be won by at least a two point margin.
                        A point is scored after each ball is put into play (not just when the server
                        wins the point as in volleyball).
                        </p>
                        <h1 style="font-weight: bold; margin-left: 10px;">Flow of game:</h1>
                        <p class="mainpara">
                        Each player serves five points in a row and then switch server. However, if a score
                        of 20-20 is reached in any game, then each server serves only one point and then
                        the server is switched.
                        </p>	
                </div>
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
