<?php
session_start();
include 'configdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $statut = $_POST['statut']; // etudiant ou professeur

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, statut, valide) VALUES (?, ?, ?, ?, ?, 0)");
    if ($stmt->execute([$nom, $prenom, $email, $mot_de_passe, $statut])) {
        $success = "Inscription réussie. En attente de validation.";
    } else {
        $error = "Erreur lors de l'inscription.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

<div class="container mt-5">
    <div class="register-box">
        <h2 class="text-center">Inscription</h2>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <select name="statut" required>
                <option value="">Sélectionner un statut</option>
                <option value="etudiant">Étudiant</option>
                <option value="admin">Professeur</option>
            </select>
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>
        <p class="mt-3 text-center">Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
    
</body>
</html>

<?php include 'includes/footer.php'; ?>
