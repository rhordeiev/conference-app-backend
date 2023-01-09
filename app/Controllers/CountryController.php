<?php

declare(strict_types=1);

namespace Application\Controllers;

use Application\Models\Country;

class CountryController
{
    public static function getCountries(): array
    {
        return Country::getAll();
    }

}