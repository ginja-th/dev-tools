<?php

namespace App\Services\CodeReviews;

class Notifier
{
    protected $emoji = ':exclamation:';

    protected $username = 'Code Review Bot';

    /**
     * @param $pullRequest
     */
    public function notify($pullRequest)
    {
        $payload = [
            'username' => $this->username,
            'icon' => $this->emoji,
        ];

        $slack = new \Maknz\Slack\Client(env('SLACK_WEBHOOK_URL'), $payload);

        $messageObj = $slack->createMessage();
        $messageObj->send($this->generateMessage($pullRequest));
    }

    /**
     * @param $pullRequest
     * @return string
     */
    protected function generateMessage($pullRequest)
    {
        return '!';
    }
}