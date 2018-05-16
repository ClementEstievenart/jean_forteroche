<nav id="head_menu" <?php if (isset($_SESSION['login'])) {?>style="height:649px"<?php }?>>
    <div class="site_title top_menu no_display">
        <h1>Billet Simple<br>pour l'Alaska</h1>
        <p>Par Jean Forteroche</p>
    </div>
    <ul>
    <li><a href="Accueil" class="button" title="Page d'accueil"><i class="fas fa-home"></i> Accueil</a></li>
    <li><a href="Chapitres/1" class="button sublist_menu" title="Liste des chapitres"><i class="fas fa-book-open"></i> Chapitres</a>
        <ol class="sublist">
            <?php foreach ($this->_listPostTitles as $postTitle) {?>
                <li><a href="Chapitre-<?= htmlspecialchars($postTitle->id()) ?>/1" class="button"><?= htmlspecialchars_decode($postTitle->title()) ?></a></li>
            <?php }?>
        </ol>
    </li>
    <?php if (isset($_SESSION['login'])) {?>
        <li><a href="Nouveau-chapitre" class="button" title="Écrire un nouveau chapitre"><i class="far fa-plus-square"></i> Nouveau chapitre</a></li>
        <li><a href="Titre-des-chapitres/1" class="button" title="Éditer/Publier un chapitre"><i class="far fa-edit"></i> Éditer un chapitre</a></li>
        <li><a href="Liste-des-commentaires/1" class="button" title="Lister les commentaires pour les modérer"><i class="far fa-comments"></i> Modérer</a></li>
        <li><a href="Deconnexion" class="button" title="Déconnexion"><i class="fas fa-unlock"></i> Déconnexion</a></li>
    <?php } else {?>
        <li><a id="login_button" class="button sublist_menu" title="Connexion"><i class="fas fa-unlock"></i> Connexion</a>
            <form action="Connexion" method="post">
                <ul class="sublist login<?php if (!empty($_POST['login'])) {?> active<?php }?>">
                    <li><i class="fas fa-user input"></i><input id="login" name="login" type="text" required placeholder="Identifiant"></li>
                    <li><i class="fas fa-key input"></i><input id="password" name="password" type="password" required placeholder="Mot de passe"></li>
                    <li><input class="connection" type="submit" value="Se connecter"></li>
                    <?php if (!empty($_POST['login'])) {?>
                        <p id="connection_fail">Erreur de connexion :<br>identifiants invalides !</p>
                    <?php }?>
                </ul>
            </form>
        </li>
    <?php }?>
        <li><div class="nav_frame author">
            <h1>A propos de l'auteur :</h1>
            <p>Auteur de best-sellers, notamment "Le destin d'une montagne" publié chez Bayard, je trouve mon inspiration dans la beauté de la nature de mon pays : l'Alaska. A travers ce blook, je souhaite trouver une nouvelle expérience avec mes lecteurs grâce aux commentaires.</p>
            <p>Contact : <a href="mailto:jean@forteroche.fr">jean@forteroche.fr</a></p>
        </div></li>
        <li><div class="nav_frame">
            <h1>Derniers commentaires :</h1>
            <div class="last_comments">
                <?php foreach ($this->_lastComments as $comment) {?> <p><a href="Voir-le-context-<?= htmlspecialchars($comment->id()) ?>"><strong><?= $comment->pseudo() ?>:</strong> <?= $comment->content()?></a></p> <?php }?>
            </div>
        </div></li>
    </ul>
</nav>
