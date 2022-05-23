<?php

namespace Matchday\TestServer\model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class Team implements JsonSerializable
{
    private string $teamId;
    private ProperName $name;

    /**
     * Team constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->teamId = UUID::create();
        $this->name = new ProperName($name);
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
    #[Pure] public function getName(): string
    {
        return $this->name->getName();
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
