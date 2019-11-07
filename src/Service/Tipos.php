<?php


namespace App\Service;


class Tipos{
    public $codigo;
    public $op1;
    public $op2;

    /**
     * Construtor sem parâmetros.
     * Todos os atributos são inicializados com valores padrões.
     */
    public function __construct()
    {
        $this->codigo=0;
        $this->op1=0;
        $this->op2=0;
    }


}