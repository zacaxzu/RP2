<?php
class UserPartExpense
{
    protected $id_part, $id_expense, $id_user, $expense_cost, $part_cost, $description, $date;

    function __construct($id_user, $id_part, $id_expense, $expense_cost, $part_cost, $username, $description, $date)
    {
        $this->id_user = $id_user;
        $this->id_part = $id_part;
        $this->id_expense = $id_expense;
        $this->expense_cost = $expense_cost;
        $this->part_cost = $part_cost;
        $this->username = $username;
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
