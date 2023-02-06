<?php

namespace Matchday\TestServer\model;

use JsonSerializable;

define('TITLES', [
    'Pre-Match', '1st Half', '2nd Half', 'Extra Time/Penalties',
    'Trophy Ceremony', 'Post-Match'
]);

class VideoFile implements JsonSerializable
{
    private string $externalUrl;
    private string $title;

    /**
     * @param string $url
     * @param string $part
     */
    public function __construct(string $url, string $part)
    {
        $this->externalUrl = $url;
        $this->title = $part; //TITLES[$part];
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
    public function getExternalUrl(): string
    {
        return $this->externalUrl;
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
