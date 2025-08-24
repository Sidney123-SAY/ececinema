<?php
include 'configdb.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche - ECE CINÉ</title>
     <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .search-container {
            padding: 20px;
            text-align: center;
            background-color: #111;
            box-shadow: 0 0 10px #00ff88;
        }

        .search-container input[type="text"] {
            width: 60%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: #222;
            color: white;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #00ff88;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-left: 10px;
        }

        .results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
        }

        .film-card {
            background-color: #111;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 5px #00ff88;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .film-card:hover {
            transform: scale(1.05);
        }

        .film-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .film-card h3 {
            color: #00ff88;
            margin-bottom: 5px;
            font-size: 18px;
        }

        .film-card p {
            color: #ccc;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="search-container">
    <form method="GET">
        <input type="text" name="q" placeholder="Rechercher un film..." required>
        <button type="submit">🔍</button>
    </form>
</div>

<div class="results">
<?php
if (isset($_GET['q'])) {
    $q = '%' . $_GET['q'] . '%';
    $stmt = $pdo->prepare("SELECT * FROM films WHERE titre LIKE ? AND valide = 1");
    $stmt->execute([$q]);

    foreach ($stmt as $film) {
        echo "<div class='film-card'>
                <img src='uploads/posters/" . htmlspecialchars($film['image'] ?? 'default.jpg') . "' alt='Affiche'>
                <h3>" . htmlspecialchars($film['titre']) . "</h3>
                <p>Réalisateur : " . htmlspecialchars($film['realisateur']) . "</p>
              </div>";
    }
}
?>
</div>

</body>
</html>
