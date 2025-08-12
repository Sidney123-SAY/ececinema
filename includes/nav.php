<?php
// includes/nav.php
?>
<nav>
  <ul>
    <li><a href="index.php">Accueil</a></li>
    <li><a href="parcourir.php">Tout Parcourir</a></li>
    <li><a href="partage.php">Partage</a></li>
    <li><a href="notifications.php">Notifications</a></li>
    <li><a href="profil.php">Compte</a></li>
    <li><a href="recherche.html">Recherche</a></li>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'enseignant') { ?>
      <li><a href="/validation_film.html">Valider Films</a></li>
    <?php } ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
      <li><a href="/validation_inscription.html">Valider Utilisateurs</a></li>
    <?php } ?>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin') { ?>
      <li><a href="/radiation.html">Radiation</a></li>
    <?php } ?>
    <li><a href="logout.php">Déconnexion</a></li>
  </ul>
</nav>
