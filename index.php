<?php
try {
    session_start();

    $config = parse_ini_file('config.ini', true);
    $path = $config['locator']['path'];

    require($path . '/controller/Controller.php');
    require($path . '/controller/Frontend.php');
    require($path . '/controller/Backend.php');
    require($path . '/Helper.php');
    include($path . '/routerConfig.php');

    function loadModel($class) {
        require('/model/' . $class . '.php');
    }
    spl_autoload_register('loadModel');

    $helper = new Helper();
    $getVar = $helper->getGetValues();
    $postVar = $helper->getPostValues();

    $controlerList = ['frontend', 'backend'];

    for ($i = 0; $i<= 1; $i++) {
        if (!isset($getVar['action'])) {
            $controler = new Frontend($config);
            $controler->homePage();
            break;
        }

        foreach ($routerConfig[$controlerList[$i]] as $action => $actionParameters) {
            if($getVar['action'] === $action) {
                if ($i === 0) {
                    $controler = new Frontend($config);
                } else {
                    $controler = new Backend($config);
                }

                $parameters = [];

                if(isset($actionParameters['getKeys'])){
                    foreach ($actionParameters['getKeys'] as $getKeys) {
                        if(isset($getVar[$getKeys])) {
                            $parameters[] = $getVar[$getKeys];
                        } else {
                            throw new exception($getKeys . ' doesn\'t exist for the action : ' . $action);
                        }
                    }
                }

                if(isset($actionParameters['postKeys'])) {
                    foreach ($actionParameters['postKeys'] as $postKeys) {
                        if (isset($postVar[$postKeys])) {
                            $parameters[] = $postVar[$postKeys];
                        } else {
                            throw new exception($postKeys . ' doesn\'t exist for the action : ' . $action);
                        }
                    }
                }

                $controler->$actionParameters['method'](...$parameters);
                break 2;
            }
        }
    }
} catch(Execption $e) {
    die('ERROR : ' . $e->getMessage());
}
