<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 02.11.18
 * Time: 09:45
 */

namespace Module;

use Angle\Engine\RouterEngine\Route;
use Controllers\Panel;
use Objects\NavPoint;
use Objects\Permission;
use Safe\Exceptions\FilesystemException;
use Safe\Exceptions\JsonException;
use function Safe\file_get_contents;
use function Safe\json_decode;

abstract class Module {
    public $engine, $collection;
    /** @var string Name of the Module */
    private $name;
    /** @var string Version of the Module */
    private $version;
    /** @var string Author of the Module */
    private $author;
    private $routes, $config;

    /**
     * Module constructor.
     * @param $name
     * @param $version
     * @param $author
     * @throws FilesystemException
     */
    public function __construct($name, $version, $author) {
        $this->name = $name;
        $this->version = $version;
        $this->author = $author;
        $this->engine = Panel::getEngine();
        $this->collection = Panel::getCollection();
        $this->config = file_get_contents(dirname(__FILE__) . "/" . $this->name . "/module.json");
    }

    public function _registerRoutes($routes) {
        $this->routes = $routes;
        $this->register();
    }

    private function register() {
        foreach ($this->routes as $route) {
            $this->collection->attachRoute(new Route($route[0], array("_controller" => "Module\\" . $route[1], "parameters" => $route[2], "methods" => $route[3])));
        }
    }

    /**
     * @param $points NavPoint[]
     * @throws JsonException
     */
    public function _registerNavbar($points) {
        $config = json_decode($this->config);
        if (isset($config->navs)) {
            if (!empty((array)$config->navs)) {
                foreach ($config->navs as $key => $nav) {
                    if (isset($nav->$key->orderid)) {
                        Panel::getNavManager()->pushPoint(new NavPoint($this->name, $nav->$key->text, $nav->$key->url, $nav->$key->permission), $nav->$key->orderid);
                    } else {
                        Panel::getNavManager()->addPoint(new NavPoint($this->name, $nav->$key->text, $nav->$key->url, $nav->$key->permission));
                    }
                }
            }
        }
        foreach ($points as $point) {
            if (!Panel::getNavManager()->hasPoint($point->getSaveName())) {
                Panel::getNavManager()->addPoint($point);
            }
        }
    }

    /**
     * @param $perms Permission[]
     * @throws \Safe\Exceptions\PcreException
     */
    public function _registerPermissions($perms) {
        foreach ($perms as $perm) {
            Panel::getPermissionManager()->addPermission($perm);
        }
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion(): string {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getAuthor(): string {
        return $this->author;
    }
}