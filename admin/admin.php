 <?php
ini_set ('display_errors',1);
ini_set ('display_startup_errors',1);
error_reporting (E_ALL);

 include ("../includes/db.php");

//  DELETE
if (isset($_POST["action"]) && $_POST["action"] === "delete") {
    $id = $_POST["dex_number"] ?? null;

   $stmt = $conn->prepare("DELETE FROM tb_pokemon WHERE dex_number = ?");
   $stmt->bind_param("i", $id);

   if ($stmt->execute()) {
       header ("Location: admin.php");
       exit;
    } else { $error = "verwijderen mislukt:". $conn->error; 
    } 
    $stmt->close();
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
        <form action="insert.php" method="POST">
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

            <input type="Submit" value="Submit">
            <br> <br> 
        </form>
        <p>

<?php
$result = $conn->query("SELECT * FROM tb_pokemon");

 if (!$result) {
    echo "<p style='color:red; font-weight:bold;'> ";
    echo 'data query mislukt'. htmlspecialchars($conn->error);
    echo '</p>';
 } elseif ($result->num_rows === 0) {
    echo '<p> geen producten gevonden.</p>';
 } else { 
 ?>
    <!-- lijst met hele database -->
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

        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
            <td><?= htmlspecialchars($row['dex_number']    ?? '—') ?></td>
            <td><?= htmlspecialchars($row['name']  ?? '—') ?></td>
            <td> <img src="../pokemon img/icons/<?= htmlspecialchars($row['dex_number']  ?? '—') ?>.png" alt=""></td>
            <td><?= htmlspecialchars($row['type1'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['type2'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['weight'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['height'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['description'] ?? '—') ?></td>
            <td>
                            <form>
                                
                            </form>
                            <form action="admin.php" method="POST" style="display:inline;"> 
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="dex_number" value="<?= $row['dex_number'] ?>">
                                <button type="submit" class="btn delete"
                                    onclick="return confirm('Weet je zeker dat je <?= htmlspecialchars($row['name'], ENT_QUOTES) ?> wilt verwijderen?');">
                                    🗑️ Verwijderen
                                </button>
                            </form>
                            <a href="edit.php?dex_number=<?= $row['dex_number'] ?>" 
                            class="btn change"
                            onclick="return confirm('Weet je zeker dat je <?= htmlspecialchars($row['name'], ENT_QUOTES) ?> wilt wijzigen?');">
                            wijzigen ✏️
                            </a>

                        </td>
</td>
                            </a>
                        </td>
            </tr>
        <?php endwhile; ?>

    </table>
    <?php
        }
    ?>
    </center>
</body>
</html>