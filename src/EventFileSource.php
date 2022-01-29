<?php

namespace Matchday\TestServer;

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
    private int $fileSize;

    /**
     * EventFileSource constructor.
     */
    public function __construct()
    {
        $this->eventFileSrcId = UUID::create();
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
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    /**
     * @param int $fileSize
     */
    public function setFileSize(int $fileSize): void
    {
        $this->fileSize = $fileSize;
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
