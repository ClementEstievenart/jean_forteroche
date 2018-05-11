<?php
class Frontend {
    private $_db;
    private $_path;

    public function __construct() {
        $this->_db = new PDO('mysql:host=localhost;dbname=jean_forteroche;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $this->_path = realpath('.');
    }

    public function homePage() {
        $postTitles = $this->listPostTitles();

        require($this->_path . '/view/home.php');
    }

    public function getPostsPublished($page) {
        $page = (int) $page;

        $postsManager = new PostsManager($this->_db);
        $posts = $postsManager->getListPublished($page);

        $nbPosts = $postsManager->nbPostsPublish();

        $postTitles = $this->listPostTitles();

        require($this->_path . '/view/listPosts.php');
    }

    public function getPostById($postId, $page) {
        $postId = (int) $postId;
        $page = (int) $page;

        $postsManager = new PostsManager($this->_db);
        $commentsManager = new CommentsManager($this->_db);
        $usersManager = new UsersManager($this->_db);

        $post = $postsManager->get($postId);
        $comments = $commentsManager->getCommentsByPostId($postId, $page);
        $user = $usersManager->get($post->idUser());

        $postTitles = $this->listPostTitles();

        $postNextId = $postsManager->getNextPublished($post);
        $postPrevId = $postsManager->getPrevPublished($post);

        require($this->_path . '/view/post.php');
    }

    public function login() {
        $postTitles = $this->listPostTitles();

        require($this->_path . '/view/login.php');
    }

    public function connection($login, $password) {
        $usersManager = new UsersManager($this->_db);
        $user = $usersManager->getByLogin($login);

        $postTitles = $this->listPostTitles();

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

    public function addComment($postId, $page, $lastName, $firstName, $content) {
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

        header('location: index.php?action=getPost&postId=' . $postId . '&page=' . $page);
    }

    public function reportComment($commentId, $page) {
        $commentsManager = new CommentsManager($this->_db);
        $comment = $commentsManager->get($commentId);

        if ($comment->reportStatut() !== Comment::COMMENT_VALIDATED) {
            if ($comment->reportStatut() === Comment::COMMENT_NOT_REPORTED) {
                $comment->setReportStatut(Comment::COMMENT_REPORTED);
            }
            $comment->setReportNumber($comment->reportNumber() + 1);
        }
        $commentsManager->update($comment);

        header('location: index.php?action=getPost&postId=' . $comment->idPost() . '&page=' . $page . '#commentId' . $commentId);
    }

    public function listPostTitles() {
        $postsManager = new PostsManager($this->_db);
        return $postsManager->getListTitles();
    }
}
