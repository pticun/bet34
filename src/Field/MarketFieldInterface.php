<?php

namespace App\Field;

interface MarketFieldInterface
{
    const MARKET_NAME = 'name';
    const MARKET_TYPE = 'markettype';

    const SELECTIONS = 'selections';

    const SELECTION_CURRENT_PRICE_UP = 'currentPriceUp';
    const SELECTION_CURRENT_PRICE_DOWN = 'currentPriceDown';
    const SELECTION_HAD_VALUE = 'hadValue';
    const SELECTION_NAME = 'name';
    const HOME_HAD_VALUE = 'H';
    const DRAW_HAD_VALUE = 'D';
    const AWAY_HAD_VALUE = 'A';
}
