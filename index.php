<?php
require('controller/Frontend.php');
$frontend = new Frontend();
try {
    if(isset($_GET['action'])) {
        if ($_GET['action'] == 'home') {
            $frontend->homePage();
        } elseif($_GET['action'] == 'listPosts') {
            $frontend->getPosts();
        } elseif($_GET['action'] == 'getPost') {
            if(isset($_GET['postId'])) {
                $frontend->getPostById($_GET['postId']);
            } else {
                throw new exception('postId doesn\'t exist for the action getPost');
            }
        } else {
            throw new exception('the action isn\'t recognized');
        }
    } else {
        $frontend->homePage();
    }
} catch(Execption $e) {
    die('ERROR : ' . $e->getMessage());
}
