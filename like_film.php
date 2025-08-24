<?php
session_start();
include 'configdb.php';

header('Content-Type: application/json');

// Vérification des données
if (!isset($_SESSION['user_id']) || !isset($_POST['film_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté ou ID manquant']);
    exit;
}

$film_id = intval($_POST['film_id']);
$user_id = intval($_SESSION['user_id']);

// Vérifier si l'utilisateur a déjà liké
$stmt = $pdo->prepare("SELECT * FROM likes WHERE film_id = :film_id AND user_id = :user_id");
$stmt->execute(['film_id' => $film_id, 'user_id' => $user_id]);

if ($stmt->fetch()) {
    // Retirer le like
    $delete = $pdo->prepare("DELETE FROM likes WHERE film_id = :film_id AND user_id = :user_id");
    $delete->execute(['film_id' => $film_id, 'user_id' => $user_id]);
    $action = 'unliked';
} else {
    // Ajouter le like
    $insert = $pdo->prepare("INSERT INTO likes (film_id, user_id) VALUES (:film_id, :user_id)");
    $insert->execute(['film_id' => $film_id, 'user_id' => $user_id]);
    $action = 'liked';
}

// Compter les likes mis à jour
$count_stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE film_id = :film_id");
$count_stmt->execute(['film_id' => $film_id]);
$like_count = $count_stmt->fetchColumn();

// Réponse JSON
echo json_encode([
    'success' => true,
    'action' => $action,
    'like_count' => $like_count
]);
