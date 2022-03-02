<?php
require __DIR__ . '/../../vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
// use Mike42\Escpos\CapabilityProfile;


// $profile = CapabilityProfile::load("default");
$connector = new RawbtPrintConnector();
$printer = new Printer($connector);

$printer->pulse();
$printer->cut();

$printer->close();