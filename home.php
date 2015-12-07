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
        <link rel="stylesheet" href="main.css" type="text/css" />
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
			<li><a href="enterscores.php">Enter Scores</a></li>
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
