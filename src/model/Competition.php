<?php

namespace Matchday\TestServer\model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class Competition implements JsonSerializable
{
    private string $competitionId;
    private ProperName $properName;

    /**
     * Competition constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->competitionId = UUID::create();
        $this->properName = new ProperName($name);
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
    #[Pure] public function getProperName(): string
    {
        return $this->properName->getName();
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
