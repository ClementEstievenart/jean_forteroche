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
        } elseif($_GET['action'] == 'addComment') {
            if(!empty($_POST['lastName']) AND !empty($_POST['firstName']) AND !empty($_POST['content']) AND isset($_GET['postId'])) {
                $frontend->addComment($_POST['lastName'], $_POST['firstName'], $_POST['content'], $_GET['postId']);
            } else {
                throw new exception('miss a $_POST[] value to add a comment');
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
