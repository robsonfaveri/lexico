<?php


namespace App\Service;


class AreaInstrucoes{

    const RETU = 1;
    const CRVL = 2;
    const CRCT = 3;
    const ARMZ = 4;
    const SOMA = 5;
    const SUBT = 6;
    const MULT = 7;
    const DIV = 8;
    const INVR = 9;
    const NEGA = 10;
    const CONJ = 11;
    const DISJ = 12;
    const CMME = 13;
    const CMMA = 14;
    const CMIG = 15;
    const CMDF = 16;
    const CMEI = 17;
    const CMAI = 18;
    const DSVS = 19;
    const DSVF = 20;
    const LEIT = 21;
    const IMPR = 22;
    const IMPRL = 23;
    const AMEM = 24;
    const CALL = 25;
    const PARA = 26;
    const NADA = 27;
    const COPI = 28;
    const DSVT = 29;
    

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