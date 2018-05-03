<?php
class Frontend {
    private $_db;

    public function __construct() {
        $this->_db = new PDO('mysql:host=localhost;dbname=jean_forteroche;charset=utf8', 'root', '');

        function loadClassFrontend($class) {
            require('model/' . $class . '.php');
        }
        spl_autoload_register('loadClassFrontend');
    }

    public function homePage() {
        require('view/home.php');
    }

    public function getPostsPublished() {
        $postsManager = new PostsManager($this->_db);
        $posts = $postsManager->getListPublished();

        require('view/listPosts.php');
    }

    public function getPostById($postId) {
        $postId = (int) $postId;

        $postsManager = new PostsManager($this->_db);
        $commentsManager = new CommentsManager($this->_db);
        $usersManager = new UsersManager($this->_db);

        $post = $postsManager->get($postId);
        $comments = $commentsManager->getCommentsByPostId($postId);
        $user = $usersManager->get($post->idUser());

        require('view/post.php');
    }

    public function login() {
        require('view/login.php');
    }

    public function connection($login, $password) {
        $password = htmlspecialchars($password);
        $login = htmlspecialchars($login);

        $usersManager = new UsersManager($this->_db);
        $user = $usersManager->getByLogin($login);

        if ($login == $user->login() AND password_verify($password, $user->password())) {
            $_SESSION['login'] = $login;
            header('location: index.php?action=home');
        } else {
            require('view/login.php');
        }
    }

    public function addComment($lastName, $firstName, $content, $postId) {
        $data = array(
            'lastName' => $lastName,
            'firstName' => $firstName,
            'content' => $content,
            'idPost' => $postId
        );

        $commentsManager = new CommentsManager($this->_db);
        $postsManager = new PostsManager($this->_db);

        $commentsManager->add(new Comment($data));

        $post = $postsManager->get($postId);
        $post->setNbComments($post->nbComments() + 1);
        $postsManager->update($post);

        header('location: index.php?action=getPost&postId=' . $postId);
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
        $commentsManager->update($comment);

        header('location: index.php?action=getPost&postId=' . $comment->idPost());
    }

    public function db() {
        return $this->_db;
    }
}
