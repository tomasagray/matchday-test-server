<?php

namespace matchday;

use JsonSerializable;

class Competition implements JsonSerializable
{
    private string $name;

    /**
     * Competition constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
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
