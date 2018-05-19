<?php
class PostsManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(Post $post, $published) {
        if ($published) {
            $sql = 'INSERT INTO posts (id_user, title, content, date_publication) VALUES (:idUser, :title, :content, NOW())';
        } else {
            $sql = 'INSERT INTO posts (id_user, title, content) VALUES (:idUser, :title, :content)';
        }
        $req = $this->_db->prepare($sql);
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

        if ($data) {
            return new Post($data);
        } else {
            throw new exception('request fail get');
        }
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

        if (!$posts AND $page !== 1) {
            throw new exception('request fail');
        } else {
            return $posts;
        }
    }

    public function getListTitles() {
        $posts = [];
        $req = $this->_db->query('
            SELECT id, title
            FROM posts
            WHERE date_publication != "NULL"
            ORDER BY date_publication');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = new Post($data);
        }
        $req->closeCursor();

        if ($posts) {
            return $posts;
        } else {
            throw new exception('request fail');
        }
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

        if (!$posts AND $page !== 1) {
            throw new exception('request fail');
        } else {
            return $posts;
        }
    }

    public function getNextPublished(Post $post) {
        $req = $this->_db->prepare('
            SELECT date_publication
            FROM posts
            WHERE id = :id');
        $req->execute(array(
            'id' => $post->id()
        ));

        $datePublication = $req->fetch()['date_publication'];
        $req->closeCursor();

        $req = $this->_db->prepare('
            SELECT id
            FROM posts
            WHERE date_publication != "NULL" AND date_publication > :datePublication
            ORDER BY date_publication
            ');
        $req->execute(array(
            'datePublication' => $datePublication
        ));
        $postId = $req->fetch()['id'];
        $req->closeCursor();

        return (int) $postId;
    }

    public function getPrevPublished(Post $post) {
        $req = $this->_db->prepare('
            SELECT date_publication
            FROM posts
            WHERE id = :id');
        $req->execute(array(
            'id' => $post->id()
        ));

        $datePublication = $req->fetch()['date_publication'];
        $req->closeCursor();

        $req = $this->_db->prepare('
            SELECT id
            FROM posts
            WHERE date_publication != "NULL" AND date_publication < :datePublication
            ORDER BY date_publication DESC
            ');
        $req->execute(array(
            'datePublication' => $datePublication
        ));
        $postId = $req->fetch()['id'];
        $req->closeCursor();

        return (int) $postId;

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
        $req = $this->_db->query('SELECT COUNT(*) FROM posts');
        $nbPosts = $req->fetch()[0];
        $req->closeCursor();

        if ($nbPosts) {
            return (int) $nbPosts;
        } else {
            throw new exception('request fail');
        }
    }

    public function nbPostsPublish () {
        $req = $this->_db->query('SELECT COUNT(*) FROM posts WHERE date_publication != "NULL"');
        $nbPostsPublish = $req->fetch()[0];
        $req->closeCursor();

        if ($nbPostsPublish) {
            return (int) $nbPostsPublish;
        } else {
            throw new exception('request fail');
        }
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }
}
