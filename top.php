<?php
include 'configdb.php';
$stmt = $pdo->query("SELECT f.id, f.titre, f.affiche, COUNT(l.id) as nb_likes
                     FROM films f
                     LEFT JOIN likes l ON f.id = l.film_id
                     WHERE f.valide = 1
                     GROUP BY f.id
                     ORDER BY nb_likes DESC
                     LIMIT 5");

echo "<h2>Top 5 des films les plus aimés</h2><div class='films'>";
foreach ($stmt as $film) {
    echo "<div class='film'>
            <img src='uploads/" . $film['affiche'] . "' width='150'>
            <h4>" . $film['titre'] . "</h4>
            <p>👍 " . $film['nb_likes'] . "</p>
         </div>";
}
echo "</div>";


