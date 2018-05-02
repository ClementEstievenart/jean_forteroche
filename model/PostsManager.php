<?php
class PostsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add (Post $post) {
        $req = $this->_db->prepare('INSERT INTO posts(title, content, published) VALUES (:title, :content, :published)');
        $req->execute(array(
            'title' => $post->title(),
            'content' => $post->content(),
            'published' => $post->published()
        ));
    }

    public function delete(Post $post) {
        $req = $this->_db->exec('DELETE FROM posts WHERE id = ' . $post->id());
    }

    public function get($id) {
        $id = (int) $id;
        $req = $this->_db->query('SELECT * FROM posts WHERE id = ' . $id);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return new Post($data);
    }

    public function getList() {
        $posts = [];
        $req = $this->_db->query('SELECT * FROM posts');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }
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
    }

    public function db() {
        return $this->_db;
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }
}
