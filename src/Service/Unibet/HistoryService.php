<?php

namespace App\Service\Unibet;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class HistoryService
{
    /**
     * @var Client
     */
    private $unibetApi;

    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        Client $unibetApi,
        LoginService $loginService
    ) {
        $this->unibetApi = $unibetApi;
        $this->loginService = $loginService;
    }

    public function getHistory()
    {
        $cookies = CookieJar::fromArray($this->loginService->getLoginData(), 'www.unibet.fr');

        $response = $this->unibetApi->post('zones/myaccount/betting-history-result.json', [
            'cookies' => $cookies,
            'form_params' => [
                'datepickerFrom' => (new \DateTime('-3 days'))->format('d/m/Y'),
                'datepickerTo' => (new \DateTime())->format('d/m/Y'),
                'pageNumber' => 1,
                'resultPerPage' => 10,
                'statusFilter' => 'all',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
