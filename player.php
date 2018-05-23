<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="modifiedbootstrapstyles.css">

	<title>Attributes</title>
</head>
<body>
	<div style="text-align:center;"><br><br><a href="index.php"> <img alt="logo" src="logo.png"></a>
		<h4 style="font-size:300%; text-align:center;">Attributes</h4>
		<?php
		require_once 'config.php';
		logout(); 
		session_start();
		echo '<br><p style="text-align:center;">' .$_SESSION['username']. '</p>';
	//error php messages
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		$id = $_SESSION['id'];
	//database connection
		$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
	//database onection successfu or die
		if (!$conn) {
			echo "Database connection error. ";
		}
		else {
			if(!isset($_SESSION['attribute'])){
				$select = "SELECT level, attribute, attack, defense FROM stats WHERE id = '$id';";

				$result = pg_query($conn,$select);
				$row = pg_fetch_assoc($result);

				$_SESSION['level'] = $row['level'];
				$_SESSION['attribute'] = $row['attribute'];
				$_SESSION['attack'] = $row['attack'];
				$_SESSION['defense'] = $row['defense'];
			}
		}
		$attack = $_SESSION['attack'];
		$defense = $_SESSION['defense'];
		echo floor($_SESSION['level']). " Level<br><br>";

			echo '<div style="text-align:center;" class="container">
  						<div class="row justify-content-md-left">
  							<form method="POST" action="player.php">
								<button type="submit" name="attack" class="btn btn-outline-success"><strong> + </strong></button>  ' .$attack. '  Attack (Damage, every point gives you +2 damage)
							</form><br>
    					</div>

    					<div class="row justify-content-md-left">
    						<form method="POST" action="player.php">
      							<button type="submit" name="defense" class="btn btn-outline-success"><strong> + </strong></button>  ' .$defense. '  Defense (HP and Armour, evry point gives you +10 HP and +1 Armour) 
							</form>
    					</div>
  					</div>';

		function Attributes (){
			if($_SESSION['attribute'] > 0){
				echo '<br><div class="alert alert-success" role="alert">
						You have '.$_SESSION['attribute'].' points and can improve your skills!
						</div><br>';
			}else{
				echo "<br><div class='alert alert-warning' role='alert'>
						You didn't have attribute points, go and get EXP! Every new level gives you 2 attributes points
						</div>";
			}
		}

		if(!isset($_POST['attack']) && !isset($_POST['defense'])){
			Attributes();
		}
		if(isset($_POST['attack']) || isset($_POST['defense'])){
			if($_SESSION['attribute'] > 0){
				if(isset($_POST['attack'])){
					$_SESSION['attack']++;
					$attack = $_SESSION['attack'];
					$update = "UPDATE stats SET attack = '$attack' WHERE id = '$id';";
				}else if(isset($_POST['defense'])){
					$_SESSION['defense']++;
					$defense = $_SESSION['defense'];
					$update = "UPDATE stats SET defense = '$defense' WHERE id = '$id';";
				}
				$_SESSION['attribute']--;
				$attribute = $_SESSION['attribute'];
				$update .= "UPDATE stats SET attribute = '$attribute' WHERE id = '$id'";
				pg_query($conn,$update);
				Attributes();
			}else if($_SESSION['attribute'] == 0){
				if(isset($_POST['attack']) or isset($_POST['defense'])){
					Attributes();
					echo "<br><div class='alert alert-danger' role='alert'>
					You haven't enought attribute points!
					</div>";
				}
			}
		}
		unset($_SESSION['hp'], $_SESSION['mname'], $_POST['attack'], $_POST['defense']);
		unset($_POST['attack']);
		pg_close($conn);
		?><br>
		<form>
			<button type="button" class="btn btn-secondary btn-lg btn-block" onclick="window.location.href='steppe.php'">Go to steppe (here you can face with rabbits, raccons and foxes)</button>
			<button type="button" class="btn btn-secondary btn-lg btn-block" onclick="window.location.href='leaved.php'">Go to mixed leaved forest (here you can face with foxes, vulpins and genets)</button>
			<button type="button" class="btn btn-secondary btn-lg btn-block" onclick="window.location.href='southern.php'">Go to southern taiga (here you can face with genetes, hyenas and cougars)</button>
			<button type="button" class="btn btn-secondary btn-lg btn-block" onclick="window.location.href='moderate.php'">Go to moderate taiga (here you can face with cougars, pandas and bears)</button>
			<button type="button" class="btn btn-secondary btn-lg btn-block" onclick="window.location.href='nothern.php'">Go to northern taiga (here you can face with bears)</button><
		</form>
	</div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>