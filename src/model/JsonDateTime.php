<?php


namespace Matchday\TestServer\model;

use DateTime;
use JsonSerializable;

class JsonDateTime extends DateTime implements JsonSerializable
{

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->format('Y-m-d\TH:m:s');
    }
}
