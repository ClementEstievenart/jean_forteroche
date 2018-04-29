<?php
$title = 'Les épisodes';
ob_start();
?>
<h2>Liste des épisodes</h2>
<?php
while ($post = $posts->fetch()) {
?>
  <article>
        <h3><?= htmlspecialchars($post->title()) ?></h3>
        <p><?= htmlspecialchars($post->content()) ?></p>
        <div><a href="../index.php?action=getPostById&postId=" + <?= $post->id() ?>>Commentaires</a></div>
  </article>
<?php
}
$content = ob_get_clean();
require('template/template.php');
