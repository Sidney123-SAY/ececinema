<?php
include 'includes/header.php';
?>

<h2>Partager un film</h2>

<form action="film_partage.php" method="POST" enctype="multipart/form-data">
  <input type="text" name="titre" placeholder="Titre du film" required>
  <input type="text" name="genre" placeholder="Thème" required>
  <textarea name="description" placeholder="Description" rows="4" required></textarea>
  <input type="file" name="image" accept="image/*" required>
  <button type="submit">Partager</button>
</form>

<?php
include 'includes/footer.php';
?>
