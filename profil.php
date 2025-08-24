<?php
session_start();
include 'configdb.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $avatar = $_FILES['avatar']['name'];
    $bg = $_FILES['fond']['name'];

    if (!empty($avatar)) {
        move_uploaded_file($_FILES['avatar']['tmp_name'], "uploads/" . $avatar);
    }
    if (!empty($bg)) {
        move_uploaded_file($_FILES['fond']['tmp_name'], "uploads/" . $bg);
    }

    $stmt = $pdo->prepare("UPDATE utilisateurs SET avatar = ?, fond_ecran = ? WHERE id = ?");
    $stmt->execute([$avatar, $bg, $user_id]);
    $success_message = "Profil mis à jour.";
}

$stmt = $pdo->prepare("SELECT avatar, fond_ecran FROM utilisateurs WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            background-image: url('uploads/<?= htmlspecialchars($user['fond_ecran'] ?? 'default_bg.jpg') ?>');
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            color: white;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-box {
            background-color: rgba(0, 0, 0, 0.85);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 320px;
            box-shadow: 0 0 10px #00ff88;
        }

        .profile-box h2 {
            margin-bottom: 20px;
            color: #00ff88;
        }

        .profile-box img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 20px;
            border: 2px solid #00ff88;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #00ff88;
            font-weight: bold;
        }

        .form-group input[type="file"] {
            width: 100%;
            background-color: #222;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
        }

        .profile-box button {
            background-color: #00ff88;
            color: #000;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .success {
            background-color: #00ff88;
            color: #000;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<main>
    <div class="profile-box">
        <h2>Mon Profil</h2>
        <img src="uploads/<?= htmlspecialchars($user['avatar'] ?? 'default.png') ?>" alt="Avatar">
        
        <?php if (!empty($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="avatar">Nouvel avatar</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
            </div>
            <div class="form-group">
                <label for="fond">Nouveau fond d’écran</label>
                <input type="file" name="fond" id="fond" accept="image/*">
            </div>
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>
