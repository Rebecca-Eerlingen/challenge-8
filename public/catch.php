<?php
session_start();

if (!isset($_SESSION["email"])) {
    echo"<script> 
    alert('You are not logged in, please log in to access this page');
    window.location.href = '../inlog_pokedex/login.php';
    </script>";
    exit;
    }

    include "../includes/db.php";
    require_once "../includes/db.php";

    $conn_users = new mysqli($servername, $username, $password, $dbname);
    $users_email = $_SESSION["email"];

    $stmt = $conn->prepare("SELECT dex_number FROM tb_pokemon ORDER BY RAND() LIMIT 1");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("Geen Pokémon gevonden in de database.");
}

$dex_number = (int)$row['dex_number'];

$stmt = $conn_users->prepare("INSERT IGNORE INTO user_pokemon (user_id, pokemon_dex_number, level) VALUES (?, ?, 5)");
$stmt->bind_param("si", $users_email, $dex_number);
$stmt->execute();

$msg = ($stmt->affected_rows > 0) 
    ? "🎉 Je hebt een nieuwe Pokémon gevangen!" 
    : "Je had deze Pokémon al! Probeer opnieuw te rollen.";

$conn_users->close();

header("Location: index.php?msg=" . urlencode($msg));
exit;
        ?>