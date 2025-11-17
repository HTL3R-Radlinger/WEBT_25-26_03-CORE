<?php

namespace App\Classes;

class MealPlan implements \JsonSerializable
{
    public int $id;
    public string $name;
    public string $schoolName;
    public string $weekOfDelivery;
    public array $meals;

    function __construct(
        int    $id,
        string $name,
        string $schoolName,
        string $weekOfDelivery,
        array  $meals,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->schoolName = $schoolName;
        $this->weekOfDelivery = $weekOfDelivery;
        $this->meals = $meals;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
