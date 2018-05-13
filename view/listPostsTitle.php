<?php
$title = 'Liste des épisodes';
$tinyMCE = null;

ob_start();
?>
<h2>Sélectionner le chapitre à éditer :</h2>
<?php
foreach ($posts as $post) {?>
    <h3 class="list_post_title <?php if ($post->datepublication()) {?>publish<?php } else {?>no_publish<?php }?>"><a href="Editer-un-chapitre-<?= htmlspecialchars($post->id()) ?>"><?= htmlspecialchars_decode($post->title()) ?></a> <em><?php if ($post->datePublication()) {?>Publié le <?php echo($post->datePublication()); }?></em></h3>
<?php }?>
<div>
    <?php
    if ($nbPosts > 10) {?>
        <nav id="pages">
            <a <?php if ($page > 1) {?>href="Titre-des-chapitres/<?= htmlspecialchars($page - 1) ?>"<?php }?> class="button"> ◄ Précédent </a>
            <a <?php if ($page * 10 < $nbPosts) {?>href="Titre-des-chapitres/<?= htmlspecialchars($page + 1) ?>"<?php }?> class="button"> Suivant ►</a>
        </nav>
    <?php }?>
</div>
<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
