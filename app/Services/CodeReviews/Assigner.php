<?php

namespace App\Services\CodeReviews;

use Carbon\Carbon;
use GuzzleHttp\Client;

/**
 * Class Assigner
 * @package App\Services\CodeReviews\Assigner
 */
class Assigner
{
    /**
     * @param $pullRequest
     * @return mixed
     */
    public function assign($repository, $pullRequest)
    {
        // e.g: ginja-th/dev-tools
        $assignee = $this->findAssignee($repository['full_name'], $pullRequest['user']['login']);

        $assigneeObj = [
            'login' => $assignee->github_username,
        ];

        $pullRequest['assignee'] = $assigneeObj;
        $pullRequest['assignees'] = [$assigneeObj];

        $this->assignInGithub($pullRequest, $assignee->github_username);

        $assignee->update(['last_code_review_at' => Carbon::now()]);

        return $pullRequest;
    }

    /**
     * @param $repo
     * @return mixed
     */
    public function findAssignee($repo, $omit = null)
    {
        /** @var \App\Repositories\Collaborators $collaborators */
        $collaborators = app()->make('App\Repositories\Collaborators');

        $list = $collaborators->findCollaboratorsForRepo($repo);

        // omit PR creator...
        if (!is_null($omit)) {
            $list = $list->filter(function ($element) use ($omit) {
                return $element->github_username !== $omit;
            });
        }

        // avoid someone getting two code reviews in a row
        $list = $list->sortBy('last_code_review_at', SORT_REGULAR, 'DESC');

        if (!empty($list->last()->last_code_review_at)) {
            $list->pop();
        }

        return $list->random(1);
    }

    /**
     * @param $pullRequest array
     * @param $githubUsername string
     */
    public function assignInGithub($pullRequest, $githubUsername)
    {
        $url = $pullRequest['issue_url'] . '/assignees';

        /** @var \App\Integrations\GitHub $github */
        $github = app()->make('App\Integrations\GitHub');
        $github->assignUserToIssue($url, $githubUsername);
    }
}