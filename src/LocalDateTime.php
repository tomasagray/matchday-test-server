<?php

namespace Matchday\TestServer;

use JsonSerializable;

class LocalDateTime implements JsonSerializable
{
    private LocalDate $date;
    private LocalTime $time;

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function __construct(int $year, int $month, int $day)
    {
        $this->date = new LocalDate($year, $month, $day);
        $this->time = new LocalTime(0, 0, 0, 0);
    }

    public static function fromString(string $data): LocalDateTime
    {
        $year = (int)substr($data, 0, 4);
        $month = (int)substr($data, 4, 2);
        $day = (int)substr($data, 6, 2);
        return new LocalDateTime($year, $month, $day);
    }

    /**
     * @return LocalDate
     */
    public function getDate(): LocalDate
    {
        return $this->date;
    }

    /**
     * @return LocalTime
     */
    public function getTime(): LocalTime
    {
        return $this->time;
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
