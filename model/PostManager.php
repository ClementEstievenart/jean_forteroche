<?php
class article {
    private $_id;
    private $_idUser;
    private $_title;
    private $_content;
    private $_datePublication;
    private $_dateUpdate;
    private $_published;
    private $_nbComments;

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

    public function published() {
        return $this->_published;
    }

    public function nbComments() {
        return $this->_nbComments;
    }

    public function setId($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        } else {
            throw new exception('setId() in class article : $id is not an int -> ' . $id);
        }
    }

    public function setIdUser($idUser) {
        $idUser = (int) $idUser;
        if ($idUser > 0) {
            $this->_idUser = $idUser;
        } else {
            throw new exception('setIdUser() in class article : $idUser is not an int -> ' . $idUser);
        }
    }

    public function setTitle($title) {
        if (strlen($title) > 255) {
            $this->_title = $title;
        } else {
            throw new exception('setTitle() in class article : $title is not a varchar -> ' . $title);
        }
    }

    public function setContent($content) {
        $this->_content = $content;
    }

    public function setDatePublication($datePublication) {
        $this->_datePublication = $datePublication;
    }

    public function setDateUpdate($dateUpdate) {
        $this->_dateUpdate = $dateUpdate;
    }

    public function setPublished($published) {
        if (is_bool($published)) {
            $this->_published = $published;
        } else {
            throw new exception('setPublished() in class article : $published is not a boolean -> ' . $published);
        }
    }

    public function setNbComments($nbComments) {
        $nbComments = (int) $nbComments;
        if (is_int($nbComments)) {
            $this->_nbComments = $nbComments;
        } else {
            throw new exception('setNbComments() in class article : $nbComments is not an int -> ' . $nbComments);
        }
    }

}
