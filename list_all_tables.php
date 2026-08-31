<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
$dbName = config('database.connections.mysql.database');
$keyName = "Tables_in_" . $dbName;

echo "All tables in database '{$dbName}':\n";
foreach ($tables as $t) {
    echo " - " . $t->$keyName . "\n";
}
