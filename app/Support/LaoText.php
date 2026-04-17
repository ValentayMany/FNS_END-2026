<?php

namespace App\Support;

/**
 * Helpers for Lao script stored as UTF-8.
 *
 * Some keyboards store ລ້ຽງ as ລ + ຽ + tone + ງ; shapers then show Mai Tho on U+25CC.
 * Canonical syllable order here: consonant (U+0E81–U+0EAF) + tone (U+0EC8–U+0ECB) + ຽ (U+0EBD) + rest.
 */
final class LaoText
{
    public static function normalize(?string $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        $value = trim($value);
        if (extension_loaded('intl')) {
            $nfc = \Normalizer::normalize($value, \Normalizer::FORM_C);
            if ($nfc !== false) {
                $value = $nfc;
            }
        }

        return self::fixSemivowelNyToneOrder($value);
    }

    /**
     * After a leading Lao consonant, move Mai Ek / Tho / Ti / Catawa before ຽ (semivowel NYO).
     */
    public static function fixSemivowelNyToneOrder(string $s): string
    {
        $ny = mb_chr(0x0EBD, 'UTF-8');
        /** ລຽ້ — tone immediately after ຽ */
        $pNyTone = '/([\x{0E81}-\x{0EAF}])\x{0EBD}([\x{0EC8}-\x{0ECB}])/u';
        /** ລຽງ້ — tone after coda (e.g. ງ); move tone before ຽ */
        $pNyCodaTone = '/([\x{0E81}-\x{0EAF}])\x{0EBD}([\x{0E81}-\x{0EAF}])([\x{0EC8}-\x{0ECB}])/u';

        do {
            $prev = $s;
            $s = preg_replace($pNyCodaTone, '${1}${3}'.$ny.'${2}', $s) ?? $s;
            $s = preg_replace($pNyTone, '${1}${2}'.$ny, $s) ?? $s;
            if ($s === $prev) {
                return $s;
            }
        } while (true);
    }
}
