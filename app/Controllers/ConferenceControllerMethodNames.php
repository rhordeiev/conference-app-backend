<?php

declare(strict_types=1);

namespace Application\Controllers;

enum ConferenceControllerMethodNames: string
{
    case createConference = 'createConference';
    case getConferences = 'getConferences';
    case deleteConference = 'deleteConference';
    case editConference = 'editConference';
}
