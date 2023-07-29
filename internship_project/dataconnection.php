<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'birth_certificate';


$db = mysqli_connect($servername, $username, $password, $dbname) or die(mysqli_error($db));


if (!$db) {
    die("Connection failed: " . mysqli_connect_error());  // Check if the connection was successful
}


function sanitizeInput($input) //to check the data take as input is without (space,specialcharecter)
{
    global $db;
    return mysqli_real_escape_string($db, htmlspecialchars(trim($input))); //to same act as validation of the data 
}                                                                          //htmlspecialchars is trim the space

// Function to close the database connection
function closeDatabaseConnection()
{
    global $db;   //because the data can be accesing from  variable $db and look for it 
    mysqli_close($db);
}
?>
