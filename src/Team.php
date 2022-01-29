<?php

namespace Matchday\TestServer;

use JsonSerializable;

class Team implements JsonSerializable
{
    private string $teamId;
    private string $name;

    /**
     * Team constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->teamId = UUID::create();
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTeamId(): string
    {
        return $this->teamId;
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
        return (object)get_object_vars($this);
    }
}
