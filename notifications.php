<?php
session_start();
include 'configdb.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY date_envoi DESC");
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes notifications</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      background-color: #000;
      color: white;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      flex: 1;
    }

    h1 {
      text-align: center;
      color: #00ff88;
      margin-bottom: 30px;
    }

    .notification {
      background-color: #111;
      border-left: 4px solid #00ff88;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 5px;
    }

    .notification p {
      margin: 0;
    }

    .notification small {
      color: #888;
      font-size: 12px;
    }

    footer {
      background-color: #111;
      color: #00ff88;
      text-align: center;
      padding: 15px;
      margin-top: auto;
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<div class="container">
  <h1>Mes notifications</h1>

  <?php if (empty($notifications)): ?>
    <p style="text-align:center;">Aucune notification pour le moment.</p>
  <?php else: ?>
    <?php foreach ($notifications as $notif): ?>
      <div class="notification">
        <p><?= htmlspecialchars($notif['message']) ?></p>
        <small>Envoyée le <?= date('d/m/Y à H:i', strtotime($notif['date_envoi'])) ?></small>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
