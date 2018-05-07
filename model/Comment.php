<?php
class Comment {
    private $_id;
    private $_lastName;
    private $_firstName;
    private $_content;
    private $_idPost;
    private $_datePublication;
    private $_reportNumber;
    private $_reportStatut;

    const COMMENT_NOT_REPORTED = 0;
    const COMMENT_REPORTED = 1;
    const COMMENT_VALIDATED = 2;

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
            throw new exception('setId() : $id is not an int > 0 -> ' . $id);
        }
    }

    public function setLastName($lastName) {
        if (strlen($lastName) < 255) {
            $this->_lastName = $lastName;
        } else {
            throw new exception('setLastName() : $lastName is not a varchar -> ' . $lastName);
        }
    }

    public function setFirstName($firstName) {
        if (strlen($firstName) < 255) {
            $this->_firstName = $firstName;
        } else {
            throw new exception('setFirstName() : $firstName is not a varchar -> ' . $firstName);
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
            throw new exception('setIdPost() : $idPost is not an int > 0 -> ' . $idPost);
        }
    }

    public function setDatePublication($datePublication) {
        if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $datePublication) OR preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4} à [0-9]{2}h[0-9]{2}/', $datePublication)) {
            $this->_datePublication = $datePublication;
        } else {
            throw new exception('setDatePublication() : $datePublication is not a date : ' . $datePublication);
        }

    }

    public function setReportNumber($reportNumber) {
        $reportNumber = (int) $reportNumber;
        if ($reportNumber >= 0) {
            $this->_reportNumber = $reportNumber;
        } else {
            throw new exception('setReportNumber() : $reportNumber is not an int >= 0 -> ' . $reportNumber);
        }
    }

    public function setReportStatut($reportStatut) {
        if (in_array($reportStatut, [self::COMMENT_NOT_REPORTED, self::COMMENT_REPORTED, self::COMMENT_VALIDATED])) {
            $this->_reportStatut = (int) $reportStatut;
        } else {
            throw new exception('setReportStatut() : $reportStatut is not a valid const ["COMMENT_NO_REPORTED", "COMMENT_REPORTED", "COMMENT_VALIDATED"] -> ' . $reportStatut);
        }
    }
}
