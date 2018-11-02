<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 02.11.18
 * Time: 09:47
 */

namespace Module\BaseModule;

use Module\Module;
use Objects\NavPoint;
use Objects\Permission;
use Safe\Exceptions\JsonException;
use Safe\Exceptions\PcreException;

class BaseModule extends Module {
    private $name = "BaseModule";
    private $version = "0.0.1";
    private $author = "Bennet Gallein <me@bennetgallein.de>";

    /**
     * UserModule constructor.
     * @throws \Safe\Exceptions\FilesystemException
     * @throws JsonException
     * @throws PcreException
     */
    public function __construct() {
        parent::__construct($this->name, $this->version, $this->author);
        $this->routes();
        $this->sidebar();
        $this->permissions();
    }

    public function routes() {
        $data = array(
            array("/", "BaseModule\Test::main", ["engine" => $this->engine], "GET"),
        );
        $this->_registerRoutes($data);
    }

    /**
     * @throws JsonException
     */
    public function sidebar() {
        $data = array(
            new NavPoint($this->name, "Test Point", "", "module.user.test")
        );
        $this->_registerNavbar($data);
    }

    /**
     * @throws PcreException
     */
    public function permissions() {
        $data = array(
            new Permission($this->name, "module.user.test")
        );
        $this->_registerPermissions($data);
    }
}