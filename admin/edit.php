<?php
ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);
include ("#");
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    echo "ongeldige ID";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['#']   ?? '');
    $cost   = trim($_POST['#']   ?? '');
    $type   = $_POST['type']   ?? '';
    $points = trim($_POST['#'] ?? '');
    $lang   = $_POST['lang']   ?? '#';

    if ($name && $cost && in_array($type, ['eten','drinken']) && is_numeric($points) && in_array($lang, ['nl','en'])) {
        $stmt = $conn->prepare("UPDATE tb_producten SET name=?, cost=?, type=?, points=?, lang=? WHERE ID=?");
        $stmt->bind_param("sssssi", $name, $cost, $type, $points, $lang, $id);

        if ($stmt->execute()) {
            header("Location: admin.php?msg=Product+bijgewerkt");
            exit;
        } else {
            $error = "Update mislukt: " . $conn->error;
        }
        $stmt->close();
    } else {
        $error = "Vul alle velden correct in.";
    }
}

// load current data

$stmt = $conn->prepare("SELECT * FROM tb_producten WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    echo "Product niet gevonden.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product wijzigen</title>
    <style>
        body { font-family: sans-serif; max-width: 500px; margin: 40px auto; }
        label { display: block; margin: 1.2em 0 0.3em; }
        input[type=text], input[type=number] { width: 100%; padding: 8px; }
        .error { color: #c00; }
    </style>
</head>
<body>

<h2>Product wijzigen: <?= htmlspecialchars($product['name']) ?></h2>

<?php if (isset($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Product naam:</label>
    <input name="name"   required value="<?= htmlspecialchars($product['name']) ?>">

    <label>Prijs:</label>
    <input name="cost"   required value="<?= htmlspecialchars($product['cost']) ?>">

    <label>Type:</label>
    <label><input type="radio" name="type" value="eten"    <?= $product['type']==='eten'?'checked':'' ?>> eten</label>
    <label><input type="radio" name="type" value="drinken" <?= $product['type']==='drinken'?'checked':'' ?>> drinken</label>

    <label>Punten (prijs × 10):</label>
    <input name="points" required type="number" min="0" value="<?= htmlspecialchars($product['points']) ?>">

    <label>Taal:</label>
    <label><input type="radio" name="lang" value="nl" <?= $product['lang']==='nl'?'checked':'' ?>> Nederlands</label>
    <label><input type="radio" name="lang" value="en" <?= $product['lang']==='en'?'checked':'' ?>> Engels</label>

    <br><br>
    <button type="submit">Opslaan</button>
    &nbsp; &nbsp;
    <a href="admin.php">Annuleren / Terug</a>
</form>

</body>
</html>