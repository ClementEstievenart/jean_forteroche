<?php
$title = "Billet simple pour l'Alaska";

ob_start();
?>
<h2 class="page_content">'Billet simple pour l'Alaska' : le livre en ligne !</h2>
<div class="img_container"><img src="/public/images/ebook.png" alt="livre numérique"></div>
<p class="page_content">Venez découvrir l'Alaska et vivre une aventure humaine hors du commun à travers les lignes de ce livre. Vous ferez connaissance avec des personnages drôles, émouvant et attachant. Mais par-dessus tout vous allez explorez un pays avec de majestueux paysages, des montagnes à couper le souffle et aussi les dangers qui en découlent... Chaque semaine, un nouveau chapitre dévoilé pour le meilleur des voyages.</p>
<p class="page_content">Alors ne perdez pas plus de temps et prenez un billet simple pour l'Alaska !</p>
<?php
$content = ob_get_clean();

require($this->_path . '/view/template/template.php');
