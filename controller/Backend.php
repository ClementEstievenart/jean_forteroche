<?php
class Backend {
    private $_db;
    private $_path;
    private $_login;

    public function __construct() {
        $this->_db = new PDO('mysql:host=localhost;dbname=jean_forteroche;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        if (!isset($_SESSION['login'])) {
            header('location: index.php?action=home');
        }
        $usersManager = new UsersManager($this->_db);
        if(!$usersManager->getByLogin($_SESSION['login'])) {
            header('location: index.php?action=home');
        }

        $this->_login = $_SESSION['login'];
        $this->_path = realpath('.');
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
        $postsManager->add(new Post($data));

        if ($published) {
            $postsManager->publish($post);
        }

        header('location: index.php?action=listPostsTitle&page=1');
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

        header('location: index.php?action=listPostsTitle&page=1');
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

        header('location: index.php?action=listPostsTitle&page=1');
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

    public function findPageOfComment ($commentId, $postId) {
        $commentId = (int) $commentId;
        $postId = (int) $postId;

        $commentsManager = new CommentsManager($this->_db);
        $positionComment = $commentsManager->findCommentPosition($commentId, $postId);

        $page = (int) floor($positionComment / 10) + 1;

        header('location: index.php?action=getPost&postId=' . $postId . '&page=' . $page . '#commentId' . $commentId);
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

        header('location: index.php?action=listCommentsReport&page=' . $page);
    }

    public function validComment($commentId, $page) {
        $commentId = (int) $commentId;

        $commentsManager = new CommentsManager($this->_db);
        $comment = $commentsManager->get($commentId);
        $comment->setReportStatut(Comment::COMMENT_VALIDATED);
        $commentsManager->update($comment);

        header('location: index.php?action=listCommentsReport&page=' . $page);
    }

    public function disconnection() {
        session_destroy();

        header('location: index.php?action=home');
    }

    public function listPostTitles() {
        $postsManager = new PostsManager($this->_db);
        return $postsManager->getListTitles();
    }
}
