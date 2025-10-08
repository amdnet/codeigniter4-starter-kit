<?php

namespace App\Libraries;

class AuthRememberLastIdLibrari
{
    private static ?int $id = null;

    public static function setId(int $id): void
    {
        self::$id = $id;
    }

    public static function getId(): ?int
    {
        $id = self::$id;
        self::$id = null; // Langsung reset setelah diambil
        return $id;
    }
}
