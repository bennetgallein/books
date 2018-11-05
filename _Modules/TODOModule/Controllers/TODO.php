<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 05.11.18
 * Time: 21:08
 */

namespace Module\TODOModule\Controllers;


use Angle\Engine\Template\Engine;
use Controllers\Panel;
use PDO;

class TODO {

    public static function main(Engine $engine) {

        $lists = Panel::getDatabase()->fetch_all("todo_lists", PDO::FETCH_ASSOC);

        $engine->render("_views/todo_overview.php", array(
            "lists" => $lists
        ));
    }

    public static function specific(Engine $engine, int $id) {

        $elements = Panel::getDatabase()->custom_query("SELECT * FROM todo_points WHERE done=0 AND listid=?", array("listid" => $id), PDO::FETCH_ASSOC);
        $list = Panel::getDatabase()->fetch_single_row("todo_lists", "id", $id, 2);

        $engine->render("_views/todo_specific.php", array(
           "elements" => $elements,
            "list" => $list
        ));
    }

    public static function remove(int $id) {
        Panel::getDatabase()->update("todo_points", array("done" => 1), "id", $id);
        die(json_encode(["success" => true]));
    }

    public static function createList() {

        $title = $_POST['title'];
        $description = $_POST['description'];

        Panel::getDatabase()->insert("todo_lists", array("title" => $title, "description" => $description));
    }

    public static function createTask(int $id) {

        $description = $_POST['description'];

        Panel::getDatabase()->insert("todo_points", array("listid" => $id, "text" => $description));
    }
}