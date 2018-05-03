<?php
$title = 'Éditer';
ob_start();
?>
<h2>Éditer l'épisode</h2>
<form action="index.php?action=updatePost&amp;postId=<?= htmlspecialchars($post->id()) ?>" method="post">
    <div><label for="title">Titre : <input id="title" name="title" type="text" value="<?= htmlspecialchars($post->title()) ?>" required></label></div>
    <div><label for="content">Épisode : <textarea id="content" name="content" required><?= htmlspecialchars($post->content()) ?></textarea></label></div>
    <div>
        Publier ?
        <label for="publish"><input id="publish" name="published" type="radio" value="1"<?php if ($post->published() === 1) { echo('checked'); } ?>>Oui</label>
        <label for="noPublish"><input id="noPublish" name="published" type="radio" value="0"<?php if ($post->published() === 0) { echo('checked'); } ?>>Non</label>
    </div>
    <div><input id="send" type="submit" value="Modifier l'épisode"></div>
</form>
<h2>Supprimer l'épisode</h2>
<p><a href="index.php?action=deletePost&amp;postId=<?= htmlspecialchars($post->id()) ?>"><button>Supprimer !</button></a></p>


<?php
$content = ob_get_clean();
require('template/template.php');
