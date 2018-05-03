<?php
class CommentsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Comment $comment) {
        $req = $this->_db->prepare('INSERT INTO comments (lastName, firstName, content, idPost) VALUES (:lastName, :firstName, :content, :idPost)');
        $req->execute(array(
            'lastName' => htmlspecialchars($comment->lastName()),
            'firstName' => htmlspecialchars($comment->firstName()),
            'content' => htmlspecialchars($comment->content()),
            'idPost' => (int) htmlspecialchars($comment->idPost())
        ));
        $req->closeCursor();
    }

    public function delete(Comment $comment) {
        $req = $this->_db->prepare('DELETE FROM comments WHERE id = :id');
        $req->execute(array('id' => (int) htmlspecialchars($comment->id())));
        $req->closeCursor();
    }

    public function get($id) {
        $req = $this->_db->prepare('SELECT * FROM comments WHERE id = :id');
        $req->execute(array('id' => (int) htmlspecialchars($id)));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return new Comment($data);
    }

    public function getList() {
        $comments = [];
        $req = $this->_db->query('SELECT * FROM comments WHERE reportStatut < 2 ORDER BY reportNumber DESC');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        $req->closeCursor();

        return $comments;
    }

    public function getCommentsByPostId($postId) {
        $comments = [];
        $req = $this->_db->prepare('SELECT * FROM comments WHERE idPost = :idPost ORDER BY datePublication DESC');
        $req->execute(array('idPost' => (int) htmlspecialchars($postId)));
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        $req->closeCursor();

        return $comments;
    }

    public function update(Comment $comment) {
        $req = $this->_db->prepare('UPDATE comments SET lastName = :lastName, firstName = :firstName, content = :content, idPost = :idPost, reportNumber = :reportNumber, reportStatut = :reportStatut WHERE id = :id');
        $req->execute(array(
            'lastName' => htmlspecialchars($comment->lastName()),
            'firstName' => htmlspecialchars($comment->firstName()),
            'content' => htmlspecialchars($comment->content()),
            'idPost' => (int) htmlspecialchars($comment->idPost()),
            'reportNumber' => (int) htmlspecialchars($comment->reportNumber()),
            'reportStatut' => (int) htmlspecialchars($comment->reportStatut()),
            'id' => htmlspecialchars($comment->id())
        ));
        $req->closeCursor();
    }

    public function db() {
        return $this->_db;
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }
}
