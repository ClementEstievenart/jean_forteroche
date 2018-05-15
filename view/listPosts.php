<?php
$title = 'Les épisodes';
$tinyMCE = null;

ob_start();
?>
<h2 class="page_content">Liste des chapitres</h2>
<?php
foreach ($posts as $post) {?>
  <article>
        <h3 class="page_content"><?= htmlspecialchars_decode($post->title()) ?>
        <em>Publié le <?= htmlspecialchars($post->datePublication()) ?></em></h3>
        <div class="post_content extract"><?= htmlspecialchars_decode($post->content()) ?></div>
        <div><a href="Chapitre-<?= htmlspecialchars($post->id()) ?>/1" class="button">Lire la suite</a></div>
  </article>
<?php }?>

<div>
    <?php
    if ($nbPosts > 10) {?>
        <nav id="pages">
            <a <?php if ($page > 1) {?>href="Chapitres/<?= htmlspecialchars($page - 1) ?>"<?php }?> class="button"><i class="fas fa-chevron-left"></i> Précédent</a>
            <a <?php if ($page * 10 < $nbPosts) {?>href="Chapitres/<?= htmlspecialchars($page + 1) ?>"<?php }?> class="button">Suivant <i class="fas fa-chevron-right"></i></a>
        </nav>
    <?php }?>
</div>

<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
