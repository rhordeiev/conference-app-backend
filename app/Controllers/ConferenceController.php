<?php

declare(strict_types=1);

namespace Application\Controllers;

use Application\Models\Conference;

class ConferenceController
{

    public static function createConference(array $conferenceData): array
    {
        $newConference = new Conference($conferenceData);
        return $newConference->create();
    }

    public static function getConferences(array $conferenceData = []): array
    {
        if (array_key_exists('id', $conferenceData)) {
            return Conference::getConference($conferenceData['id']);
        } else {
            return Conference::getAll();
        }
    }

    public static function deleteConference(string $id): array
    {
        return Conference::deleteConference($id);
    }

    public static function editConference(
        string $id,
        array $conferenceData
    ): array {
        $conference = new Conference($conferenceData);
        return $conference->editConference($id);
    }
}