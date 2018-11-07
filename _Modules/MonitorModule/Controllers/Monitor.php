<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 06.11.18
 * Time: 17:30
 */

namespace Module\MonitorModule\Controllers;


use Angle\Engine\Template\Engine;

class Monitor {

    public static function listAll(Engine $engine) {
        $engine->render("_views/monitor_list.php", array(

        ));
    }
}