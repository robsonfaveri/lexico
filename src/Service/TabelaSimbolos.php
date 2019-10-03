<?php


namespace App\Service;


class TabelaSimbolos
{

    const TABLE_SIZE = 30011;


    public $list;


    public function __construct()
    {
        $this->list = new \SplFixedArray(self::TABLE_SIZE);
    }

    public function adiciona($nome, $categoria, $nivel, $geralA, $geralB)
    {
        $simbolo = $this->search($nome);
        if(!$simbolo) {
            $hash = $this->hash($nome, self::TABLE_SIZE);
            $this->list[$hash] = new Simbolo($nome, $categoria, $nivel, $geralA, $geralB);
        }else{
            while($simbolo->getProximo() != null){
                $simbolo = $simbolo->getProximo();
            }
            $simbolo->setProximo(new Simbolo($nome, $categoria, $nivel, $geralA, $geralB));
        }
    }

    public function editar($nome, $label, $value)
    {
        $simbolo = $this->search($nome);
        if($simbolo) {
            return $simbolo->edit($label, $value);
        }else{
            return false;
        }
    }

    public function search($nome)
    {
        $hash = $this->hash($nome, self::TABLE_SIZE);
        if($this->list[$hash] != null) {
            /**
             * @var Simbolo $simboloAtual
             */
            $simboloAtual  = $this->list[$hash];
            if($simboloAtual->getNome() == $nome){
                return $simboloAtual;
            }else{
                while($simboloAtual->getProximo() != null){
                    $simboloAtual = $simboloAtual->getProximo();
                    if($simboloAtual->getNome() == $nome){
                        return $simboloAtual;
                    }
                }
            }

        }else{
            return false;
        }

    }

    public function remove($nome)
    {
        $hash = $this->hash($nome, self::TABLE_SIZE);
        if ($this->list[$hash] != null) {
            /**
             * @var Simbolo $simboloAtual
             */
            $simboloAtual  = $this->list[$hash];
            if ($simboloAtual->getNome() == $nome) {
                $this->list[$hash] = $simboloAtual->getProximo();
                return true;
           } else {
                $simboloAnterior = $simboloAtual;
                $simboloAtual = $simboloAtual->getProximo();
                while ($simboloAtual->getNome() != $nome) {
                    $simboloAnterior = $simboloAtual;
                    $simboloAtual = $simboloAtual->getProximo();
                }
                if ($simboloAtual != null) {
                    $simboloAnterior->setProximo($simboloAtual);
                    return true;
                }else{
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    private function hash($key, $tableSize) {
        $hashVal = 0;
        for ($i = 0; $i < strlen($key); $i++)
            $hashVal = 37 * $hashVal + ord($key[$i]);
        $hashVal %= $tableSize;
        if ($hashVal < 0)
            $hashVal += $tableSize;
        return $hashVal;
    }

}
