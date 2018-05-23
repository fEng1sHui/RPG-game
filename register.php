<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="modifiedbootstrapstyles.css">

    <title>Registration - Lineage Polska - RPG Game</title>
</head>
<body>

    <div style="text-align:center;"> <br> <br> <a href="index.php"> <img alt="logo" src="logo.png"></a><br><br>

        <form id='register' action='register.php' method='post' accept-charset='UTF-8' >
            <div class="containerForm">
              <div class="form-group">
                <input type="text" class="form-control" id="username" aria-describedby="username" placeholder="Username" name='username' maxlength="50" required>
            </div>

            <div class="form-group">
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name='email' maxlength="50" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password' maxlength="50" required>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Confirm Password" name='confirmpassword' maxlength="50" required>
            </div>

            <button type="submit" value="Register" class="btn btn-outline-secondary">Register</button></div>
    </form>
</div>

    <?php

//error php messages
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

//connection variables
    require_once 'config.php';

//database connection
    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

//database onection successfu or die
    if (!$conn) {
     echo "Database connection error. ";
 }
 else {
// sql query create table
    $create="CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY NOT NULL,
    username CHAR(50),
    email CHAR(50),
    confirmed SMALLINT NOT NULL DEFAULT 0,
    password CHAR(100),
    last_login timestamp without time zone DEFAULT now()
    );

    CREATE TABLE IF NOT EXISTS stats (
    id SERIAL PRIMARY KEY NOT NULL,
    level real NOT NULL DEFAULT 1,
    attribute SMALLINT NOT NULL DEFAULT 10,
    attack SMALLINT NOT NULL DEFAULT 3,
    defense SMALLINT NOT NULL DEFAULT 5,
    gold INT NOT NULL DEFAULT 100
);";
}
// Execute query
if (pg_query($conn,$create))  {
       //echo "Table users created successfully. ";
}
else  {
       //echo "Error creating table. ";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        //check 2 passwords
    if($_POST['password'] == $_POST['confirmpassword']){

        //checking if username is available 
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $select = "SELECT username FROM users WHERE username = '$username'";

        $result = pg_query($conn,$select);
        $count = pg_num_rows($result);

        if ($count==1) {
            echo '<br><div class="alert alert-danger" role="alert" align="center">
            The username is already taken, please select another one.
            </div>';
        } 
        else{
            // sql query create table
            $insert = "INSERT INTO users (username, email, password) VALUES ('$username', '$_POST[email]', '$password');
            INSERT INTO stats (level) VALUES (1)";
                 // Execute query
            if (pg_query($conn,$insert)) {
                    //echo "Data entered successfully. ";
            }
            else {
                  //echo "Data entry unsuccessful. ";
            }
            header("location: login.php"); // Redirecting To Other Page
        }
    }
    else{
        echo '<br><div class="alert alert-danger" role="alert" align="center">
        Passwords do not macth!
        </div>';
    }
}
else{
}

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