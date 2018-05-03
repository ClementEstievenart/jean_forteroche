<?php
session_start();
try {
    require('controller/Frontend.php');
    require('controller/Backend.php');
    require('Helper.php');

    $helper = new Helper();
    $get = $helper->getGetValues();
    $post = $helper->getPostValues();

    include('routerConfig.php');
    $fontback = ['frontend', 'backend'];

    for ($i = 0; $i<= 2; $i++) {
        if ($i === 2) {
            $controler = new Frontend();
            $controler->homePage();
            break;
        }

        foreach ($routerConfig[$fontback[$i]] as $action => $data) {
            if($get['action'] === $action) {
                if ($i === 0) {
                    $controler = new Frontend();
                } else {
                    $controler = new Backend();
                }

                $parameters = [];

                if(isset($data['getName'])){
                    if(isset($get[$data['getName']])) {
                        $parameters[] = $get[$data['getName']];
                    } else {
                        throw new exception($data['getName'] . 'doesn\'t exist for the action : ' . $action);
                    }
                }

                if(isset($data['postsName'])) {
                    foreach ($data['postsName'] as $postName) {
                        if (isset($post[$postName])) {
                            $parameters[] = $post[$postName];
                        } else {
                            throw new exception($postName . 'doesn\'t exist for the action : ' . $action);
                        }
                    }
                }

                $controler->$data['method'](...$parameters);
                break 2;
            }
        }
    }
} catch(Execption $e) {
    die('ERROR : ' . $e->getMessage());
}
