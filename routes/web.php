<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return response()->json(['data' => [
        'message' => 'Ok',
        'rev' => exec('git log --pretty=format:\'%h\' -n 1'),
        'lumen' => $app->version(),
    ]]);
});

$app->get('webhooks/github/pull-request', 'Webhooks\\GitHubController@getPullRequest');
$app->post('webhooks/github/pull-request', 'Webhooks\\GitHubController@postPullRequest');

$app->get('tokens/github', 'Tokens\\GitHubController@index');
$app->get('tokens/github/exchange', 'Tokens\\GitHubController@exchange');
