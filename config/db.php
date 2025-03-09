<?php 
// connect to mysql

$dsn = "mysql:host=localhost;dbname=school;charset=utf8mb4";
$user = "root";
$pass = "";

try {
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    die("Database connection failed: " . $error->getMessage());
}

    
     

?>