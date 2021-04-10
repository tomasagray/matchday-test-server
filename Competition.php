<?php

namespace matchday;

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
        $this->competitionId = md5(date_format(new DateTime(), 'c') . $name);
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
