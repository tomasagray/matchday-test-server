<?php

namespace Matchday\TestServer;

class UUID
{
    public static function create(): string
    {
        mt_srand((double)microtime() * 10000);
        $charId = strtoupper(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);
        return substr($charId, 0, 8) . $hyphen
            . substr($charId, 8, 4) . $hyphen
            . substr($charId, 12, 4) . $hyphen
            . substr($charId, 16, 4) . $hyphen
            . substr($charId, 20, 12);
    }
}
