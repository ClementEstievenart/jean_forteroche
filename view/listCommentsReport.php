<?php
$title = 'Liste des commentaires';
ob_start();
?>
<h2>Modérer les commentaires :</h2>
<?php foreach ($comments as $comment) {?>
    <div>
        <h4><?= $comment->lastName() ?> <?= $comment->firstName() ?> à commenté le <?= $comment->datePublication() ?> l'épisode <strong><?= $postsManager->get($comment->idPost())->title() ?></strong></h4>
        <p><?= $comment->content() ?></p>
        <p>Statut : <?php
        if ($comment->reportStatut() == 0) {
            echo 'Non signalé';
        } else {
            echo 'Signalé ' . $comment->reportNumber() . ' fois';
        }
        ?></p>
        <div>
            <a href="index.php?action=deleteComment&amp;commentId=<?= $comment->id() ?>"><button>Supprimer le commentaire</button></a>
            <a href="index.php?action=validComment&amp;commentId=<?= $comment->id() ?>"><button>Valider le commentaire</button></a>
        </div>
    </div>

<?php }
$content = ob_get_clean();
require('template/template.php');
