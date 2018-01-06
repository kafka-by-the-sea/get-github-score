<?php

require_once 'vendor/autoload.php';

class GithubScore
{
    private $events;

    private function __construct($events)
    {
        $this->events = $events;
    }

    public static function score($events)
    {
        return (new static($events))->scoreEvents();
    }

    private function scoreEvents()
    {
        return $this->events->pluck('type')->map(function ($eventType) {
            return $this->lookupEventScore($eventType);
        })->sum();
    }

    private function lookupEventScore($eventType)
    {
        return collect([
            'PushEvent' => 5,
            'CreateEvent' => 4,
            'IssuesEvent' => 3,
            'CommitCommentEvent' => 2,
        ])->get($eventType, 1);
    }
}

function load_json($path)
{
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}

$events = collect(load_json('events.json'));
dd(GithubScore::score($events));