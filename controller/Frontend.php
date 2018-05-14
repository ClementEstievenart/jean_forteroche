<?php
class Frontend {
    private $_db;
    private $_path;
    private $_url;
    private $_lastComments;

    public function __construct(array $config) {
        $this->_path = $config['locator']['path'];
        $this->_url = $config['locator']['url'];
        $dbConfig = $config['db'];

        $this->_db = new PDO('mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'] . ';charset=utf8', $dbConfig['login'], $dbConfig['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        $commentsManager = new CommentsManager($this->_db);
        $this->_lastComments = $commentsManager->getLast();
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
                header('location: ' . $this->_url . '/Accueil');
            } else {
                require($this->_path . '/view/home.php');
            }
        } else {
            require($this->_path . '/view/home.php');
        }
    }

    public function addComment($postId, $page, $pseudo, $content) {
        $postId = (int) $postId;
        $page = (int) $page;

        $data = array(
            'pseudo' => $pseudo,
            'content' => $content,
            'idPost' => $postId
        );

        $commentsManager = new CommentsManager($this->_db);
        $postsManager = new PostsManager($this->_db);

        $comment = new Comment($data);
        $commentsManager->add($comment);

        $post = $postsManager->get($postId);
        $post->setNbComments($post->nbComments() + 1);
        $postsManager->updateWithSameDateUpdate($post);

        header('location: ' . $this->_url . '/Chapitre-' . $postId . '/' . $page . '#commentId' . $comment->id());
    }

    public function reportComment($commentId, $page) {
        $commentId = (int) $commentId;
        $page = (int) $page;

        $commentsManager = new CommentsManager($this->_db);
        $comment = $commentsManager->get($commentId);

        if ($comment->reportStatut() !== Comment::COMMENT_VALIDATED) {
            if ($comment->reportStatut() === Comment::COMMENT_NOT_REPORTED) {
                $comment->setReportStatut(Comment::COMMENT_REPORTED);
            }
            $comment->setReportNumber($comment->reportNumber() + 1);
        }
        $commentsManager->update($comment);

        header('location: ' . $this->_url . '/Chapitre-' . $comment->idPost() . '/' . $page . '#commentId' . $commentId, false);
    }

    public function listPostTitles() {
        $postsManager = new PostsManager($this->_db);
        return $postsManager->getListTitles();
    }
}
