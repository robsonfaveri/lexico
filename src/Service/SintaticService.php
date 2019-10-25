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
    private $currentToken = null;
    private $previousToken = null;
    private $tokensLexico;
    private $contador;
    private $semanticService;

    public function __construct($tokens, SemanticService $semanticService)
    {
        $this->stack = new Stack();
        $this->contador = 0;
        $this->tokensLexico = $tokens;
        $this->semanticService = $semanticService;
    }


    //Inicia analise sintatica dos tokens
    public function analize()
    {
        //È ADICIONADO $(Fim de sentença) E O SIMBOLO INICIAL PARA A PILHA ONDE o S.I. IIRÁ COMEÇAR A DERIVAÇÂO
        $this->stack->add(Constants::DOLLAR);
        $this->stack->add(ParserConstant::START_SIMBOL);

        do {
            $this->currentToken = $this->nextToken();
            $retorno =$this->verify();
        }
        while(!$this->stack->isEmpty());
        return $retorno;
    }

    //METODO ONDE È VERIFICADO OS TOKENS SE ESTÃO VALIDOS CONFORME AS REGRAS SINTATICAS
    protected function verify()
    {
        //ADICIONADO $ AO ULTIMO TOKEN JÁ DA LISTA DE TOKEN JÀ QUE O LEXICO NÂO RETORNA O MESMO
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
            //SENDO CADEIA VAZIA O ITEM È REMOVIDO DA PILHA
            $this->stack->removeTop();
            return false;
        }
        else if ($this->isTerminal($branchCode)) {

            //SE TERMINAL E OS CODIGOS DOS TOKENS FOREM IGUAIS É REMOVIDO DA PILHA O TOKEN
            if ($branchCode == $lexicoCode) {
                $this->stack->removeTop();

                //SE A PILHA ESTÀ VAZIA E O ULTIMO TOKEN VERIFICADO FOI o $ FINALIZA
                if ($this->stack->isEmpty()) {
                    if($lexicoCode == Constants::DOLLAR){
                        return true;
                    }
                } else {
                    $this->previousToken = $this->currentToken;
                    $this->contador = $this->contador + 1;
                }
            } else {
                throw new SintaticError( ParserConstant::PARSER_ERROR[$branchCode]. " Não era esperado \"". $this->currentToken->getName() ."\" depois de ". $this->previousToken->getName(), $this->contador,$this->previousToken->getLineToken(), $this->currentToken->getName());
            }
        } else if ($this->isNoTerminal($branchCode)) {
            //SE NÂO FOR TERMINAL IRÁ DERIVAR ATÈ ACHAR O PROXIMO TERMINAL
            if ($this->ordenaRegras($branchCode, $lexicoCode)) {
                return false;
            } else {;
                if($this->contador == 0 ) {
                    throw new SintaticError('O codigo deve começar com o comando "program"', $this->contador, $this->currentToken->getLineToken());
                }elseif($branchCode == 59 && $this->currentToken->getLineToken() == null && $this->currentToken->getName() == '$' ){
                    throw new SintaticError('O codigo deve terminar com o comando "end."', $this->contador);
                }
                else{
                    throw new SintaticError(ParserConstant::PARSER_ERROR[$branchCode], $this->contador, $this->currentToken->getLineToken(), $this->currentToken->getName());
                }
            }
        } elseif($this->isSemantic($branchCode)){
                $valorSemantico = $branchCode - ParserConstant::FIRST_SEMANTIC_ACTION;
                $this->semanticService->exec($valorSemantico);

        }else{
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

    private function isSemantic($x)
    {
        return  $x > ParserConstant::FIRST_SEMANTIC_ACTION;
    }
}
