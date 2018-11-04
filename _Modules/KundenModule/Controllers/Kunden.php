<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 03.11.18
 * Time: 16:03
 */

namespace Module\KundenModule\Controllers;

use Angle\Engine\Template\Engine;
use Controllers\Panel;
use PDO;

class Kunden {

    public static function getList(Engine $engine) {
        $data = Panel::getDatabase()->fetch_all("customers", PDO::FETCH_ASSOC);

        $customers = array();

        foreach ($data as $customer) {
            $customers[] = $customer;
        }

        $engine->render("_views/customers.php", array(
            "data" => $customers
        ));
    }

    public static function add(Engine $engine) {
        $engine->render("_views/form-wizard.php", array());
    }

    public static function addNew() {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $telefon = $_POST["telefon"];
        $country = $_POST["country"];
        $birthday = $_POST["birthday"];
        $street = $_POST["street"];
        $zip_code = $_POST["zip_code"];
        $city = $_POST["city"];
        $company = $_POST["company"];

        Panel::getDatabase()->insert("customers", array(
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "telefon" => $telefon,
            "country" => $country,
            "birthday" => $birthday,
            "street" => $street,
            "zip_code" => $zip_code,
            "city" => $city,
            "company" => $company
        ));
    }
}