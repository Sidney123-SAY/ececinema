<?php
session_start();
include 'configdb.php';

// Vérification de session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fonction pour normaliser un texte
function normalize($string) {
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string); // Supprime accents
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9]+/', '_', $string);
    return trim($string, '_');
}

// 📌 Synchronisation images <-> films
$image_dir = __DIR__ . "/images/";
$files = scandir($image_dir);

// Récupérer tous les films
$stmt = $pdo->query("SELECT id, titre FROM films");
$films = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($films as $film) {
    $titre_norm = normalize($film['titre']);
    $found_image = null;

    // Vérifie si une image correspond
    foreach ($files as $file) {
        if (in_array($file, ['.', '..'])) continue;
        $filename = pathinfo($file, PATHINFO_FILENAME);
        if (normalize($filename) === $titre_norm) {
            $found_image = $file;
            break;
        }
    }

    // Met à jour l'image si trouvée
    if ($found_image) {
        $update = $pdo->prepare("UPDATE films SET image = :image WHERE id = :id");
        $update->execute([':image' => $found_image, ':id' => $film['id']]);
    }
}

// Récupération des films avec images à jour
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
            <?php
                // Utilisation directe de la colonne "image"
                $image_path = !empty($film['image']) ? 'images/' . htmlspecialchars($film['image']) : 'images/default.jpg';
            ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= $image_path ?>" class="card-img-top" alt="Affiche de <?= htmlspecialchars($film['titre']) ?>">
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
