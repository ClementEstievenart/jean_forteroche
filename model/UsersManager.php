<?php
class UsersManager {
    private $_db;

    public function __construct($db) {
        $this->setDb($db);
    }

    public function add(User $user) {
        $req = $this->_db->prepare('INSER INTO users (login, password) VALUES (:login, :password)');
        $req->execute(array(
            'login' => $user->login(),
            'password' => $user->password()
        ));
    }

    public function delete(User $user) {
        $this->_db->exec('DELETE FROM users WHERE id = ' . $user->id());
    }

    public function get($id) {
        $id = (int) $id;
        $req = $this->_db->query('SELECT * FROM users WHERE id = ' . $id);
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return new User($data);
    }

    public function getList() {
        $users = [];
        $req = $this->_db->query('SELECT * FROM users');
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($data);
        }
        return $users;
    }

    public function update(User $user) {
        $req = $this->_db->prepare('UPDATE users SET login = :login, password = :password');
        $req->execute(array(
            'login' => $user->login(),
            'password' => $user->password()
        ));
    }

    public function setDb(PDO $db) {
        $this->_db = $db;
    }

    public function db() {
        return $this->_db;
    }
}
