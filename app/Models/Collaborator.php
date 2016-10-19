<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    protected $fillable = [
        'github_username',
        'slack_username',
        'email',
        'last_code_review_at',
    ];
}