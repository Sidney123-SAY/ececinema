<?php
// =============== NOTIFICATIONS AUTOMATIQUES ==================
// Lors d’un like ou d’une validation

// --- like_film.php : notifier le posteur du film ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && basename(__FILE__) == "like_film.php") {
    include 'configdb.php';
    session_start();
    $film_id = $_POST['film_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO likes (film_id, user_id) VALUES (?, ?)");
    $stmt->execute([$film_id, $user_id]);

    // Notification automatique
    $filmInfo = $pdo->prepare("SELECT poste_par, titre FROM films WHERE id = ?");
    $filmInfo->execute([$film_id]);
    $film = $filmInfo->fetch();

    $message = "Votre film '" . $film['titre'] . "' a été liké.";
    $notif = $pdo->prepare("INSERT INTO notifications (user_id, film_id, message) VALUES (?, ?, ?)");
    $notif->execute([$film['poste_par'], $film_id, $message]);

    echo "Film liké et notification envoyée.";
}

// --- validation.php : notifier l’utilisateur ou le posteur ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && basename(__FILE__) == "validation.php") {
    include 'configdb.php';
    $id = $_POST['id'];
    $type = $_POST['type'];

    if ($type == 'utilisateur') {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET valide = 1 WHERE id = ?");
        $stmt->execute([$id]);

        $message = "Votre inscription sur ECE CINÉ a été validée.";
        $notif = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $notif->execute([$id, $message]);

    } elseif ($type == 'film') {
        $stmt = $pdo->prepare("UPDATE films SET valide = 1 WHERE id = ?");
        $stmt->execute([$id]);

        $getUser = $pdo->prepare("SELECT poste_par, titre FROM films WHERE id = ?");
        $getUser->execute([$id]);
        $film = $getUser->fetch();

        $message = "Votre film '" . $film['titre'] . "' a été validé.";
        $notif = $pdo->prepare("INSERT INTO notifications (user_id, film_id, message) VALUES (?, ?, ?) ");
        $notif->execute([$film['poste_par'], $id, $message]);
    }
    echo "Validation effectuée et notification envoyée.";
}
