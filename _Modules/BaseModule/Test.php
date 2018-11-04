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

        $umsatz = array(100, 5, 8, 6, 3, 10, 8, 1, 2, 3, 4, 7);

        $umsatz_netto_total = 0;
        $umsatz_brutto_total = 0;

        foreach ($umsatz as $um) {
            $umsatz_netto_total += $um;
            $umsatz_brutto_total += $um * 1.19;
            $umsatz_brutto[] = -($um * 1.19);
        }
        $umsatz = json_encode($umsatz);
        $umsatz_brutto = json_encode($umsatz_brutto);

        $engine->render("_views/index.php", array(
            "test" => "Hello World",
            "customers" => $customers,
            "umsatz_netto" => $umsatz,
            "umsatz_brutto" => $umsatz_brutto,
            "umsatz_netto_total" => $umsatz_netto_total,
            "umsatz_brutto_total" => $umsatz_brutto_total
        ));
    }

}