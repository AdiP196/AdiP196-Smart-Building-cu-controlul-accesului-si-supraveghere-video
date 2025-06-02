<?php
// common.php – se ocupă de conexiunea la baza de date

$host = "localhost";
$user = "admin";
$password = "parola"; // înlocuiește cu parola ta reală
$database_name = "sistemsupraveghere";

// Creare conexiune
$mysqli = new mysqli($host, $user, $password, $database_name);

// Verificare conexiune
if ($mysqli->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $mysqli->connect_error);
}
?>
