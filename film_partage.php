<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'configdb.php';
    session_start();
    $titre = $_POST['titre'];
    $realisateur = $_POST['realisateur'];
    $trailer = $_POST['trailer'];
    $user_id = $_SESSION['user_id'];
    $affiche = $_FILES['affiche']['name'];
    move_uploaded_file($_FILES['affiche']['tmp_name'], "uploads/" . $affiche);

    $stmt = $pdo->prepare("INSERT INTO films (titre, realisateur, trailer, affiche, poste_par) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$titre, $realisateur, $trailer, $affiche, $user_id]);
    echo "Film soumis pour validation.";
}
