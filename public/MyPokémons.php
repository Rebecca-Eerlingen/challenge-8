<?php 
session_start();
include_once "../includes/db.php";

if (!isset($_SESSION["email"])) {
    echo "<script> 
    alert('You are not logged in, please log in to access this page');
    window.location.href = '../inlog_pokedex/login.php';
    </script>";
    exit;
}

$users_email = $_SESSION['email'];


$stmt = $conn->prepare("
SELECT up.id, up.user_id, up.pokemon_dex_number, up.level, up.caught_at,
           p.name, p.type1, p.type2 
    FROM user_pokemon up
    JOIN tb_pokemon p ON p.dex_number = up.pokemon_dex_number
    WHERE up.user_id = ?
    ORDER BY up.caught_at DESC");

$stmt->execute([$users_email]);
$caught_pokemon = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="MyPokémon">mijn Pokémons</title>
    <link rel="stylesheet" href="pokemon.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
   
</head>
    <body style="background-image: url('pokemon background.jpg'); background-size: cover;">

    <div style="text-align: center; padding: 40px 20px;">
        <h1 style="color: white; text-shadow: 3px 3px 6px black; font-size: 32px;">
            Mijn Gevangen Pokémon
        </h1>
        <p style="color: #ffeb3b; font-size: 18px;">
            Je hebt <?= count($caught_pokemon) ?> Pokémon gevangen
        </p>

        <?php if (empty($caught_pokemon)): ?>
            <div style="margin-top: 80px; color: white; font-size: 20px;">
                Je hebt nog geen Pokémon gevangen!<br>
                <a href="index.php" style="color: #ffeb3b;">Ga rollen om Pokémon te vangen →</a>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-wrap: wrap; gap: 25px; justify-content: center; margin-top: 40px;">
                <?php foreach ($caught_pokemon as $pokemon): ?>
                    <div style="background: white; border: 5px solid #333; border-radius: 15px; 
                                width: 200px; padding: 15px; text-align: center; box-shadow: 0 6px 15px rgba(0,0,0,0.4);">
                        
                        <div style="font-size: 14px; color: #666;">
                            #<?= htmlspecialchars($pokemon['pokemon_dex_number']) ?>
                        </div>
                        
                        <img src="../pokemon img/icons/<?= htmlspecialchars($pokemon['pokemon_dex_number']) ?>.png" 
                             alt="<?= htmlspecialchars($pokemon['name']) ?>" 
                             style="width: 140px; height: 140px; image-rendering: pixelated; margin: 10px 0;">

                        <h3 style="margin: 10px 0 8px; color: #222; font-size: 18px;">
                            <?= htmlspecialchars($pokemon['name']) ?>
                        </h3>

                        <div style="font-size: 13px; color: #e3350d;">
                            <?= htmlspecialchars($pokemon['type1'] ?? '') ?>
                            <?php if (!empty($pokemon['type2'])): ?>
                                / <?= htmlspecialchars($pokemon['type2']) ?>
                            <?php endif; ?>
                        </div>

                        <div style="margin-top: 10px; font-size: 12px; color: #666;">
                            Level <?= $pokemon['level'] ?> 
                            • <?= date('d-m-Y', strtotime($pokemon['caught_at'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="margin-top: 50px;">
            <a href="index.php" style="color: white; text-decoration: none; font-size: 18px;">
                ← Terug naar RNGdex
            </a>
        </div>
    </div>
    
</body>
</html>