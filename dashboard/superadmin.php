<?php
session_start();
include '../configdb.php';

if ($_SESSION['statut'] !== 'superadmin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $valide = ($_POST['action'] === 'valider') ? 1 : 0;
    $stmt = $pdo->prepare("UPDATE utilisateurs SET valide = ? WHERE id = ?");
    $stmt->execute([$valide, $_POST['user_id']]);
}

$utilisateurs = $pdo->query("SELECT * FROM utilisateurs WHERE statut IN ('etudiant', 'admin')")->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<div class="container mt-5">
    <h2>Validation des utilisateurs (étudiants et professeurs)</h2>
    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Validé</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $u): ?>
                <tr>
                    <td><?= $u['prenom'] . ' ' . $u['nom'] ?></td>
                    <td><?= $u['email'] ?></td>
                    <td><?= ucfirst($u['statut']) ?></td>
                    <td><?= $u['valide'] ? 'Oui' : 'Non' ?></td>
                    <td>
                        <form method="POST" class="d-flex gap-2">
                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                            <button name="action" value="valider" class="btn btn-success btn-sm">Valider</button>
                            <button name="action" value="refuser" class="btn btn-danger btn-sm">Refuser</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    
</body>
</html>
