<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
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
        <title>Official Dunwoody Ping Pong | Log in</title>
        <link rel="stylesheet" href="main_mobile.css" type="text/css" />
        <link rel="shortcut icon" href="http://www.dunwoody.edu/wp-content/themes/dunwoody/images/favicon.ico">
    </head>
<body>
        <div id="wrapper">
            <div id="login">
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
				    <h3>Please enter your login information</h3>
			        </div>
				
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
					<td><a href="register.php">Sign Up Here</a></td>
					</tr>
					</table>
				</form>
			        
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
