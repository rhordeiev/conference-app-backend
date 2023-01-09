<?php

declare(strict_types=1);

namespace Application\Config;

class Database
{
    public function connect(
        string $driver,
        string $host,
        string $dbname,
        string $username,
        string $password
    ): ?\PDO {
        try {
            $database = new \PDO(
                "{$driver}:host={$host};dbname={$dbname}",
                $username,
                $password
            );
            return $database;
        } catch (\PDOException $e) {
            header('HTTP/1.1 500 Problem with database connection');
            http_response_code(500);
            $response = [
                'code' => 500,
                'message' => 'Problem with database connection'
            ];
            echo json_encode($response);
            return null;
        }
    }
}