<?php

namespace App;

class Meal
//    implements \JsonSerializable
{
    public int $id;
    public string $name;
    public string $allergens;
    public string $nutritionalInfo;
    public float $price;

    function __construct(
        int    $id,
        string $name,
        string $allergens,
        string $nutritionalInfo,
        float  $price,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->allergens = $allergens;
        $this->nutritionalInfo = $nutritionalInfo;
        $this->price = $price;
    }

//    public function jsonSerialize(): array {
//        return get_object_vars($this);
//    }
}
