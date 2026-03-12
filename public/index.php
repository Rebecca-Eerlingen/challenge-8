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
<div class="container pokedex">
    
</div>

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

</a>
</body>

<footer>
    <?php include '../includes/footer.html'; ?>
</footer>
</html>