<?php
session_start();
include 'configdb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $statut = $_POST['statut']; // etudiant ou admin

    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, statut, valide) VALUES (?, ?, ?, ?, ?, 0)");
    if ($stmt->execute([$nom, $prenom, $email, $mot_de_passe, $statut])) {
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['statut'] = $statut;
        header("Location: index.php");
        exit;
    } else {
        $error = "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - ECE CINÉ</title>
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

        .register-box {
            background-color: #111;
            padding: 30px;
            border-radius: 10px;
            width: 280px;
            text-align: center;
            box-shadow: 0 0 10px #0f0;
        }

        .register-box h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #0f0;
        }

        .register-box input,
        .register-box select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #222;
            color: #fff;
        }

        .register-box button {
            width: 100%;
            padding: 10px;
            background-color: #0f0;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .register-box .login-link {
            margin-top: 15px;
            font-size: 13px;
            color: #0f0;
        }

        .register-box .login-link a {
            color: #0f0;
            text-decoration: underline;
        }

        .alert {
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #0f0;
            color: #000;
        }

        .alert-danger {
            background-color: #f00;
            color: white;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Inscription</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
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
            <button type="submit">S'inscrire</button>
        </form>
        <p class="login-link">Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </div>
</body>
</html>
