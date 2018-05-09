<?php
$title = htmlspecialchars($post->title());
$tinyMCE = null;

ob_start();
?>
<article>
    <h2><?= htmlspecialchars_decode($post->title()) ?></h2>
    <p><?= htmlspecialchars_decode($post->content()) ?></p>
    <p class="date_display"><em>Publié le <?= htmlspecialchars($post->datePublication()) ?> par <?= htmlspecialchars($user->login()) ?></em></p>
    <?php if ($post->dateUpdate()) {?><p class="date_display"><em>Modifié le <?= htmlspecialchars($post->dateUpdate()) ?></em></p><?php } ?>
</article>

<form action="index.php?action=addComment&amp;postId=<?= htmlspecialchars($post->id()) ?>&amp;page=<?= htmlspecialchars($page) ?>" method="post">
    <h3>Ajouter un commentaire :</h3>
    <div><input id="lastName" name="lastName" type="text" required placeholder="Votre nom">
    <input id="firstName" name="firstName" type="text" required placeholder="Votre prénom"></div>
    <div><textarea id="content" name="content" required placeholder="Rédigez votre commentaire"></textarea></div>
    <div><input id="send" type="submit" value="Envoyer"></div>
</form>

<h3><?= htmlspecialchars($post->nbComments()) ?> commentaires :</h3>
<div class="comments">
    <?php
    foreach($comments as $comment) {
    ?>
        <h5 id="commentId<?= htmlspecialchars($comment->id()) ?>"><?= htmlspecialchars($comment->lastName()) ?> <?= htmlspecialchars($comment->firstName()) ?></h5>
        <div class="post_description">
            <div><em>a commenté le <?= htmlspecialchars($comment->datePublication()) ?></em></div>
            <div class="report_link"><a href="index.php?action=report&amp;commentId=<?= htmlspecialchars($comment->id()) ?>&amp;page=<?= htmlspecialchars($page) ?>">Signaler ce commentaire !</a></div>
        </div>
        <p><?= htmlspecialchars($comment->content()) ?></p>
    <?php }?>
</div>
<div>
    <?php
    if ($post->nbComments() > 10) {?>
        <nav id="pages">
            <a <?php if ($page !== 1) {?>href="index.php?action=getPost&amp;postId=<?= htmlspecialchars($post->id()) ?>&amp;page=<?= htmlspecialchars($page - 1) ?>"<?php }?>> ◄ Précédant </a>
            <a <?php if ($page * 10 < $post->nbComments()) {?>href="index.php?action=getPost&amp;postId=<?= htmlspecialchars($post->id()) ?>&amp;page=<?= htmlspecialchars($page + 1) ?>"<?php }?>> Suivant ►</a>
        </nav>
    <?php }?>
</div>

<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
