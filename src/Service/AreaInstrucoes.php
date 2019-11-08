<?php


namespace App\Service;


class AreaInstrucoes{

    const AMEM = 24;
    const PARA = 26;

    public $AI = [];
    public $LC;

        /**
         * Construtor sem parâmetros.
         * Todos os atributos são inicializados com valores padrões.
         */
    public function __construct($maxInst){
        for($i=0; $i<$maxInst; $i++){
         $this->AI[$i]=new Tipos();
        }
    }

}