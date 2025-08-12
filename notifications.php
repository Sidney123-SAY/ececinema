<?php
session_start();
include 'configdb.php';
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? AND vue = 0 ORDER BY date DESC");
$stmt->execute([$user_id]);
foreach ($stmt as $notif) {
    echo "<p>" . $notif['message'] . "</p>";
}