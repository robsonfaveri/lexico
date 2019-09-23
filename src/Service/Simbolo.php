<?php


namespace App\Service;


class Simbolo
{
    public $id;
    public $nome;
    public $categoria;
    public $nivel;
    public $geralA;
    public $geralB;
    public $proximo;

    public function __construct($id, $nome, $categoria, $nivel, $geralA, $geralB, $proximo)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->categoria = $categoria;
        $this->nivel = $nivel;
        $this->geralA = $geralA;
        $this->geralB = $geralB;
        $this->proximo = $proximo;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function edit($label, $value)
    {
        switch ($label) {
            case "nome":
                $this->nome = $value;
                break;
            case "categoria":
                $this->categoria = $value;
                break;
            case "nivel":
                $this->nivel = $value;
                break;
            case "geralA":
                $this->geralA = $value;
                break;
            case "geralB":
                $this->geralB = $value;
                break;
            case "proximo":
                $this->proximo = $value;
                break;
        }

        return true;
    }
    public function toString()
    {
        return "nome:" . $this->nome . ", categoria:" . $this->categoria . ", nivel:" . $this->nivel . ", geralA:" . $this->geralA . ", geralB" . $this->geralB . ", hasProximo:" . $this->proximo ? true : false;
    }
}
