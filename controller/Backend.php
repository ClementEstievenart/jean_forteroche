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

    public function deletePost() {

    }

    public function updatePost() {

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
