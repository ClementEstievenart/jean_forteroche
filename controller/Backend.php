<?php
class Backend {
    private $_db;

    public function __construct() {
        $this->_db = new PDO('mysql:host=localhost;dbname=jean_forteroche;charset=utf8', 'root', '');
    }

    public function writeNewPost() {
        require('view/writeNewPost.php');
    }

    public function addPost($title, $content, $published) {
        $published = (int) htmlspecialchars($published);
        if ($published != 0 AND $published != 1) {
            throw new exception('$published value isn\'t 0 or 1 -> ' . $published);
        }
        $data = array(
            'title' => htmlspecialchars($title),
            'content' => htmlspecialchars($content),
            'published' => $published
        );
        $postsManager = new PostsManager($this->_db);
        $postsManager->add(new Post($data));
        header('location: index.php?action=home');
    }

    public function listPostsTitle() {
        $postsManager = new PostsManager($this->_db);
        $posts = $postsManager->getList();
        require('view/listPostsTitle.php');
    }

    public function editPost($postId) {
        $postId = (int) $postId;
        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);
        require('view/editPost.php');
    }

    public function deletePost($postId) {
        $postId = (int) $postId;
        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);
        $postsManager->delete($post);
        header('location: index.php?action=home');
    }

    public function updatePost($postId) {
        $postId = (int) $postId;
        $postsManager = new PostsManager($this->_db);
        $post = $postsManager->get($postId);
        $post->setTitle(htmlspecialchars($_POST['title']));
        $post->setContent(htmlspecialchars($_POST['content']));
        $post->setPublished((int) htmlspecialchars($_POST['published']));
        $post->setDateUpdate(date('Y-m-d H:i:s'));
        $postsManager->update($post);
        header('location: index.php?action=home');
    }

    public function ListComments() {

    }

    public function deleteComment() {

    }

    public function validComment() {

    }

    public function disconnection() {
        session_destroy();
        header('location: index.php?action=home');
    }
}
