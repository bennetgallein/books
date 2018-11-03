<?php

use Controllers\Panel;
use Tracy\Debugger;

require("vendor/autoload.php");

session_start();

define("APP_URL", "/books/");

Debugger::enable();
$p = new Panel();