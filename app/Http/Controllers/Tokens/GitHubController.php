<?php

namespace App\Http\Controllers\Tokens;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Settings;

class GitHubController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        // generate and store a one-time-use random number
        Settings::set('github_nonce', str_random(32));

        // set the params for the oauth redirect
        $clientId = env('GITHUB_CLIENT_ID');
        $redirectUri = url('tokens/github/exchange');
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

        // redirect the user
        return redirect()->to($url . implode('&', $params));
    }

    /**
     * @param Request $request
     */
    public function exchange(Request $request)
    {
        $code = $request->get('code');
        $state = $request->get('state');

        \Log::info('****************');
        \Log::info("code={$code}");
        \Log::info("state={$state}");
        \Log::info('****************');

        if ($state !== Settings::get('github_nonce')) {
            abort(401, 'State parameter did not match. Please try again.');
        }

        $clientId = '';
        $clientSecret = '';
        $redirectUri = '';
        $state = Settings::get('github_nonce');
    }
}