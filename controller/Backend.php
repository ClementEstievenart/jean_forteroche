<?php
class Backend {
    private $_db;
    private $_path;

    public function __construct() {
        $this->_db = new PDO('mysql:host=localhost;dbname=jean_forteroche;charset=utf8', 'root', '');
        $this->_path = realpath('.');

        if (!isset($_SESSION['login'])) {
            header('location: ' . $this->_path . '/index.php?action=home');
        }
    }

    public function writeNewPost() {
        require($this->_path . '/view/writeNewPost.php');
    }

    public function addPost($title, $content, $published) {
        $published = (int) $published;

        $data = array(
            'title' => $title,
            'content' => $content,
            'published' => $published
        );

        $postsManager = new PostsManager($this->_db);
        $postsManager->add(new Post($data));

        header('location: ' . $this->_path . '/index.php?action=home');
    }

    public function listPostsTitle() {
        $postsManager = new PostsManager($this->_db);
        $posts = $postsManager->getList();

        require($this->_path . 'view/listPostsTitle.php');
    }

    public function editPost($postId) {
        $postId = (int) $postId;

        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);

        require($this->_path . 'view/editPost.php');
    }

    public function deletePost($postId) {
        $postId = (int) $postId;

        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);
        $postsManager->delete($post);

        header('location: ' . $this->_path . '/index.php?action=home');
    }

    public function updatePost($postId, $title, $content, $published) {
        $postId = (int) $postId;
        $published = (int) $published;

        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);

        if (!$post->published() AND $published) {
            $post->setDatePublication(date('Y-m-d H:i:s'));
        } elseif ($post->published() AND $content !== $post->content()) {
            $post->setDateUpdate(date('Y-m-d H:i:s'));
        }

        $post->setTitle($title);
        $post->setContent($content);
        $post->setPublished($published);

        $postsManager->update($post);

        header('location: ' . $this->_path . '/index.php?action=home');
    }

    public function ListCommentsReport() {
        $postsManager = new PostsManager($this->_db);
        $commentsManager = new CommentsManager($this->_db);
        $comments = $commentsManager->getList();

        require($this->_path . '/view/listCommentsReport.php');
    }

    public function deleteComment($commentId) {
        $commentId = (int) $commentId;

        $postsManager = new PostsManager($this->_db);
        $commentsManager = new CommentsManager($this->_db);

        $comment = $commentsManager->get($commentId);
        $post = $postsManager->get($comment->idPost());
        $post->setNbComments($post->nbComments() - 1);

        $postsManager->update($post);
        $commentsManager->delete($comment);

        header('location: ' . $this->_path . '/index.php?action=listCommentsReport');
    }

    public function validComment($commentId) {
        $commentId = (int) $commentId;

        $commentsManager = new CommentsManager($this->_db);
        $comment = $commentsManager->get($commentId);
        $comment->setReportStatut(2);
        $commentsManager->update($comment);

        header('location: ' . $this->_path . '/index.php?action=listCommentsReport');
    }

    public function disconnection() {
        session_destroy();

        header('location: ' . $this->_path . '/index.php?action=home');
    }
}
