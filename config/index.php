<?php 

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'my_bakery';

try {
    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
    if (!$conn) {
        throw new Exception('Unable to connect!');
    }
} catch (Exception $e) {
    echo $e->getMessage();
}