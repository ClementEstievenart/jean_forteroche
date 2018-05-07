<?php
$title = "Billet simple pour l'Alaska";
$tinyMCE = null;

ob_start();
?>
<h2>'Billet simple pour l'Alaska' : le livre en ligne !</h2>
<p>Vous retrouverez ici mon livre dévoilé par épisode</p>
<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
