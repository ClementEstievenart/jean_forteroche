<?php
class Backend {
    private $_db;

    public function __construct() {
        $this->_db = new PDO('mysql:host=localhost;dbname=jean_forteroche;charset=utf8', 'root', '');
    }

    public function addPost() {

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
