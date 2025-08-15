<?php
session_start();
include 'configdb.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parcourir les films - ECE CINÉ</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #000;
      color: white;
      font-family: 'Arial', sans-serif;
    }

    h2 {
      text-align: center;
      color: #00ff88;
      margin-top: 30px;
    }

         display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
      padding: 30px;
    }

    .film-card {
      background-color: #111;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 0 5px #00ff88;
      transition: transform 0.3s ease;
    }

    .film-card:hover {
      transform: scale(1.05);
    }

    .film-card img {
      width: 100%;
      height: 280px;
      object-fit: cover;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .film-card h3 {
      color: #00ff88;
      margin: 10px 0 5px;
    }

    .film-card p {
      color: #ccc;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .film-card form button {
      background-color: #00ff88;
      color: #000;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    .film-card form button:hover {
      background-color: #00cc66;
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<h2>Parcourir les films</h2>

<div class="film-grid">
  <?php
  $query = $pdo->query("
    SELECT f.id, f.titre, f.genre, f.image, f.date_ajout,
      (SELECT COUNT(*) FROM likes WHERE film_id = f.id) AS likes
    FROM films f
    ORDER BY f.date_ajout DESC
  ");

  while ($film = $query->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="film-card">';
    echo '<img src="uploads/posters/' . htmlspecialchars($film['image']) . '" alt="Affiche du film">';
    echo '<h3>' . htmlspecialchars($film['titre']) . '</h3>';
    echo '<p>Thème : ' . htmlspecialchars($film['genre']) . '</p>';
    echo '<form action="like_film.php" method="POST">';
    echo '<input type="hidden" name="film_id" value="' . $film['id'] . '">';
    echo '<button type="submit">👍 ' . $film['likes'] . '</button>';
    echo '</form>';
    echo '</div>';
  }
  ?>
</div>

</body>
</html>
