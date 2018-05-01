<?php
class CommentsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Comment $comment) {
        $req = $this->_db->prepare('INSERT INTO comments(lastName, firstName, content, idPost) VALUES (:lastName, :firstName, :content, :idPost)');
        $req->execute(array(
            'lastName' => $comment->lastName(),
            'firstName' => $comment->firstName(),
            'content' => $comment->content(),
            'idPost' => $comment->idPost()
        ));
    }

    public function delete(Comment $comment) {
        $this->_db->exec('DELETE FROM comments WHERE id = ' . $comment->id());

    }

    public function get($id) {
        $id = (int) $id;
        $req = $this->_db->query('SELECT * FROM comments WHERE id = ' . $id);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return new Comment($data);
    }

    public function getList() {
        $comments = [];
        $req = $this->_db->query('SELECT * FROM comments');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        return $comments;
    }

    public function getCommentsByPostId($postId) {
        $comments = [];
        $req = $this->_db->query('SELECT * FROM comments WHERE idPost = ' . $postId);
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        return $comments;
    }

    public function update(Comment $comment) {
        $req = $this->_db->prepare('UPDATE comments SET lastName = :lastName, firstName = :firstName, content = :content, idPost = :idPost, reportNumber = :reportNumber, reportStatut = :reportStatut WHERE id = :id');
        $req->execute(array(
            'lastName' => $comment->lastName(),
            'firstName' => $comment->firstName(),
            'content' => $comment->content(),
            'idPost' => $comment->idPost(),
            'reportNumber' => $comment->reportNumber(),
            'reportStatut' => $comment->reportStatut(),
            'id' => $comment->id()
        ));
    }

    public function db() {
        return $this->_db;
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }
}
