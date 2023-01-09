<?php

declare(strict_types=1);

namespace Application\Models;

use Application\Application;

class Conference
{
    private string $title;
    private \DateTime $date;
    private array $address;
    private string $country;

    public function __construct(array $conferenceData)
    {
        $this->title = $conferenceData['title'];
        $this->date = new \DateTime(
            $conferenceData['date'],
            new \DateTimeZone('Europe/Kyiv')
        );
        $isLatNull = $conferenceData['lat'] !== 'null'
            && $conferenceData['lat'];
        $this->address['lat'] = $isLatNull ? (float)$conferenceData['lat']
            : null;
        $isLngNull = $conferenceData['lng'] !== 'null'
            && $conferenceData['lat'];
        $this->address['lng'] = $isLngNull ? (float)$conferenceData['lng']
            : null;
        $this->country = $conferenceData['country'];
    }

    public function create(): array
    {
        $database = Application::getDatabase();
        $conferenceQuery = <<<QUERY
                INSERT INTO `conference` (`title`, `date`, `address_lat`, `address_lng`, `country_name`)
                VALUES (?, ?, ?, ?, ?)
                QUERY;
        try {
            $conferencePreparedQuery = $database->prepare($conferenceQuery);
            $conferencePreparedQuery->execute(
                [
                    $this->title,
                    $this->date->format('Y-m-d'),
                    $this->address['lat'],
                    $this->address['lng'],
                    $this->country
                ]
            );
            return ['code' => 200, 'message' => 'Conference created'];
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                'code' => 500,
                'message' => 'Problem with conference creation'
            ];
        }
    }

    public static function getAll(): array
    {
        $database = Application::getDatabase();
        $conferenceQuery = <<<QUERY
                SELECT * FROM `conference`
                QUERY;
        try {
            $data = $database->query($conferenceQuery);
            $conferences = $data->fetchAll();
            return [
                'code' => 200,
                'message' => 'Conferences successfully fetched',
                'data' => $conferences
            ];
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                'code' => 500,
                'message' => 'Problem with fetching conferences'
            ];
        }
    }

    public static function getConference(string $id): array
    {
        $database = Application::getDatabase();
        $conferenceQuery = <<<QUERY
                SELECT * FROM `conference` WHERE id = ?
                QUERY;
        try {
            $conferencePreparedQuery = $database->prepare($conferenceQuery);
            $conferencePreparedQuery->execute([$id]);
            $conference = $conferencePreparedQuery->fetch();
            return [
                'code' => 200,
                'message' => 'Conference successfully fetched',
                'data' => $conference
            ];
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                'code' => 500,
                'message' => 'Problem with fetching conference'
            ];
        }
    }

    public static function deleteConference(string $id): array
    {
        $database = Application::getDatabase();
        $conferenceQuery = <<<QUERY
                DELETE FROM `conference` WHERE id=?
                QUERY;
        try {
            $conferencePreparedQuery = $database->prepare($conferenceQuery);
            $conferencePreparedQuery->execute([$id]);
            return [
                'code' => 200,
                'message' => 'Conference successfully deleted'
            ];
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                'code' => 500,
                'message' => 'Problem with deleting conference'
            ];
        }
    }

    public function editConference(string $id): array
    {
        $database = Application::getDatabase();
        $conferenceQuery = <<<QUERY
                UPDATE `conference` 
                SET title=?, date=?, address_lat=?, address_lng=?,
                country_name=? 
                WHERE id=?
                QUERY;
        try {
            $conferencePreparedQuery = $database->prepare($conferenceQuery);
            $conferencePreparedQuery->execute(
                [
                    $this->title,
                    $this->date->format('Y-m-d'),
                    $this->address['lat'],
                    $this->address['lng'],
                    $this->country,
                    $id
                ]
            );
            return [
                'code' => 200,
                'message' => 'Conference changes has been successfully saved.'
            ];
        } catch (\Exception $e) {
            http_response_code(500);
            return [
                'code' => 500,
                'message' => 'Problem with deleting conference'
            ];
        }
    }
}
