<?php

namespace Matchday\TestServer\model;

use JsonSerializable;

define('PARTS', [
    'PRE_MATCH',
    'FIRST_HALF',
    'SECOND_HALF',
    'EXTRA_TIME',
    'TROPHY_CEREMONY',
    'POST_MATCH'
]);

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
        $partId = PARTS[$part];
        $this->videoFiles[$partId] = new VideoFile($file, $part);
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
