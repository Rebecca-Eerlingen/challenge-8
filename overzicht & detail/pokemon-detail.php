<?php 
include ('../includes/db.php');

$sql = "SELECT * FROM tb_pokemon WHERE dex_number = :dex_number";

$stmt = $conn->prepare($sql);

$stmt->execute(['dex_number' => $_GET['dex_number']]);

$pokemon = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>overzicht en detail</title>
  <link rel="stylesheet" href="overzicht-cards.css">
</head>
<body>

<div class="wrapper">
    <div class="card-container">
        <div class="card">
            <h2 class="name"> <?= htmlspecialchars($pokemon['name']) ?> <h2>
            <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/dream-world/<?= htmlspecialchars($pokemon['dex_number']  ?? '—') ?>.svg" alt="">
            <div class="card-body">
                <p> <?= htmlspecialchars($pokemon['description']) ?> </p>
                <p> <?= htmlspecialchars($pokemon['type1']) ?> </P>
                <p> <?= htmlspecialchars($pokemon['type2']) ?> </P>
                <p> <?= htmlspecialchars($pokemon['weight']) ?> </P>
                <p> <?= htmlspecialchars($pokemon['height']) ?> </P>
                <a class="button" href="https://pokemondb.net"> More information </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>