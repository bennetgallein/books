<?php

use Controllers\Panel;
use Tracy\Debugger;

require("vendor/autoload.php");

session_start();

Debugger::enable();
$p = new Panel();