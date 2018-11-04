<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 04.11.18
 * Time: 15:18
 */

namespace Module\RechnungsModule\Controllers;


use Angle\Engine\Template\Engine;
use Controllers\Panel;
use PDO;

class Invoices {

    public static function list(Engine $engine) {

        $data = Panel::getDatabase()->fetch_all("invoices", PDO::FETCH_ASSOC);

        $invoices = array();

        foreach ($data as $invoice) {

            $customer_name = Panel::getDatabase()->fetch_single_row("customers", "id", $invoice['customer']);
            $customer_name = $customer_name->first_name . " " . $customer_name->last_name;

            $invoices[] = array("id" => $invoice['id'],
                "invoice_id" => $invoice['invoice_id'],
                "customer" => $customer_name,
                "product" => $invoice['product'],
                "netto" => $invoice['netto'],
                "total" => $invoice['total'] . "€",
                "_date" => $invoice['_date'],
                "complete" => $invoice['complete'] ? "Ja" : "Nein"
            );
        }

        $engine->render("_views/invoices.php", array(
            "data" => $invoices
        ));
    }
}