<?php
require 'vendor/autoload.php';

$text = 'aku mau makan aku mau makan aku mau makan aku';

// Test MyMemory API with langpair=id|jv
$response = @file_get_contents('https://api.mymemory.translated.net/get?q=' . urlencode($text) . '&langpair=id|jv');
$data = json_decode($response, true);

echo "MyMemory Response (id|jv):\n";
print_r($data);
