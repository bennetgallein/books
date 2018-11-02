<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 28.10.18
 * Time: 16:12
 */

namespace Objects;


class Permission {

    private $module;
    private $permission;

    public function __construct($module, $permission) {
        $this->module = $module;
        $this->permission = $permission;
    }

    public function getModule() {
        return $this->module;
    }

    public function getPermission() {
        return $this->permission;
    }
}