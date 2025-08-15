<?php
session_start();
include 'configdb.php';

// Vérification de session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Récupération des films
$stmt = $pdo->query("SELECT * FROM films ORDER BY annee DESC");
$films = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ECE CINÉ - Accueil</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="accueil">
   
<?php include 'includes/nav.php'; ?>

    <!-- Contenu principal -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Bienvenue sur ECE Ciné</h1>

        <div class="row">
            <?php foreach ($films as $film): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="uploads/posters/<?= htmlspecialchars($film['image'] ?? 'default.jpg') ?>" 
                             class="card-img-top" alt="Affiche">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($film['titre'] ?? 'Titre inconnu') ?></h5>
                            <p class="card-text"><?= htmlspecialchars(substr($film['description'] ?? '', 0, 100)) ?>...</p>
                            <p><strong>Genre:</strong> <?= htmlspecialchars($film['genre'] ?? 'Non spécifié') ?></p>
                            <p><strong>Date de sortie:</strong> <?= htmlspecialchars($film['date_sortie'] ?? 'Inconnue') ?></p>
                            <a href="film_details.php?id=<?= $film['id'] ?>" class="btn btn-primary">Voir plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

