<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 23.10.18
 * Time: 22:56
 */

namespace Controllers;


use Angle\Engine\RouterEngine\Collection;
use Angle\Engine\RouterEngine\Router;
use Angle\Engine\Template\Engine;
use Module\BaseModule\BaseModule;
use Module\UserModule\UserModule;
use Safe\Exceptions\FilesystemException;
use Safe\Exceptions\JsonException;

class Panel {

    private $engine, $collection, $database, $navmanager, $permissionmanager;

    private static $instance;

    /**
     * Panel constructor.
     */
    public function __construct() {
        $this->engine = new Engine("_views");
        $this->collection = new Collection();

        self::setInstance($this);

        $this->initBaseRoutes();

        // NavigationManager
        new DataBase("localhost", "powerhost", "powerhost", "powerhost");
        new PermissionManager();
        new NavigationManager();

        // initiate all Modules
        new BaseModule();


        $this->match();
    }

    private function initBaseRoutes() {
        $engine = $this->engine;
    }

    private function match() {
        $router = new Router($this->collection);
        $route = $router->matchCurrentRequest();
        if (!$route) {
            $this->engine->render("_views/404.tmp");
        }
    }

    /**
     * @return Engine
     */
    public static function getEngine() {
        return self::$instance->engine;
    }

    /**
     * @return Collection
     */
    public static function getCollection() {
        return self::$instance->collection;
    }

    /**
     * @return DataBase
     */
    public static function getDatabase() {
        return self::$instance->database;
    }

    /**
     * @return NavigationManager
     */
    public static function getNavManager() {
        return self::$instance->navmanager;
    }

    /**
     * @param $newdatabase
     */
    public static function setDatabase($newdatabase) {
        self::$instance->database = $newdatabase;
    }

    /**
     * @param $newmanager
     */
    public static function setNavManager($newmanager) {
        self::$instance->navmanager = $newmanager;
    }

    /**
     * @param $newpermission
     */
    public static function setPermissionManager($newpermission) {
        self::$instance->permissionmanager = $newpermission;
    }

    /**
     * @return PermissionManager
     */
    public static function getPermissionManager() {
        return self::$instance->permissionmanager;
    }

    /**
     * @param $instance Panel
     */
    public static function setInstance($instance) {
        self::$instance = $instance;
    }

    /**
     * @return Panel
     */
    public static function getInstance() {
        return self::$instance;
    }

}