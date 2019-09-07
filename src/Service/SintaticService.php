<?php


namespace App\Service;


use App\Entity\Token;
use App\Service\Stack;
use App\Constants\Constants;
use App\Constants\ParserConstant;
use App\Exception\SintaticError;

class SintaticService
{
    private $stack;
    private $constants;
    private $parseConstants;
    private $currentToken = null;
    private $previousToken = null;
    private $tokensLexico;
    private $contador;
    private $semanticAnalyser;

    public function __construct($tokens)
    {
        $this->stack = new Stack();
        $this->contador = 0;
        $this->tokensLexico = $tokens;
    }


    //Inicia analise sintatica dos tokens
    public function analize()
    {
        $this->stack->add(Constants::DOLLAR);
        $this->stack->add(ParserConstant::START_SIMBOL);

        do {
            $this->currentToken = $this->nextToken();
            $retorno =$this->verify();
        }
        while(!$this->stack->isEmpty());
        return $retorno;
    }

    protected function verify()
    {
        if ($this->currentToken == null) {
            $position = 0;
            if ($this->previousToken != null) {
                $position = strlen($this->previousToken->getDescription());
            }
            $this->currentToken = new Token("$", Constants::DOLLAR, $position);
        }



        $branchCode = $this->stack->getTop();
        $lexicoCode = $this->currentToken->getCode();
        if($branchCode === Constants::EPSILON){
            $this->stack->removeTop();
            return false;
        }
        else if ($this->isTerminal($branchCode)) {
            if ($branchCode == $lexicoCode) {
                $this->stack->removeTop();
                if ($this->stack->isEmpty()) {
                    if($lexicoCode == Constants::DOLLAR){
                        return true;
                    }
                } else {
                    $this->previousToken = $this->currentToken;


                    $this->contador = $this->contador + 1;
                }
            } else {
                throw new SintaticError( ParserConstant::PARSER_ERROR[$branchCode]. "Não era esperado ". $this->currentToken->getName() ." depois de ". $this->previousToken->getName(), $this->contador,$this->previousToken->getLineToken(), $this->currentToken->getName());
            }
        } else if ($this->isNoTerminal($branchCode)) {
            if ($this->ordenaRegras($branchCode, $lexicoCode)) {

                return false;
            } else {
                throw new SintaticError( ParserConstant::PARSER_ERROR[$branchCode], $this->contador,$this->currentToken->getLineToken(), $this->currentToken->getName());
            }
        } else {
            if ($this->stack->isEmpty()) {
                return true;
            }

            return false;
        }
    }

    // Funcao retorna proximo token e atualiza contador
    private function nextToken()
    {
        $token = count($this->tokensLexico)  > $this->contador ? $this->tokensLexico[$this->contador] : null;
        return $token;
    }

    //Funcao responsavel por verificar as regras e ordenar para comparacao ao token atual
    protected function ordenaRegras($topStack, $tokenInput)
    {
        $p = ParserConstant::PARSER_TABLE[$topStack - ParserConstant::FIRST_NON_TERMINAL][$tokenInput - 1];
        if ($p >= 0) {
            $produtos = ParserConstant::PRODUCTIONS[$p];
            $this->stack->removeTop();
            for ($i = count($produtos) - 1; $i >= 0; $i--) {
                $this->stack->add($produtos[$i]);
            }
            return true;
        } else {
            return false;
        }
    }


    private function isTerminal($x)
    {
        return $x < ParserConstant::FIRST_NON_TERMINAL ? true : false;
    }

    private function isNoTerminal($x)
    {
        return $x >= ParserConstant::FIRST_NON_TERMINAL && $x < ParserConstant::FIRST_SEMANTIC_ACTION;
    }
}
