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

        // Redirection selon le statut
        if ($user['statut'] === 'superadmin') {
            header("Location: dashboard/superadmin.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Connexion échouée.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - ECE CINÉ</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #0f0;
        }

        .login-box {
            background-color: #111;
            padding: 30px;
            border-radius: 10px;
            width: 280px;
            text-align: center;
            box-shadow: 0 0 10px #0f0;
        }

        .login-box h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #0f0;
        }

        .login-box input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #222;
            color: #fff;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            background-color: #0f0;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-box .register {
            margin-top: 15px;
            font-size: 13px;
            color: #0f0;
        }

        .login-box .register a {
            color: #0f0;
            text-decoration: underline;
        }

        .error {
            background-color: #f00;
            color: white;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <p class="register">Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
    </div>
</body>
</html>



