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
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            font-family: 'Arial', sans-serif;
            color: #00ff88;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 60px); /* Ajuster selon la hauteur de la nav */
        }

        .login-box {
            background-color: #111;
            padding: 40px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            box-shadow: 0 0 15px #00ff88;
        }

        .login-box h2 {
            margin-bottom: 25px;
            font-size: 26px;
            color: #00ff88;
        }

        .login-box input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #222;
            color: #fff;
            font-size: 16px;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            background-color: #00ff88;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
        }

        .login-box .register {
            margin-top: 20px;
            font-size: 14px;
            color: #00ff88;
        }

        .login-box .register a {
            color: #00ff88;
            text-decoration: underline;
        }

        .error {
            background-color: #f00;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <?php include 'includes/nav.php'; ?>

    <div class="main-content">
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
    </div>

</body>
</html>
