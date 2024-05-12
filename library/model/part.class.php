<?php
class Part
{
    protected $id, $id_expense, $id_user, $cost;

    function __construct($id, $id_expense, $id_user, $cost)
    {
        $this->id = $id;
        $this->id_expense = $id_expense;
        $this->id_user = $id_user;
        $this->cost = $cost;
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
