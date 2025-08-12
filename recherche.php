<?php
include 'configdb.php';
if (isset($_GET['q'])) {
    $q = '%' . $_GET['q'] . '%';
    $stmt = $pdo->prepare("SELECT * FROM films WHERE titre LIKE ? AND valide = 1");
    $stmt->execute([$q]);
    foreach ($stmt as $film) {
        echo "<div><h3>" . $film['titre'] . "</h3><p>" . $film['realisateur'] . "</p></div>";
    }
}
