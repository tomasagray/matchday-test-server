<?php

namespace Matchday\TestServer\model;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class Competition implements JsonSerializable
{
    private string $competitionId;
    private ProperName $name;

    /**
     * Competition constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->competitionId = UUID::create();
        $this->name = new ProperName($name);
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
    #[Pure] public function getName(): string
    {
        return $this->name->getName();
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
