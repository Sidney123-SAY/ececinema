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
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      background-color: #000;
      color: white;
      font-family: 'Arial', sans-serif;
      display: flex;
      flex-direction: column;
    }

    h2 {
      text-align: center;
      color: #00ff88;
      margin-top: 30px;
    }

    .film-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
      padding: 30px;
      flex: 1;
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
      font-size: 16px;
      word-wrap: break-word;
      overflow-wrap: break-word;
      white-space: normal;
    }

    .film-card p {
      color: #ccc;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .like-button {
      background-color: #00ff88;
      color: #000;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    .like-button:hover {
      background-color: #00cc66;
    }

    footer {
      background-color: #111;
      color: #00ff88;
      text-align: center;
      padding: 15px;
      margin-top: auto;
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
    $image_path = !empty($film['image']) ? 'images/' . htmlspecialchars($film['image']) : 'images/default.jpg';
    echo '<div class="film-card">';
    echo '<img src="' . $image_path . '" alt="Affiche du film">';
    echo '<h3>' . htmlspecialchars($film['titre']) . '</h3>';
    echo '<p>Thème : ' . htmlspecialchars($film['genre']) . '</p>';
    echo '<button class="like-button" data-id="' . $film['id'] . '">👍 <span class="like-count">' . $film['likes'] . '</span></button>';
    echo '</div>';
  }
  ?>
</div>

<?php include 'includes/footer.php'; ?>

<script>
document.querySelectorAll('.like-button').forEach(button => {
  button.addEventListener('click', function () {
    const filmId = this.getAttribute('data-id');
    const countSpan = this.querySelector('.like-count');

    fetch("like_film.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "film_id=" + filmId,
      credentials: "same-origin"
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        countSpan.textContent = data.like_count;
      }
    });
  });
});
</script>

</body>
</html>
