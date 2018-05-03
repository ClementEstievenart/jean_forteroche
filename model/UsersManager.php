<?php
class UsersManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(User $user) {
        $req = $this->_db->prepare('INSERT INTO users (login, password) VALUES (:login, :password)');
        $req->execute(array(
            'login' => htmlspecialchars($user->login()),
            'password' => htmlspecialchars($user->password())
        ));
        $req->closeCursor();
    }

    public function delete(User $user) {
        $this->_db->prepare('DELETE FROM users WHERE id = :id');
        $req->execute(array('id' => (int) htmlspecialchars($user->id())));
        $req->closeCursor();
    }

    public function get($id) {
        $req = $this->_db->prepare('SELECT * FROM users WHERE id = :id');
        $req->execute(array('id' => (int) htmlspecialchars($id)));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        return new User($data);
    }

    public function getList() {
        $users = [];
        $req = $this->_db->query('SELECT * FROM users');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($data);
        }
        $req->closeCursor();

        return $users;
    }

    public function getByLogin($login) {
        $req = $this->_db->prepare('SELECT * FROM users WHERE login = :login');
        $req->execute(array('login' => htmlspecialchars($login)));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();

        if ($data) {
            return new User($data);
        } else {
            return false;
        }

    }

    public function update(User $user) {
        $req = $this->_db->prepare('UPDATE users SET login = :login, password = :password');
        $req->execute(array(
            'login' => htmlspecialchars($user->login()),
            'password' => htmlspecialchars($user->password())
        ));
        $req->closeCursor();
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }

    public function db() {
        return $this->_db;
    }
}
