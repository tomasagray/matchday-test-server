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
    private array $videoFiles;

    public function __construct()
    {
        $this->videoFiles = [];
    }

    public function addVideoFile($file, $part): void
    {
        $partId = PARTS[$part];
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
