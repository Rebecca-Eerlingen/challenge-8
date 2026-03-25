
<?php
session_start();
include '../includes/db.php';
$stmt = $conn->prepare("SELECT * FROM tb_pokemon");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

            <?php 
            foreach ($data as $row):?>
            <div class="card">

                <h2 class="name">
                    <?= htmlspecialchars($row['name']) ?>
                </h2>

                <img class="card-img"
                    src="../pokemon img/icons/<?= (int)$row['dex_number'] ?>.png"
                    alt="<?= htmlspecialchars($row['name']) ?>">
                
                <div class="card-body">
                    <h3>
                        <?=  htmlspecialchars($row['type1']) ?>
                        <?=  $row ['type2'] ? '/'.htmlspecialchars($row['type2']) : '' ?>
                    </h3>
                    <p> type 1: <?= htmlspecialchars($row['type1']) ?></p>
                    <p> type 2: <?=  htmlspecialchars($row['type2'] ?? '-') ?></p>
                    <p> Height: <?=  htmlspecialchars($row['height']) ?> m </p>
                    <p> weight: <?= htmlspecialchars($row['weight']) ?>kg </p>

                    <a class="button"
                    href="catch.php?dex=<?=  (int)$row ['dex_number'] ?>"> probeer deze te vangen!
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
    </div>
</div>
            

</body>
</html>