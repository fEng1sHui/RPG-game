<?php

//error php messages
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host="localhost";
$dbname="accounts";
$user="postgres";
$password="proste$01";

function logout(){
	echo '<form method = "POST">
					<button type="submit" name="logout" class="btn btn-outline-danger">Logout</button><br>
			</form>';
			if(isset($_POST['logout'])){
				session_destroy();
				header("location: index.php");
			}
}
?>