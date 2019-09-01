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
        $this->stack->add(Constants::EPSILON);
        $this->currentToken = $this->nextToken();
        $retorno = $this->verify();
        $retorno = $this->verify();
        $retorno = $this->verify();
        $retorno = $this->verify();
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

        $x = $this->stack->getTop();
        $a = $this->currentToken->getCode();

        if ($x === Constants::EPSILON) {
            return false;
        } else if ($this->isTerminal($x)) {
            if ($x == $a) {

                if ($this->stack->isEmpty()) {
                    return true;
                } else {
                    $this->previousToken = $this->currentToken;
                    $this->currentToken = $this->nextToken();
                    return false;
                }
            } else {
                dd(ParserConstant::PARSER_ERROR[$x], $x, $a);
                throw new SintaticError(ParserConstant::PARSER_ERROR[$x], $this->currentToken->getName());
            }
        } else if ($this->isNoTerminal($x)) {
            if ($this->ordenaRegras($x, $a)) {
                return false;
            } else {
                dd(ParserConstant::PARSER_ERROR[$x]);
                throw new SintaticError(ParserConstant::PARSER_ERROR[$x], $this->currentToken->getName());
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
        $token = $this->tokensLexico[$this->contador] ? $this->tokensLexico[$this->contador] : null;
        $this->contador = $this->contador + 1;
        return $token;
    }

    //Funcao responsavel por verificar as regras e ordenar para comparacao ao token atual
    private function ordenaRegras($topStack, $tokenInput)
    {
        $p = ParserConstant::PARSER_TABLE[$topStack - ParserConstant::FIRST_NON_TERMINAL][$tokenInput - 1];
        if ($p >= 0) {
            $produtos = ParserConstant::PRODUCTIONS[$p];
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
