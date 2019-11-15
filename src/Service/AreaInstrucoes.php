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

    const Titles= ["","RETU","CRVL"
        ,"CRCT"
        ,"ARMZ"
        ,"SOMA"
        ,"SUBT"
        ,"MULT"
        ,"DIV "
        ,"INVR"
        ,"NEGA"
        ,"CONJ"
        ,"DISJ"
        ,"CMME"
        ,"CMMA"
        ,"CMIG"
        ,"CMDF"
        ,"CMEI"
        ,"CMAI"
        ,"DSVS"
        ,"DSVF"
        ,"LEIT"
        ,"IMPR"
        ,"IMPRL"
        ,"AMEM"
        ,"CALL"
        ,"PARA"
        ,"NADA"
        ,"COPI"
        ,"DSVT"];
    

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

    public function toArray(){
        $retorno = [];

        foreach ($this->AI as $aItem){
            if($aItem->codigo != -1){
                $aItem->title = self::Titles[$aItem->codigo];
                $aItem = $this->cleanInstruction($aItem);
                $retorno[] =$aItem;
            }
        }
        return $retorno;
    }

    public function toJson(){
        $retorno = new \stdClass();
        $retorno->AI = $this->AI;
        $retorno->LC = $this->LC;
        return json_encode($retorno);
    }

    private function cleanInstruction($aItem){

        if($aItem->codigo == self::AMEM || $aItem->codigo == self::DSVS || $aItem->codigo == self::DSVF ||
            $aItem->codigo == self::DSVT || $aItem->codigo == self::IMPRL || $aItem->codigo == self::RETU ||
            $aItem->codigo == self::CALL || $aItem->codigo == self::CRCT
        )
        {
            $aItem->op1 = "-";
        }

        if($aItem->codigo == self::PARA || $aItem->codigo == self::IMPR || $aItem->codigo == self::LEIT ||
            $aItem->codigo == self::COPI || $aItem->codigo == self::CMME || $aItem->codigo == self::CMMA ||
            $aItem->codigo == self::CMIG || $aItem->codigo == self::CMDF || $aItem->codigo == self::CMEI ||
            $aItem->codigo == self::CMAI || $aItem->codigo == self::SOMA || $aItem->codigo == self::DIV ||
            $aItem->codigo == self::MULT || $aItem->codigo == self::SUBT
        )
        {
            $aItem->op1 = "-";
            $aItem->op2 = "-";
        }

        return $aItem;
    }

}