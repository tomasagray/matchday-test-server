<?php

namespace matchday;

use DateTime;
use JsonSerializable;

define('PARTS', [
    'Pre-Match', '1st Half', '2nd Half', 'Extra Time/Penalties',
    'Trophy Ceremony', 'Post-Match'
]);

class EventFileSource implements JsonSerializable
{

    private string $eventFileSrcId;
    private array $eventFiles;

    /**
     * EventFileSource constructor.
     */
    public function __construct()
    {
        $this->eventFileSrcId = md5(date_format(new DateTime(), 'c') . mt_rand());
    }

    public function addEventFile($eventFile, $part): void
    {
        $name = PARTS[$part];
        $this->eventFiles[$name] = $eventFile;
    }

    /**
     * @return string
     */
    public function getEventFileSrcId(): string
    {
        return $this->eventFileSrcId;
    }

    /**
     * @return array
     */
    public function getEventFiles(): array
    {
        return $this->eventFiles;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): object
    {
        $files_bk = $this->eventFiles;
        $this->eventFiles = array_values($this->eventFiles);
        $serialized = (object)get_object_vars($this);
        $this->eventFiles = $files_bk;
        return $serialized;
    }
}
