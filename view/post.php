<?php
$title = $post->title();
ob_start();
?>
<article>
    <h3><?= htmlspecialchars($post->title()) ?></h3>
    <div><em>Publié le <?= htmlspecialchars($post->datePublication()) ?> par <?= htmlspecialchars($user->login()) ?></em></div>
    <p><?= htmlspecialchars($post->content()) ?></p>
</article>
<form action="index.php?action=addComment&amp;postId=<?= $post->id() ?>" method="post">
    <h4>Ajouter un commentaire :</h4>
    <div><label for="lastName">Nom : <input id="lastName" name="lastName" type="text" required></label></div>
    <div><label for="firstName">Prénom : <input id="firstName" name="firstName" type="text" required></label></div>
    <div><label for="content">Commentaire : <textarea id="content" name="content" required></textarea></label></div>
    <div><input id="send" type="submit" value="Envoyer"></div>
</form>
<h4><?= $post->nbComments() ?> commentaires :</h4>
<div id="comments">
    <?php
    foreach($comments as $comment) {
    ?>
        <h5><?= htmlspecialchars($comment->lastName()) ?> <?= htmlspecialchars($comment->firstName()) ?></h5>
        <div><em>à commenter le <?= htmlspecialchars($comment->datePublication()) ?></em></div>
        <p><?= htmlspecialchars($comment->content()) ?></p>
        <a href="index.php?action=report&amp;commentId=<?= $comment->id() ?>"><button>Signaler ce commentaire !</button></a>
    <?php
    }
    ?>
</div>

<?php
$content = ob_get_clean();
require('template/template.php');
