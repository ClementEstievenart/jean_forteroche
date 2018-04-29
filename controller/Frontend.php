<?php
class Frontend {
    private $_db;

    public function __construct() {
        $this->_db = new PDO('mysql:host=localhost;dbname=jean_forteroche;charset=utf-8', 'root', '');
        function loadClass($class) {
            require('../model/' . $class . '.php');
        }
        spl_autoload_register(loadClass);
    }

    public function homePage() {
        require('../view/homeView.php');
    }

    public function getPosts() {
        $postsManager = new PostsManager($this->_db);
        $posts = $postsManager->getList();
        require('../view/listPostsView.php');
    }

    public function getPostById($postId) {
        if (isset($postId)) {
            $postId = (int) $postId;
            $postsManager = new PostsManager($this->_db);
            $commentsManager = new CommentsManager($this->_db);
            $post = $postsManager->get($postId);
            $comments = $commentsManager->getCommentsByPostId($postId);
            require('../view/postView.php');
        } else {
            throw new exception('postView() in class Frontend : $postId doesn\'t exist ->');
        }
    }

    public function connection() {
        //To do
    }

    public function addComment(Comment $comment) {
        $commentsManager = new CommentsManager($this->_db);
        $commentsManager->add($comment);
        //redirection
    }

    public function reportComment($commentId) {
        $commentsManager = new CommentsManager($this->_db);
        $comment = $commentsManager->get($commentId);
        if ($comment->reportStatut() != 2) {
            if ($comment->reportStatut() ==0) {
                $comment->setReportStatut(1);
            }
            $comment->setReportNumber($comment->reportNumber() + 1);
        }
        //redirection
    }

    public function db() {
        return $this->_db;
    }
}
