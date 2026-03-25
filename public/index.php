<?php 
session_start();
include ('../includes/db.php');
// use Vtiful\Kernel\Format;
ini_set ('display_errors',1);
ini_set ('display_startup_errors',1);
error_reporting (E_ALL); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="rngdex">RNGdex</title>
    <link rel="stylesheet" href="pokemon.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
</head>

<body>
    <?php
    if (isset($_GET['msg'])):?>
    <div style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%);
                    background: #4CAF50; color: white; padding: 15px 25px; border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 10000; 
                    font-family: 'Press Start 2P', cursive; text-align: center;">
                    <?= htmlspecialchars($_GET['msg']) ?>
    </div>

    <script>
        setTimeout(function() {
            const msgDiv = document.querySelector('div[style*="position: fixed"]');
        if (msgDiv) msgDiv.style.display = 'none';            
        }, 4000);
    </script>
    <?php endif; ?>

<div class="container">

    <div class="header">
        <img src="rngdex2.png">
    

    <div class="speaker">
        <button id="speakerbutton">
            <img id="speakericon" src="mspeaker_45x45.png">
        </button>
    </div>

    <!-- <div class="gebruiker">
        <button>Gebruiker</button>
    </div> -->
    </div>
    <div class="flexbox" style="bottom: 100px; width: 99%;">

        <div class="index">
            <a href="https://pokemondb.net/pokedex/all" target="_blank">
            <button>Index</button>
            </a>
        </div>

        <div class="rollen">
            <form method="POST" action="catch.php">
                <button type="submit">
                <img src="rollen3.png">
            </button>
            </form>
            
    </div>

        <div class="kansen">
            <button>Kansen</button>
        </div>

    <audio id="bgmusic" loop>
        <source src="pokemon lake.mp3" type="audio/mpeg">
    </audio>
    </div>
</div>
    </div>

<div class="container pokedex">

        <table>
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
            <td><a href="../detail/pokemon-detail.php?dex_number=<?= htmlspecialchars($row['dex_number']) ?>">Details</a></td>
<?php } ?>
</table>
</div>
<script src="pokemon.js"></script>
</body>

<footer>
    <?php include '../includes/footer.html'; ?>
</footer>
</html>