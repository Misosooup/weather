<?php

namespace App\Models;

use JsonSerializable;

class Info implements JsonSerializable
{
    /** @var string */
    private $title;

    /** @var bool */
    private $hasPrecipitation;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Info
     */
    public function setTitle(string $title): Info
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasPrecipitation(): bool
    {
        return $this->hasPrecipitation;
    }

    /**
     * @param bool $hasPrecipitation
     * @return Info
     */
    public function setHasPrecipitation(bool $hasPrecipitation): Info
    {
        $this->hasPrecipitation = $hasPrecipitation;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle(),
            'hasPrecipitation' => $this->hasPrecipitation()
        ];
    }
}
