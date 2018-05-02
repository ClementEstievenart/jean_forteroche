<header>
    <h1>Billet Simple pour l'Alaska</h1>
    <nav>
        <a href="index.php?action=home">Accueil</a>
        <a href="index.php?action=listPosts">Épisodes</a>
        <?php if (isset($_SESSION['login']) AND isset($_SESSION['password'])) {?>
            <a href="index.php?action=writeNewPost">Nouvel épisode</a>
            <a>Éditer un épisode</a>
            <a>Modérer les commentaires</a>
            <a href="index.php?action=disconnection">Déconnexion</a>
        <?php } else {?>
            <a href="index.php?action=login">Connexion</a>
        <?php }?>
    </nav>
</header>
