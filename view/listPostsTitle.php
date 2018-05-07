<?php
$title = 'Liste des épisodes';
$tinyMCE = null;

ob_start();
?>
<h2>Sélectionner l'épisode à éditer :</h2>
<?php
foreach ($posts as $post) {?>
    <h3><a href="index.php?action=editPost&amp;postId=<?= htmlspecialchars($post->id()) ?>"><?= htmlspecialchars_decode($post->title()) ?></a></h3>
<?php }
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
