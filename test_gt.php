<?php
require 'vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

try {
    $tr = new GoogleTranslate();
    $tr->setSource('id');
    $tr->setTarget('jw');
    $res = $tr->translate('aku mau makan aku mau makan aku mau makan aku');
    echo "SUCCESS: " . $res . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . get_class($e) . " - " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
