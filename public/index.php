<?php 
session_start();
include ('../includes/db.php');
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
                    <p>
                    <?= htmlspecialchars($_GET['msg']) ?>
                    <?php if (isset($_GET['dex'])):?>
                        <img class="poke-img"
                        src="../pokemon img/icons/<?= (int)$_GET['dex'] ?>.png">
                        <?php endif; ?>
                        </p>

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
    </div>
    <div class="flexbox" style="bottom: 100px; width: 99%;">

        <div class="index">
            <a href="#pokedex">
            <button>PokeDex</button>
            </a>
        </div>

        <div class="rollen">
            <form method="POST" action="catch.php">
                <button type="submit">
                <img src="rollen3.png">
            </button>
            </form>
            
    </div>

    <div class="gebruiker">
        <a href="../inlog_pokedex/login.php">
        <button>gebruiker</button></a>
    </div>
    <div class="gevangen pokemons">
        <a href="MyPokémons.php">
        <button>mijn pokémons</button></a>
    </div>

    <audio id="bgmusic" loop>
        <source src="pokemon lake.mp3" type="audio/mpeg">
    </audio>
    </div>
</div>
    </div>

   <?php $search = $_GET['search'] ?? '';
if (!empty($search)) {
    $stmt = $conn->prepare("
        SELECT * FROM tb_pokemon 
        WHERE name LIKE :search 
        OR type1 LIKE :search 
        OR type2 LIKE :search 
        OR description LIKE :search 
        OR dex_number LIKE :search 
        or weight LIKE :search 
        or height LIKE :search");
    $searchTerm = "%" . $search . "%";

    $stmt->bindValue(':search', $searchTerm);

    $stmt->execute();
    $result = $stmt;
} else {
    $result = $conn->query("SELECT * FROM tb_pokemon");
}


 if (!$result) {
    echo "<p style='color:red; font-weight:bold;'> dataquery mislukt: ";
 } $data = $result->fetchAll(PDO::FETCH_ASSOC);

    if (!$data) {
        echo "<p style='color:red; font-weight:bold;'> geen pokemon gevonden.</p>";
 } else{
    ?>
        <form method="GET">
        <input type="text" name="search" placeholder="Zoeken" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit">Search</button>
        <p></p><a href="index.php"> reset</a>
    </form>

<div id="pokedex" class = "container pokedex">

        <table>
            
     <?php 
     foreach ($data as $row) { ?>
            <tr>
            <td><?= htmlspecialchars($row['dex_number']    ?? '—') ?></td>
            <td><?= htmlspecialchars($row['name']  ?? '—') ?></td>
            <td> <img src="../pokemon img/icons/<?= htmlspecialchars($row['dex_number']  ?? '—') ?>.png" alt=""></td>
            <td><?= htmlspecialchars($row['type1'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['type2'] ?? '—') ?></td>
            <td><a href="../overzicht & detail/pokemon-detail.php?dex_number=<?= htmlspecialchars($row['dex_number']) ?>">Details</a></td>
<?php }} ?>

</table>
</div>
<script src="pokemon.js"></script>
</body>

<footer>
    <?php include '../includes/footer.html'; ?>
</footer>
</html>