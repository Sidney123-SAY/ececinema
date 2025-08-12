<?php
include 'includes/header.php';
include 'includes/nav.php';
include 'configdb.php';
?>

<h2>Parcourir les films</h2>
<div class="film-grid">
  <?php
  // Requête avec sous-requête pour compter les likes
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
    echo '<p>Thème: ' . htmlspecialchars($film['genre']) . '</p>';
    echo '<form action="like_film.php" method="POST">';
    echo '<input type="hidden" name="film_id" value="' . $film['id'] . '">';
    echo '<button type="submit">👍 ' . $film['likes'] . '</button>';
    echo '</form>';
    echo '</div>';
  }
  ?>
</div>

<?php include 'includes/footer.php'; ?>
