<?php
try {
    require ('router/Helper.php');

    $config = parse_ini_file('config.ini', true);
    $router = new Helper($config);
    $router->routing();

} catch(Exception $e) {
    if ($config['phase']['realise']) {
        $router->error();
    } elseif ($config['phase']['development']) {
        die('ERROR : ' . $e->getMessage());
    } else {
        die ('ERROR : bad initialization');
    }
}
