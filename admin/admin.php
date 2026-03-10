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
            <input name="name" required type="text" placeholder="Naam"> <br/> <br/>

            dex_number
            <input name="dex_number" required type="number" placeholder="Dex number"> <br/> <br/>

            img
            <input name="img" required type="text" placeholder="Image URL"> <br/> <br>

            type pokemon<br>
            <input name="type" required type="radio" value="water"> Water <br>
            <input name="type" required type="radio" value="fire"> Fire <br>
            <input name="type" required type="radio" value="grass"> Grass <br>
            <input name="type" required type="radio" value="electric"> Electric <br>
            <input name="type" required type="radio" value="wind"> Wind <br>

            weight
            <input type="text" name="weight" required class="weight" placeholder="Weight">

            height
            <input type="text" name="height" required class="height" placeholder="Height">

            discription
            <input type="text" name="discription" required class="discription" placeholder="Discription">

            <input type="submit" value="submit">
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
            <th>Type</th>
            <th>Weight</th>
            <th>Height</th> 
            <th>Discription</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
            <td><?= htmlspecialchars($row['dex_number']    ?? '—') ?></td>
            <td><?= htmlspecialchars($row['name']  ?? '—') ?></td>
            <td><?= htmlspecialchars($row['img']  ?? '—') ?></td>
            <td><?= htmlspecialchars($row['type'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['weight'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['height'] ?? '—') ?></td>
            <td><?= htmlspecialchars($row['discription'] ?? '—') ?></td>
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
                            <a href="edit.php?id=<?= $row['dex_number'] ?>" 
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