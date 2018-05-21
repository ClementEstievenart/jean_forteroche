<?php
$title = "Erreur : vous vous êtes égaré(e) !";

ob_start();
?>
<h2 class="page_content">La page demandée n'existe pas !</h2>
<p class="page_content">De nombreux dangers guettent les montagnes de l'Alaska pour ceux qui ne connaissent pas le pays ! Ne vous égarez pas car les accidents sont fréquent et je ne souhaite pas vous perdre.</p>
<p class="page_content">Alors revenez sur les sentiers balisés et retrouvez la sécurité dans les lignes du roman.</p>
<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
