<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="modifiedbootstrapstyles.css">

	<title>Steppe</title>
</head>
<body>
	<div style="text-align:center;"><br><br><a href="player.php"><img alt="logo" src="logo.png"></a><br><br>
		<button type="submit" class="btn btn-primary" onclick="window.location.href='player.php'">Go to stats page</button><br><br>
		<div class="logout">
			<?php
			require_once 'config.php';
			session_start(); 
			logout();?>
		</div>

		<?php
//error php messages
		error_reporting(E_ALL);
		ini_set('display_errors',1);

//database connection
		$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
//database onection successfu or die 
		$id = $_SESSION['id'];
		$username = $_SESSION['username'];
		if(!$conn){
			echo "Database connection error.";
		}
		else{
			if(!isset($_SESSION['hp'])){
	//
	// TAKING
	// USERS
	// STATS
	// FROM
	// DB
	//
				$select = "SELECT level, attribute, attack, defense, gold FROM stats WHERE id = '$id';";

				$result = pg_query($conn,$select);
				$row = pg_fetch_assoc($result);

	//
	//USERS
	//VARIABLES
	//ON
	//SERVER
	//
				$_SESSION['level'] = $row['level'];
				$_SESSION['attribute'] = $row['attribute'];
				$_SESSION['attack'] = $row['attack'];
				$_SESSION['defense'] = $row['defense'];
				$_SESSION['gold'] = $row['gold'];
				$_SESSION['hp'] = $_SESSION['defense'] * 10;
				$_SESSION['energy'] = 100;
			}
		}
		$checkLevel = floor($_SESSION['level']);
		$minAttack = round($_SESSION['attack'] * 1.4);
		$maxAttack = round($_SESSION['attack'] * 2.4);
//
// REGENERATING
// MONSTER
// ON
// SERVER
//
		if(!isset($_SESSION['mname'])){
//
// TAKING
// MONSTER
// STATS
// FROM
// DB
//
			$randomMonster = rand(1,4);
			$select = "SELECT id, name, hp, attack, exp, gold FROM monsters WHERE id='$randomMonster';";
			$result = pg_query($conn,$select);
			$row = pg_fetch_assoc($result);

//
//MONSTERS
//VARIABLES
//ON
//SERVER
//
			$_SESSION['mname'] = $row['name'];
			$_SESSION['mhp'] = $row['hp'];
			$_SESSION['mattack'] = $row['attack'];
			$_SESSION['mexp'] = $row['exp'];
			$_SESSION['mgold'] = $row['gold'];
		}
		$minMAttack = round($_SESSION['mattack'] * 0.7);
		$maxMAttack = round($_SESSION['mattack'] * 1.2);
//
//FUNCTION
//FOR
//ECHO
//STATS
//AND
//BUTTONS
//
		function Stats ($minAttack, $maxAttack, $minMAttack, $maxMAttack){
			echo '<br>'. $_SESSION['username']. ' statistics: Level: '.round($_SESSION['level'], 2).' Gold: '.$_SESSION['gold'].' HP: '.$_SESSION['hp'].' Attack: '.$minAttack.'-'.$maxAttack.' Energy: ' .$_SESSION['energy'].'<br>
			'.$_SESSION['mname'].' statistics: HP: '.$_SESSION['mhp'].' Attack: '.$minMAttack.'-'.$maxMAttack. '<br>
			<form method="POST" action="steppe.php"><br>
			<div class="btn-group">
			<button type="submit" name="attack" class="btn btn-danger">Attack</button>
			<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="sr-only">Toggle Dropdown</span>
			</button>
			<div class="dropdown-menu">
			<button type="submit" name="attackHead" class="dropdown-item">Head (60% chance, damage x1.9)</button>
			<button type="submit" name="attackBody" class="dropdown-item">Body (75% chance, damage x1.4)</button>
			<button type="submit" name="attackLegs" class="dropdown-item">Legs (90% chance, damage x1.1)</button>
			<button type="submit" name="attackHands" class="dropdown-item">Hands (95% chance)</button>
			</div>
			</div>
			or  
			<div class="btn-group">
			<button type="submit" name="defense" class="btn btn-primary">Defense</button>
			<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="sr-only">Toggle Dropdown</span>
			</button>
			<div class="dropdown-menu">
			<button type="submit" name="attackHead" class="dropdown-item">Regenerate Energy (+40 energy)</button>
			<button type="submit" name="attackBody" class="dropdown-item">Defense (+20 energy, armor x1.3)</button>
			<button type="submit" name="attackLegs" class="dropdown-item">Run away! (75% to run away. You will lose some gold and exp.)</button>
			</div>
			</div>
			</form><br>';
		}

//
//START
//OF
//GAME
//
		if($_SESSION['mhp'] > 0 and $_SESSION['hp'] > 0){
			if(!isset($_POST['attack']) and !isset($_POST['defense'])){
				Stats($minAttack,$maxAttack,$minMAttack, $maxMAttack);
			}
	//
	//ATTACK
	//BUTTON
	//WAS
	//CLICKED
	//
			if(isset($_POST['attack'])){
				if($_SESSION['energy'] >= 20){
					$damageFromUser = round(rand($minAttack,$maxAttack));
					$damageFromMonster = round(rand($minMAttack,$maxMAttack));
					$_SESSION['mhp'] -= $damageFromUser;
					$_SESSION['hp'] -= $damageFromMonster;
					$_SESSION['energy'] -= 20;
					Stats($minAttack,$maxAttack,$minMAttack, $maxMAttack);
					echo 'You damaged '.$_SESSION['mname'].' for ' .$damageFromUser. ' HP<br>'.$_SESSION['mname'].' damaged you for '.$damageFromMonster.' HP<br>';
				}else{
					Stats($minAttack,$maxAttack,$minMAttack, $maxMAttack);
					echo '<br><br> 
					<div class="alert alert-warning" role="alert">
					<h3>
					Didnt enought energy for attack, you have to regenerate energy!
					</h3>
					</div>';
				}
			}
//
//DEFENSE
//BUTTON
//WAS
//CLICKED
//
			if(isset($_POST['defense'])){
				if($_SESSION['energy'] + 30 < 100){
					$damageFromMonster = round(0.6 * rand($minMAttack,$maxMAttack));
					$_SESSION['hp'] -= $damageFromMonster;
					$_SESSION['energy'] += 30;
					Stats($minAttack,$maxAttack,$minMAttack, $maxMAttack);
					echo $_SESSION['mname'].' damaged you for '.$damageFromMonster.' HP<br> ';
				}else if($_SESSION['energy'] != 100){
					$damageFromMonster = round(0.6 * rand($minMAttack,$maxMAttack));
					$_SESSION['hp'] -= $damageFromMonster;
					$_SESSION['energy'] = 100;
					Stats($minAttack,$maxAttack,$minMAttack, $maxMAttack);
					echo $_SESSION['mname'].' damaged you for '.$damageFromMonster.' HP<br> ';
				}else if($_SESSION['energy'] === 100){
					Stats($minAttack,$maxAttack,$minMAttack, $maxMAttack);
					echo '<br><br> 
					<div class="alert alert-warning" role="alert">
					<h3>
					You are full of energy, attack monster now!
					</h3>
					</div>';
				}
			}
//
//IF
//USER
//OR
//MONSTER
//DIE
//

//if user lose
			if($_SESSION['hp'] <= 0){

				$lose = $_SESSION['mexp'] / $_SESSION['level'] / 10;
				if($checkLevel > floor($_SESSION['level'] - $lose)){
					$lose =  $_SESSION['level'] - $checkLevel;
					$_SESSION['level'] = $checkLevel;
				}else{
					$_SESSION['level'] -= $lose;
				}
				if($_SESSION['gold'] - $_SESSION['mgold'] < 0){
					$_SESSION['mgold'] = $_SESSION['gold'];
					$_SESSION['gold'] = 0;
				}else{
					$_SESSION['gold'] -= $_SESSION['mgold'];
				}
				$level = $_SESSION['level'];
				$gold = $_SESSION['gold'];

//
//UPDATE
//DATABASES
//ADD
//EXP
//AND
//GOLD
//

				$update = "UPDATE stats SET level = '$level', gold = '$gold' WHERE id = '$id';";
				pg_query($conn,$update);

//
//ECHO
//Message
//
				echo '<br><br> 
				<div class="alert alert-danger" role="alert">
				<h3>
				You lose! You lose '.round($lose).' experience and '.$_SESSION['mgold'].' gold!
				</h3>
				</div>';
				unset($_SESSION['mname']); 
				$_SESSION['hp'] = $_SESSION['defense'] * 10;
				$_SESSION['energy'] = 100;
} //if user win 
else if($_SESSION['mhp'] <= 0){

	$_SESSION['level'] += ($_SESSION['mexp'] / $_SESSION['level']) / 20;
	if($checkLevel < floor($_SESSION['level'])){
		$_SESSION['attribute'] += 2;
		$attribute = $_SESSION['attribute'];
		echo '<br><br> 
		<div class="alert alert-success" role="alert">
		<h2>
		Congratulations, new level! You recieved 2 attribute points. Now you can improve your skills!
		</h2>
		</div>';
		$update = "UPDATE stats SET attribute = '$attribute' WHERE id = '$id';";
		pg_query($conn,$update);
	}

	$level = $_SESSION['level'];
	$_SESSION['gold'] += $_SESSION['mgold'];
	$gold = $_SESSION['gold'];
//
//UPDATE
//DATABASES
//ADD
//EXP
//AND
//GOLD
//

	$update = "UPDATE stats SET level = '$level', gold = '$gold' WHERE id = '$id';";
	pg_query($conn,$update);

//
//ECHO
//Message
//
	echo '<br><br> 
	<div class="alert alert-success" role="alert">
	<h3>
	You win! You get '.$_SESSION['mexp'].' experience and '.$_SESSION['mgold'].' gold!
	</h3>
	</div>';
	unset($_SESSION['mname']);
	$_SESSION['hp'] = $_SESSION['defense'] * 10;
	$_SESSION['energy'] = 100;
}
}
?>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>