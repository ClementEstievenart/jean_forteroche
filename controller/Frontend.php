<?php
class Frontend {
    private $_db;
    private $_path;

    public function __construct() {
        $this->_db = new PDO('mysql:host=localhost;dbname=jean_forteroche;charset=utf8', 'root', '');
        $this->_path = realpath('.');
    }

    public function homePage() {
        require($this->_path . '/view/home.php');
    }

    public function getPostsPublished() {
        $postsManager = new PostsManager($this->_db);
        $posts = $postsManager->getListPublished();

        require($this->_path . '/view/listPosts.php');
    }

    public function getPostById($postId) {
        $postId = (int) $postId;

        $postsManager = new PostsManager($this->_db);
        $commentsManager = new CommentsManager($this->_db);
        $usersManager = new UsersManager($this->_db);

        $post = $postsManager->get($postId);
        $comments = $commentsManager->getCommentsByPostId($postId);
        $user = $usersManager->get($post->idUser());

        require($this->_path . '/view/post.php');
    }

    public function login() {
        require($this->_path . '/view/login.php');
    }

    public function connection($login, $password) {
        $usersManager = new UsersManager($this->_db);
        $user = $usersManager->getByLogin($login);

        if ($user) {
            if (password_verify($password, $user->password())) {
                $_SESSION['login'] = $login;
                header('location: index.php?action=home');
            } else {
                require($this->_path . '/view/login.php');
            }
        } else {
            require($this->_path . '/view/login.php');
        }
    }

    public function addComment($postId, $lastName, $firstName, $content) {
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
        $postsManager->updateWithSameDateUpdate($post);

        header('location: index.php?action=getPost&postId=' . $postId);
    }

    public function reportComment($commentId) {
        $commentsManager = new CommentsManager($this->_db);
        $comment = $commentsManager->get($commentId);

        if ($comment->reportStatut() !== Comment::COMMENT_VALIDATED) {
            if ($comment->reportStatut() === Comment::COMMENT_NOT_REPORTED) {
                $comment->setReportStatut(Comment::COMMENT_REPORTED);
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
