<?php

session_start();


if (!isset($_SESSION["email"])) {
    echo "<script> 
    alert('You are not logged in, please log in to access this page');
    window.location.href = '../inlog_pokedex/login.php';
    </script>";
    exit;
}

include "../includes/db.php";

$stmt = $conn->prepare("
    SELECT dex_number, name 
    FROM tb_pokemon 
    ORDER BY RAND() 
    LIMIT 1
");
$stmt->execute();
$row = $stmt->fetch();

if (!$row) {
    die("Geen Pokémon gevonden in de database.");
}

$dex_number = (int)$row['dex_number'];
$name = $row['name'];
$img = '<img class="poke-img" src="../pokemon_img/icons/' . $dex_number . '.png" alt="' . htmlspecialchars($name) . '">';

$user_id = $_SESSION['email'];

if (!$user_id) {
    die("Gebruiker niet gevonden.");
}

$stmt = $conn->prepare("
    INSERT IGNORE INTO user_pokemon (user_id, pokemon_dex_number, level)
    VALUES (:user_id, :dex, 5)
");

$stmt->execute([
    ':user_id' => $user_id,
    ':dex' => $dex_number
]);

if ($stmt->rowCount() > 0) {
    $msg = "🎉 Je hebt $img gevangen!";
} else {
    $msg = "⚠️ Je had $name al! Probeer opnieuw.";
}

header("Location: index.php?msg=" . urlencode("je hebt $name gevangen!") . "&dex=" . $dex_number);
exit;