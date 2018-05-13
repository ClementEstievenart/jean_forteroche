<nav id="head_menu">
    <ul>
    <li><a href="Accueil" class="button">Accueil</a></li>
    <li><a href="Chapitres/1" class="button">Chapitres</a>
        <ol class="sublist">
            <?php foreach ($postTitles as $postTitle) {?>
                <a href="Chapitre-<?= htmlspecialchars($postTitle->id()) ?>/1"><li class="button"><?= htmlspecialchars_decode($postTitle->title()) ?></li></a>
            <?php }?>
        </ol>
    </li>
    <?php if (isset($_SESSION['login'])) {?>
        <li><a href="Nouveau-chapitre" class="button">Nouveau chapitre</a></li>
        <li><a href="Titre-des-chapitres/1" class="button">Éditer un chapitre</a></li>
        <li><a href="Liste-des-commentaires/1" class="button">Modérer les commentaires</a></li>
        <li><a href="Deconnexion" class="button">Déconnexion</a></li>
    <?php } else {?>
        <li><a href="Login" class="button">Connexion</a></li>
    <?php }?>
    </ul>
</nav>
