<?php

namespace App\Field;

interface GameFieldInterface
{
    const CHRONO = 'chrono';
    const CHRONO_VALUE = 'value';
    const CHRONO_PERIOD = 'period';

    const COMPETITION_ID = 'competitionId';
    const COMPETITION_NAME = 'competitionName';

    const DATE_START = 'eventStartDate';
    const DATE_END = 'betEndDate';

    const EVENT_ID = 'eventId';
    const EVENT_NAME = 'name';
    const EVENT_AWAY_TEAM_NAME = 'awayName';
    const EVENT_HOME_TEAM_NAME = 'homeName';

    const EVENT_HOME_SCORE = 'homeScore';
    const EVENT_AWAY_SCORE = 'awayScore';

    const SCORE = 'score';
    const SPORT = 'cmsSportName';
    const SPORT_TYPE = 'sportType';

    const URL = 'friendlyUrl';
}
