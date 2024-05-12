<?php
class PartExpense
{
    protected $id, $id_expense, $id_user, $cost, $description, $date;

    function __construct($id, $id_expense, $id_user, $cost, $description, $date)
    {
        $this->id = $id;
        $this->id_expense = $id_expense;
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
