<?php
namespace matchday;


use JsonSerializable;

class Team implements JsonSerializable
{
    private string $name;

    /**
     * Team constructor.
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
