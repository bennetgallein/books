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
        $invoices_c = Panel::getDatabase()->custom_query("SELECT * FROM invoices")->rowCount();

        $invoices = Panel::getDatabase()->custom_query("SELECT * FROM invoices WHERE complete=1");

        $umsatz = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        foreach ($invoices as $in) {
            $posInArr = date('n', strtotime($in->_date)) - 1;
            $umsatz[$posInArr] += $in->netto;
        }

        $umsatz_netto_total = 0;
        $umsatz_brutto_total = 0;

        foreach ($umsatz as $um) {
            $umsatz_netto_total += $um;
            $umsatz_brutto_total += $um * 1.19;
            $umsatz_brutto[] = ($um * 0.19);
            $umsatz_total[] = ($um * 1.19);
        }
        $umsatz = json_encode($umsatz);
        $umsatz_brutto = json_encode($umsatz_brutto);
        $umsatz_total = json_encode($umsatz_total);

        $engine->render("_views/index.php", array(
            "test" => "Hello World",
            "customers" => $customers,
            "invoices" => $invoices_c,
            "umsatz_netto" => $umsatz,
            "umsatz_brutto" => $umsatz_brutto,
            "umsatz_total" => $umsatz_total,
            "umsatz_netto_total" => number_format($umsatz_netto_total, "2", ",", " "),
            "umsatz_brutto_total" => number_format($umsatz_brutto_total, "2",",", "")
        ));
    }

}