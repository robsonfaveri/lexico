<?php


namespace App\Service;


class Stack
{
    private $itens;

    public function __construct()
    {
        $this->itens = array();
    }

    public function add($item)
    {
        array_push($this->itens, $item);
    }

    public function isEmpty()
    {
        return count($this->itens) == 0 ? true : false;
    }

    public function getTop()
    {
        return end($this->itens) ? end($this->itens) : null;
    }

    public function removeTop()
    {
        return array_pop($this->itens);
    }

    public function all()
    {
        return $this->itens;
    }

    public function clear()
    {
        $this->itens = [];
    }
}
