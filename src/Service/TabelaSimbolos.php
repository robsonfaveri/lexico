<?php


namespace App\Service;

use App\Service\Simbolo;


class TabelaSimbolos
{
    public $lista;


    public function __construct()
    {
        $this->lista = [];
    }

    public function adiciona($nome, $categoria, $nivel, $geralA, $geralB, $proximo)
    {
        $hash = hash("md5", "simbolo_" . $nome);
        $this->list[$hash] = new Simbolo($hash, $nome, $categoria, $nivel, $geralA, $geralB, $proximo);
    }

    public function editar($id, $nivel, $label, $value)
    {
        $this->list[$id]->edit($label, $value);
    }

    public function remove($id, $nivel)
    {
        if (is_array($this->list[$id]) && $nivel) {
            dd("Nao");
        } else {
            unset($this->list[$id]);
        }
    }
}
