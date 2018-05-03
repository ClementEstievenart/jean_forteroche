<?php
class PostsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Post $post) {
        $req = $this->_db->prepare('INSERT INTO posts (title, content, published) VALUES (:title, :content, :published)');
        $req->execute(array(
            'title' => htmlspecialchars($post->title()),
            'content' => htmlspecialchars($post->content()),
            'published' => (int) htmlspecialchars($post->published())
        ));
        $req->closeCursor();
    }

    public function delete(Post $post) {
        $req = $this->_db->prepare('DELETE FROM posts WHERE id = :id');
        $req->execute(array('id' => (int) htmlspecialchars($post->id())));
        $req->closeCursor();
    }

    public function get($id) {
        $req = $this->_db->prepare('SELECT * FROM posts WHERE id = :id');
        $req->execute(array('id' => (int) htmlspecialchars($id)));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return new Post($data);
    }

    public function getList() {
        $posts = [];
        $req = $this->_db->query('SELECT * FROM posts ORDER BY datePublication DESC');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }
        $req->closeCursor();

        return $posts;
    }

    public function getListPublished() {
        $posts = [];
        $req = $this->_db->query('SELECT * FROM posts WHERE published = 1 ORDER BY datePublication DESC');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }
        $req->closeCursor();

        return $posts;
    }

    public function update(Post $post) {
        $req = $this->_db->prepare('UPDATE posts SET idUser = :idUser, title =  :title, content = :content, dateUpdate = :dateUpdate, updateStatut = :updateStatut, published = :published, nbComments = :nbComments WHERE id = :id');
        $req->execute(array(
            'idUser' => (int) htmlspecialchars($post->idUser()),
            'title' => htmlspecialchars($post->title()),
            'content' => htmlspecialchars($post->content()),
            'dateUpdate' => htmlspecialchars($post->dateUpdate()),
            'updateStatut' => htmlspecialchars($post->updateStatut()),
            'published' => (int) htmlspecialchars($post->published()),
            'nbComments' => (int) htmlspecialchars($post->nbComments()),
            'id' => (int) htmlspecialchars($post->id())
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
