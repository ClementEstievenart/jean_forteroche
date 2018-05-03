<?php
$title = 'Liste des épisodes';
ob_start();
?>
<h2>Sélectionner l'épisode à éditer :</h2>
<?php
foreach ($posts as $post) {
?>
    <h3><a href="index.php?action=editPost&amp;postId=<?= htmlspecialchars($post->id()) ?>"><?= htmlspecialchars($post->title()) ?></a></h3>
<?php
}
$content = ob_get_clean();
require('template/template.php');
