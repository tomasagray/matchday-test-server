<?php

namespace Matchday\TestServer;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class Team implements JsonSerializable
{
    private string $teamId;
    private ProperName $properName;

    /**
     * Team constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->teamId = UUID::create();
        $this->properName = new ProperName($name);
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
    #[Pure] public function getProperName(): string
    {
        return $this->properName->getName();
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
