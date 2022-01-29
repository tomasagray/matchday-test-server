<?php

namespace Matchday\TestServer\TestServer;

use JetBrains\PhpStorm\Pure;
use JsonException;
use Matchday\TestServer\Event;
use Matchday\TestServer\HtmlFrontEnd;
use Matchday\TestServer\Server;

#[Pure] function sort_events(Event $ea, Event $eb): int
{
    $ea_time = $ea->getDate();
    $eb_time = $eb->getDate();
    if ($ea_time == $eb_time) {
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

    if (isset($_GET['format'])) {
        $format = $_GET['format'];
        if ($format === 'json') {
            $values = array_values($events);
            echo json_encode($values, JSON_THROW_ON_ERROR);
        }
    } else {
        HtmlFrontEnd::display_html_events($events);
    }
} catch (JsonException $e) {
    die($e);
}
