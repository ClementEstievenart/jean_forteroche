<?php
try {
    require ('/router/Helper.php');

    $router = new Helper();
    $router->routing();

} catch(Execption $e) {
    die('ERROR : ' . $e->getMessage());
}
