<?php

use Dom\Sqlite;

include ("../includes/db.php");

$name = $_POST["name"] ?? '';
$img = $_POST["img"]?? '';
$type = $_POST["type"]?? '';
$weight = $_POST["weight"]?? '';
$height = $_POST["height"]?? '';
$discription = $_POST["discription"]?? '';

$sql = "INSERT INTO `tb_pokemon` (`name`, `img`, `type`, `weight`, `height`, `discription`)
VALUES ('$name', '$img', '$type', '$weight', '$height', '$discription')";
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