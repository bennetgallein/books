<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 14.11.18
 * Time: 21:19
 */

namespace Module\BaseModule\Controllers;


use Angle\Engine\Template\Engine;
use Controllers\Panel;
use Module\BaseModule\Objects\User;

class Login {

    public static function view(Engine $engine) {
        $engine->render("_views/login.php", array());
    }

    public static function work() {
        $email = isset($_POST['email']) ? strip_tags($_POST['email']) : false;
        $password = isset($_POST['password']) ? strip_tags($_POST['password']) : false;

        if (!($email && $password)) {
            die("Fill in all parameters");
        }

        if (!Panel::getDatabase()->check_exist("users", array("email" => $email))) {
            die("Email not found!");
        }

        $user = Panel::getDatabase()->fetch_single_row("users", "email", $email);

        if (password_verify($password, $user->password)) {
            $user = new User($user->id, $user->uname, $user->email);
            $_SESSION['books'] = serialize($user);
            header("Location: " . APP_URL);
        }
    }
}