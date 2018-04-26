<?php
class comment {
    private $_id;
    private $_lastName;
    private $_firstName;
    private $_content;
    private $_idPost;
    private $_datePublication;
    private $_reportNumber;
    private $_reportStatut;

    public function id() {
        return $this->_id;
    }

    public function lastName() {
        return $this->_lastName;
    }

    public function firstNAme() {
        return $this->_firstName;
    }

    public function content() {
        return $this->_content;
    }

    public function idPost() {
        return $this->_idPost;
    }

    public function datePublication() {
        return $this->_datePublication;
    }

    public function reportNumber() {
        return $this->_reportNumber;
    }

    public function reportStatut() {
        return $this->_reportStatut;
    }

    public function setId($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        } else {
            throw new exception('setId() in class comment : $id is not an int -> ' . $id);
        }
    }

    public function setLastName($lastName) {
        if (strlen($lastName) < 255) {
            $this->_lastName = $lastName;
        } else {
            throw new exception('setLastName() in class comment : $lastName is not a varchar -> ' . $lastName);
        }
    }

    public function setFirstName($firstName) {
        if (strlen($firstName) < 255) {
            $this->_firstName = $firstName;
        } else {
            throw new exception('setFirstName() in class comment : $firstName is not a varchar -> ' . $firstName);
        }
    }

    public function setContent($content) {
        $this->_content = $content;
    }

    public function setIdPost($idPost) {
        $idPost = (int) $idPost;
        if ($idPost > 0) {
            $this->_idPost = $idPost;
        } else {
            throw new exception('setIdPost() in class comment : $idPost is not an int -> ' . $idPost);
        }
    }

    public function setDatePublication($datePublication) {
        $this->_datePublication = $datePublication;
    }

    public function setReportNumber($reportNumber) {
        $reportNumber = (int) $reportNumber;
        if ($reportNumber > 0) {
            $this->_reportNumber = $reportNumber;
        } else {
            throw new exception('setReportNumber() in class comment : $reportNumber is not an int -> ' . $reportNumber);
        }
    }

    public function setReportStatut($reportStatut) {
        $reportStatut = (int) $reportStatut;
        if ($reportStatut > 0 ) {
            $this->_reportStatut = $reportStatut;
        } else {
            throw new exception('setReportStatut() in class comment : $reportStatut is not an int -> ' . $reportStatut);
        }
    }
}
