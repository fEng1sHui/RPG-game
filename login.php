		<!doctype html>
		<html lang="en">
		<head>
			<!-- Required meta tags -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

			<!-- Bootstrap CSS -->
			<link rel="stylesheet" href="css/bootstrap.min.css">
			<link rel="stylesheet" href="modifiedbootstrapstyles.css">

			<title>Login</title>
		</head>
		<body>
			<div style="text-align:center;"><br><br><a href="index.php"> <img alt="logo" src="logo.png"></a><br><br>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="containerForm">
						<div class="form-group">
							<input type="text" class="form-control" id="username" aria-describedby="username" placeholder="Username" name='username' maxlength="50" required>
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password' maxlength="50" required>
						</div>
						<button type="submit" value="Login" class="btn btn-outline-primary">Login</button>
					</div>
			</form>
			</div>

			<?php
			session_start();
//error php messages
			error_reporting(E_ALL);
			ini_set('display_errors', 1);

//connection variables
			require_once 'config.php';

//database connection
			$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
//database onection successfu or die 

			if (!$conn) {
				echo "Database connection error.";
			} 
			else 
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){

					$username = $_POST['username'];
					$password = md5($_POST['password']);

					$select = "SELECT id, username, password FROM users WHERE username = '$username' and password = '$password'";

					$result = pg_query($conn,$select);
					$count = pg_num_rows($result);
					if ($count==1) {
						$update = "UPDATE users SET last_login = NOW() WHERE username = '$username' and password = '$password'";
						pg_query($conn,$update);
						$row = pg_fetch_assoc($result);
						$_SESSION['authenticated'] = true;
						$_SESSION['username'] = $username;
			    $_SESSION['id'] = $row['id']; // Initializing Session
				header("location: player.php"); // Redirecting To Other Page
			} else {
				    echo '<br><div class="alert alert-danger" role="alert" align="center">
        						Wrong username or password, please try again!
        					</div>';
			}
		}
		unset($_SESSION['attribute']);
		pg_close($conn);

		?>

		<script>
			window.onload = function() {
				document.getElementById('username').focus();    
			}
		</script>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>
			</body>
			</html>