<?php

namespace Matchday\TestServer;

use JsonSerializable;

class VideoFilePack implements JsonSerializable
{
    private string $id;
    private array $videoFiles;

    public function __construct()
    {
        $this->id = UUID::create();
        $this->videoFiles = [];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function addVideoFile($file, $part): void
    {
        $partId = "<>";
        if ($part === 1) {
            $partId = "FIRST_HALF";
        } elseif ($part === 2) {
            $partId = "SECOND_HALF";
        }
        $this->videoFiles[$partId] = new VideoFile($file, $partId);
    }

    /**
     * @return array
     */
    public function getVideoFiles(): array
    {
        return $this->videoFiles;
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
