<?php

namespace matchday;


class Server
{
    public const DATA_PATH = 'data';
    public const DIR_PATTERN = '/^([\w ]+)_\-_([\w\- ]+)_vs._([\w\-_]+)$/';
    private array $events;

    /**
     * Scan the specified data directory for match videos
     */
    public function scan_data_dir(): void
    {
        $path = realpath(self::DATA_PATH);
        $items = scandir($path);
        if ($items !== false) {
            foreach ($items as $item) {
                $event_path = (realpath($path . '/' . $item));
                $event = $this->get_event_data($event_path);
                if ($this->is_event($event)) {
                    $this->events[] = $event;
                }
            }
        }
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
                return new Event(
                    new Competition($competition),
                    new Team($homeTeam),
                    new Team($awayTeam),
                    $path);
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
}
