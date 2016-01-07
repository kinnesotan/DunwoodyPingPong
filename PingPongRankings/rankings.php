<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
	//header("Location: index.php");
	?>
	<style type="text/css">#loginfields{
	display:none;
	}</style>
	<?php
}
else
{
	?>
	<style type="text/css">#loginfields2{
	display:none;
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
		header("Location: home.php");
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
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Official Rankings | Dunwoody Ping Pong</title>
        <link rel="stylesheet" media="(min-width: 1000px)" href="main.css" />
	<link rel="stylesheet" media="(max-width: 999px)" href="mobile/style.css" />
        <link rel="shortcut icon" href="http://www.dunwoody.edu/wp-content/themes/dunwoody/images/favicon.ico">
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
		<div id="loginfields">
			<?php
				$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
				$userRow=mysql_fetch_array($res);
			?>
			<span id="loggedin">Hi <?php echo $userRow['username']; ?>: <span id="logout"><a href="logout.php?logout">Sign Out</a></span></span>
                </div>
		<div id="loginfields2">
			<form action="index.php">
			    <input  class="login-button" type="submit" value="LOG IN">
			</form>
		</div>
	    </div>
	  </div>
	<script src="mobile/jquery-1.11.3.js"></script>
	<script src="mobile/app.js"></script>
	<!-- Top bar body -->
	
	<!-- Main body -->
		
		<div class="main" >
			
			<h1 style="text-align: center; font-weight:bold; padding-top: 30px;">Official Rankings</h1>
			<table style="margin-bottom: 20px;"  align="center" border="1" width="90%">
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
			<footer>
	    <div id="footer">
		<h4>Dunwoody Ping Pong</h4>
		818 Dunwoody Blvd | Minneapolis, MN 55403
		<br>
		Email: kinmatw@dunwoody.edu | kinandd@dunwoody.edu
	    </div>
	</footer>
		</div>
	<!-- Main body -->
	</div>
</div>     
<!-- MOBILE CONTENT ENDS HERE -->  
        <div id="wrapper">
            <div id="login">
                <div id="loginfields">
			<?php
				$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
				$userRow=mysql_fetch_array($res);
			?>
			<span id="loggedin">Hi <?php echo $userRow['username']; ?>: &nbsp;&nbsp;<span id="logout"><a href="logout.php?logout">Sign Out</a></span></span>
                </div>
		<div id="loginfields2">
			<form method="post">
				<input type="text" name="email" placeholder="Your Email" required />&nbsp;&nbsp;
				<input type="password" name="pass" placeholder="Your Password" required />&nbsp;&nbsp;
				<input  class="login-button" name="btn-login" type="submit" value="LOG IN">
				<br />
				<span id="register" ><a href="register.php">Not a member yet? Sign up here!</a></span>
			</form>
		</div>
            </div>
            
            
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
			    <br>
			        <div id="headline">
				    <h3>These are the official Dunwoody Ping Pong Rankings</h3>
			        </div>
			        <h1 style="text-align: center; font-weight:bold;">Official Rankings</h1>
				<table style="margin-bottom: 20px;" align="center" border="1" width="90%">
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
	</div>
</body>
</html>