<?php
$title = htmlspecialchars($post->title());
ob_start()    ;
?>
    <meta name="description" content="<?= htmlspecialchars_decode($post->title()) ?> | Billet simple pour l'Alaska par Jean Forteroche" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@JeanForteroche" />
    <meta name="twitter:title" content="<?= htmlspecialchars_decode($post->title()) ?> | Billet simple pour l'Alaska par Jean Forteroche" />
    <meta name="twitter:description" content="<?= strip_tags($this->getPostExcerpt($post)) ?>" />
    <meta name="twitter:image" content="<?= $this->_url ?>/public/images/logo.jpg" />


    <!-- Open Graph data -->
    <meta property="og:title" content="<?= htmlspecialchars_decode($post->title()) ?> | Billet simple pour l'Alaska par Jean Forteroche" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="http://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" />
    <meta property="og:image" content="<?= $this->_url ?>/public/images/logo.jpg" />
    <meta property="og:description" content="<?= strip_tags($this->getPostExcerpt($post)) ?>" />
    <meta property="og:site_name" content="Billet simple pour l'Alaska" />

    <!-- Schema.org meta for Google+ -->
    <meta itemprop="name" content="<?= htmlspecialchars_decode($post->title()) ?> | Billet simple pour l'Alaska par Jean Forteroche">
    <meta itemprop="description" content="<?= strip_tags($this->getPostExcerpt($post)) ?>">
    <meta itemprop="image" content="<?= $this->_url ?>/public/images/logo.jpg">
    <link rel="author" href="" />
    <link rel="publisher" href="" />
<?php
$metaSocial = ob_get_clean();

ob_start();
?>
<article>
    <h2 class="page_content"><?= htmlspecialchars_decode($post->title()) ?></h2>
    <div class="post_content"><?= htmlspecialchars_decode($post->content()) ?></div>
    <p class="date_display"><em>Publié le <?= htmlspecialchars($post->datePublication()) ?> par <?= htmlspecialchars($user->login()) ?></em></p>
    <?php if ($post->dateUpdate()) {?><p class="date_display"><em>Modifié le <?= htmlspecialchars($post->dateUpdate()) ?></em></p><?php } ?>
</article>

<nav class="pages">
    <a <?php if ($postPrevId) {?>href="Chapitre-<?= htmlspecialchars($postPrevId) ?>/1"<?php }?> class="button" title="Chapitre précédent"><i class="fas fa-chevron-left"></i> Chapitre précédent</a>
    <a <?php if ($postNextId) {?>href="Chapitre-<?= htmlspecialchars($postNextId) ?>/1"<?php }?> class="button">Chapitre suivant <i class="fas fa-chevron-right" title="Chapitre suivant"></i></a>
</nav>

<h3 class="page_content">Partager :
    <a target="_blank" id="twitter" title="Twitter" href="https://twitter.com/share?url=http://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;" class="share"><i class="fab fa-twitter"></i></a>
    <a target="_blank" id="facebook" title="Facebook" href="https://www.facebook.com/sharer.php?u=http://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=700');return false;" class="share"><i class="fab fa-facebook"></i></a>
    <a target="_blank" id="google" title="Google +" href="https://plus.google.com/share?url=http://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>&hl=fr" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650');return false;" class="share"><i class="fab fa-google-plus-g"></i></a>
    <a target="_blank" id="email" title="E-mail" href="mailto:?subject=<?= htmlspecialchars_decode($post->title()) ?>%20|%20Billet%20simple%20pour%20l'Alaska&body=http://<?= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ?>" rel="nofollow" class="share"><i class="fas fa-envelope"></i></a>
</h3>


<h3 class="page_content">Ajouter un commentaire :</h3>
<form action="Ajouter-un-commentaire-<?= htmlspecialchars($post->id()) ?>" method="post">
    <div><i class="fas fa-user input"></i><input id="pseudo" name="pseudo" type="text" required placeholder="Votre pseudo" maxlength="16"></div>
    <div><textarea id="content" name="content" required placeholder="Rédigez votre commentaire"></textarea></div>
    <div><input id="send" type="submit" value="Envoyer" title="Envoyer votre commentaire"></div>
</form>

<h3 class="page_content"><?= htmlspecialchars($post->nbComments()) ?> commentaires :</h3>
<div class="comments">
    <?php
    foreach($comments as $comment) {
    ?>
       <div id="commentId<?= htmlspecialchars($comment->id()) ?>">
            <h5 class="page_content"><i class="fas fa-user"></i> <?= htmlspecialchars($comment->pseudo()) ?></h5>
            <div class="post_description">
                <div><em>a commenté le <?= htmlspecialchars($comment->datePublication()) ?></em></div>
                <div><a class="report_link button" title="Signaler le commentaire" href="Signaler-un-commentaire-<?= htmlspecialchars($comment->id()) ?>/<?= htmlspecialchars($page) ?>"><i class="fas fa-flag"></i></a></div>
            </div>
            <p class="page_content"><?= htmlspecialchars($comment->content()) ?></p>
            <?php if (isset($_SESSION['login'])) {?>
                <div class="report_button">
                    <p class="report_statut page_content">Statut : <?php
                        if (!$comment->reportStatut()) {
                            echo 'Non signalé';
                        } elseif ($comment->reportStatut() === 1) {
                            echo 'Signalé ' . htmlspecialchars($comment->reportNumber()) . ' fois';
                        } else {
                            echo 'Validé';
                        }
                    ?></p>
                    <?php if ($comment->reportStatut() < 2) {?>
                       <div>
                        <a title="Supprimer le commentaire" href="Supprimer-le-commentaire-<?= htmlspecialchars($comment->id()) ?>-post/<?= $page ?>" class="delete_comment button"><i class="fas fa-times-circle"></i> Supprimer</a>
                        <a title="Valider le commentaire" href="Valider-le-commentaire-<?= htmlspecialchars($comment->id()) ?>-post/<?= $page ?>" class="button"><i class="fas fa-check-circle"></i> Valider</a>
                        </div>
                    <?php }?>
                </div>
            <?php }?>
        </div>
    <?php }?>
</div>
<div>
    <?php
    if ($post->nbComments() > 10) {?>
        <nav class="pages">
            <a <?php if ($page !== 1) {?>href="Chapitre-<?= htmlspecialchars($post->id()) ?>/<?= htmlspecialchars($page - 1) ?>"<?php }?> class="button" title="Commentaires précédents"><i class="fas fa-chevron-left"></i> Précédent</a>
            <a <?php if ($page * 10 < $post->nbComments()) {?>href="Chapitre-<?= htmlspecialchars($post->id()) ?>/<?= htmlspecialchars($page + 1) ?>"<?php }?> class="button" title="Commentaires suivants">Suivant <i class="fas fa-chevron-right"></i></a>
        </nav>
    <?php }?>
</div>

<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
