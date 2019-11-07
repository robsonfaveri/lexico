<?php


namespace App\Service;


class AreaInstrucoes{

    const PARA = 26;
    public $AI = [];
    public $LC;

        /**
         * Construtor sem parâmetros.
         * Todos os atributos são inicializados com valores padrões.
         */
    public function __construct(){
        for($i=0; $i<1000; $i++){
         $this->AI[$i]=new Tipos();
        }
    }

}