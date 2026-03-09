<?php
include ("MEESdb.php");

$Producten = mysqli_real_escape_string($conn, $_POST["name"] ?? '');
$prijs = mysqli_real_escape_string($conn, $_POST["cost"]?? '');
$type = mysqli_real_escape_string($conn, $_POST["type"]?? '');
$points = mysqli_real_escape_string($conn, $_POST["points"]?? '');
$lang = mysqli_real_escape_string($conn, $_POST["lang"]?? 'nl');

$sql = "INSERT INTO `tb_producten` (`id`, `name`, `cost`, `type`, `points`, `lang`)
VALUES ('', '$Producten', '$prijs', '$type','$points', '$lang')";
if ($conn->query($sql) === TRUE) {
    echo "producten succesvol toegevoegd";
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