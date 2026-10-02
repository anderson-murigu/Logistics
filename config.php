<?php
declare(strict_types=1);

const SITE_NAME = 'Zenara Group';
const SITE_EMAIL = 'hello@zenaragroup.co.ke';
const SITE_PHONE = '+254 700 000 000';

const DB_HOST = 'localhost';
const DB_NAME = 'zenaraDB-353036353ef3';
const DB_USER = 'sa-71b8';
const DB_PASS = 'MAnu0077@21@!';

function database(): ?PDO
{
    static $connection = null;

    if ($connection instanceof PDO) {
        return $connection;
    }

    try {
        $connection = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        return $connection;
    } catch (PDOException $exception) {
        error_log('Zenara database connection failed: ' . $exception->getMessage());
        return null;
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}