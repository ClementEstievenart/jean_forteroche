<?php
class Helper {
    private $_path;
    private $_getVar;
    private $_postVar;
    private $_config;
    private $_routerConfig;

    public function __construct($config) {
        session_start();
        spl_autoload_register('Helper::loadClass');

        $this->_config = $config;
        $this->_path = $this->_config['locator']['path'];
        $this->_getVar = $this->getGetValues();
        $this->_postVar = $this->getPostValues();

        require($this->_path . '/router/routerConfig.php');
        $this->_routerConfig = $routerConfig;
    }

    public function loadClass($class) {
        if (file_exists('model/' . $class . '.php')){
            include('model/' . $class . '.php');
        } elseif (file_exists('controller/' . $class . '.php')) {
            include('controller/' . $class . '.php');
        } else {
            throw new exception('class ' . $class . ' no found');
        }
    }

    private function getGetValues() {
        $getVar = [];
        foreach ($_GET as $key => $value) {
            $getVar[htmlspecialchars($key)] = htmlspecialchars($value);
        }

        return $getVar;
    }

    private function getPostValues() {
        $postVar = [];
        foreach ($_POST as $key => $value) {
            $postVar[htmlspecialchars($key)] = htmlspecialchars($value);
        }

        return $postVar;
    }

    public function routing() {
        if (!isset($this->_getVar['action'])) {
            $controler = new Frontend($this->_config);
            $controler->homePage();
            return;
        }

        foreach ($this->_routerConfig as $ctrl => $actions) {
            foreach ($actions as $action => $actionParameters) {
                if($this->_getVar['action'] === $action) {

                    $controler = new $ctrl($this->_config);
                    $parameters = [];

                    if(isset($actionParameters['getKeys'])){
                        foreach ($actionParameters['getKeys'] as $getKeys) {
                            if(isset($this->_getVar[$getKeys])) {
                                $parameters[] = $this->_getVar[$getKeys];
                            } else {
                                throw new exception($getKeys . ' doesn\'t exist for the action : ' . $action);
                            }
                        }
                    }

                    if(isset($actionParameters['postKeys'])) {
                        foreach ($actionParameters['postKeys'] as $postKeys) {
                            if (isset($this->_postVar[$postKeys])) {
                                $parameters[] = $this->_postVar[$postKeys];
                            } else {
                                throw new exception($postKeys . ' doesn\'t exist for the action : ' . $action);
                            }
                        }
                    }

                    $controler->$actionParameters['method'](...$parameters);
                    return;
                }
            }
        }
        throw new exception('$_GET["action"] is unknown :' . $this->_getVar['action']);
    }

    public function error() {
        $frontent = new Frontend(($this->_config));
        $frontent->error();
    }
}
