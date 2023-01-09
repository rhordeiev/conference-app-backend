<?php

declare(strict_types=1);

namespace Application;

use Application\Config\Database;
use Application\Controllers\ConferenceControllerMethodNames;
use Application\Controllers\CountryControllerMethodNames;
use Application\Routers\ConferenceRouter;
use Application\Routers\CountryRouter;

class Application
{
    private ConferenceRouter $conferenceRouter;
    private CountryRouter $countryRouter;
    private static \PDO $database;

    public function __construct()
    {
        $this->conferenceRouter = new ConferenceRouter();
        $this->countryRouter = new CountryRouter();
        $this->conferenceRouter->addRoute(
            'POST',
            'new',
            ConferenceControllerMethodNames::createConference->value
        );
        $this->conferenceRouter->addRoute(
            'GET',
            'list',
            ConferenceControllerMethodNames::getConferences->value
        );
        $this->conferenceRouter->addRoute(
            'DELETE',
            ':id',
            ConferenceControllerMethodNames::deleteConference->value
        );
        $this->conferenceRouter->addRoute(
            'PUT',
            ':id',
            ConferenceControllerMethodNames::editConference->value
        );
        $this->countryRouter->addRoute(
            'GET',
            'list',
            CountryControllerMethodNames::getCountries->value
        );
        static::$database = (new Database())->connect(
            'mysql',
            'us-cdbr-east-06.cleardb.net',
            'heroku_d4462a2625af7d9',
            'bec6a4e584bc09',
            '928e2814'
        );
    }

    public static function getDatabase(): \PDO
    {
        return static::$database;
    }

    public function run(
        string $path,
        string $method,
        array $conferenceData = []
    ): array {
        $mainPath = explode('/', $path)[1];
        $response = match ($mainPath) {
            'conference' => $this->conferenceRouter->resolve(
                $path,
                $method,
                $conferenceData
            ),
            'country' => $this->countryRouter->resolve($path, $method),
            default => ['code' => 404, 'message' => 'Route not found'],
        };
        return $response;
    }
}