<?php
session_start();
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($name) && !empty($img) && count($types) >= 1) {
        try {
            $stmt = $conn->prepare("INSERT INTO tb_pokemon (name, img, type1, type2, weight, height, description, dex_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $img, $type1, $type2, $weight, $height, $description, $dex_number]);
            header("Location: admin.php?msg=Product+toegevoegd");
            exit;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        echo "Vul alle vereiste velden in.";
    }
}
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