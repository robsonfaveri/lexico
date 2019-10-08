<?php


namespace App\Service;


class Simbolo
{
    public $nome;
    public $categoria;
    public $nivel;
    public $geralA;
    public $geralB;

    /**
     * @var Simbolo
     */
    public $proximo;

    public function __construct($nome, $categoria, $nivel, $geralA, $geralB)
    {
        $this->nome = $nome;
        $this->categoria = $categoria;
        $this->nivel = $nivel;
        $this->geralA = $geralA;
        $this->geralB = $geralB;
    }



    public function edit($label, $value)
    {
        switch ($label) {
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
            default:
                return false;
        }

        return true;
    }

    /**
     * @param mixed $toString
     * @return Simbolo
     */
    public function __toString()
    {
        return "</tr><td>" . $this->nome . " </td><td>" . $this->categoria . " </td><td>" . $this->nivel . " </td><td>" . $this->geralA . "</td><td>" . $this->geralB . "</td><td>" . ($this->getProximo() ? "S" : "N") . "</td></tr>";
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return Simbolo
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     * @return Simbolo
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @param mixed $nivel
     * @return Simbolo
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGeralA()
    {
        return $this->geralA;
    }

    /**
     * @param mixed $geralA
     * @return Simbolo
     */
    public function setGeralA($geralA)
    {
        $this->geralA = $geralA;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGeralB()
    {
        return $this->geralB;
    }

    /**
     * @param mixed $geralB
     * @return Simbolo
     */
    public function setGeralB($geralB)
    {
        $this->geralB = $geralB;
        return $this;
    }

    /**
     * @return Simbolo
     */
    public function getProximo()
    {
        return $this->proximo;
    }

    /**
     * @param Simbolo $proximo
     * @return Simbolo
     */
    public function setProximo (Simbolo $proximo = null)
    {
        $this->proximo = $proximo;
        return $this;
    }
}
