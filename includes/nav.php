<?php
// includes/nav.php
?>

<style>
.navbar-netflix {
    background-color: #000;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 40px;
    font-family: 'Arial', sans-serif;
    flex-wrap: wrap;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    color: #00ff88;
}

.main-nav ul {
    list-style: none;
    display: flex;
    gap: 25px;
    margin: 0;
    padding: 0;
    flex-wrap: wrap;
}

.main-nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    transition: color 0.3s ease;
}

.main-nav ul li a:hover {
    color: #00ff88;
}

.nav-icons {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-top: 10px;
}

.icon {
    color: #fff;
    font-size: 18px;
    text-decoration: none;
    position: relative;
}

.icon:hover {
    color: #00ff88;
}

.badge {
    position: absolute;
    top: -6px;
    right: -10px;
    background-color: #00ff88;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
}

@media (max-width: 768px) {
    .navbar-netflix {
        flex-direction: column;
        align-items: flex-start;
        padding: 10px 20px;
    }

    .main-nav ul {
        flex-direction: column;
        gap: 10px;
        width: 100%;
        margin-top: 10px;
    }

    .nav-icons {
        width: 100%;
        justify-content: flex-start;
        gap: 15px;
    }

    .main-nav ul li a,
    .icon {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .logo {
        font-size: 20px;
    }

    .main-nav ul li a {
        font-size: 14px;
    }

    .icon {
        font-size: 16px;
    }
}
</style>

<header class="navbar-netflix">
    <div class="logo">ECE CINÉ</div>
    <nav class="main-nav">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="parcourir.php">Tout Parcourir</a></li>
            <li><a href="partage.php">Partage</a></li>
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
    <div class="nav-icons">
        <a href="recherche.html" class="icon">🔍</a>
        <a href="notifications.php" class="icon">🔔<span class="badge">2</span></a>
        <a href="profil.php" class="icon">👤</a>
    </div>
</header>
