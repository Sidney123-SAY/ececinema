<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'configdb.php';
    session_start();
    $film_id = $_POST['film_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO likes (film_id, user_id) VALUES (?, ?)");
    $stmt->execute([$film_id, $user_id]);
    echo "Film liké.";
}
