<?php
session_start();
include_once 'dbconnect.php';
include 'elo.php';
$config = parse_ini_file('config/config.ini'); 

// Try and connect to the database
$connection = mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
if($connection === false) {
    mysqli_connect_error();
    echo "WHOOPS THERE WAS AN ERROR.";
}

if(!isset($_SESSION['user']))
{
	header("Location: login.php");
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
if(isset($_POST['btn-post']))
{
	$opponent = $_POST["opponent"];
	//$opponent = array_key_exists('opponent', $_POST) ? $_POST['opponent'] : false;
	
	$userscore = mysqli_real_escape_string($connection, $_POST['userscore']);
	$oppscore = mysqli_real_escape_string($connection, $_POST['oppscore']);
	
	if($userscore != $oppscore)
	{
		if($userscore > $oppscore)
		{
			$Winner_ID = $_SESSION['user'];
			$query = mysqli_query($connection, "SELECT user_id FROM users WHERE username = '".$opponent."'");
			$result = mysqli_fetch_array($query, MYSQLI_BOTH) or die(mysql_error());
			$Loser_ID = $result['user_id'];
			
			$query1 = mysqli_query($connection, "SELECT Elo FROM users WHERE user_id=".$_SESSION['user']);
			$result1 = mysqli_fetch_array($query1, MYSQLI_BOTH) or die(mysql_error());
			$winnerRating = $result1['Elo'];
			
			$query2 = mysqli_query($connection, "SELECT Elo FROM users WHERE user_id=".$Loser_ID);
			$result2 = mysqli_fetch_array($query2, MYSQLI_BOTH) or die(mysql_error());
			$loserRating = $result2['Elo'];
			
			$rating = new Rating($winnerRating, $loserRating, 1, 0);			
			$results = $rating->getNewRatings();
			
			if(mysqli_query($connection, "UPDATE users SET Elo = " . $results['a'] . " WHERE              user_id=".$_SESSION['user']))
			{

			}
			else
			{
				?>
				<script>alert('There was an error while entering winners(user) ranking...');</script>
				<?php
			}
			if(mysqli_query($connection,"UPDATE users SET Elo = " . $results['b'] . " WHERE user_id=".$Loser_ID))
			{
			
			}
			else
			{
				?>
				<script>alert('There was an error while entering losers(opp) ranking..');</script>
				<?php
			}
			
		}	
		elseif($oppscore > $userscore)
		{		
			$Loser_ID = $_SESSION['user'];
			$query = mysqli_query($connection,"SELECT user_id FROM users WHERE username = '".$opponent."'");
			$result = mysqli_fetch_array($query, MYSQLI_BOTH) or die(mysqli_error());
			$Winner_ID = $result['user_id'];
			
			//get rating from user table in database
			
			$query1 = mysql_query("SELECT Elo FROM users WHERE user_id=".$_SESSION['user']);
			$result1 = mysqli_fetch_array($query1, MYSQLI_BOTH) or die(mysqli_error());
			$loserRating = $result1['Elo'];
			
			$query2 = mysql_query("SELECT Elo FROM users WHERE user_id=".$Loser_ID);
			$result2 = mysqli_fetch_array($query2, MYSQLI_BOTH) or die(mysqli_error());
			$winnerRating = $result2['Elo'];
			
			$rating = new Rating($winnerRating, $loserRating, 1, 0);			
			$results = $rating->getNewRatings();
			
			$results = $rating->getNewRatings();
			if(mysqli_query($connection, "UPDATE users SET Elo = " . $results['b'] . " WHERE user_id=".$_SESSION['user']))
			{
				
			}
			else
			{
				?>
				<script>alert('There was an error while entering losers(user) ranking...');</script>
				<?php
			}
			if(mysqli_query($connection, "UPDATE users SET Elo = " . $results['a'] . " WHERE user_id=".$Winner_ID))
			{

			}
			else
			{
				?>
				<script>alert('There was an error while entering winners(opp) ranking...');</script>
				<?php
			}
			
		}
		if(mysqli_query($connection, "INSERT INTO games(WinnerID,LoserID,PointsFor,PointsAgainst) VALUES('$Winner_ID','$Loser_ID','$userscore','$oppscore')"))
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
	else
	{
		?>
		<script>alert('There cannot be a tie in ping pong, please re-enter your scores...');</script>
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
		<title>Enter Scores | Ping Pong Rankings</title>
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
					$res=mysqli_query($connection, "SELECT * FROM users WHERE user_id=".$_SESSION['user']);
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
				<div id="headline"><h3 style="font-size: .9em;">Welcome to Ping Pong Rankings</h3></div>
				<form method="post">
				<table align="center" width="100%" border="0">
				<tr>
				<td style="font-size: 1.1em; text-align:center;">
				    Choose your opponent:
				     <select id='opponent' name='opponent'>
					    <?php
						    include 'dbconnect.php';
						    $id = mysqli_real_escape_string($connection, $_SESSION['user']);
						    $search = mysqli_query($connection, "SELECT username, user_id FROM users WHERE user_id!=".$_SESSION['user']);
						    $result = mysqli_fetch_assoc($search);
						    $totalRows = mysqli_num_rows($search);
						    
						    
						    echo $result['user_id'];
						    do {  
							    ?>
							    <option value="<?php echo $result['username'] ?>"<?php if (!(strcmp($result['username'], $result['username']))) {echo "selected=\"selected\"";} ?>><?php echo $result['username']?></option>
							    <?php
						    } while ($result = mysqli_fetch_assoc($search, MYSQLI_BOTH));
						      $rows = mysqli_num_rows($search, MYSQLI_BOTH);
						      if($rows > 0) {
							  mysqli_data_seek($search, 0);
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
                <form method="post">
				<table align="center" width="30%" border="0">
				<tr>
				<td style="font-size: 1.4em; text-align:center;">
				    Choose your opponent:
				     <select id='opponent' name='opponent'>
					    <?php
						    include 'dbconnect.php';
                            $config = parse_ini_file('config/config.ini'); 

                            // Try and connect to the database
                            $connection =   mysqli_connect('localhost',$config['username'],$config['password'],$config['dbname']);
                            if($connection === false) {
                                mysqli_connect_error();
                                echo "WHOOPS THERE WAS AN ERROR.";
}
						    $id = mysqli_real_escape_string($connection, $_SESSION['user']);
						    $search = mysqli_query($connection, "SELECT username, user_id FROM users WHERE user_id!=".$_SESSION['user']);
						    $result = mysqli_fetch_assoc($search);
						    $totalRows = mysqli_num_rows($search);
						    
						    
						    echo $result['user_id'];
						    do {  
							    ?>
							    <option value="<?php echo $result['username'] ?>"<?php if (!(strcmp($result['username'], $result['username']))) {echo "selected=\"selected\"";} ?>><?php echo $result['username']?></option>
							    <?php
						    } while ($result = mysql_fetch_assoc($search));
						      $rows = mysqli_num_rows($search);
						      if($rows > 0) {
							  mysqli_data_seek($search, 0);
							  $result = mysqli_fetch_assoc($search);
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
