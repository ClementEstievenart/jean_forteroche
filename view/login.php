<?php
$title = 'Connexion';
$tinyMCE = null;

ob_start();
?>
<h2>Connexion :</h2>
<form action="index.php?action=connection" method="post">
    <div><label for="login">Identifiant : <input id="login" name="login" type="text" required></label></div>
    <div><label for="password">Mot de passe : <input id="password" name="password" type="password" required></label></div>
    <?php if (!empty($_POST['login'])) {?>
        <div id="connection_fail">Erreur de connexion : identifiant ou mot de passe invalide !</div>
    <?php }?>
        <div><input id="connection" type="submit" value="Se connecter"></div>
</form>
<?php
$content = ob_get_clean();

require ($this->_path . '/view/template/template.php');
