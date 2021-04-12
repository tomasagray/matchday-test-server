<?php

namespace matchday;


class Server
{
    public const DATA_PATH = 'data';
    public const DIR_PATTERN = '/^([\w ]+)_\-_([\w ]+)_vs._([\w ]+)$/';
    private array $events;

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

    private function get_event_data($path): ?Event
    {
        if (is_dir($path)) {
            $groups = array();
            $pathinfo = pathinfo($path);
            $dirname = $pathinfo['basename'];
            $group_count = preg_match_all(self::DIR_PATTERN, $dirname, $groups);
            if ($group_count > 0) {
                return new Event(
                    new Competition($groups[1][0]),
                    new Team($groups[2][0]),
                    new Team($groups[3][0]),
                    $path);
            }
        }
        return null;
    }

    /**
     * @param array $event
     * @return bool
     */
    private function is_event(?object $event): bool
    {
        return $event instanceof Event;
    }
}
