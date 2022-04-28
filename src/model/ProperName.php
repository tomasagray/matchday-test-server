<?php

namespace Matchday\TestServer\model;

use JsonSerializable;

class ProperName implements JsonSerializable
{
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    private string $name;

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
