<?php
class PostsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Post $post) {
        $req = $this->_db->prepare('INSERT INTO posts (idUser, title, content, published) VALUES (:idUser, :title, :content, :published)');
        $req->execute(array(
            'idUser' => $post->idUser(),
            'title' => $post->title(),
            'content' => $post->content(),
            'published' => $post->published()
        ));
        $req->closeCursor();
    }

    public function delete(Post $post) {
        $req = $this->_db->prepare('DELETE FROM posts WHERE id = :id');
        $req->execute(array('id' => $post->id()));
        $req->closeCursor();
    }

    public function get($id) {
        $req = $this->_db->prepare('SELECT id, idUser, title, content, DATE_FORMAT(datePublication, "%d/%m/%Y à %Hh%i") as datePublication, DATE_FORMAT(dateUpdate, "%d/%m/%Y à %Hh%i") as dateUpdate, published, nbComments FROM posts WHERE id = :id');
        $req->execute(array('id' => $id));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return new Post($data);
    }

    public function getList() {
        $posts = [];
        $req = $this->_db->query('SELECT id, idUser, title, content, DATE_FORMAT(datePublication, "%d/%m/%Y à %Hh%i") as datePublication, DATE_FORMAT(dateUpdate, "%d/%m/%Y à %Hh%i") as dateUpdate, published, nbComments FROM posts ORDER BY datePublication DESC');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }
        $req->closeCursor();

        return $posts;
    }

    public function getListPublished() {
        $posts = [];
        $req = $this->_db->query('SELECT id, idUser, title, content, DATE_FORMAT(datePublication, "%d/%m/%Y à %Hh%i") as datePublication, DATE_FORMAT(dateUpdate, "%d/%m/%Y à %Hh%i") as dateUpdate, published, nbComments FROM posts WHERE published = 1 ORDER BY datePublication DESC');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }
        $req->closeCursor();

        return $posts;
    }

    public function update(Post $post) {
        $req = $this->_db->prepare('UPDATE posts SET idUser = :idUser, title =  :title, content = :content, dateUpdate = :dateUpdate, published = :published, nbComments = :nbComments WHERE id = :id');
        $req->execute(array(
            'idUser' => $post->idUser(),
            'title' => $post->title(),
            'content' => $post->content(),
            'dateUpdate' => $post->dateUpdate(),
            'published' => $post->published(),
            'nbComments' => $post->nbComments(),
            'id' => $post->id()
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
