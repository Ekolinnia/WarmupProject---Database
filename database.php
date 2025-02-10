<?php
$server = 'zrc353.encs.concordia.ca:3306';
$username = 'zrc353_4';
$password = 'Leocat30';
$database = 'zrc353_4';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>