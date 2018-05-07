<?php
session_start();
try {
    $path = realpath('.');

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

    for ($i = -1; $i<= 1; $i++) {
        if ($i === -1 AND !isset($getVar['action'])) {
            $controler = new Frontend();
            $controler->homePage();
            break;
        } elseif ($i === -1) {
            continue;
        }

        foreach ($routerConfig[$controlerList[$i]] as $action => $actionParameters) {
            if($getVar['action'] === $action) {
                if ($i === 0) {
                    $controler = new Frontend();
                } else {
                    $controler = new Backend();
                }

                $parameters = [];

                if(isset($actionParameters['getKey'])){
                    if(isset($getVar[$actionParameters['getKey']])) {
                        $parameters[] = $getVar[$actionParameters['getKey']];
                    } else {
                        throw new exception($actionParameters['getKey'] . 'doesn\'t exist for the action : ' . $action);
                    }
                }

                if(isset($actionParameters['postKeys'])) {
                    foreach ($actionParameters['postKeys'] as $postKeys) {
                        if (isset($postVar[$postKeys])) {
                            $parameters[] = $postVar[$postKeys];
                        } else {
                            throw new exception($postKeys . 'doesn\'t exist for the action : ' . $action);
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
