<?php

namespace Matchday\TestServer\model;

use Exception;
use JsonSerializable;

class Fixture implements JsonSerializable
{
    private string $title;
    private int $fixtureNumber;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->title = "Matchday";
        $this->fixtureNumber = 0;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getFixtureNumber(): int
    {
        return $this->fixtureNumber;
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
