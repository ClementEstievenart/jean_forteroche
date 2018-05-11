<?php
$title = 'Liste des commentaires';
$tinyMCE = null;

ob_start();
?>
<h2>Modérer les commentaires :</h2>
<?php foreach ($comments as $comment) {?>
    <div>
        <h5 class="report_title"><?= htmlspecialchars($comment->lastName()) ?> <?= htmlspecialchars($comment->firstName()) ?> a commenté le <?= htmlspecialchars($comment->datePublication()) ?> le chapitre <?= htmlspecialchars_decode($postsManager->get($comment->idPost())->title()) ?></h5>
        <div class="comments list_report"><a href="index.php?action=findPageOfComment&amp;commentId=<?= htmlspecialchars($comment->id()) ?>&amp;postId=<?= htmlspecialchars($postsManager->get($comment->idPost())->id()) ?>&amp;page=1"><?= htmlspecialchars($comment->content()) ?></a></div>
        <div class="report_button">
            <p class="report_statut">Statut : <?php
                if (!$comment->reportStatut()) {
                    echo 'Non signalé';
                } else {
                    echo 'Signalé ' . htmlspecialchars($comment->reportNumber()) . ' fois';
                }
            ?></p>
            <div>
                <a href="index.php?action=deleteComment&amp;commentId=<?= htmlspecialchars($comment->id()) ?>&amp;page=<?= $page ?>" class="delete_comment button">Supprimer le commentaire</a>
                <a href="index.php?action=validComment&amp;commentId=<?= htmlspecialchars($comment->id()) ?>&amp;page=<?= $page ?>" class="button">Valider le commentaire</a>
            </div>
        </div>
    </div>
<?php }?>
<div>
    <?php
    if ($nbComments > 10) {?>
        <nav id="pages">
            <a <?php if ($page > 1) {?>href="index.php?action=listCommentsReport&amp;page=<?= htmlspecialchars($page - 1) ?>"<?php }?> class="button"> ◄ Précédent </a>
            <a <?php if ($page * 10 < $nbComments) {?>href="index.php?action=listCommentsReport&amp;page=<?= htmlspecialchars($page + 1) ?>"<?php }?> class="button"> Suivant ►</a>
        </nav>
    <?php }?>
</div>
<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
