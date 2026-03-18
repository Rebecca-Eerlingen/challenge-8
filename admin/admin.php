 <?php
ini_set ('display_errors',1);
ini_set ('display_startup_errors',1);
error_reporting (E_ALL);

include ("../includes/db.php");


//  DELETE
if (isset($_POST["action"]) && $_POST["action"] === "delete") {
    $id = $_POST["id"] ?? null;

   $stmt = $conn->prepare("DELETE FROM tb_pokemon WHERE id = ?");
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
    <link rel="stylesheet" href="style.css">
    <body>

    <div class="dropdown">
    <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Meer
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Overzicht</a>
        <a class="dropdown-item" href="#">Pokedex</a>
        <a class="dropdown-item" href="#">Database</a>
    </div>
    </div>


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

    <center>
        <h2 id="titel">
            Pokemon database, add, delete en edit pokemons
        </h2>
        <form class="formBox" action="insert.php" method="POST">
            Pokemon naam
            <input name="name" required type="text" placeholder="Naam"> <br/> <br/>

            img
            <input name="img" required type="text" placeholder="Image URL"> <br/> <br>
        
        <div class="box"> 
            <p>type pokemon<p><br>

            <input name="type" required type="radio" value="water"> Water <br>
            <input name="type" required type="radio" value="fire"> Fire <br>
            <input name="type" required type="radio" value="grass"> Grass <br>
            <input name="type" required type="radio" value="electric"> Electric <br>
            <input name="type" required type="radio" value="wind"> Wind <br>
        </div>

            weight
            <input type="text" name="weight" required class="weight" placeholder="Weight">

            height
            <input type="text" name="height" required class="height" placeholder="Height">

            description
            <input type="text" name="description" required class="description" placeholder="Description">

            <input type="submit" value="submit">
        
            <br> <br> 
        </form>

    <form action="admin.php" method="GET">
        <input type="text" name="query" placeholder="search...">
        <button type="submit">Search</button>
    </form>
        <p>

<?php
//searchbar
$search = $_GET['query'] ?? '';

if ($search !== '') {
    $stmt = $conn->prepare("
        SELECT * FROM tb_pokemon 
        WHERE name LIKE ? 
        OR type LIKE ? 
        OR weight LIKE ? 
        OR height LIKE ? 
        OR discription LIKE ?
    ");

    $like = "%".$search."%";

    $stmt->bind_param("sssss", $like, $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    $result = $conn->query("SELECT * FROM tb_pokemon");
}
/* Als de ingevulde zoektermen niet staan in de database, 
dan laat hij de onderstaande tekst zien 
'geen resultaat' in het rood
*/
if (!$result) {
    echo "<p style='color:red; font-weight:bold;'>";
    echo '</p>';
} elseif ($result->rowCount() === 0) {
    echo '<p>geen resultaat.</p>';
} else {

    //searchbar
 ?>
    <!-- lijst met hele database -->
    <table>
        <tr>
            <th>ID</th>
            <th>Pokemon</th>
            <th>Img</th>
            <th>Type</th>
            <th>Weight</th>
            <th>Height</th> 
            <th>Description</th>
        </tr>

        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
            <td><?= htmlspecialchars($row['id']    ?? '—') ?></td>
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
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn delete"
                                    onclick="return confirm('Weet je zeker dat je <?= htmlspecialchars($row['name'], ENT_QUOTES) ?> wilt verwijderen?');">
                                    🗑️ Verwijderen
                                </button>
                            </form>
                            <a href="edit.php?id=<?= $row['id'] ?>" 
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