<?php

namespace App\Libraries;

class AuthLoginsLastIdLibrari
{
    protected static ?int $lastId = null;

    public static function setId(int $id): void
    {
        self::$lastId = $id;
    }

    public static function getId(): ?int
    {
        return self::$lastId;
    }

    public static function reset(): void
    {
        self::$lastId = null;
    }
}
