<?php

namespace App\Http\Controllers\Tokens;

use App\Http\Controllers\Controller;
use App\Integrations\GitHub;
use Illuminate\Http\Request;
use App\Services\Settings;

class GitHubController extends Controller
{
    protected $github;

    public function __construct(GitHub $github)
    {
        $this->github = $github;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        // redirect the user
        return redirect()->to($this->github->getOauthRedirectUrl(url('tokens/github/exchange')));
    }

    /**
     * @param Request $request
     */
    public function exchange(Request $request)
    {
        $nonce = $request->get('state');

        if ($nonce !== Settings::get('github_nonce')) {
            abort(401, 'State parameter did not match. Please try again.');
        }

        $accessToken = $this->github->exchangeCodeForAccessToken($request->get('code'), $nonce);

        $user = $this->github->fetchUserDetails($accessToken);

        dd($user);
    }
}