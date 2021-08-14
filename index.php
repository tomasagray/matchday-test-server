<?php

namespace matchday;

use JetBrains\PhpStorm\Pure;
use JsonException;

require_once 'Server.php';
require_once 'EventFileSource.php';
require_once 'Event.php';
require_once 'Competition.php';
require_once 'Team.php';
require_once 'html_frontend.php';

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
    uasort($events, 'matchday\sort_events');

    if (isset($_GET['format'])) {
        $format = $_GET['format'];
        if ($format === 'json') {
            $values = array_values($events);
            echo json_encode($values, JSON_THROW_ON_ERROR);
        }
    } else {
        display_html_events($events);
    }
} catch (JsonException $e) {
    die($e);
}
