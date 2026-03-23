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

</body>

<footer>
    <?php include '../includes/footer.html'; ?>
</footer>
</html>