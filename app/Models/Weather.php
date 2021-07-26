<?php

namespace App\Models;

use DateTime;
use JsonSerializable;

class Weather implements JsonSerializable
{
    /**
     * @var DateTime
     */
    private $date;
    /**
     * @var float
     */
    private $minimum;

    /** @var float */
    private $maximum;
    /**
     * @var Info
     */
    private $dayInfo;

    /**
     * @var Info
     */
    private $nightInfo;

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): Weather
    {
        $this->date = $date;
        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return float
     */
    public function getMinimum(): float
    {
        return $this->minimum;
    }

    /**
     * @param float $minimum
     * @return Weather
     */
    public function setMinimum(float $minimum): Weather
    {
        $this->minimum = $minimum;
        return $this;
    }

    /**
     * @return float
     */
    public function getMaximum(): float
    {
        return $this->maximum;
    }

    /**
     * @param float $maximum
     * @return Weather
     */
    public function setMaximum(float $maximum): Weather
    {
        $this->maximum = $maximum;
        return $this;
    }

    public function setDayInfo(Info $dayInfo)
    {
        $this->dayInfo = $dayInfo;
        return $this;
    }

    private function getDayInfo(): Info
    {
        return $this->dayInfo;
    }

    /**
     * @return Info
     */
    public function getNightInfo(): Info
    {
        return $this->nightInfo;
    }

    /**
     * @param Info $nightInfo
     * @return Weather
     */
    public function setNightInfo(Info $nightInfo): Weather
    {
        $this->nightInfo = $nightInfo;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'date' => $this->getDate()->format('D, d/m/Y'),
            'temperature' => [
                'min' => $this->getMinimum(),
                'max' => $this->getMaximum(),
            ],
            'day' => $this->getDayInfo(),
            'night' => $this->getNightInfo()
        ];
    }
}
