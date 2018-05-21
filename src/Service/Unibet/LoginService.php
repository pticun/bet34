<?php

namespace App\Service\Unibet;

use GuzzleHttp\Client;

class LoginService
{
    const LOGIN_URL = 'zones/loginbox/processLogin.json';

    /**
     * @var Client
     */
    private $unibetApi;

    public function __construct(Client $unibetApi)
    {
        $this->unibetApi = $unibetApi;
    }

    public function getLoginData(): array
    {
        $response = $this->unibetApi->get('/');
        $content = $response->getBody()->getContents();
        $channelId = explode(': ', explode(',', explode('channelId', $content)[1])[0])[1];

        $response = $this->unibetApi->post(self::LOGIN_URL, [
            'form_params' => [
                'channelId' => $channelId,
                'dateOfBirth' => getenv('UNIBET_USERNAME'),
                'password' => getenv('UNIBET_PASSWORD'),
                'username' => getenv('UNIBET_USERNAME'),
            ],
        ]);

        return [
            'spsSession' => $this->getSpsSession($response->getHeader('Set-Cookie')),
            'sps-v3-cookie' => $this->getSpsV3Session($response->getHeader('Set-Cookie')),
        ];
    }

    private function getSpsSession(array $setCookies): ?string
    {
        foreach ($setCookies as $setCookie) {
            if (false !== strpos($setCookie, 'spsSession')) {
                return explode(';', explode('spsSession=', $setCookie)[1])[0];
            }
        }
    }

    private function getSpsV3Session(array $setCookies): ?string
    {
        foreach ($setCookies as $setCookie) {
            if (false !== strpos($setCookie, 'sps-v3-cookie')) {
                return explode(';', explode('sps-v3-cookie=', $setCookie)[1])[0];
            }
        }
    }
}
