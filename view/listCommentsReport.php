<?php
$title = 'Liste des commentaires';
$tinyMCE = null;

ob_start();
?>
<h2>Modérer les commentaires :</h2>
<?php foreach ($comments as $comment) {?>
    <div>
        <h5 class="report_title"><?= htmlspecialchars($comment->lastName()) ?> <?= htmlspecialchars($comment->firstName()) ?> a commenté le <?= htmlspecialchars($comment->datePublication()) ?> l'épisode <em><a href="index.php?action=findPageOfComment&amp;commentId=<?= htmlspecialchars($comment->id()) ?>&amp;postId=<?= htmlspecialchars($postsManager->get($comment->idPost())->id()) ?>&amp;page=1"><?= htmlspecialchars_decode($postsManager->get($comment->idPost())->title()) ?></a></em></h5>
        <div class="comments"><p><?= htmlspecialchars($comment->content()) ?></p></div>
        <div class="report_button">
            <p class="report_statut">Statut : <?php
                if (!$comment->reportStatut()) {
                    echo 'Non signalé';
                } else {
                    echo 'Signalé ' . htmlspecialchars($comment->reportNumber()) . ' fois';
                }
            ?></p>
            <div>
                <a href="index.php?action=deleteComment&amp;commentId=<?= htmlspecialchars($comment->id()) ?>" class="delete_comment">Supprimer le commentaire</a>
                <a href="index.php?action=validComment&amp;commentId=<?= htmlspecialchars($comment->id()) ?>">Valider le commentaire</a>
            </div>
        </div>
    </div>
<?php }?>
<div>
    <?php
    if ($nbComments > 10) {?>
        <nav id="pages">
            <a <?php if ($page > 1) {?>href="index.php?action=listCommentsReport&amp;page=<?= htmlspecialchars($page - 1) ?>"<?php }?>> ◄ Précédant </a>
            <a <?php if ($page * 10 < $nbComments) {?>href="index.php?action=listCommentsReport&amp;page=<?= htmlspecialchars($page + 1) ?>"<?php }?>> Suivant ►</a>
        </nav>
    <?php }?>
</div>
<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
