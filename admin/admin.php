 <?php
ini_set ('display_errors',1);
ini_set ('display_startup_errors',1);
error_reporting (E_ALL);

 include ("../includes/db.php");

//  DELETE
if (isset($_POST["action"]) && $_POST["action"] === "delete") {
    $id = $_POST["dex_number"] ?? null;

   $stmt = $conn->prepare("DELETE FROM tb_pokemon WHERE dex_number = :id");
   $stmt->bindParam(":id", $id);

   if ($stmt->execute()) {
       header ("Location: admin.php");
       exit;
    } else { $error = "verwijderen mislukt:". implode(", ", $conn->errorInfo()); 
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert/delete page</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 1em 0;
        }
        th, td { padding: 6px 10px; border: 1px solid #999; }
        th { background: #eee; }
        .btn {
    display: inline-block;
    padding: 6px 12px;
    margin: 2px;
    text-decoration: none;
    color: white;
    border-radius: 4px;
    font-size: 0.95em;
    cursor: pointer;
}

.btn.btn.change {
    background-color: #007bff;      /* blue */
}

.btn.delete {
    background-color: #dc3545;      /* red */
}

.btn:hover {
    opacity: 0.9;
}


    </style>
</head>

<!-- lijst van pokemons -->
<body>
    <center>
        <h2>
            voeg pokemons toe aan Database
        </h2>
        <form action="insert.php" method="POST" container class="insert-form">
            Pokemon naam
            <input name="name" required type="text" placeholder="Naam"> <br> <br>

            dex_number
            <input name="dex_number" required type="number" placeholder="Dex number"> <br/> <br/>

            img
            <input name="img" required type="text" placeholder="Image URL"> <br/> <br>

            Type <br><br>
            <input type="checkbox" name="type[]" value="water"> Water
            <input type="checkbox" name="type[]" value="fire"> Fire
            <input type="checkbox" name="type[]" value="grass"> Grass
            <input type="checkbox" name="type[]" value="electric"> Electric
            <input type="checkbox" name="type[]" value="flying"> Flying
            <input type="checkbox" name="type[]" value="ground"> Ground
            <input type="checkbox" name="type[]" value="rock"> Rock
            <input type="checkbox" name="type[]" value="poison"> Poison
            <input type="checkbox" name="type[]" value="ice"> Ice
            <input type="checkbox" name="type[]" value="dark"> Dark
            <input type="checkbox" name="type[]" value="steel"> Steel
            <input type="checkbox" name="type[]" value="fairy"> Fairy
            <input type="checkbox" name="type[]" value="fighting"> Fighting
            <input type="checkbox" name="type[]" value="psychic"> Psychic
            <input type="checkbox" name="type[]" value="bug"> Bug
            <input type="checkbox" name="type[]" value="ghost"> Ghost
            <input type="checkbox" name="type[]" value="dragon"> Dragon
            <input type="checkbox" name="type[]" value="normal"> Normal
            <br> <br>

            

            weight
            <input type="text" name="weight" required class="weight" placeholder="Weight">

            height
            <input type="text" name="height" required class="height" placeholder="Height">

            Description
            <input type="text" name="description" required class="description" placeholder="Description">

            <br> <br>
            <input type="Submit" value="Submit">
            <br> <br> 
        </form>
        <p>

<?php

$search = $_GET['search'] ?? '';

// searchbar
if (!empty($search)) {
    $stmt = $conn->prepare("
        SELECT * FROM tb_pokemon 
        WHERE name LIKE :search 
        OR type1 LIKE :search 
        OR type2 LIKE :search 
        OR description LIKE :search 
        OR dex_number LIKE :search 
        or weight LIKE :search 
        or height LIKE :search");
    $searchTerm = "%" . $search . "%";

    $stmt->bindValue(':search', $searchTerm);

    $stmt->execute();
    $result = $stmt;
} else {
    $result = $conn->query("SELECT * FROM tb_pokemon");
}


 if (!$result) {
    echo "<p style='color:red; font-weight:bold;'> dataquery mislukt: ";
 } $data = $result->fetchAll(PDO::FETCH_ASSOC);

    if (!$data) {
        echo "<p style='color:red; font-weight:bold;'> geen pokemon gevonden.</p>";
 } else{
 ?>
    <!-- lijst met hele database -->

    <form method="GET">
        <input type="text" name="search" placeholder="Zoeken" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit">Search</button>
    </form>
    <a href="admin.php">Reset</a>

    <table>
        <tr>
            <th>dex nummer</th>
            <th>Pokemon</th>
            <th>Img</th>
            <th>Type1</th>
            <th>type 2</th>
            <th>Weight</th>
            <th>Height</th> 
            <th>Description</th>
        </tr>

        <?php foreach ($data as $row) { ?>
            <tr>
            <td><?= htmlspecialchars($row['dex_number']    ?? '—') ?></td>
            <td><?= htmlspecialchars($row['name']  ?? '—') ?></td>
            <td> <img src="../pokemon img/icons/<?= htmlspecialchars($row['dex_number']  ?? '—') ?>.png" alt=""></td>
            <td><?= htmlspecialchars($row['type1'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['type2'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['weight'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['height'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['description'] ?? '—') ?></td>
            <td><form action="admin.php" method="POST" style="display:inline;"> 
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="dex_number" value="<?= $row['dex_number'] ?>">
            <button type="submit" class="btn delete"
                onclick="return confirm('Weet je zeker dat je <?= htmlspecialchars($row['name'], ENT_QUOTES) ?> wilt verwijderen?');">
                🗑️ Verwijderen
            </button> 
        <a href="edit.php?dex_number=<?= $row['dex_number'] ?>" 
                            class="btn change"
                            onclick="return confirm('Weet je zeker dat je <?= htmlspecialchars($row['name'], ENT_QUOTES) ?> wilt wijzigen?');">
                            wijzigen ✏️
                            </a>
        
        </td> 
 </form>

</tr>
        
    <?php
        }}
    ?>
    </table>
    </center>
</body>
</html>