<?php


namespace App\Service;


class SemanticService
{

    private $pilha;

    private $tabelaSimbolo;

    private $instrucoes;

    private $literais;

    private $nivelAtual;

    private $ptLivre;

    private $escopo = [];

    private $numeroVariaveis;

    private $deslocamento;

    private $lc;

    private $lit;



    public function __construct()
    {
        $this->pilha = new Stack();
        $this->tabelaSimbolo = new TabelaSimbolos();
        $this->literais = [];
        $this->instrucoes = [];
        $this->nivelAtual = 0;
        $this->ptLivre = 1;
        $this->escopo[0] = 1;
        $this->numeroVariaveis = 0;
        $this->deslocamento = 3;
        $this->lc = 1;
        $this->lit = 1;

    }

    public function exec($branchCode)
    {
        switch ($branchCode){
            case  100 :
                break;
            case 101:
                


        }
    }
}