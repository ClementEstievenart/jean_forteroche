<?php
class User {
    private $_id;
    private $_login;
    private $_password;

    public function __construct($data) {
        $this->hydrate($data);
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function id() {
        return $this->_id;
    }

    public function login() {
        return $this->_login;
    }

    public function password() {
        return $this->_password;
    }

    public function setId($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        } else {
            throw new exception('setId() in class user : $id is not an int > 0 -> ' . $id);
        }
    }

    public function setLogin($login) {
        if (strlen($login) < 255) {
            $this->_login = $login;
        } else {
            throw new exception('setLogin in class user : $login is not a varchar -> ' . $login);
        }
    }

    public function setPassword($password) {
        if (strlen($password) < 255) {
            $this->_password = $password;
        } else {
            throw new exception('setPassword in class user : $password is not a varchar -> ' . $password);
        }
    }
}
