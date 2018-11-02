<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 28.10.18
 * Time: 16:11
 */

namespace Controllers;


use Objects\Permission;

class PermissionManager {

    private $permissions = array();

    private $hasPermission = array();

    public function __construct() {
        Panel::setPermissionManager($this);
        $this->hasPermission['UserModule'][] = "module.*";
    }

    /**
     * @param $perm Permission
     */
    public function addPermission($perm) {
        $this->permissions[$perm->getModule()][] = $perm->getPermission();
    }

    /**
     * @param $perm Permission
     * @return bool if the user has the permission
     */
    public function hasPermission($perm) {
        if (isset($this->hasPermission[$perm->getModule()])) {
            $permission = $perm->getPermission();
            foreach ($this->hasPermission[$perm->getModule()] as $hasPerm) {
                $hasPerm = str_replace(".", "\.", $hasPerm);
                $hasPerm = str_replace("*", "(.*)", $hasPerm);
                preg_match("/" . $hasPerm . "/", $permission, $matches);
                if (!$matches) {
                    return false;
                }
                return true;
            }
        }
        return false;
    }

    /**
     * @param $perm Permission
     */
    public function addHasPermission($perm) {
        $this->hasPermission[$perm->GetModule()] = $perm->getPermission();
    }

}