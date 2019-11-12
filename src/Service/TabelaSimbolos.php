<?php


namespace App\Service;

use App\Service\Simbolo;
use App\Exception\TableError;
use Exception;

class TabelaSimbolos
{
    //Tamanho da tabela de simbolos
    const TABLE_SIZE = 111;


    public $list;


    public function __construct()
    {
        $this->list = new \SplFixedArray(self::TABLE_SIZE);
    }

    //adiciona simbolo a tabela
    public function adiciona($nome, $categoria, $nivel, $geralA, $geralB)
    {
        $hash = $this->hash($nome, self::TABLE_SIZE);
        $simbolo = $this->list[$hash];
        if ($simbolo == null) {
            $hash = $this->hash($nome, self::TABLE_SIZE);
            $this->list[$hash] = new Simbolo($nome, $categoria, $nivel, $geralA, $geralB);
        } else {
            while ($simbolo->getProximo() != null) {
                $simbolo = $simbolo->getProximo();
            }
            $simbolo->setProximo(new Simbolo($nome, $categoria, $nivel, $geralA, $geralB));
        }
        return $hash;

    }

    //edita simbolo da tabela
    public function editar($nome,$nivel, $label, $value)
    {
        $simbolo = $this->searchNameAndNivel($nome, $nivel);
        if ($simbolo) {
            return $simbolo->edit($label, $value);
        } else {
            return false;
        }
    }

    //busca por nome e simbolo da tabela, pode ser usado pra buscar simbolos por nome e nivel especifico em uma posição da tabela
    public function searchNameAndNivel($nome,$nivel = 0, $showError = false)
    {
        $hash = $this->hash($nome, self::TABLE_SIZE);
        if ($this->list[$hash] != null) {
            /**
             * @var Simbolo $simboloAtual
             */
            $simboloAtual  = $this->list[$hash];


            if ($simboloAtual->getNome() == $nome && $simboloAtual->getNivel() == $nivel) {

                return $simboloAtual;
            } else {
                while ($simboloAtual->getProximo() != null) {
                    $simboloAtual = $simboloAtual->getProximo();
                    if ($simboloAtual->getNome() == $nome && $simboloAtual->getNivel() == $nivel) {
                        return $simboloAtual;
                    }
                }
            }
        }

        return $showError ? $this->errorMessage($nome) : false;


    }

    //busca por nome, irá encontrar o primeiro simbolo do hash passado
    public function search($nome, $showError = false)
    {
        $hash = $this->hash($nome, self::TABLE_SIZE);
        if ($this->list[$hash] != null) {
            /**
             * @var Simbolo $simboloAtual
             */
            $simboloAtual  = $this->list[$hash];

            if ($simboloAtual->getNome() == $nome) {
                return $simboloAtual;
            } else {
                while ($simboloAtual->getProximo() != null) {
                    $simboloAtual = $simboloAtual->getProximo();
                    if ($simboloAtual->getNome() == $nome) {
                        return $simboloAtual;
                    }
                }
            }
        } else {
            return $showError ? $this->errorMessage($nome) : false;
        }
    }

    //remove simbolo da tabela
    public function remove($nome, $nivel)
    {
        $hash = $this->hash($nome, self::TABLE_SIZE);
        if ($this->list[$hash] != null) {
            /**
             * @var Simbolo $simboloAtual
             */
            $simboloAtual  = $this->list[$hash];

            if ($simboloAtual->getNome() == $nome && $simboloAtual->getNivel() == $nivel) {
                $this->list[$hash] = $simboloAtual->getProximo();
                return true;
            } else {

                $simboloAnterior = $simboloAtual;
                $simboloAtual = $simboloAtual->getProximo();

                while ($simboloAtual->getNome() != $nome  && $simboloAtual->getNivel() != $nivel) {
                    $simboloAnterior = $simboloAtual;
                    $simboloAtual = $simboloAtual->getProximo();

                }
                if ($simboloAtual != null) {
                    $simboloAnterior->setProximo($simboloAtual->getProximo());
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    //remove simbolo da tabela
    public function removeByNivel($nivel)
    {
        foreach ($this->list as $key=>$simbol) {
            if($simbol && $simbol->getNivel() == $nivel){
                $this->list[$key]=null;
            }
        }
    }

    public function showList()
    {
        echo "<br><h4>Tabela Simbolos</h4>";
        echo "<table><thead><th>Nome</th><th>Categoria</th><th>Nivel</th><th>GeralA</th><th>GeralB</th><th>Tem Prox.</th></thead>";
        foreach ($this->list as $k => $item) {
            if ($item) {
                echo ($item);
            }
        }
        echo "</table>";
    }

    public function errorMessage($nome)
    {
        return "<h3>*Simbolo ({$nome}) não foi encontrado na tabela de simbolos.</h3>";
    }

    //tabela hash (*ord* - retorna o numero da tabela ASCII)
    private function hash($key, $tableSize)
    {
        $hashVal = 0;
        for ($i = 0; $i < strlen($key); $i++)
            $hashVal = 37 * $hashVal + ord($key[$i]);
        $hashVal %= $tableSize;
        if ($hashVal < 0)
            $hashVal += $tableSize;
        return $hashVal;
    }
}
