<?php include ('../includes/db.php');use Vtiful\Kernel\Format;
ini_set ('display_errors',1);
ini_set ('display_startup_errors',1);
error_reporting (E_ALL); ?>


<!DOCTYPE html>
<html lang="en">
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pokedex</title>
    <link rel="stylesheet" href="style.css">
    <div w3-include-html="../includes/header.html"></div>
    <?php include '../includes/header.html'; ?>
    <h1>welkom bij Pokedex Vista</h1>

</header>
<body>
    <?php

$search = $_GET['search'] ?? '';

// searchbar
if (!empty($search)) {
    $stmt = $conn->prepare("
        SELECT * FROM tb_pokemon 
        WHERE name LIKE ? 
        OR type1 LIKE ? 
        OR type2 LIKE ? 
        OR description LIKE ?
        OR dex_number LIKE ?
        or weight LIKE ?
        or height LIKE ?");
    $searchTerm = "%" . $search . "%";

    $stmt->bind_param("sssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM tb_pokemon");
}?>
<form method="GET">
    <input type="text" name="search" placeholder="Zoek een pokémon..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button type="submit">Scouting</button>
</form>
<a href="index.php" class="href">reset</a>

 <!-- lijst met pokemons -->

 <table>
    <tr>
            <th>dex nummer</th>
            <th>Pokemon</th>
            <th>Img</th>
            <th>Type1</th>
            <th>type 2</th>
            <th>Weight</th>
            <th>Height</th> 
            <th>Description</th>
    </tr>

    <?php 
    while ($row = $result->fetch_all(PDO::FETCH_ASSOC)): ?>  
        <tr>
            <td><?= htmlspecialchars($row['dex_number'])  ?? '—'?></td>
            <td><?= htmlspecialchars($row['name'])  ?? '—'?></td>
            <td><img src="../pokemon img/icons/<?= htmlspecialchars($row['dex_number'])  ?? '—'?>" width="100"></td>
            <td><?= htmlspecialchars($row['type1'])  ?? '—'?></td>
            <td><?= htmlspecialchars($row['type2'])  ?? ''?></td>
            <td><?= htmlspecialchars($row['weight'])  ?? '—'?></td>
            <td><?= htmlspecialchars($row['height'])  ?? '—'?></td>
            <td><?= htmlspecialchars($row['description'])  ?? '—'?></td>
        </tr>
        <?php endwhile; ?>
 </table>
</body>
<footer>
    <?php include '../includes/footer.html'; ?>
</footer>
</html>