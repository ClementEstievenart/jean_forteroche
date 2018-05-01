<?php
$title = $post->title();
ob_start();
?>
<article>
    <h3><?= htmlspecialchars($post->title()) ?></h3>
    <div><em>Publié le <?= htmlspecialchars($post->datePublication()) ?> par <?= htmlspecialchars($user->login()) ?></em></div>
    <p><?= htmlspecialchars($post->content()) ?></p>
</article>
<h4><?= $post->nbComments() ?> commentaires :</h4>
<div id="comments">
    <?php
    foreach($comments as $key => $comment) {
    ?>
        <h5><?= htmlspecialchars($comment->lastName()) ?> <?= htmlspecialchars($comment->firstName()) ?></h5>
        <div><em>à commenter le <?= htmlspecialchars($comment->datePublication()) ?></em></div>
        <p><?= htmlspecialchars($comment->content()) ?></p>
        <div><button>Signaler le commentaire !</button></div>
    <?php
    }
    ?>
</div>

<?php
$content = ob_get_clean();
require('template/template.php');
