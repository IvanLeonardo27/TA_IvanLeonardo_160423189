<?php

namespace App\Services;

class JavaneseSyllableService
{
    public static array $consonantMap = [
        'ꦲ' => 'h', 'ꦤ' => 'n', 'ꦕ' => 'c', 'ꦫ' => 'r', 'ꦏ' => 'k',
        'ꦢ' => 'd', 'ꦠ' => 't', 'ꦱ' => 's', 'ꦮ' => 'w', 'ꦭ' => 'l',
        'ꦥ' => 'p', 'ꦝ' => 'dh', 'ꦗ' => 'j', 'ꦪ' => 'y', 'ꦚ' => 'ny',
        'ꦩ' => 'm', 'ꦒ' => 'g', 'ꦧ' => 'b', 'ꦛ' => 'th', 'ꦔ' => 'ng',
        // Murda
        'ꦟ' => 'n', 'ꦑ' => 'k', 'ꦡ' => 't', 'ꦯ' => 's', 'ꦦ' => 'p', 'ꦓ' => 'g', 'ꦨ' => 'b',
        // Swara
        'ꦄ' => 'a', 'ꦅ' => 'i', 'ꦈ' => 'u', 'ꦌ' => 'e', 'ꦎ' => 'o', 'ꦉ' => 're', 'ꦊ' => 'le',
        // Angka Jawa
        '꧐' => '0', '꧑' => '1', '꧒' => '2', '꧓' => '3', '꧔' => '4',
        '꧕' => '5', '꧖' => '6', '꧗' => '7', '꧘' => '8', '꧙' => '9',
    ];

    /**
     * Memecah teks Aksara Jawa menjadi array karakter/kluster suku aksara.
     */
    public static function splitClusters(string $scriptText): array
    {
        $pattern = '/(?:[\x{A984}-\x{A9B2}\x{A9D0}-\x{A9D9}][\x{A9B3}]?(?:\x{A9C0}[\x{A984}-\x{A9B2}][\x{A9B3}]?)?[\x{A9BD}-\x{A9BF}]?[\x{A9B4}-\x{A9BC}]*[\x{A980}-\x{A983}]*(?:\x{A9C0})?|[\x{A9C1}-\x{A9CF}]|[^\x{A980}-\x{A9DF}\s]+|\s+)/u';
        preg_match_all($pattern, $scriptText, $matches);
        return array_values(array_filter($matches[0] ?? [], fn($c) => $c !== ''));
    }

    /**
     * Menghasilkan waosan Latin perkiraan dari satu kluster aksara Jawa.
     */
    public static function clusterToLatinApprox(string $cluster): string
    {
        $clusterTrimmed = trim($cluster);
        if ($clusterTrimmed === '') return '';

        // Tanda baca / angka
        $numbers = [
            '꧐' => '0', '꧑' => '1', '꧒' => '2', '꧓' => '3', '꧔' => '4',
            '꧕' => '5', '꧖' => '6', '꧗' => '7', '꧘' => '8', '꧙' => '9',
            '꧈' => ',', '꧉' => '.', '꧋' => '', '꧇' => ':'
        ];
        if (isset($numbers[$clusterTrimmed])) {
            return $numbers[$clusterTrimmed];
        }

        $base = '';
        $pasangan = '';
        $medial = '';
        $vowel = 'a';
        $final = '';
        $isDead = false;

        if (mb_substr($clusterTrimmed, -1) === '꧀') {
            $isDead = true;
            $clusterNoPangkon = mb_substr($clusterTrimmed, 0, -1);
        } else {
            $clusterNoPangkon = $clusterTrimmed;
        }

        $hasTaling = mb_strpos($clusterTrimmed, 'ꦺ') !== false;
        $hasTarung = mb_strpos($clusterTrimmed, 'ꦴ') !== false;
        $hasWulu = mb_strpos($clusterTrimmed, 'ꦶ') !== false || mb_strpos($clusterTrimmed, 'ꦷ') !== false;
        $hasSuku = mb_strpos($clusterTrimmed, 'ꦸ') !== false || mb_strpos($clusterTrimmed, 'ꦹ') !== false;
        $hasPepet = mb_strpos($clusterTrimmed, 'ꦼ') !== false;
        $hasDirgaMure = mb_strpos($clusterTrimmed, 'ꦻ') !== false;

        if ($hasDirgaMure && $hasTarung) {
            $vowel = 'au';
        } elseif ($hasTaling && $hasTarung) {
            $vowel = 'o';
        } elseif ($hasDirgaMure) {
            $vowel = 'ai';
        } elseif ($hasTaling) {
            $vowel = 'e';
        } elseif ($hasPepet) {
            $vowel = 'e';
        } elseif ($hasWulu) {
            $vowel = 'i';
        } elseif ($hasSuku) {
            $vowel = 'u';
        } elseif ($hasTarung) {
            $vowel = 'a';
        }

        // Medials: pengkal ꦾ (y), cakra ꦿ (r), cakra keret ꦽ (re)
        if (mb_strpos($clusterTrimmed, 'ꦾ') !== false) $medial = 'y';
        if (mb_strpos($clusterTrimmed, 'ꦿ') !== false) $medial = 'r';
        if (mb_strpos($clusterTrimmed, 'ꦽ') !== false) { $medial = 'r'; $vowel = 'e'; }

        // Finals: cecak ꦁ (ng), layar ꦂ (r), wignyan ꦃ (h)
        if (mb_strpos($clusterTrimmed, 'ꦁ') !== false) $final = 'ng';
        if (mb_strpos($clusterTrimmed, 'ꦂ') !== false) $final = 'r';
        if (mb_strpos($clusterTrimmed, 'ꦃ') !== false) $final = 'h';

        // Check pasangan (꧀ + consonant)
        if (preg_match('/꧀([\x{A984}-\x{A9B2}])/u', $clusterNoPangkon, $pMatches)) {
            $pasangan = self::$consonantMap[$pMatches[1]] ?? '';
        }

        // Base consonant
        if (preg_match('/^[\x{A9C0}]?([\x{A984}-\x{A9B2}])/u', $clusterTrimmed, $bMatches)) {
            $base = self::$consonantMap[$bMatches[1]] ?? '';
        }

        // Aksara Ha sering sebagai pembawa vokal (a, i, u, e, o)
        if ($base === 'h') {
            $base = '';
        }

        if ($pasangan !== '') {
            $res = ($base ? $base : '') . $pasangan . $medial . ($isDead ? '' : $vowel) . $final;
        } else {
            $res = $base . $medial . ($isDead ? '' : $vowel) . $final;
        }

        return $res;
    }

    /**
     * Memetakan seluruh kalimat Aksara Jawa menjadi pasangan [aksara, latin].
     */
    public static function alignSentence(?string $scriptText, ?string $latinText = null): array
    {
        if (empty($scriptText)) return [];

        $clusters = self::splitClusters($scriptText);
        $result = [];

        foreach ($clusters as $c) {
            if (trim($c) === '') {
                // Spasi
                $result[] = ['aksara' => ' ', 'latin' => ' '];
                continue;
            }

            $approx = self::clusterToLatinApprox($c);
            $result[] = [
                'aksara' => $c,
                'latin'  => $approx
            ];
        }

        return $result;
    }
}
