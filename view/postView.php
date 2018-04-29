<?php
$title = $post->title();
ob_start();
?>
<article>
    <h3><?= $post->title() ?></h3>
    <div><em>Publié le <?= post->datePublication() ?> par <?= $post->idUser() ?></em></div>
    <p><?= $post->content() ?></p>
</article>
<h4><?= $post->nbComments() ?> commentaires :</h4>
<div id="comments">
    <?php
    while($comment = $comments->fetch()) {
    ?>
        <h5><?= $comment->lastName() ?> <?= $comment->firstName() ?></h5>
        <div><em>à commenter le <?= $comment->datePublication() ?></em></div>
        <p><?= $comment->content() ?></p>
        <div><button>Signaler le commentaire !</button></div>
    <?php
    }
    ?>
</div>

<?php
$content = ob_get_clean();
require('template/template.php');
