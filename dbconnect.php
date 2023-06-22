<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "shipwave_db";
$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>