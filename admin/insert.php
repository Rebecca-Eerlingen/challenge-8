<?php

use Dom\Sqlite;

include ("../includes/db.php");

$name = $_POST["name"] ?? '';
$img = $_POST["img"]?? '';
$weight = $_POST["weight"]?? '';
$height = $_POST["height"]?? '';
$description = $_POST["description"]?? '';
$dex_number = $_POST["dex_number"]?? '';

$types = $_POST["type"] ?? [];
$type1 = $types[0] ?? NULL;
$type2 = $types[1] ?? NULL;

$sql = "INSERT INTO `tb_pokemon` 
(`name`, `img`, `type1`, `type2`, `weight`, `height`, `description`, `dex_number`)
VALUES 
('$name', '$img', '$type1', '$type2', '$weight', '$height', '$description', '$dex_number')";
if ($conn->query($sql) === TRUE) {
    echo "pokemon succesvol toegevoegd";
} 
else {
    echo "Error" . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br>
    <a href="admin.php">Terug naar adminpagina</a>
</body>
</html>