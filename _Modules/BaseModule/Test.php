<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 02.11.18
 * Time: 09:53
 */

namespace Module\BaseModule;


use Angle\Engine\Template\Engine;
use Controllers\Panel;

class Test {

    public static function main(Engine $engine) {

        $customers = Panel::getDatabase()->custom_query("SELECT * FROM customers")->rowCount();

        $umsatz = "[0, 5, 8, 6, 3, 10, 8, 1, 1, 1, 1, 1]";

        $engine->render("_views/index.php", array(
            "test" => "Hello World",
            "customers" => $customers,
            "umsatz" => $umsatz
        ));
    }

}