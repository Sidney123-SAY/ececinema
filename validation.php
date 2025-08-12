<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config/db.php';
    $id = $_POST['id'];
    $type = $_POST['type']; // 'utilisateur' ou 'film'

    if ($type == 'utilisateur') {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET valide = 1 WHERE id = ?");
    } else if ($type == 'film') {
        $stmt = $pdo->prepare("UPDATE films SET valide = 1 WHERE id = ?");
    }
    $stmt->execute([$id]);
    echo "Validation effectuée.";
}