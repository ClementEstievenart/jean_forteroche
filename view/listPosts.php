<?php
$title = 'Les épisodes';
$tinyMCE = null;

ob_start();
?>
<h2>Liste des chapitres</h2>
<?php
foreach ($posts as $post) {?>
  <article>
        <h3><?= htmlspecialchars_decode($post->title()) ?>
        <em>Publié le <?= htmlspecialchars($post->datePublication()) ?></em></h3>
        <p><?= htmlspecialchars_decode($post->content()) ?></p>
        <div><a href="index.php?action=getPost&amp;postId=<?= htmlspecialchars($post->id()) ?>&amp;page=1" class="button">Commentaires</a></div>
  </article>
<?php }?>

<div>
    <?php
    if ($nbPosts > 10) {?>
        <nav id="pages">
            <a <?php if ($page > 1) {?>href="index.php?action=listPosts&amp;page=<?= htmlspecialchars($page - 1) ?>"<?php }?> class="button"> ◄ Précédent </a>
            <a <?php if ($page * 10 < $nbPosts) {?>href="index.php?action=listPosts&amp;page=<?= htmlspecialchars($page + 1) ?>"<?php }?> class="button"> Suivant ►</a>
        </nav>
    <?php }?>
</div>

<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
