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
        $this->stack->add(ParserConstant::START_SIMBOL);

        do {
            $this->currentToken = $this->nextToken();
            dump($this->stack);
            dump($this->currentToken);
            $retorno = $this->verify();
        }
        while(!$this->stack->isEmpty());

        //while (!$this->verify());
        dd($retorno);
    }

    private function verify()
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
        dump($this->stack);
        dump($this->currentToken);
        dump($branchCode);
        dump($lexicoCode);

        if($branchCode === Constants::EPSILON){
            $this->stack->removeTop();
            return false;
        }
        else if ($this->isTerminal($branchCode)) {
            if ($branchCode == $lexicoCode) {

                if ($this->stack->isEmpty()) {
                    if($lexicoCode == Constants::DOLLAR){
                        dd('acabou');
                    }
                } else {
                    $this->previousToken = $this->currentToken;
                    $this->stack->removeTop();

                    $this->contador = $this->contador + 1;
                }
            } else {
                dd(ParserConstant::PARSER_ERROR[$branchCode], $branchCode, $lexicoCode, $this->contador, $this->stack);
                throw new SintaticError(ParserConstant::PARSER_ERROR[$branchCode], $this->currentToken->getName());
            }
        } else if ($this->isNoTerminal($branchCode)) {
            if ($this->ordenaRegras($branchCode, $lexicoCode)) {

                return false;
            } else {
                dd(ParserConstant::PARSER_ERROR[$branchCode]);
                throw new SintaticError(ParserConstant::PARSER_ERROR[$branchCode], $this->currentToken->getName());
            }
        } else {
            dd('para');
            if ($this->stack->isEmpty()) {
                return true;
            }

            return false;
        }
    }

    // Funcao retorna proximo token e atualiza contador
    private function nextToken()
    {
        $token = $this->tokensLexico[$this->contador] ? $this->tokensLexico[$this->contador] : null;
        return $token;
    }

    //Funcao responsavel por verificar as regras e ordenar para comparacao ao token atual
    private function ordenaRegras($topStack, $tokenInput)
    {
        $p = ParserConstant::PARSER_TABLE[$topStack - ParserConstant::FIRST_NON_TERMINAL][$tokenInput - 1];
        dump('parse'.$p);
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

    private function isSemanticAction($x)
    {
        return $x >= ParserConstant::FIRST_SEMANTIC_ACTION;
    }
}
