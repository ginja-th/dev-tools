<?php

namespace App\Http\Controllers\Tokens;

use App\Http\Controllers\Controller;
use App\Integrations\GitHub;
use App\Repositories\Collaborators;
use Illuminate\Http\Request;
use App\Services\Settings;

class GitHubController extends Controller
{
    protected $github;
    protected $collaborators;
    protected $settings;

    public function __construct(GitHub $github, Collaborators $collaborators, Settings $settings)
    {
        $this->github = $github;
        $this->collaborators = $collaborators;
        $this->settings = $settings;
    }

    /**
     * Redirects user to GitHub to complete OAuth
     *
     * @return mixed
     */
    public function index()
    {
        // redirect the user
        return redirect()->to($this->github->getOauthRedirectUrl(url('tokens/github/exchange')));
    }

    /**
     * Exchanges the "code" for an actual access token
     *
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

        if ($user && $this->collaborators->findByGithubUsername($user->login)) {
            $this->settings->set('github_oauth_token', $accessToken);
            return response()->json(['data' => ['message' => 'Token stored.']]);
        }

        return response()->json(['data' => ['message' => 'Token was not stored.']], 400);
    }
}