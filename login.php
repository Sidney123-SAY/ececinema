<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'configdb.php';
    $email = $_POST['email'];
    $pass = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ? AND valide = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['statut'] = $user['statut'];
        header("Location: dashboard/" . $user['statut'] . ".php");
        exit;
    } else {
        $error = "Connexion échouée.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

<div class="container mt-5">
    <div class="login-box">
        <h2 class="text-center">Connexion</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
        <p class="mt-3 text-center">Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
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

