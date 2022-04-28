<?php

namespace Matchday\TestServer\model;

use JsonSerializable;

class LocalDate implements JsonSerializable
{
    private int $year;
    private int $month;
    private int $day;

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function __construct(int $year, int $month, int $day)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDay(): int
    {
        return $this->day;
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
