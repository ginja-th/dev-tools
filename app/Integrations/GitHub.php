<?php

namespace App\Integrations;

use App\Services\Settings;
use GuzzleHttp\Client;

class GitHub
{
    /**
     * @param $redirect
     * @return string
     */
    public function getOauthRedirectUrl($redirect)
    {
        // generate and store a one-time-use random number
        Settings::set('github_nonce', str_random(32));

        // set the params for the oauth redirect
        $clientId = env('GITHUB_CLIENT_ID');
        $redirectUri = $redirect;
        $scope = 'repo';
        $state = Settings::get('github_nonce');
        $allowSignup = 'false';

        // assemble the url
        $url = "https://github.com/login/oauth/authorize?";
        $params = [
            "client_id={$clientId}",
            "redirect_uri={$redirectUri}",
            "scope={$scope}",
            "state={$state}",
            "allow_signup={$allowSignup}"
        ];

        return $url . implode('&', $params);
    }

    /**
     * @param $code
     * @param $nonce
     * @return bool
     */
    public function exchangeCodeForAccessToken($code, $nonce)
    {
        $endpoint = 'https://github.com/login/oauth/access_token';
        $http = new Client();

        $response = $http->post($endpoint, [
            'body' => [
                'client_id' => env('GITHUB_CLIENT_ID'),
                'client_secret' => env('GITHUB_CLIENT_SECRET'),
                'code' => $code,
                'redirect_url' => url('/'), // not used?
                'state' => $nonce,
            ],
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $responseBody = json_decode($response->getBody()->__toString());

        if ($responseBody && property_exists($responseBody, 'access_token')) {
            return $responseBody->access_token;
        }

        return false;
    }

    /**
     * @param $accessToken
     * @return bool
     */
    public function fetchUserDetails($accessToken)
    {
        $endpoint = 'https://api.github.com/user';
        $http = new Client();
        $response = $http->get("{$endpoint}?access_token={$accessToken}");

        $responseBody = json_decode($response->getBody()->__toString());

        return $responseBody ?: false;
    }
}