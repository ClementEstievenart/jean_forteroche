<?php
$title = 'Les épisodes';
ob_start();
?>
<h2>Liste des épisodes</h2>
<?php
foreach ($posts as $key => $post) {
?>
  <article>
        <h3><?= htmlspecialchars($post->title()) ?></h3>
        <p><?= htmlspecialchars($post->content()) ?></p>
        <div><a href="../projet_4/index.php?action=getPost&amp;postId=<?= $post->id() ?>">Commentaires</a></div>
  </article>
<?php
}
$content = ob_get_clean();
require('template/template.php');
