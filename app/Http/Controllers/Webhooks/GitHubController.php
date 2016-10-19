<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GitHubController extends Controller
{
    public function postPullRequest(Request $request)
    {
        \Log::info('********************************');
        \Log::info(print_r($request->json(), true));
        \Log::info('********************************');
    }

    public function getPullRequest()
    {
        return response()->json([
            'data' => [
                'message' => 'Ok',
            ],
        ], 200);
    }
}