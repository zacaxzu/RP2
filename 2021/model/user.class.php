<?php
class Student
{
    protected $id, $ime, $kolegij;

    function __construct($id, $ime, $kolegij)
    {
        $this->id = $id;
        $this->ime = $ime;
        $this->kolegij = $kolegij;
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

    public function getIme()
    {
        return $this->ime;
    }
}
class Prostorija
{
    protected $id, $ime;

    function __construct($id, $ime)
    {
        $this->id = $id;
        $this->ime = $ime;
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

    public function getIme()
    {
        return $this->ime;
    }
}
