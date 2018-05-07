<?php
$title = 'Les épisodes';
$tinyMCE = null;

ob_start();
?>
<h2>Liste des épisodes</h2>
<?php
foreach ($posts as $post) {?>
  <article>
        <h3><?= htmlspecialchars_decode($post->title()) ?></h3>
        <p><em>Publié le <?= htmlspecialchars($post->datePublication()) ?></em></p>
        <p><?= htmlspecialchars_decode($post->content()) ?></p>
        <div><a href="index.php?action=getPost&amp;postId=<?= htmlspecialchars($post->id()) ?>">Commentaires</a></div>
  </article>
<?php }
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
