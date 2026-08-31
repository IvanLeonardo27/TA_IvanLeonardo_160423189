<?php
require 'vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

try {
    $tr = new GoogleTranslate('jw', 'id', [
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        ]
    ]);
    $res = $tr->translate('aku mau makan aku mau makan aku mau makan aku');
    echo "GoogleTranslate UserAgent SUCCESS: " . $res . "\n";
} catch (\Throwable $e) {
    echo "GoogleTranslate UserAgent ERROR: " . $e->getMessage() . "\n";
}

// Test alternative Google Translate endpoint (translate.googleapis.com)
try {
    $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=id&tl=jw&dt=t&q=" . urlencode('aku mau makan aku mau makan aku mau makan aku');
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);
    if ($response) {
        $json = json_decode($response, true);
        $translated = '';
        if (isset($json[0])) {
            foreach ($json[0] as $item) {
                if (isset($item[0])) {
                    $translated .= $item[0];
                }
            }
        }
        echo "Googleapis Direct SUCCESS: " . $translated . "\n";
    } else {
        echo "Googleapis Direct FAILED\n";
    }
} catch (\Throwable $e) {
    echo "Googleapis Direct ERROR: " . $e->getMessage() . "\n";
}
