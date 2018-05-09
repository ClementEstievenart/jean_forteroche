<?php
class PostsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Post $post) {
        $req = $this->_db->prepare('INSERT INTO posts (id_user, title, content) VALUES (:idUser, :title, :content)');
        $req->execute(array(
            'idUser' => $post->idUser(),
            'title' => $post->title(),
            'content' => $post->content()
        ));
        $req->closeCursor();
    }

    public function delete(Post $post) {
        $req = $this->_db->prepare('DELETE FROM posts WHERE id = :id');
        $req->execute(array('id' => $post->id()));
        $req->closeCursor();
    }

    public function get($id) {
        $req = $this->_db->prepare('
            SELECT id, id_user as idUser, title, content, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, DATE_FORMAT(date_update, "%d/%m/%Y à %Hh%imin%ss") as dateUpdate, nb_comments as nbComments
            FROM posts
            WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return new Post($data);
    }

    public function getList($page) {
        $posts = [];
        $start = ($page - 1) * 10;
        $req = $this->_db->prepare('
            SELECT id, id_user as idUser, title, content, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, DATE_FORMAT(date_update, "%d/%m/%Y à %Hh%imin%ss") as dateUpdate, nb_comments
            FROM posts
            ORDER BY IFNULL(date_publication, date_creation) DESC
            LIMIT 10 OFFSET :start');
        $req->bindParam(':start', $start, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }
        $req->closeCursor();

        return $posts;
    }

    public function getListPublished($page) {
        $posts = [];
        $start = ($page - 1) * 10;
        $req = $this->_db->prepare('
            SELECT id, id_user as idUser, title, content, DATE_FORMAT(date_publication, "%d/%m/%Y à %Hh%imin%ss") as datePublication, DATE_FORMAT(date_update, "%d/%m/%Y à %Hh%imin%ss") as dateUpdate, nb_comments
            FROM posts
            WHERE date_publication != "NULL"
            ORDER BY date_publication DESC
            LIMIT 10 OFFSET :start');
        $req->bindParam(':start', $start, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }
        $req->closeCursor();

        return $posts;
    }

    public function updateWithDateUpdate(Post $post) {
        $req = $this->_db->prepare('UPDATE posts SET id_user = :idUser, title =  :title, content = :content, date_update = NOW(), nb_comments = :nbComments WHERE id = :id');
        $req->execute(array(
            'idUser' => $post->idUser(),
            'title' => $post->title(),
            'content' => $post->content(),
            'nbComments' => $post->nbComments(),
            'id' => $post->id()
        ));
        $req->closeCursor();
    }

    public function updateWithSameDateUpdate(Post $post) {
        $req = $this->_db->prepare('UPDATE posts SET id_user = :idUser, title =  :title, content = :content, nb_comments = :nbComments WHERE id = :id');
        $req->execute(array(
            'idUser' => $post->idUser(),
            'title' => $post->title(),
            'content' => $post->content(),
            'nbComments' => $post->nbComments(),
            'id' => $post->id()
        ));
        $req->closeCursor();
    }

    public function updateWithNoDateUpdate(Post $post) {
        $req = $this->_db->prepare('UPDATE posts SET id_user = :idUser, title =  :title, content = :content, date_update = :dateUpdate, nb_comments = :nbComments WHERE id = :id');
        $req->execute(array(
            'idUser' => $post->idUser(),
            'title' => $post->title(),
            'content' => $post->content(),
            'dateUpdate' => null,
            'nbComments' => $post->nbComments(),
            'id' => $post->id()
        ));
        $req->closeCursor();
    }

    public function publish (Post $post) {
        $req = $this->_db->prepare('UPDATE posts SET date_publication = NOW() WHERE id = :id');
        $req->execute(array(
            'id' => $post->id()
        ));
        $req->closeCursor();
    }

    public function unpublish (Post $post) {
        $req = $this->_db->prepare('UPDATE posts SET date_publication = :datePublication WHERE id = :id');
        $req->execute(array(
            'datePublication' => null,
            'id' => $post->id()
        ));
        $req->closeCursor();
    }

    public function nbPosts () {
        return (int) $this->_db->query('SELECT COUNT(*) FROM posts')->fetch()[0];
    }

    public function nbPostsPublish () {
        return (int) $this->_db->query('SELECT COUNT(*) FROM posts WHERE date_publication != "NULL"')->fetch()[0];
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }
}
