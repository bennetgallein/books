<?php

use Controllers\Panel;
use Tracy\Debugger;

require("vendor/autoload.php");

session_start();

define("APP_URL", "panel_template");

Debugger::enable();
$p = new Panel();