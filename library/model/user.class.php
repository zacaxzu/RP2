<?php
class User
{
    protected $id, $name, $surname, $password;

    function __construct($id, $name, $surname, $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->password = $password;
    }

    function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

    function __set($property, $value)
    {
        if (property_exists($property))
            return $this->$property = $value;
    }
}
?>