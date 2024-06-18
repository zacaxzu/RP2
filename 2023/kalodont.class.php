<?php

class Kalodont
{
    protected $id, $igra, $igrac, $rijec;

    function __construct($id, $igra, $igrac, $rijec)
    {
        $this->id = $id;
        $this->igra = $igra;
        $this->igrac = $igrac;
        $this->rijec = $rijec;
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

    public function getRijec()
    {
        return $this->rijec;
    }
}

?>