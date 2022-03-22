<?php

namespace Matchday\TestServer;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class Season implements JsonSerializable
{
    private LocalDate $startDate;
    private LocalDate $endDate;

    #[Pure] public function __construct()
    {
        $this->startDate = new LocalDate(2022, 1, 1);
        $this->endDate = new LocalDate(2023, 4, 31);
    }

    /**
     * @return LocalDate
     */
    public function getStartDate(): LocalDate
    {
        return $this->startDate;
    }

    /**
     * @return LocalDate
     */
    public function getEndDate(): LocalDate
    {
        return $this->endDate;
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
