<?php

declare(strict_types=1);

namespace Application\Models;

use Application\Application;

class Country
{
    public static function getAll(): array
    {
        $database = Application::getDatabase();
        $countryQuery = <<<QUERY
                SELECT * FROM `country`
                QUERY;
        try {
            $data = $database->query($countryQuery);
            $countries = $data->fetchAll();
            return [
                'code' => 200,
                'message' => 'Countries successfully fetched',
                'data' => $countries
            ];
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                'code' => 500,
                'message' => 'Problem with fetching countries'
            ];
        }
    }
}