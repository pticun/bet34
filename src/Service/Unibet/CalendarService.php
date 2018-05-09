<?php

namespace App\Service\Unibet;

use GuzzleHttp\Client;

use Psr\Http\Message\ResponseInterface;

class CalendarService implements UnibetInterface
{

    /**
     * @var Client
     */
    private $unibetApi;

    public function __construct(Client $unibetApi)
    {
        $this->unibetApi = $unibetApi;
    }

    public function getNextGames(): ResponseInterface
    {
        return $this->unibetApi->get(sprintf('%s?%s', UnibetInterface::URL_CALENDAR, http_build_query($this->getParameters())));
    }




    private function getParameters(): array
    {
        return [
            'from' => (new \DateTime())->format('d/m/Y'),
            'willBeLive' => false,
            'isOnPlayer' => false
        ];
    }
}
