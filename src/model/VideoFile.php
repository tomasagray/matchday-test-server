<?php

namespace Matchday\TestServer\model;

use JsonSerializable;

class VideoFile implements JsonSerializable
{
    private string $fileId;
    private string $externalUrl;
    private string $title;

    /**
     * @param string $url
     * @param string $title
     */
    public function __construct(string $url, string $title)
    {
        $this->fileId = UUID::create();
        $this->externalUrl = $url;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @return string
     */
    public function getExternalUrl(): string
    {
        return $this->externalUrl;
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
