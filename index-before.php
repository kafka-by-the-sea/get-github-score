<?php

require_once 'vendor/autoload.php';

function load_json($path)
{
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}

function getGithubScore($events)
{
    $eventTypes = [];
    foreach ($events as $event) {
        $eventTypes[] = $event['type'];
    }

    $score = 0;

    foreach ($eventTypes as $eventType) {
        switch ($eventType) {
        case 'PushEvent':
            $score += 5;
            break;
        case 'CreateEvent':
            $score += 4;
            break;
        case 'IssuesEvent':
            $score += 3;
            break;
        case 'CommitCommentEvent':
            $score += 2;
            break;
        default:
            $score += 1;
            break;
        }
    }

    return $score;
}

$events = load_json('events.json');
dd(getGithubScore($events));