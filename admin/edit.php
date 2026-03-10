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
    $type1   = $_POST['type1']   ?? '';
    $type2   = $_POST['type2']   ?? '';
    $img    = trim($_POST['img']    ?? '');
    $weight = trim($_POST['weight'] ?? '');
    $height = trim($_POST['height'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name && in_array($type1, ['water','fire','grass','electric','wind']) && $img) {
        $stmt = $conn->prepare("UPDATE tb_pokemon SET name=?, type1=?, type2=?, img=?, weight=?, height=?, description=? WHERE dex_number=?");
        $stmt->bind_param("sssssssi", $name, $type1, $type2, $img, $weight, $height, $description, $id);
        // $stmt->bind_param("sssssssi", $name, $type1, $type2, $img, $weight, $height, $description, $id);

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

$stmt = $conn->prepare("SELECT * FROM tb_pokemon WHERE dex_number = ?");
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
    <label>naam:</label>
    <input name="name"   required value="<?= htmlspecialchars($product['name']) ?>">

    dex_number
    <input name="dex_number" required type="number" value="<?= htmlspecialchars($product['dex_number']) ?>">

    <label>img:</label>
    <input name="img"    required value="<?= htmlspecialchars($product['img']) ?>">

    <label>Type:</label>
    <label> <input name="type" required type="radio" value="water"> Water <br> </label>
    <label> <input name="type" required type="radio" value="fire"> Fire <br> </label>
    <label> <input name="type" required type="radio" value="grass"> Grass <br> </label>
    <label> <input name="type" required type="radio" value="electric"> Electric <br> </label>
    <label> <input name="type" required type="radio" value="wind"> Wind <br> </label>
    <br><br>

     2e type<br>
    <input type="type"  name="radio" value="fly"> Fly <br>  
    <input type="type"  name="radio" value:="ground"> Ground <br>
    <input type="type"  name="radio" value:="rock"> Rock <br>
    <input type="type"  name="radio" value:="poison"> Poison <br>

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