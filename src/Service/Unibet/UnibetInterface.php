<?php

namespace App\Service\Unibet;

interface UnibetInterface
{
    const URL_CALENDAR = '/zones/calendar/nextbets.json';

    const URL_REFRESH_ALL = '/zones/livebox/overview/refresh.json';

    const URL_REFRESH = '/event/refresh.json?eventId=';
}
