<?php

use function PHPSTORM_META\type;

ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);
include ("../includes/db.php");
$id = (int)($_GET['dex_number'] ?? 0);

if ($id <= 0) {
    echo "ongeldige dex number opgegeven.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name']   ?? '');
    $img    = trim($_POST['img']    ?? '');
    $weight = trim($_POST['weight'] ?? '');
    $height = trim($_POST['height'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $types = $_POST['type'] ?? [];
    $type1 = $types[0] ?? null;
    $type2 = $types[1] ?? null;

    if ($name && $img && count($types) >= 1) {

    try {
        $stmt = $conn->prepare("UPDATE tb_pokemon SET name = ?, img = ?, type1 = ?, type2 = ?, weight = ?, height = ?, description = ? WHERE dex_number = ?");    
        $stmt->execute([$name, $img, $type1, $type2, $weight, $height, $description, $id]);

        if ($stmt->execute()) {
            header("Location: admin.php?msg=Product+bijgewerkt");
            exit;
        } 
        } catch (PDOException $e) {
            $error = "Update mislukt: " . $e->getMessage();
        }
        } else {
        $error = "Vul alle velden correct in.";
    }
}

// load current data

$stmt = $conn->prepare("SELECT * FROM tb_pokemon WHERE dex_number = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <label>naam:</label>
    <input name="name"   required value="<?= htmlspecialchars($product['name']) ?>">

    dex_number
    <input type="hidden" name="dex_number" value="<?= htmlspecialchars($product['dex_number']) ?>">
    <label>img:</label>
    <input name="img"    required value="<?= htmlspecialchars($product['img']) ?>">

    <label>
        <input type="checkbox" name="type[]" value="water"
        <?=  ($product['type1'] === 'water') || ($product['type2'] === 'water') ? 'checked' : '' ?>
        > Water
    </label>

    <label>
        <input type="checkbox" name="type[]" value="fire"
        <?=  ($product['type1'] === 'fire') || ($product['type2'] === 'fire') ? 'checked' : '' ?>
        > Fire
    </label>

    <label>
        <input type="checkbox" name="type[]" value="grass"
        <?=  ($product['type1'] === 'grass') || ($product['type2'] === 'grass') ? 'checked' : '' ?>
        > Grass
    </label>

    <label>
        <input type="checkbox" name="type[]" value="electric"
        <?=  ($product['type1'] === 'electric') || ($product['type2'] === 'electric') ? 'checked' : '' ?>
        > Electric
    </label>

    <label>
        <input type="checkbox" name="type[]" value="flying"
        <?=  ($product['type1'] === 'flying') || ($product['type2'] === 'flying') ? 'checked' : '' ?>
        > Flying
    </label>      

    <label>
        <input type="checkbox" name="type[]" value="ground"
        <?=  ($product['type1'] === 'ground') || ($product['type2'] === 'ground') ? 'checked' : '' ?>
        > Ground
    </label>

    <label>
        <input type="checkbox" name="type[]" value="rock"
        <?=  ($product['type1'] === 'rock') || ($product['type2'] === 'rock') ? 'checked' : '' ?>
        > Rock
    </label>

    <label>
        <input type="checkbox" name="type[]" value="poison"
        <?=  ($product['type1'] === 'poison') || ($product['type2'] === 'poison') ? 'checked' : '' ?>
        > Poison
    </label>

    <label>
        <input type="checkbox" name="type[]" value="ice"
        <?=  ($product['type1'] === 'ice') || ($product['type2'] === 'ice') ? 'checked' : '' ?>
        > Ice
    </label>

    <label>
        <input type="checkbox" name="type[]" value="dark"
        <?=  ($product['type1'] === 'dark') || ($product['type2'] === 'dark') ? 'checked' : '' ?>
        > Dark
    </label>

    <label>
        <input type="checkbox" name="type[]" value="steel"
        <?=  ($product['type1'] === 'steel') || ($product['type2'] === 'steel') ? 'checked' : '' ?>
        > Steel
    </label>

    <label>
        <input type="checkbox" name="type[]" value="fairy"
        <?=  ($product['type1'] === 'fairy') || ($product['type2'] === 'fairy') ? 'checked' : '' ?>
        > Fairy
    </label>

    <label>
        <input type="checkbox" name="type[]" value="fighting"
        <?=  ($product['type1'] === 'fighting') || ($product['type2'] === 'fighting') ? 'checked' : '' ?>
        > Fighting
    </label>

    <label>
        <input type="checkbox" name="type[]" value="psychic"
        <?=  ($product['type1'] === 'psychic') || ($product['type2'] === 'psychic') ? 'checked' : '' ?>
        > Psychic
    </label>

    <label>
        <input type="checkbox" name="type[]" value="bug"
        <?=  ($product['type1'] === 'bug') || ($product['type2'] === 'bug') ? 'checked' : '' ?>
        > Bug
    </label>

    <label>
        <input type="checkbox" name="type[]" value="ghost"
        <?=  ($product['type1'] === 'ghost') || ($product['type2'] === 'ghost') ? 'checked' : '' ?>
        > Ghost
    </label>

    <label>
        <input type="checkbox" name="type[]" value="dragon"
        <?=  ($product['type1'] === 'dragon') || ($product['type2'] === 'dragon') ? 'checked' : '' ?>
        > Dragon
    </label>

    <label>
        <input type="checkbox" name="type[]" value="normal"
        <?=  ($product['type1'] === 'normal') || ($product['type2'] === 'normal') ? 'checked' : '' ?>
        > Normal
    </label>

    <label>Weight:</label>
    <input type="text" name="weight" required class="weight" placeholder="Weight" value="<?= htmlspecialchars($product['weight']) ?>">

    <label>Height:</label>
    <input type="text" name="height" required class="height" placeholder="Height" value="<?= htmlspecialchars($product['height']) ?>">

    <label>Description:</label>
    <input type="text" name="description" required class="description" placeholder="Description" value="<?= htmlspecialchars($product['description']) ?>">

    <button type="submit">Opslaan</button>
    &nbsp; &nbsp;
    <a href="admin.php">Annuleren / Terug</a>
</form>

</body>
</html>