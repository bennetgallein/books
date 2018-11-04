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
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use PDO;

class Invoices {

    /**
     * @param Engine $engine
     */
    public static function list(Engine $engine) {

        $data = Panel::getDatabase()->fetch_all("invoices", PDO::FETCH_ASSOC);

        $invoices = array();

        putenv("GOOGLE_APPLICATION_CREDENTIALS=credentials.json");
        $client = new Google_Client();
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->useApplicationDefaultCredentials();

        $service = new Google_Service_Drive($client);

        $results = $service->files->listFiles();

        foreach ($data as $invoice) {

            $customer_name = Panel::getDatabase()->fetch_single_row("customers", "id", $invoice['customer']);
            $customer_name = $customer_name->first_name . " " . $customer_name->last_name;

            $link = "#";
            /** @var Google_Service_Drive_DriveFile $file */
            foreach ($results->getFiles() as $file) {
                if ($file->getName() == $invoice['invoice_id'] . ".pdf") {
                    $link = "https://drive.google.com/file/d/" . $file->getId() . "/preview";
                }
            }
            $invoices[] = array("id" => $invoice['id'],
                "invoice_id" => $invoice['invoice_id'],
                "customer" => $customer_name,
                "product" => $invoice['product'],
                "netto" => $invoice['netto'],
                "total" => $invoice['total'] . "€",
                "_date" => $invoice['_date'],
                "complete" => $invoice['complete'] ? "Ja" : "Nein",
                "link" => $link
            );
        }
        $engine->render("_views/invoices.php", array(
            "data" => $invoices
        ));
    }

    public static function newGet(Engine $engine) {
        $engine->render("_views/invoice_new.php", array());
    }

    public static function newPost() {

        $description = $_POST['desc'];
        $customer = $_POST['customer_id'];
        $date = $_POST['date'];
        $netto = $_POST['netto'];

        $odler = Panel::getDatabase()->custom_query("SELECT * FROM invoices WHERE DATE(`_date`) > DATE_SUB(CURDATE(), INTERVAL 1 DAY )");
        $id = $odler->rowCount() + 1;


        $ar = array_reverse(explode(".", $date));

        $invoice_id = "R-" . $ar[0] . $ar[1] . $ar[2] . $id;

        Panel::getDatabase()->insert("invoices", array(
            "invoice_id" => $invoice_id,
            "customer" => $customer,
            "product" => $description,
            "netto" => $netto,
            "total" => number_format($netto * 1.19, 2, ",", " "),
        ));

        $customer = Panel::getDatabase()->fetch_single_row("customers", "id", $customer);

        putenv("GOOGLE_APPLICATION_CREDENTIALS=credentials.json");
        $client = new Google_Client();
        $client->addScope(Google_Service_Drive::DRIVE);
        $client->useApplicationDefaultCredentials();

        $service = new Google_Service_Drive($client);

        $fileMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $invoice_id,
            'mimeType' => 'application/vnd.google-apps.document',
            'parents' => array("1ZrD4NXrLKBa0fbTqBSNetVZsleu1EF1N")
        ));
        $content = Panel::getEngine()->compile("_views/invoice_template.html", array(
            "gender" => $customer->gender == 0 ? "Herr" : "Frau",
            "first_name" => $customer->first_name,
            "last_name" => $customer->last_name,
            "street" => $customer->street,
            "zip_code" => $customer->zip_code,
            "city" => $customer->city,
            "date" => $date,
            "invoice_id" => $invoice_id,
            "netto" => $netto,
            "mwst" => number_format($netto * 0.19, 2, ",", " "),
            "total" => number_format($netto * 1.19, 2, ",", " "),
            "description" => $description
        ));

        $file = $service->files->create($fileMetadata, array(
            'data' => $content,
            "mimeType" => "text/html",
            "uploadType" => 'multipart',
            'fields' => 'id'
        ));
    }
}