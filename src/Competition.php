<?php

namespace Matchday\TestServer;

use DateTime;
use JsonSerializable;

class Competition implements JsonSerializable
{
    private string $competitionId;
    private string $name;

    /**
     * Competition constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->competitionId = UUID::create();
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCompetitionId(): string
    {
        return $this->competitionId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): object
    {
        return (object) get_object_vars($this);
    }
}
