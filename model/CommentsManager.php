<?php
class CommentsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Comment $comment) {
        $req = $this->_db->prepare('INSERT INTO comments (pseudo, content, id_post) VALUES (:pseudo, :content, :idPost)');
        $req->execute(array(
            'pseudo' => $comment->pseudo(),
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
        $req = $this->_db->prepare('
            SELECT id, pseudo, content, id_post as idPost, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, report_number as reportNumber, report_statut as reportStatut
            FROM comments
            WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        if ($data) {
            return new Comment($data);
        } else {
            throw new exception('get in CommentsManager : request fail');
        }
    }

    public function getList($page) {
        $comments = [];
        $start = ($page - 1) * 10;
        $req = $this->_db->prepare('
            SELECT id, pseudo, content, id_post as idPost, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, report_number as reportNumber, report_statut as reportStatut
            FROM comments
            WHERE report_statut < 2
            ORDER BY report_number DESC, date_publication DESC
            LIMIT 10 OFFSET :start');
        $req->bindParam(':start', $start, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        $req->closeCursor();

        if (!$comments AND $page !== 1) {
            throw new exception('getList in CommentsManager : request fail');
        } else {
            return $comments;
        }
    }

    public function getLast() {
        $comments = [];
        $req = $this->_db->query('
            SELECT id, pseudo, content
            FROM comments
            ORDER BY date_publication DESC
            LIMIT 10');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        $req->closeCursor();

        if ($comments) {
            return $comments;
        } else {
            throw new exception('getLast in CommentsManager : request fail');
        }
    }

    public function getAllCommentsByPostId($postId) {
        $comments = [];
        $req = $this->_db->prepare('
            SELECT id, pseudo, content, id_post as idPost, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, report_number as reportNumber, report_statut as reportStatut
            FROM comments
            WHERE id_post = :idPost
            ORDER BY date_publication DESC');
        $req->bindParam(':idPost', $postId, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        $req->closeCursor();

        return $comments;
    }

    public function getCommentsByPostId($postId, $page) {
        $comments = [];
        $start = ($page - 1) * 10;
        $req = $this->_db->prepare('
            SELECT id, pseudo, content, id_post as idPost, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, report_number as reportNumber, report_statut as reportStatut
            FROM comments
            WHERE id_post = :idPost
            ORDER BY date_publication DESC
            LIMIT 10 OFFSET :start');
        $req->bindParam(':idPost', $postId, PDO::PARAM_INT);
        $req->bindParam(':start', $start, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }
        $req->closeCursor();

        if (!$comments AND $page !== 1) {
            throw new exception('getCommentsByPostId in CommentsManager : request fail');
        } else {
            return $comments;
        }
    }

    public function update(Comment $comment) {
        $req = $this->_db->prepare('UPDATE comments SET pseudo = :pseudo, content = :content, id_post = :idPost, report_number = :reportNumber, report_statut = :reportStatut WHERE id = :id');
        $req->execute(array(
            'pseudo' => $comment->pseudo(),
            'content' => $comment->content(),
            'idPost' => $comment->idPost(),
            'reportNumber' => $comment->reportNumber(),
            'reportStatut' => $comment->reportStatut(),
            'id' => $comment->id()
        ));
        $req->closeCursor();
    }

    public function findCommentPosition ($commentId, $postId) {
        $comments = [];
        $req = $this->_db->prepare('SELECT id FROM comments WHERE id_post = :postId ORDER BY date_publication DESC');
        $req->execute(array(
            'postId' => $postId
        ));
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $comments[] = (int) $data['id'];
        }
        $req->closeCursor();

        foreach ($comments as $key => $id) {
            if ($id === $commentId) {
                $positionComment = $key;
                break;
            }
        }

        if (isset($positionComment)) {
            return $positionComment + 1;
        } else {
            throw new exception('findCommentPosition in CommentsManager : request fail');
        }
    }

    public function nbCommentsNoValidated () {
        $req = $this->_db->query('SELECT COUNT(*) FROM comments WHERE report_statut < 2');
        $nbComments = (int) $req->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
        $req->closeCursor();

        return $nbComments;
    }

    public function db() {
        return $this->_db;
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }
}
