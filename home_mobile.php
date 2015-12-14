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
        <title>Official Dunwoody Ping Pong</title>
        <link rel="stylesheet" href="main_mobile.css" type="text/css" />
        <link rel="shortcut icon" href="http://www.dunwoody.edu/wp-content/themes/dunwoody/images/favicon.ico">
    </head>
<body>
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
				<button type="submit" name="btn-login">Sign In</button>
				<br />
				<span id="register" ><a href="register.php">Not a member yet? Sign up here!</a></span>
			</form>
		</div>
            </div>
            
            </div>
            <header></header>
            
            <!-- Navigation starts here -->
            <nav>
                <ul class="navigation">
					<li><a href="home.php">Home</a></li>
					<li><a href="rankings.php">Rankings</a></li>
					<li><a href="enterscores.php">Scores</a></li>
					<li><a href="aboutus.php">About</a></li>
                </ul>
            </nav>
			
            <!-- Navigation ends here -->
            
            <!-- Main content starts here -->
            <div id="main">
			    <br>
			        <div id="headline">
				    <h3>Welcome to the official Dunwoody Ping Pong Website</h3>
			        </div>
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
						<h1 style="font-weight: bold; text-align: center; font-weight: bold; font-size: 2.8em; margin: 5px auto -15px auto;">
							Official Dunwoody Ping Pong Rules
						</h1>
						<h1 style="font-weight: bold; margin-left: 15px;">Serving:</h1>
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
						
						<h1 style="font-weight: bold; margin-left: 15px;">Scoring:</h1>
						<p class="mainpara">
						A match is played best 2 of 3 games. For each game, the first player to reach 21
						points wins that game, however a game must be won by at least a two point margin.
						A point is scored after each ball is put into play (not just when the server
						wins the point as in volleyball).
						</p>
						<h1 style="font-weight: bold; margin-left: 15px;">Flow of game:</h1>
						<p class="mainpara">
						Each player serves five points in a row and then switch server. However, if a score
						of 20-20 is reached in any game, then each server serves only one point and then
						the server is switched.
						</p>	
					</div>
					<p>
					CURRENT TOP PLAYER
					</p>
					<!--Code currently prints the player based on username, in the future the greatest score will be used instead -->
					
					<?php
						$res =
							  mysql_query("SELECT username FROM users WHERE user_id=1 LIMIT 1")
								or die(mysql_error());

							if( $row = mysql_fetch_array($res, MYSQL_ASSOC) )
							{
								
							  $username = $row['username'];
							  echo $username;
							}
							else
							{
							  // No records matched query.
							}
					?> 
					</div>
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
