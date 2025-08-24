<?php
session_start();
include 'configdb.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$film_id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM films WHERE id = :id");
$stmt->execute([':id' => $film_id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$film) {
    header("Location: index.php");
    exit;
}

// Compter le nombre de likes
$like_count_stmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE film_id = :film_id");
$like_count_stmt->execute([':film_id' => $film_id]);
$like_count = $like_count_stmt->fetchColumn();

// Vérifier si l'utilisateur a liké
$user_liked = false;
if (isset($_SESSION['user_id'])) {
    $check_like = $pdo->prepare("SELECT * FROM likes WHERE film_id = :film_id AND user_id = :user_id");
    $check_like->execute([':film_id' => $film_id, ':user_id' => $_SESSION['user_id']]);
    $user_liked = $check_like->fetch() ? true : false;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($film['titre']) ?> - Détails</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .img-fluid {
            max-width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-success {
            background-color: #00ff88;
            color: #000;
        }
        .btn-danger {
            background-color: #ff4444;
            color: #fff;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4"><?= htmlspecialchars($film['titre']) ?></h1>

    <div class="row">
        <div class="col-md-4">
            <?php $image_path = !empty($film['image']) ? 'images/' . htmlspecialchars($film['image']) : 'images/default.jpg'; ?>
            <img src="<?= $image_path ?>" alt="Affiche de <?= htmlspecialchars($film['titre']) ?>" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-8">
            <h3>Description</h3>
            <p><?= nl2br(htmlspecialchars($film['description'] ?? 'Aucune description')) ?></p>
            <p><strong>Genre:</strong> <?= htmlspecialchars($film['genre'] ?? 'Non spécifié') ?></p>
            <p><strong>Année:</strong> <?= htmlspecialchars($film['annee'] ?? 'Inconnue') ?></p>
            <p><strong>Date d'ajout:</strong> <?= htmlspecialchars($film['date_ajout'] ?? 'Inconnue') ?></p>

            <?php if (isset($_SESSION['user_id'])): ?>
                <button id="like-button" class="btn <?= $user_liked ? 'btn-danger' : 'btn-success' ?>">
                    <?= $user_liked ? '💔 Retirer Like' : '❤️ Like' ?>
                </button>
            <?php else: ?>
                <p><em>Connectez-vous pour liker ce film.</em></p>
            <?php endif; ?>

            <p class="mt-3"><strong>Likes :</strong> <span id="like-count"><?= $like_count ?></span></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<?php if (isset($_SESSION['user_id'])): ?>
<script>
document.getElementById("like-button").addEventListener("click", function () {
    fetch("like_film.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "film_id=<?= $film['id'] ?>",
        credentials: "same-origin"
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("like-count").textContent = data.like_count;
            const btn = document.getElementById("like-button");
            if (data.action === "liked") {
                btn.classList.remove("btn-success");
                btn.classList.add("btn-danger");
                btn.textContent = "💔 Retirer Like";
            } else {
                btn.classList.remove("btn-danger");
                btn.classList.add("btn-success");
                btn.textContent = "❤️ Like";
            }
        }
    });
});
</script>
<?php endif; ?>

</body>
</html>
