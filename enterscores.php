<?php
session_start();
include_once 'dbconnect.php';
include 'elo.php';

if(!isset($_SESSION['user']))
{
	header("Location: index.php");
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
if(isset($_POST['btn-post']))
{
	
	$userscore = mysql_real_escape_string($_POST['userscore']);
	$oppscore = md5(mysql_real_escape_string($_POST['oppscore']));
	
	
	echo $_GET["oppscore"];
	if(mysql_query("INSERT INTO games(winloss,userscore,oppscore) VALUES('$userscore','$oppscore')"))
	{
		?>
		<script>alert('Your scores were successfully entered');</script>
		<?php
	}
	else
	{
		?>
		<script>alert('There was an error while entering your score...');</script>
		<?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Enter your scores | Dunwoody Ping Pong</title>
        <link rel="stylesheet" href="main.css" type="text/css" />
        <link rel="shortcut icon" href="http://www.dunwoody.edu/wp-content/themes/dunwoody/images/favicon.ico">
	<style type="text/css">
		#main
		{
			height: 336px;
		}
	</style>
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
			<h3>Enter your ping pong scores here</h3>
		    </div>
		    <div id="login-form">
			    <form method="post">
				<table align="center" width="30%" border="0">
				<tr>
				<td>
				    Choose your opponent:
				     <select>
					    <?php
						    include 'dbconnect.php';
						    $id = mysql_real_escape_string($_SESSION['user']);
						    //$search = mysql_query("SELECT user_id, username FROM games WHERE user_id!=" + $id);
						    //$search = mysql_query("SELECT user_id FROM users");
						    $search = mysql_query("SELECT username FROM users");
						    $result = mysql_fetch_assoc($search);
						    $totalRows = mysql_num_rows($search);
						    
						    
						    echo $result['user_id'];
						    do {  
							    ?>
							    <option value="<?php echo $result['username'] ?>"<?php if (!(strcmp($result['username'], $result['username']))) {echo "selected=\"selected\"";} ?>><?php echo $result['username']?></option>
							    <?php
						    } while ($result = mysql_fetch_assoc($search));
						      $rows = mysql_num_rows($search);
						      if($rows > 0) {
							  mysql_data_seek($search, 0);
							  $result = mysql_fetch_assoc($search);
						      }
					    ?>
				     </select>	 
				</td>
				</tr>
				<tr>
				<td><input type="text" name="userscore" placeholder="Enter your score" required /></td>
				</tr>
				<tr>
				<td><input type="text" name="oppscore" placeholder="Enter opponent's score" required /></td>
				</tr>
				<tr>
				<td><button type="submit" name="btn-post">Submit</button></td>
				</tr>
				</table>
			    </form>
			    
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