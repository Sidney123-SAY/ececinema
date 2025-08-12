<?php
// ===============  (avatar + fond d’écran) ==============
session_start();
include 'configdb.php';
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $avatar = $_FILES['avatar']['name'];
    $bg = $_FILES['fond']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], "uploads/" . $avatar);
    move_uploaded_file($_FILES['fond']['tmp_name'], "uploads/" . $bg);

    $stmt = $pdo->prepare("UPDATE utilisateurs SET avatar = ?, fond_ecran = ? WHERE id = ?");
    $stmt->execute([$avatar, $bg, $user_id]);
    echo "Profil mis à jour.";
}

$stmt = $pdo->prepare("SELECT avatar, fond_ecran FROM utilisateurs WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

echo "<style>
    body { background-image: url('uploads/" . $user['fond_ecran'] . "'); background-size: cover; color: white; }
</style>";
echo "<h2>Mon Profil</h2>
<img src='uploads/" . $user['avatar'] . "' width='100'><br>
<form method='POST' enctype='multipart/form-data'>
    Nouvel avatar : <input type='file' name='avatar'><br>
    Nouveau fond d’écran : <input type='file' name='fond'><br>
    <button type='submit'>Mettre à jour</button>
</form>";