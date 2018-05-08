<?php
class CommentsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Comment $comment) {
        $req = $this->_db->prepare('INSERT INTO comments (last_name, first_name, content, id_post) VALUES (:lastName, :firstName, :content, :idPost)');
        $req->execute(array(
            'lastName' => $comment->lastName(),
            'firstName' => $comment->firstName(),
            'content' => $comment->content(),
            'idPost' => $comment->idPost()
        ));
        $req->closeCursor();
    }

    public function delete(Comment $comment) {
        $req = $this->_db->prepare('DELETE FROM comments WHERE id = :id');
        $req->execute(array('id' => $comment->id()));
        $req->closeCursor();
    }

    public function get($id) {
        $req = $this->_db->prepare('SELECT id, last_name as lastName, first_name as firstName, content, id_post as idPost, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, report_number as reportNumber, report_statut as reportStatut FROM comments WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return new Comment($data);
    }

    public function getList() {
        $comments = [];
        $req = $this->_db->query('SELECT id, last_name as lastName, first_name as firstName, content, id_post as idPost, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, report_number as reportNumber, report_statut as reportStatutFROM comments WHERE report_statut < 2 ORDER BY report_number DESC');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        $req->closeCursor();

        return $comments;
    }

    public function getCommentsByPostId($postId) {
        $comments = [];
        $req = $this->_db->prepare('SELECT id, last_name as lastName, first_name as firstName, content, id_post as idPost, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, report_number as reportNumber, report_statut as reportStatut FROM comments WHERE id_post = :idPost ORDER BY date_publication DESC');
        $req->execute(array('idPost' => $postId));
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        $req->closeCursor();

        return $comments;
    }

    public function update(Comment $comment) {
        $req = $this->_db->prepare('UPDATE comments SET last_name = :lastName, first_name = :firstName, content = :content, id_post = :idPost, report_number = :reportNumber, report_statut = :reportStatut WHERE id = :id');
        $req->execute(array(
            'lastName' => $comment->lastName(),
            'firstName' => $comment->firstName(),
            'content' => $comment->content(),
            'idPost' => $comment->idPost(),
            'reportNumber' => $comment->reportNumber(),
            'reportStatut' => $comment->reportStatut(),
            'id' => $comment->id()
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
