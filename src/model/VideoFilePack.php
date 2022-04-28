<?php

namespace Matchday\TestServer\model;

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
        $this->videoFiles[$part] = new VideoFile($file, $part);
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
