<?php
$servername = "localhost";
$username = "root";      
$password = "";           
$dbname = "medic"; 
$conect = new mysqli($servername, $username, $password, $dbname);
if ($conect->connect_error) {
    die("Conexão falhou: " . $conect->connect_error);
}
?>
