<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 05.11.18
 * Time: 18:38
 */

namespace Module\KundenModule\Controllers;


use Angle\Engine\Template\Engine;

class Pricing {

    public static function listAll(Engine $engine) {
        $engine->render("_views/pricing-table.php");
    }

}