<?php

namespace Matchday\TestServer\model;

use JsonSerializable;

class LocalTime implements JsonSerializable
{
    private int $hour;
    private int $minute;
    private int $second;
    private int $nano;

    /**
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param int $nano
     */
    public function __construct(int $hour, int $minute, int $second, int $nano)
    {
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
        $this->nano = $nano;
    }

    /**
     * @return int
     */
    public function getHour(): int
    {
        return $this->hour;
    }

    /**
     * @return int
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    /**
     * @return int
     */
    public function getSecond(): int
    {
        return $this->second;
    }

    /**
     * @return int
     */
    public function getNano(): int
    {
        return $this->nano;
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
