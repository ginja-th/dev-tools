<?php

namespace App\Services\CodeReviews;

class Notifier
{
    protected $emoji = ':robot_face:';

    protected $username = 'Code Review Bot';

    /**
     * @param $pullRequest
     */
    public function notify($pullRequest)
    {
        $payload = [
            'username' => $this->username,
            'icon' => $this->emoji,
            'link_names' => 1,
        ];

        $slack = new \Maknz\Slack\Client(env('SLACK_WEBHOOK_URL'), $payload);

        $messageObj = $slack->createMessage();
        $message = $this->generateMessage($pullRequest);

        if ($message) {
            $messageObj->send($message);
        }
    }

    /**
     * @param $pullRequest
     * @return string
     */
    protected function generateMessage($pullRequest)
    {
        $url = $pullRequest['html_url'];
        $assigneeGithub = $pullRequest['assignee']['login'];

        $collaborator = app()->make('App\\Repositories\\Collaborators')->findByGithubUsername($assigneeGithub);

        return !empty($collaborator) ? "Hey @{$collaborator->slack_username}, you have a new code review: {$url}" : null;
    }
}