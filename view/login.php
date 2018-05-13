<?php
$title = 'Connexion';
$tinyMCE = null;

ob_start();
?>
<h2>Connexion :</h2>
<form action="Connexion" method="post">
    <div><input id="login" name="login" type="text" required placeholder="Identifiant"></div>
    <div><input id="password" name="password" type="password" required placeholder="Mot de passe"></div>
    <?php if (!empty($_POST['login'])) {?>
        <p id="connection_fail">Erreur de connexion : identifiant ou mot de passe invalide !</p>
    <?php }?>
        <div><input id="connection" type="submit" value="Se connecter"></div>
</form>
<?php
$content = ob_get_clean();

require ($this->_path . '/view/template/template.php');
