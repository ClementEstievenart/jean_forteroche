<nav id="head_menu">
    <ul>
    <li><a href="index.php?action=home" class="button">Accueil</a></li>
    <li><a href="index.php?action=listPosts&amp;page=1" class="button">Chapitres</a>
        <ol class="sublist">
            <?php foreach ($postTitles as $postTitle) {?>
                <li class="button"><a href="index.php?action=getPost&amp;postId=<?= htmlspecialchars($postTitle->id()) ?>&amp;page=1"><?= htmlspecialchars_decode($postTitle->title()) ?></a></li>
            <?php }?>
        </ol>
    </li>
    <?php if (isset($_SESSION['login'])) {?>
        <li><a href="index.php?action=writeNewPost" class="button">Nouveau chapitre</a></li>
        <li><a href="index.php?action=listPostsTitle&amp;page=1" class="button">Éditer un chapitre</a></li>
        <li><a href="index.php?action=listCommentsReport&amp;page=1" class="button">Modérer les commentaires</a></li>
        <li><a href="index.php?action=disconnection" class="button">Déconnexion</a></li>
    <?php } else {?>
        <li><a href="index.php?action=login" class="button">Connexion</a></li>
    <?php }?>
    </ul>
</nav>
