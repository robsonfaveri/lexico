<?php


namespace App\Service;

use App\Service\Simbolo;
use App\Exception\TableError;
use Exception;

class TabelaSimbolos
{

    const TABLE_SIZE = 3011;


    public $list;


    public function __construct($size = null)
    {
        $this->list = new \SplFixedArray($size ? $size : self::TABLE_SIZE);
    }

    public function adiciona($nome, $categoria, $nivel, $geralA, $geralB)
    {
        $simbolo = $this->search($nome);
        if (!$simbolo) {
            $hash = $this->hash($nome, self::TABLE_SIZE);
            $this->list[$hash] = new Simbolo($nome, $categoria, $nivel, $geralA, $geralB);
        } else {
            while ($simbolo->getProximo() != null) {
                $simbolo = $simbolo->getProximo();
            }
            $simbolo->setProximo(new Simbolo($nome, $categoria, $nivel, $geralA, $geralB));
        }
    }

    public function editar($nome,$nivel, $label, $value)
    {
        $simbolo = $this->searchNameAndNivel($nome, $nivel);
        if ($simbolo) {
            return $simbolo->edit($label, $value);
        } else {
            return false;
        }
    }

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
        } else {
            return $showError ? $this->errorMessage($nome) : false;
        }
    }

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
                while ($simboloAtual->getNome() != $nome  && $simboloAtual->getNivel() == $nivel) {
                    $simboloAnterior = $simboloAtual;
                    $simboloAtual = $simboloAtual->getProximo();
                }
                if ($simboloAtual != null) {
                    $simboloAnterior->setProximo($simboloAtual);
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
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
