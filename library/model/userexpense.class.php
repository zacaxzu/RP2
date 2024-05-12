<?php
class UserExpense
{
    protected $id_expense, $id_user, $username, $cost, $description, $date;

    function __construct($id_expense, $id_user, $username, $cost, $description, $date)
    {
        $this->id_expense = $id_expense;
        $this->id_user = $id_user;
        $this->username = $username;
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
