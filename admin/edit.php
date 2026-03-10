<?php

use function PHPSTORM_META\type;

ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);
include ("../includes/db.php");
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    echo "ongeldige ID";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['name']   ?? '');
    $type   = $_POST['type']   ?? '';
    $img    = trim($_POST['img']    ?? '');
    $weight = trim($_POST['weight'] ?? '');
    $height = trim($_POST['height'] ?? '');
    $discription = trim($_POST['discription'] ?? '');

    if ($name && in_array($type, ['water','fire','grass','electric','wind']) && $img) {
        $stmt = $conn->prepare("UPDATE tb_pokemon SET name=?, type=?, img=?, weight=?, height=?, discription=? WHERE ID=?");
        $stmt->bind_param("ssssssi", $name, $type, $img, $weight, $height, $discription, $id);
        // $stmt->bind_param("sssssssi", $name, $type, $img, $weight, $height, $discription, $id);

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

$stmt = $conn->prepare("SELECT * FROM tb_pokemon WHERE ID = ?");
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

    <label>img:</label>
    <input name="img"    required value="<?= htmlspecialchars($product['img']) ?>">

    <label>Type:</label>
    <label> <input name="type" required type="radio" value="water"> Water <br> </label>
    <label> <input name="type" required type="radio" value="fire"> Fire <br> </label>
    <label> <input name="type" required type="radio" value="grass"> Grass <br> </label>
    <label> <input name="type" required type="radio" value="electric"> Electric <br> </label>
    <label> <input name="type" required type="radio" value="wind"> Wind <br> </label>
    <br><br>

    <label>Weight:</label>
    <input type="text" name="weight" required class="weight" placeholder="Weight" value="<?= htmlspecialchars($product['weight']) ?>">

    <label>Height:</label>
    <input type="text" name="height" required class="height" placeholder="Height" value="<?= htmlspecialchars($product['height']) ?>">

    <label>Discription:</label>
    <input type="text" name="discription" required class="discription" placeholder="Discription" value="<?= htmlspecialchars($product['discription']) ?>">

    <button type="submit">Opslaan</button>
    &nbsp; &nbsp;
    <a href="admin.php">Annuleren / Terug</a>
</form>

</body>
</html>