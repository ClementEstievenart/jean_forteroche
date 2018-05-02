<?php
session_start();
require('controller/Frontend.php');
require('controller/Backend.php');
$frontend = new Frontend();
$backend = new Backend();
try {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'home') {
            $frontend->homePage();
        } elseif ($_GET['action'] == 'listPosts') {
            $frontend->getPosts();
        } elseif ($_GET['action'] == 'getPost') {
            if (isset($_GET['postId'])) {
                $frontend->getPostById($_GET['postId']);
            } else {
                throw new exception('postId doesn\'t exist for the action getPost');
            }
        } elseif ($_GET['action'] == 'addComment') {
            if (!empty($_POST['lastName']) AND !empty($_POST['firstName']) AND !empty($_POST['content']) AND isset($_GET['postId'])) {
                $frontend->addComment($_POST['lastName'], $_POST['firstName'], $_POST['content'], $_GET['postId']);
            } else {
                throw new exception('miss a $_POST[] value to add a comment');
            }
        } elseif ($_GET['action'] == 'report') {
            if (isset($_GET['commentId'])) {
                $frontend->reportComment($_GET['commentId']);
            } else {
                throw new exception('commentId doesn\'t exist to report a comment');
            }
        } elseif ($_GET['action'] == 'login') {
            $frontend->login();
        } elseif ($_GET['action'] == 'connection') {
            if (!empty($_POST['login']) AND !empty($_POST['password'])) {
                $frontend->connection($_POST['login'], $_POST['password']);
            } else {
                throw new exception('miss a $_POST[] to connect');
            }
        } elseif ($_GET['action'] == 'disconnection') {
            $backend->disconnection();
        } elseif ($_GET['action'] == 'writeNewPost') {
            $backend->writeNewPost();
        } elseif ($_GET['action'] == 'addPost') {
            if (!empty($_POST['title']) AND !empty($_POST['content']) AND ($_POST['published'] == 1 OR $_POST['published'] == 0)) {
                $backend->addPost($_POST['title'], $_POST['content'], $_POST['published']);
            } else {
                var_dump(!empty($_POST['published']));
                throw new exception('miss a $_POST[] value to add a post');
            }
        } elseif ($_GET['action'] == 'listPostsTitle') {
            $backend->listPostsTitle();
        } elseif ($_GET['action'] == 'editPost') {
            if(isset($_GET['postId'])) {
                $backend->editPost($_GET['postId']);
            } else {
                throw new exception('postId doesn\'t exist');
            }
        } elseif ($_GET['action'] == 'updatePost') {
            if(isset($_GET['postId']) AND !empty($_POST['title']) AND !empty($_POST['content']) AND !empty($_POST['published'])) {
                $backend->updatePost($_GET['postId']);
            } else {
                throw new exception('miss a value to update a post');
            }
        } elseif ($_GET['action'] == 'deletePost') {
            if(isset($_GET['postId'])) {
                $backend->deletePost($_GET['postId']);
            } else {
                throw new exception('postId doesn\'t exist');
            }
        } elseif ($_GET['action'] == 'listCommentsReport') {
            $backend->listCommentsReport();
        } elseif ($_GET['action'] == 'deleteComment') {
            if(isset($_GET['commentId'])) {
                $backend->deleteComment($_GET['commentId']);
            } else {
                throw new exception('commentId doesn\'t exist');
            }
        } elseif ($_GET['action'] == 'validComment') {
            if(isset($_GET['commentId'])) {
                $backend->validComment($_GET['commentId']);
            } else {
                throw new exception('commentId doesn\'t exist');
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
