<?php

namespace App\Repositories;

use App\Models\Collaborator;

class Collaborators
{
    /**
     * @param $repo
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findCollaboratorsForRepo($repo)
    {
        $ids = \DB::table('collaborator_repos')
            ->select('collaborator_id')
            ->where('repo_name', $repo)
            ->pluck('collaborator_id')
            ->toArray();

        return Collaborator::whereIn('id', (array)$ids)
            ->get();
    }

    /**
     * @param $username
     * @return \App\Models\Collaborator|null
     */
    public function findByGithubUsername($username)
    {
        return Collaborator::where('github_username', $username)
            ->first();
    }
}