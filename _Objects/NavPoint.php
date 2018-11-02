<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 24.10.18
 * Time: 12:55
 */

namespace Objects;

use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\json_decode;
use function Safe\json_encode;

class NavPoint {

    private $module_name;

    private $save_name;

    private $orderid;

    private $text;

    private $url;

    private $permission;

    public function __construct($module_name, $text, $url, $permission) {
        $this->module_name = $module_name;
        $this->save_name = str_replace(" ", "_", $text);
        $this->text = $text;
        $this->url = substr($url, 0, strlen(APP_URL)) == APP_URL ? $url : APP_URL . $url;
        $this->permission = $permission;
    }

    /**
     * @return int
     */
    public function getOrderid() {
        return $this->orderid;
    }

    /**
     * @param int $orderid
     */
    public function setOrderid($orderid) {
        $this->orderid = $orderid;
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text) {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getPermission() {
        return $this->permission;
    }

    /**
     * @param string $permission
     */
    public function setPermission($permission) {
        $this->permission = $permission;
    }

    /**
     * @return string
     */
    public function getSaveName() {
        return $this->save_name;
    }

    /**
     * @throws \Safe\Exceptions\FilesystemException
     * @throws \Safe\Exceptions\JsonException
     */
    public function save() {
        $data = array($this->save_name => array("orderid" => $this->orderid, "text" => $this->text, "url" => $this->url, "permission" => $this->permission));
        $save_name = $this->save_name;
        $config = json_decode(file_get_contents(dirname(__FILE__) . "/../_Modules/" . $this->module_name . "/module.json"));
        $navs = $config->navs;
        $navs->$save_name = $data;
        file_put_contents(dirname(__FILE__) . "/../_Modules/" . $this->module_name . "/module.json", json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}