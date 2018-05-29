<?php

namespace App\Service\Unibet;

use App\Entity\Bet;

class BetService
{
    /**
     * @var LoginService
     */
    private $loginService;

    /**
     * @var Client
     */
    private $unibetApi;

    public function __construct(
        LoginService $loginService,
        Client $unibetApi
    ) {
        $this->loginService = $loginService;
        $this->unibetApi = $unibetApi;
    }

    public function send(Bet $bet): void
    {
        $cookies = CookieJar::fromArray($this->loginService->getLoginData(), 'www.unibet.fr');

        $response = $this->unibetApi->post('zones/oneclickbetslip/bet.json', [
            'cookies' => $cookies,
            'form_params' => [
                'autoaccept' => true,
                'isfreebet' => false,
                'priceDown' => $bet->getPriceDown(),
                'priceUp' => $bet->getPriceUp(),
                'selectionId' => $bet->getSelectionId(),
                'stake' => 0.1,
            ],
        ]);

        return; //json_decode($response->getBody()->getContents(), true);
    }
}
