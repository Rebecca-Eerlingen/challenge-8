<?php include ('../includes/db.php');use Vtiful\Kernel\Format;
ini_set ('display_errors',1);
ini_set ('display_startup_errors',1);
error_reporting (E_ALL); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RNGdex</title>
    <link rel="stylesheet" href="pokemon.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
    <div w3-include-html="../includes/header.html"></div>
    <?php include '../includes/header.html'; ?>
<<<<<<< HEAD
    <h1>welkom bij Pokedex Vista</h1>

    <div class="container"></div>
</header>

<body>

<div class="container">

<?php 
$result = $conn->query("SELECT * FROM tb_pokemon");
$data = $result->fetchAll(PDO::FETCH_ASSOC);

foreach ($data as $row) { ?>

<div class="pokedex">
    <br>


<div class="dex_number">
<h1> # <?= htmlspecialchars($row['dex_number'] ?? '—') ?> <?= htmlspecialchars($row['name'] ?? '—') ?></h1>
</div>



<img src="../pokemon img/icons/<?= htmlspecialchars($row['dex_number'] ?? '—') ?>.png">

<div class="type">
<?= htmlspecialchars($row['type1'] ?? '—') ?> <br>
<?= htmlspecialchars($row['type2'] ?? '') ?>
</div>

<div>
Height: <?= htmlspecialchars($row['height'] ?? '—') ?>
</div>

<div>
Weight: <?= htmlspecialchars($row['weight'] ?? '—') ?>
</div>

<div class="description">
<?= htmlspecialchars($row['description'] ?? '—') ?>
</div>

</div>

<?php } ?>

</div>

=======
</head>

<body>
<div class="container pokedex"></div>

    <div class="header" style="position: absolute; top: 75px; width: 99%;">
    <img src="rngdex2.png">
    </div>

    <div class="speaker">
        <button id="speakerbutton">
            <img id="speakericon" src="mspeaker_45x45.png">
        </button>
    </div>

    <div class="gebruiker">
        <button>Gebruiker</button>
    </div>

    <div class="flexbox" style="position: absolute; bottom: 100px; width: 99%;">

        <div class="index">
            <a href="https://pokemondb.net/pokedex/all" target="_blank">
            <button>Index</button>
            </a>
        </div>

        <div class="rollen">
            <button>
                <img src="rollen3.png">
            </button>
    </div>

        <div class="kansen">
            <button>Kansen</button>
        </div>
</div>

<audio id="bgmusic" loop>
    <source src="pokemon lake.mp3" type="audio/mpeg">
</audio>

     <?php 
     $result = $conn->query("SELECT * FROM tb_pokemon");
     $data = $result->fetchAll(PDO::FETCH_ASSOC);
     foreach ($data as $row) { ?>
            <tr>
            <td><?= htmlspecialchars($row['dex_number']    ?? '—') ?></td>
            <td><?= htmlspecialchars($row['name']  ?? '—') ?></td>
            <td> <img src="../pokemon img/icons/<?= htmlspecialchars($row['dex_number']  ?? '—') ?>.png" alt=""></td>
            <td><?= htmlspecialchars($row['type1'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['type2'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['weight'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['height'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['description'] ?? '—') ?></td> 
<?php } ?>

<script src="pokemon.js"></script>
>>>>>>> 034ee28010bda5cd48c839f2ac359e8517a02a21
</body>

<footer>
    <?php include '../includes/footer.html'; ?>
</footer>
</html>