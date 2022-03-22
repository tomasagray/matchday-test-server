<?php

namespace Matchday\TestServer;

use DateTime;
use JsonException;

class Server
{
    public const DATA_PATH = 'data';
    public const DIR_PATTERN = '/^([\w ]+)_-_([\w\- ]+)_vs._([\w\-_]+)$/';
    public string $logFile;
    private array $events = [];
    private object $config;

    public function __construct()
    {
        try {
            $this->logFile = dirname(__DIR__) . "/log/scan-data.log";
            $configData = file_get_contents(__DIR__ . "/config.json");
            if (!$configData) {
                $configData = "{}";
            }
            $this->config = json_decode($configData, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            var_dump($e);
        }
    }

    /**
     * Scan the specified data directory for match videos
     * @throws JsonException
     */
    public function scan_data_dir(): void
    {
        $path = realpath(self::DATA_PATH);
        $this->write_log("Starting scan of: " . $path . "...\n");
        $items = scandir($path);
        if ($items !== false) {
            foreach ($items as $item) {
                $this->write_log("Scanned file: " . $item . "\n");
                $event_path = (realpath($path . '/' . $item));
                $event = $this->get_event_data($event_path);
                if ($this->is_event($event)) {
                    $this->events[] = $event;
                }
            }
        }
        $this->write_log("Event count = " . count($this->events) . "\n");
        $this->write_log("Scan done.\n\n");
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param $path string path containing match video data
     * @return Event|null An Event object, if the path matched
     * @throws JsonException
     */
    private function get_event_data(string $path): ?Event
    {
        if (is_dir($path)) {
            $groups = array();
            $pathinfo = pathinfo($path);
            $dirname = $pathinfo['basename'];
            $group_count = preg_match_all(self::DIR_PATTERN, $dirname, $groups);
            if ($group_count > 0) {
                $competition = str_replace("_", " ", $groups[1][0]);
                $homeTeam = str_replace("_", " ", $groups[2][0]);
                $awayTeam = str_replace("_", " ", $groups[3][0]);
                $event = new Event(
                    new Competition($competition),
                    new Team($homeTeam),
                    new Team($awayTeam),
                    $path);
                $log_data = "Read event data: " . json_encode($event, JSON_THROW_ON_ERROR) . "\n";
                $this->write_log($log_data);
                return $event;
            }
        }
        return null;
    }

    /**
     * @param object|null $event A suspected Event
     * @return bool
     */
    private function is_event(?object $event): bool
    {
        return $event instanceof Event;
    }

    private function write_log(string $data): void
    {
        $date = new DateTime();
        $timestamp = '[' . $date->getTimeStamp() . '] ';
        if ($this->config->loggingEnabled) {
            file_put_contents($this->logFile, $timestamp . $data, FILE_APPEND);
        }
    }
}
