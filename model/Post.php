<?php
class Post {
    private $_id;
    private $_idUser;
    private $_title;
    private $_content;
    private $_datePublication;
    private $_dateUpdate;
    private $_nbComments;

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

    public function idUser() {
        return $this->_idUser;
    }

    public function title() {
        return $this->_title;
    }

    public function content() {
        return $this->_content;
    }

    public function datePublication() {
        return $this->_datePublication;
    }

    public function dateUpdate() {
        return $this->_dateUpdate;
    }

    public function nbComments() {
        return $this->_nbComments;
    }

    public function setId($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        } else {
            throw new exception('setId() : $id is not an int > 0 -> ' . $id);
        }
    }

    public function setIdUser($idUser) {
        $idUser = (int) $idUser;
        if ($idUser > 0) {
            $this->_idUser = $idUser;
        } else {
            throw new exception('setIdUser() : $idUser is not an int > 0 -> ' . $idUser);
        }
    }

    public function setTitle($title) {
        if (strlen($title) < 255) {
            $this->_title = $title;
        } else {
            throw new exception('setTitle() : $title is not a varchar -> ' . $title);
        }
    }

    public function setContent($content) {
        $this->_content = $content;
    }

    public function setDatePublication($datePublication) {
        if (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4} à [0-9]{2}h[0-9]{2}min[0-9]{2}s/', $datePublication) OR $datePublication === null) {
            $datePublication = preg_replace('/min[0-9]{2}s/', '', $datePublication);
            $this->_datePublication = $datePublication;
        } else {
            throw new exception('setDatePublication() : $datePublication is not a date : ' . $datePublication);
        }
    }

    public function setDateUpdate($dateUpdate) {
        if (preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4} à [0-9]{2}h[0-9]{2}/', $dateUpdate) OR $dateUpdate === null) {
            $dateUpdate = preg_replace('/min[0-9]{2}s/', '', $dateUpdate);
            $this->_dateUpdate = $dateUpdate;
        } else {
            throw new exception('setDateUpdate() : $dateUpdate is not a date : ' . $dateUpdate);
        }
    }

    public function setNbComments($nbComments) {
        $nbComments = (int) $nbComments;
        if ($nbComments >= 0) {
            $this->_nbComments = $nbComments;
        } else {
            throw new exception('setNbComments() : $nbComments is not an int >= 0 -> ' . $nbComments);
        }
    }

}
