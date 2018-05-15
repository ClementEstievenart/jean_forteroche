<?php
abstract class Controller {
    protected $_db;
    protected $_path;
    protected $_url;
    protected $_lastComments;
    protected $_listPostTitles;
    protected $_postsManager;
    protected $_commentsManager;
    protected $_usersManager;

    public function __construct(array $config) {
        $dbConfig = $config['db'];
        $this->_db = new PDO('mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'] . ';charset=utf8', $dbConfig['login'], $dbConfig['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        $this->_path = $config['locator']['path'];
        $this->_url = $config['locator']['url'];
        $this->_postsManager = new PostsManager($this->_db);
        $this->_commentsManager = new CommentsManager($this->_db);
        $this->_usersManager = new UsersManager($this->_db);

        $this->_lastComments = $this->_commentsManager->getLast();
        $this->_listPostTitles = $this->_postsManager->getListTitles();
    }
}
