<?php
session_start();
include 'configdb.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partager un film - ECE CINÉ</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background-color: #111;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #00ff88;
        }

        h2 {
            text-align: center;
            color: #00ff88;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #00ff88;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #222;
            color: white;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00ff88;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #00cc66;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="container">
    <h2>Partager un film</h2>
    <form action="film_partage.php" method="POST" enctype="multipart/form-data">
        <label for="titre">Titre du film</label>
        <input type="text" name="titre" id="titre" placeholder="Titre du film" required>

        <label for="genre">Thème</label>
        <input type="text" name="genre" id="genre" placeholder="Thème" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" placeholder="Description" rows="4" required></textarea>

        <label for="image">Affiche du film</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit">Partager</button>
    </form>
</div>

<footer>
    © 2025 ECE CINÉ. Tous droits réservés.
</footer>

</body>
</html>
