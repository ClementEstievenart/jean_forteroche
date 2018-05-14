<?php
class Backend {
    private $_db;
    private $_path;
    private $_url;
    private $_login;
    private $_lastComments;

    public function __construct(array $config) {
        $this->_path = $config['locator']['path'];
        $this->_url = $config['locator']['url'];
        $dbConfig = $config['db'];

        $this->_db = new PDO('mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'] . ';charset=utf8', $dbConfig['login'], $dbConfig['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        if (!isset($_SESSION['login'])) {
            header('location: ' . $this->_url . '/Accueil');
        }
        $usersManager = new UsersManager($this->_db);
        if(!$usersManager->getByLogin($_SESSION['login'])) {
            header('location: ' . $this->_url . '/Accueil');
        }

        $this->_login = $_SESSION['login'];

        $commentsManager = new CommentsManager($this->_db);
        $this->_lastComments = $commentsManager->getLast();
    }

    public function writeNewPost() {
        $postTitles = $this->listPostTitles();

        require($this->_path . '/view/writeNewPost.php');
    }

    public function addPost($title, $content, $published) {
        $published = (int) $published;

        $usersManager = new UsersManager($this->_db);
        $user = $usersManager->getByLogin($this->_login);

        $data = array(
            'idUser' => $user->id(),
            'title' => $title,
            'content' => $content
        );
        $postsManager = new PostsManager($this->_db);
        $post = new Post($data);
        $postsManager->add($post);

        if ($published) {
            $postsManager->publish($post);
        }

        header('location: ' . $this->_url . '/Titre-des-chapitres/1');
    }

    public function listPostsTitle($page) {
        $page = (int) $page;

        $postsManager = new PostsManager($this->_db);
        $posts = $postsManager->getList($page);

        $nbPosts = $postsManager->nbPosts();

        $postTitles = $this->listPostTitles();

        require($this->_path . '/view/listPostsTitle.php');
    }

    public function editPost($postId) {
        $postId = (int) $postId;

        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);

        $usersManager = new UsersManager($this->_db);
        $user = $usersManager->get($post->idUser());

        $postTitles = $this->listPostTitles();

        require($this->_path . '/view/editPost.php');
    }

    public function deletePost($postId) {
        $postId = (int) $postId;

        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);

        $commentsManager = new CommentsManager($this->_db);
        $comments = $commentsManager->getAllCommentsByPostId($post->id());
        foreach ($comments as $comment) {
            $this->deleteComment($comment->id());
        }

        $postsManager->delete($post);

        header('location: ' . $this->_url . '/Titre-des-chapitres/1');
    }

    public function updatePost($postId, $title, $content, $published) {
        $postId = (int) $postId;
        $published = (int) $published;

        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);

        $post->setTitle($title);

        if ($post->datePublication() AND $published AND $content !== $post->content()) {
            $post->setContent($content);
            $postsManager->updateWithDateUpdate($post);
        } elseif ($published) {
            $post->setContent($content);
            $postsManager->updateWithSameDateUpdate($post);
        } else {
            $post->setContent($content);
            $postsManager->updateWithNoDateUpdate($post);
        }

        if (!$post->datePublication() AND $published) {
            $postsManager->publish($post);
        } elseif ($post->datePublication() AND !$published) {
            $postsManager->unPublish($post);
        }

        header('location: ' . $this->_url . '/Titre-des-chapitres/1');
    }

    public function listCommentsReport($page) {
        $page = (int) $page;

        $postsManager = new PostsManager($this->_db);
        $commentsManager = new CommentsManager($this->_db);
        $comments = $commentsManager->getList($page);

        $nbComments = $commentsManager->nbCommentsNoValidated();

        $postTitles = $this->listPostTitles();

        require($this->_path . '/view/listCommentsReport.php');
    }

    public function findPageOfComment ($commentId) {
        $commentId = (int) $commentId;

        $commentsManager = new CommentsManager($this->_db);
        $comment = $commentsManager->get($commentId);

        $positionComment = $commentsManager->findCommentPosition($commentId, $comment->idPost());

        $page = (int) floor($positionComment / 10) + 1;

        header('location: ' . $this->_url . '/Chapitre-' . $comment->idPost() . '/' . $page . '#commentId' . $commentId);
    }

    public function deleteComment($commentId, $page) {
        $commentId = (int) $commentId;

        $postsManager = new PostsManager($this->_db);
        $commentsManager = new CommentsManager($this->_db);

        $comment = $commentsManager->get($commentId);
        $post = $postsManager->get($comment->idPost());
        $post->setNbComments($post->nbComments() - 1);

        $postsManager->updateWithSameDateUpdate($post);
        $commentsManager->delete($comment);

        header('location: ' . $this->_url . '/Liste-des-commentaires/' . $page);
    }

    public function validComment($commentId, $page) {
        $commentId = (int) $commentId;

        $commentsManager = new CommentsManager($this->_db);
        $comment = $commentsManager->get($commentId);
        $comment->setReportStatut(Comment::COMMENT_VALIDATED);
        $commentsManager->update($comment);

        header('location: ' . $this->_url . '/Liste-des-commentaires/' . $page);
    }

    public function disconnection() {
        session_destroy();

        header('location: ' . $this->_url . '/Accueil');
    }

    public function listPostTitles() {
        $postsManager = new PostsManager($this->_db);
        return $postsManager->getListTitles();
    }
}
