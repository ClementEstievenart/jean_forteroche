<?php
$title = 'Liste des commentaires';
$tinyMCE = null;

ob_start();
?>
<h2>Modérer les commentaires :</h2>
<?php foreach ($comments as $comment) {?>
    <div>
        <h4><?= htmlspecialchars($comment->lastName()) ?> <?= htmlspecialchars($comment->firstName()) ?> à commenté le <?= htmlspecialchars($comment->datePublication()) ?> l'épisode <em><a href="index.php?action=getPost&amp;postId=<?= htmlspecialchars($postsManager->get($comment->idPost())->id()) ?>"><?= htmlspecialchars($postsManager->get($comment->idPost())->title()) ?></a></em></h4>
        <p><?= htmlspecialchars($comment->content()) ?></p>
        <p>Statut : <?php
        if (!$comment->reportStatut()) {
            echo 'Non signalé';
        } else {
            echo 'Signalé ' . htmlspecialchars($comment->reportNumber()) . ' fois';
        }
        ?></p>
        <div>
            <a href="index.php?action=deleteComment&amp;commentId=<?= htmlspecialchars($comment->id()) ?>"><button>Supprimer le commentaire</button></a>
            <a href="index.php?action=validComment&amp;commentId=<?= htmlspecialchars($comment->id()) ?>"><button>Valider le commentaire</button></a>
        </div>
    </div>
<?php }
$content = ob_get_clean();

require('template/template.php');
