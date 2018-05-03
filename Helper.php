<?php
class Helper {
    public function getGetValues() {
        $get = [];

        foreach ($_GET as $key => $value) {
            $get[htmlspecialchars($key)] = htmlspecialchars($value);
        }

        return $get;
    }

    public function getPostValues() {
        $post = [];

        foreach ($_POST as $key => $value) {
            $post[htmlspecialchars($key)] = htmlspecialchars($value);
        }

        return $post;
    }
}
