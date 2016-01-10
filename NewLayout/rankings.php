<?php
session_start();
include_once 'dbconnect.php';
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
	$email = mysql_real_escape_string($_POST['email']);
	$upass = mysql_real_escape_string($_POST['pass']);
	$res=mysql_query("SELECT * FROM users WHERE email='$email'");
	$row=mysql_fetch_array($res);
	
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
		<title>Unofficial Rankings | Ping Pong Rankings</title>
		<link rel="stylesheet" media="(min-width: 1000px)" href="css/defaultview.css" />
		<link rel="stylesheet" media="(max-width: 999px)" href="css/mobileview.css" />
		<link rel="shortcut icon" href="images/favicon.ico">
		<link rel="icon" sizes="192x192" href="images/highres.png">
		<script src="js/modernizr.custom.js"></script>
	</head>
	<body class="cbp-spmenu-push">
	<div id="mobile-wrapper">
		<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<div class="loggedin-mobile">
				<?php
					$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
					$userRow=mysql_fetch_array($res);
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
				<a href="index.php">Log in/Sign up</a>
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
				<div id="headline"><h3 style="font-size: .9em;">Unofficial Ping Pong Rankings</h3></div>
				<table style="margin-bottom: 20px; margin-top: 20px;"  align="center" border="1">
					<tr>
					<th>NAME</th>
					<th>W</th>
					<th>L</th>
					<th>PF</th>
					<th>PA</th>
					<th>RANK</th>
					<!-- <th>Ranking</th> -->
					</tr>
						<?php
							$res=mysql_query("SELECT  username,
										SUM(wins),
										SUM(loss),
										SUM(PF),
										SUM(PA),
										elo
									    FROM (
										(SELECT users.user_ID,
											users.username AS username,
											COUNT(games.WinnerID) AS wins,
											0 AS loss,
											SUM(games.PointsFor) AS PF,
											SUM(games.PointsAgainst) AS PA,
											users.Elo AS elo
										FROM users, games
										WHERE games.WinnerID = users.user_ID
										GROUP BY users.user_ID)
										UNION ALL
										(SELECT users.user_ID,
										    users.username AS username,
										    0 AS wins,
										    COUNT(games.LoserID) AS loss,
										    SUM(games.PointsAgainst) AS PF,
										    SUM(games.PointsFor) AS PA,
										    users.Elo AS elo
										FROM users, games
										WHERE games.LoserID = users.user_ID
										GROUP BY users.user_ID)
									    ) AS t
									    GROUP BY username
									    ORDER BY elo desc;");
							while($row=mysql_fetch_array($res))
							{
							 ?>
							    <tr>
							    <td style="text-align: center;"><p><?php echo $row['username']; ?></p></td>
							    <td style="text-align: center;"><p><?php echo $row['SUM(wins)']; ?></p></td>
							    <td style="text-align: center;"><p><?php echo $row['SUM(loss)']; ?></p></td>
							    <td style="text-align: center;"><p><?php echo $row['SUM(PF)']; ?></p></td>
							    <td style="text-align: center;"><p><?php echo $row['SUM(PA)']; ?></p></td>
							    <td style="text-align: center;"><p><?php echo $row['elo']; ?></p></td>
							    </tr>
							    <?php
							}
						?>
					</table>
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
			    $res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
			    $userRow=mysql_fetch_array($res);
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
                <div id="headline"><h3 style="font-size: .9em; margin-top: -15px;">These are the Ping Pong Rankings</h3></div>
                <table style="margin-bottom: 20px; margin-top: 20px;" align="center" border="1" width="90%">
				<tr>
				<th>Username</th>
				<th>Wins</th>
				<th>Losses</th>
				<th>Points For</th>
				<th>Points Against</th>
				<th>Ranking</th>
				</tr>
					<?php
						$res=mysql_query("SELECT  username,
									SUM(wins),
									SUM(loss),
									SUM(PF),
									SUM(PA),
									elo
								    FROM (
									(SELECT users.user_ID,
										users.username AS username,
										COUNT(games.WinnerID) AS wins,
										0 AS loss,
										SUM(games.PointsFor) AS PF,
										SUM(games.PointsAgainst) AS PA,
										users.Elo AS elo
									FROM users, games
									WHERE games.WinnerID = users.user_ID
									GROUP BY users.user_ID)
									UNION ALL
									(SELECT users.user_ID,
									    users.username AS username,
									    0 AS wins,
									    COUNT(games.LoserID) AS loss,
									    SUM(games.PointsAgainst) AS PF,
									    SUM(games.PointsFor) AS PA,
									    users.Elo AS elo
									FROM users, games
									WHERE games.LoserID = users.user_ID
									GROUP BY users.user_ID)
								    ) AS t
								    GROUP BY username
								    ORDER BY elo desc;");
						while($row=mysql_fetch_array($res))
						{
						 ?>
						    <tr>
						    <td style="text-align: center;"><p><?php echo $row['username']; ?></p></td>
						    <td style="text-align: center;"><p><?php echo $row['SUM(wins)']; ?></p></td>
						    <td style="text-align: center;"><p><?php echo $row['SUM(loss)']; ?></p></td>
						    <td style="text-align: center;"><p><?php echo $row['SUM(PF)']; ?></p></td>
						    <td style="text-align: center;"><p><?php echo $row['SUM(PA)']; ?></p></td>
						    <td style="text-align: center;"><p><?php echo $row['elo']; ?></p></td>
						    </tr>
						    <?php
						}
					?>
				</table>
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
