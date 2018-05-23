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
    $create="CREATE TABLE IF NOT EXISTS monsters (
    id SERIAL PRIMARY KEY NOT NULL,
    name CHAR(30),
    hp SMALLINT,
    attack SMALLINT,
    exp SMALLINT,
    gold SMALLINT
    );";
}
// Execute query
if (pg_query($conn,$create))  {
       echo "Table monsters created successfully. ";
}
else  {
       echo "Error creating table. ";
}

$insert = "INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Big Rabbit', 100, 2, 3, 5);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Racoon', 110, 4, 5, 7);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Racoon', 115, 4, 7, 8);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Red Fox', 120, 6, 9, 10);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Red Fox', 125, 7, 10, 13);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Vulpini', 135, 8, 12, 15);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Vulpini', 150, 8, 15, 17);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Genet', 150, 10, 17, 22);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Genet', 160, 12, 18, 25);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Hyena', 165, 13, 20, 28);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Hyena', 180, 13, 22, 29);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Cougar', 200, 16, 25, 35);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Cougar', 215, 18, 27, 40);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Panda', 240, 20, 30, 45);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Panda', 250, 22, 33, 52);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Sloth Bear', 265, 25, 38, 60);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Sloth Bear', 280, 26, 39, 63);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Asian Bear', 300, 30, 42, 70);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Asian Bear', 310, 31, 44, 77);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Brown Bear', 335, 33, 47, 85);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Brown Bear', 350, 36, 50, 100);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Polar Bear', 375, 37, 54, 110);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Polar Bear', 385, 39, 56, 118);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('American Black Bear', 400, 42, 59, 125);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult American Black Bear', 425, 45, 63, 133);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Snow Leopard', 430, 48, 68, 142);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adultt Snow Leopard', 440, 52, 72, 155);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Lynx', 465, 55, 75, 164);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Lynx', 480, 59, 80, 170);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Cheetah', 500, 63, 84, 180);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Cheetah', 515, 68, 90, 193);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Jaguar', 530, 71, 95, 205);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Jaguar', 550, 75, 100, 218);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Leopard', 540, 82, 110, 231);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Leopard', 550, 88, 121, 252);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Lion', 601, 101, 141, 299);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Lion', 636, 113, 155, 318);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Tiger', 619, 110, 150, 307);
            INSERT INTO monsters (name, hp, attack, exp, gold) VALUES ('Adult Tiger', 647, 121, 166, 342);";

                 // Execute query
            if (pg_query($conn,$insert)) {
                    echo "Data entered successfully. ";
            }
            else {
                  echo "Data entry unsuccessful. ";
            }
?>