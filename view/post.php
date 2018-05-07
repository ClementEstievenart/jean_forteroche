<?php
$title = htmlspecialchars($post->title());
$tinyMCE = null;

ob_start();
?>
<article>
    <h3><?= htmlspecialchars_decode($post->title()) ?></h3>
    <p><em>Publié le <?= htmlspecialchars($post->datePublication()) ?> par <?= htmlspecialchars($user->login()) ?></em></p>
    <?php if ($post->dateUpdate()) {?><p><em>Modifié le <?= htmlspecialchars($post->dateUpdate()) ?></em></p><?php } ?>
    <p><?= htmlspecialchars_decode($post->content()) ?></p>
</article>

<form action="index.php?action=addComment&amp;postId=<?= htmlspecialchars($post->id()) ?>" method="post">
    <h4>Ajouter un commentaire :</h4>
    <div><label for="lastName">Nom : <input id="lastName" name="lastName" type="text" required></label></div>
    <div><label for="firstName">Prénom : <input id="firstName" name="firstName" type="text" required></label></div>
    <div><label for="content">Commentaire : <textarea id="content" name="content" required></textarea></label></div>
    <div><input id="send" type="submit" value="Envoyer"></div>
</form>

<h4><?= htmlspecialchars($post->nbComments()) ?> commentaires :</h4>
<div id="comments">
    <?php
    foreach($comments as $comment) {
    ?>
        <h5><?= htmlspecialchars($comment->lastName()) ?> <?= htmlspecialchars($comment->firstName()) ?></h5>
        <div><em>à commenter le <?= htmlspecialchars($comment->datePublication()) ?></em></div>
        <p><?= htmlspecialchars($comment->content()) ?></p>
        <a href="index.php?action=report&amp;commentId=<?= htmlspecialchars($comment->id()) ?>"><button>Signaler ce commentaire !</button></a>
    <?php
    }
    ?>
</div>
<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
