<?php
declare(strict_types=1);

function db(): PDO
{
    static $connection = null;

    if ($connection instanceof PDO) {
        return $connection;
    }

    $host = 'localhost';
    $port = '3306';
    $dbName = 'mahasiswa';
    $username = 'root';
    $password = '';

    $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4";

    $connection = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $connection;
}

function dbQuery(string $query, array $params = []): array
{
    $statement = db()->prepare($query);
    $statement->execute($params);

    return $statement->fetchAll();
}

function dbOne(string $query, array $params = []): ?array
{
    $statement = db()->prepare($query);
    $statement->execute($params);
    $result = $statement->fetch();

    return $result === false ? null : $result;
}

function dbExecute(string $query, array $params = []): bool
{
    $statement = db()->prepare($query);

    return $statement->execute($params);
}
