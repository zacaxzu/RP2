<?php
class User
{
    protected $id, $username, $password_hash, $total_paid, $total_debt, $email;

    function __construct($id, $username, $password_hash, $total_paid,$total_debt, $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->total_paid = $total_paid;
        $this->total_debt = $total_debt;
        $this->email = $email;
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

    public function getUsername()
    {
        return $this->username;
    }
}
?>