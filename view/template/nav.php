<nav id="head_menu">
    <ul>
    <li><a href="index.php?action=home">Accueil</a></li>
    <li><a href="index.php?action=listPosts&amp;page=1">Chapitres</a>
        <ol class="sublist">
            <?php foreach ($postTitles as $postTitle) {?>
                <li><a href="index.php?action=getPost&amp;postId=<?= htmlspecialchars($postTitle->id()) ?>&amp;page=1"><?= htmlspecialchars_decode($postTitle->title()) ?></a></li>
            <?php }?>
        </ol>
    </li>
    <?php if (isset($_SESSION['login'])) {?>
        <li><a href="index.php?action=writeNewPost">Nouveau chapitre</a></li>
        <li><a href="index.php?action=listPostsTitle&amp;page=1">Éditer un chapitre</a></li>
        <li><a href="index.php?action=listCommentsReport&amp;page=1">Modérer les commentaires</a></li>
        <li><a href="index.php?action=disconnection">Déconnexion</a></li>
    <?php } else {?>
        <li><a href="index.php?action=login">Connexion</a></li>
    <?php }?>
    </ul>
</nav>
