<?php

/*
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$conn->close();

*/



//PROCEDURAL

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "solicitacoes";

//localweb

$servername = "179.188.16.35";
$username = "camarasjc23";
$password = "b18di2wd";
$dbname = "camarasjc23";

// Create connection
$conn = mysqli_connect($servername, $username, $password,  $dbname);

// Check connection
if (!$conn) {
    die("Falha na conexão com o banco de Dados: " . mysqli_connect_error());
}
//echo "Connected successfully";



