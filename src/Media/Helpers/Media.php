<?php

namespace Escape\Argon\Media\Helpers;

class Media
{

    /**
     * Convert number of bytes largest unit bytes will fit into.
     *
     * It is easier to read 1kB than 1024 bytes and 1MB than 1048576 bytes. Converts
     * number of bytes to human readable number by taking the number of that unit
     * that the bytes will go into it. Supports TB value.
     *
     * Please note that integers in PHP are limited to 32 bits, unless they are on
     * 64 bit architecture, then they have 64 bit size. If you need to place the
     * larger size then what PHP integer type will hold, then use a string. It will
     * be converted to a double, which should always have 64 bit length.
     *
     * Technically the correct unit names for powers of 1024 are KiB, MiB etc.
     *
     * @param int|string $bytes    Number of bytes. Note max integer size for integers.
     * @param int        $decimals Optional. Precision of number of decimal places. Default 0.
     * @return bool|string False on failure. Number string on success.
     */
    public static function sizeFormat($bytes, $decimals = 0)
    {
        $quant = [
            // ========================= Origin ====
            'TB' => 1099511627776,  // pow( 1024, 4)
            'GB' => 1073741824,     // pow( 1024, 3)
            'MB' => 1048576,        // pow( 1024, 2)
            'kB' => 1024,           // pow( 1024, 1)
            'B ' => 1,              // pow( 1024, 0)
        ];

        foreach ($quant as $unit => $mag)
        {
            if (doubleval($bytes) >= $mag)
            {
                return number_format(($bytes / $mag), abs(intval($decimals))) . ' ' . $unit;
            }
        }

        return false;
    }

    public static function isImage($mimeType, array $imageMimeTypes=[])
    {
        $defaultImageMimeTypes = [
            "image/jpg",
            "image/jpeg",
            "image/png",
            "image/gif"
        ];

        $mimeTypes = array_merge($defaultImageMimeTypes, $imageMimeTypes);

        return in_array($mimeType, $mimeTypes);
    }

}