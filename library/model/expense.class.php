<?php
class Expense
{
    protected $id, $id_user, $cost, $description, $date;

    function __construct($id, $id_user, $cost, $description, $date)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->cost = $cost;
        $this->description = $description;
        $this->date = $date;
    }

    function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

    function __set($property, $value)
    {
        if (property_exists($this, $property))
            return $this->$property = $value;
    }
}
