<?php

namespace App\Services\CodeReviews;

use Carbon\Carbon;

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
        $assignee = $this->findAssignee($repository['full_name']);

        $assigneeObj = [
            'login' => $assignee->github_username,
        ];

        $pullRequest['assignee'] = $assigneeObj;
        $pullRequest['assignees'] = [$assigneeObj];

        // @todo: make sure the user is assigned IN GITHUB to the pull request

        $assignee->update(['last_code_review_at' => Carbon::now()]);

        return $pullRequest;
    }

    /**
     * @param $repo
     * @return mixed
     */
    public function findAssignee($repo)
    {
        /** @var \App\Repositories\Collaborators $collaborators */
        $collaborators = app()->make('App\Repositories\Collaborators');

        $list = $collaborators->findCollaboratorsForRepo($repo);

        // avoid someone getting two code reviews in a row
        $list = $list->sortBy('last_code_review_at', SORT_REGULAR, 'DESC');

        if (!empty($list->last()->last_code_review_at)) {
            $list->pop();
        }

        return $list->random(1);
    }
}