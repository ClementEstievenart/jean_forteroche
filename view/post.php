<?php
$title = htmlspecialchars($post->title());
$tinyMCE = null;

ob_start();
?>
<article>
    <h2 class="page_content"><?= htmlspecialchars_decode($post->title()) ?></h2>
    <div class="post_content"><?= htmlspecialchars_decode($post->content()) ?></div>
    <p class="date_display"><em>Publié le <?= htmlspecialchars($post->datePublication()) ?> par <?= htmlspecialchars($user->login()) ?></em></p>
    <?php if ($post->dateUpdate()) {?><p class="date_display"><em>Modifié le <?= htmlspecialchars($post->dateUpdate()) ?></em></p><?php } ?>
</article>

<nav class="pages">
    <a <?php if ($postPrevId) {?>href="Chapitre-<?= htmlspecialchars($postPrevId) ?>/1"<?php }?> class="button" title="Chapitre précédent"><i class="fas fa-chevron-left"></i> Chapitre précédent</a>
    <a <?php if ($postNextId) {?>href="Chapitre-<?= htmlspecialchars($postNextId) ?>/1"<?php }?> class="button">Chapitre suivant <i class="fas fa-chevron-right" title="Chapitre suivant"></i></a>
</nav>

<form action="Ajouter-un-commentaire-<?= htmlspecialchars($post->id()) ?>/<?= htmlspecialchars($page) ?>" method="post">
    <h3 class="page_content">Ajouter un commentaire :</h3>
    <div><i class="fas fa-user input"></i><input id="pseudo" name="pseudo" type="text" required placeholder="Votre pseudo" maxlength="16"></div>
    <div><textarea id="content" name="content" required placeholder="Rédigez votre commentaire"></textarea></div>
    <div><input id="send" type="submit" value="Envoyer" title="Envoyer votre commentaire"></div>
</form>

<h3 class="page_content"><?= htmlspecialchars($post->nbComments()) ?> commentaires :</h3>
<div class="comments">
    <?php
    foreach($comments as $comment) {
    ?>
       <div id="commentId<?= htmlspecialchars($comment->id()) ?>">
            <h5 class="page_content"><i class="fas fa-user"></i> <?= htmlspecialchars($comment->pseudo()) ?></h5>
            <div class="post_description">
                <div><em>a commenté le <?= htmlspecialchars($comment->datePublication()) ?></em></div>
                <div><a class="report_link button" title="Signaler le commentaire" href="Signaler-un-commentaire-<?= htmlspecialchars($comment->id()) ?>/<?= htmlspecialchars($page) ?>"><i class="fas fa-flag"></i></a></div>
            </div>
            <p class="page_content"><?= htmlspecialchars($comment->content()) ?></p>
            <?php if (isset($_SESSION['login'])) {?>
                <div class="report_button">
                    <p class="report_statut page_content">Statut : <?php
                        if (!$comment->reportStatut()) {
                            echo 'Non signalé';
                        } elseif ($comment->reportStatut() === 1) {
                            echo 'Signalé ' . htmlspecialchars($comment->reportNumber()) . ' fois';
                        } else {
                            echo 'Validé';
                        }
                    ?></p>
                    <?php if ($comment->reportStatut() < 2) {?>
                       <div>
                        <a title="Supprimer le commentaire" href="Supprime-le-commentaire-<?= htmlspecialchars($comment->id()) ?>-post/<?= $page ?>" class="delete_comment button"><i class="fas fa-times-circle"></i> Supprimer</a>
                        <a title="Valider le commentaire" href="Valider-le-commentaire-<?= htmlspecialchars($comment->id()) ?>-post/<?= $page ?>" class="button"><i class="fas fa-check-circle"></i> Valider</a>
                        </div>
                    <?php }?>
                </div>
            <?php }?>
        </div>
    <?php }?>
</div>
<div>
    <?php
    if ($post->nbComments() > 10) {?>
        <nav class="pages">
            <a <?php if ($page !== 1) {?>href="Chapitre-<?= htmlspecialchars($post->id()) ?>/<?= htmlspecialchars($page - 1) ?>"<?php }?> class="button" title="Commentaires précédents"><i class="fas fa-chevron-left"></i> Précédent</a>
            <a <?php if ($page * 10 < $post->nbComments()) {?>href="Chapitre-<?= htmlspecialchars($post->id()) ?>/<?= htmlspecialchars($page + 1) ?>"<?php }?> class="button" title="Commentaires suivants">Suivant <i class="fas fa-chevron-right"></i></a>
        </nav>
    <?php }?>
</div>

<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
