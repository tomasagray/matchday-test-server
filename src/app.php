<?php

namespace Matchday\TestServer\TestServer;

use JetBrains\PhpStorm\Pure;
use JsonException;
use Matchday\TestServer\HtmlFrontEnd;
use Matchday\TestServer\model\Event;
use Matchday\TestServer\Server;

#[Pure] function sort_events(Event $ea, Event $eb): int
{
    $ea_time = $ea->getDateTime();
    $eb_time = $eb->getDateTime();
    if ($ea_time === $eb_time) {
        return 0;
    }
    return ($ea_time < $eb_time) ? 1 : -1;
}

// Initialize server
$server = new Server();
try {
    $server->scan_data_dir();

    $events = $server->getEvents();
    uasort($events, 'Matchday\TestServer\TestServer\sort_events');

    if (isset($_GET['format']) && $_GET['format'] === 'json') {
        $values = array_values($events);
        header('Content-Type: application/json');
        echo json_encode($values, JSON_THROW_ON_ERROR);
    } else {
        HtmlFrontEnd::display_html_events($events);
    }
} catch (JsonException $e) {
    die($e);
}
