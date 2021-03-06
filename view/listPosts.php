<?php
$title = 'Les chapitres';

ob_start();
?>
<h2 class="page_content">Liste des chapitres</h2>
<?php
foreach ($posts as $post) {?>
  <article>
        <h3 class="page_content"><?= htmlspecialchars_decode($post->title()) ?>
        <em>Publié le <?= htmlspecialchars($post->datePublication()) ?></em></h3>
        <div class="post_content extract"><?= $this->getPostExcerpt($post) ?></div>
        <div><a href="Chapitre-<?= htmlspecialchars($post->id()) ?>/1" class="button read_more">Lire la suite</a></div>
  </article>
<?php }?>

<div>
    <?php
    if ($nbPosts > 10) {?>
        <nav class="pages">
            <a <?php if ($page > 1) {?>href="Chapitres/<?= htmlspecialchars($page - 1) ?>"<?php }?> class="button"><i class="fas fa-chevron-left" title="Chapitres précedents"></i> Précédent</a>
            <a <?php if ($page * 10 < $nbPosts) {?>href="Chapitres/<?= htmlspecialchars($page + 1) ?>"<?php }?> class="button" title="Chapitres suivants">Suivant <i class="fas fa-chevron-right"></i></a>
        </nav>
    <?php }?>
</div>

<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
