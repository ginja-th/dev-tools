<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\CodeReviews\Assigner;
use App\Services\CodeReviews\Notifier;
use Illuminate\Http\Request;

class GitHubController extends Controller
{
    protected $assigner;
    protected $notifier;

    /**
     * GitHubController constructor.
     * @param Assigner $assigner
     * @param Notifier $notifier
     */
    public function __construct(Assigner $assigner, Notifier $notifier)
    {
        $this->assigner = $assigner;
        $this->notifier = $notifier;
    }
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function postPullRequest(Request $request)
    {
        $payload = ['data' => ['message' => 'Ignored']];

        $body = $request->json()->all();

        if (!empty($body['action']) && $body['action'] === 'opened') {
            
            $pr = $body['pull_request'];

            if (empty($pr['assignees'])) {
                $pr = $this->assigner->assign($body['repository'], $pr);
            }
            
            $this->notifier->notify($pr);

            $payload = ['data' => ['message' => 'Actioned']];
        }

        return response()->json($payload);
    }

    /**
     * @return mixed
     */
    public function getPullRequest()
    {
        return response()->json([
            'data' => [
                'message' => 'Ok',
            ],
        ], 200);
    }
}