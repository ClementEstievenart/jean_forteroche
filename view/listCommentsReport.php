<?php
$title = 'Liste des commentaires';
$tinyMCE = null;

ob_start();
?>
<h2 class="page_content">Modérer les commentaires :</h2>
<?php foreach ($comments as $comment) {?>
    <div>
        <h5 class="page_content report_title"><i class="fas fa-user"></i> <?= htmlspecialchars($comment->pseudo()) ?> a commenté le <?= htmlspecialchars($comment->datePublication()) ?> le chapitre <?= htmlspecialchars_decode($this->_postsManager->get($comment->idPost())->title()) ?></h5>
        <div class="comments list_report"><a title="Voir le commentaire dans la discussion" href="Voir-le-context-<?= htmlspecialchars($comment->id()) ?>"><?= htmlspecialchars($comment->content()) ?></a></div>
        <div class="report_button">
            <p class="report_statut page_content">Statut : <?php
                if (!$comment->reportStatut()) {
                    echo 'Non signalé';
                } else {
                    echo 'Signalé ' . htmlspecialchars($comment->reportNumber()) . ' fois';
                }
            ?></p>
            <div>
                <a title="Supprimer le commentaire" href="Supprime-le-commentaire-<?= htmlspecialchars($comment->id()) ?>/<?= $page ?>" class="delete_comment button"><i class="fas fa-times-circle"></i> Supprimer</a>
                <a title="Valider le commentaire" href="Valider-le-commentaire-<?= htmlspecialchars($comment->id()) ?>/<?= $page ?>" class="button"><i class="fas fa-check-circle"></i> Valider</a>
            </div>
        </div>
    </div>
<?php }?>
<div>
    <?php
    if ($nbComments > 10) {?>
        <nav id="pages">
            <a <?php if ($page > 1) {?>href="Liste-des-commentaires/<?= htmlspecialchars($page - 1) ?>"<?php }?> class="button" title="Commentaires précédents"><i class="fas fa-chevron-left"></i> Précédent</a>
            <a <?php if ($page * 10 < $nbComments) {?>href="Liste-des-commentaires/<?= htmlspecialchars($page + 1) ?>"<?php }?> class="button" title="Commentaires suivants">Suivant <i class="fas fa-chevron-right"></i></a>
        </nav>
    <?php }?>
</div>
<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
