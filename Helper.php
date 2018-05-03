<?php
class Helper {
    public function getGetValues() {
        $getVar = [];

        foreach ($_GET as $key => $value) {
            $getVar[htmlspecialchars($key)] = htmlspecialchars($value);
        }

        return $getVar;
    }

    public function getPostValues() {
        $postVar = [];

        foreach ($_POST as $key => $value) {
            $postVar[htmlspecialchars($key)] = htmlspecialchars($value);
        }

        return $postVar;
    }
}
