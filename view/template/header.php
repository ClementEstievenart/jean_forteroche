<header>
    <div id="header_title">
        <h1>Billet Simple pour l'Alaska</h1>
        <p>Par Jean Forteroche</p>
    </div>
    <nav>
        <a href="index.php?action=home">Accueil</a>
        <a href="index.php?action=listPosts&amp;page=1">Épisodes</a>
        <?php if (isset($_SESSION['login'])) {?>
            <a href="index.php?action=writeNewPost">Nouvel épisode</a>
            <a href="index.php?action=listPostsTitle&amp;page=1">Éditer un épisode</a>
            <a href="index.php?action=listCommentsReport&amp;page=1">Modérer les commentaires</a>
            <a href="index.php?action=disconnection">Déconnexion</a>
        <?php } else {?>
            <a href="index.php?action=login">Connexion</a>
        <?php }?>
    </nav>
</header>
