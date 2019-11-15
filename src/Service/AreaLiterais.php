<?php


namespace App\Service;


class AreaLiterais{
    public $AL= [];
    public $LIT;


    public function  toJson(){
        $retorno = new \stdClass();
        $retorno->AL = $this->AL;
        $retorno->LIT = $this->LIT;
        return json_encode($retorno);
    }
}