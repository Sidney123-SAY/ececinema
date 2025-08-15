<?php
session_start();
include '../configdb.php';

if ($_SESSION['statut'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $valide = ($_POST['action'] === 'valider') ? 1 : 0;
    $stmt = $pdo->prepare("UPDATE utilisateurs SET valide = ? WHERE id = ?");
    $stmt->execute([$valide, $_POST['user_id']]);
}

$etudiants = $pdo->query("SELECT * FROM utilisateurs WHERE statut = 'etudiant'")->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<div class="container mt-5">
    <h2>Validation des étudiants</h2>
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
            <?php foreach ($etudiants as $e): ?>
                <tr>
                    <td><?= $e['prenom'] . ' ' . $e['nom'] ?></td>
                    <td><?= $e['email'] ?></td>
                    <td><?= $e['statut'] ?></td>
                    <td><?= $e['valide'] ? 'Oui' : 'Non' ?></td>
                    <td>
                        <form method="POST" class="d-flex gap-2">
                            <input type="hidden" name="user_id" value="<?= $e['id'] ?>">
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
