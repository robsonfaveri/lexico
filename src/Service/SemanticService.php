<?php


namespace App\Service;



class SemanticService
{

    private $pilha;

    /** @var TabelaSimbolos $tabelaSimbolo */
    public $tabelaSimbolo;

    /** @var AreaInstrucoes $areaInstrucoes */
    private $areaInstrucoes;

    private $areaLiterais;

    private $nivelAtual;

    private $ptLivre;

    private $escopo = [];

    private $numeroVariaveis;

    private $deslocamento;

    private $lc;

    private $lit;

    public static $maxInst=100;

    public static $maxList=30;

    private $lastHash;

    private $tipoIdentificador;

    private $possuiParametro;

    /** @var Stack $pilhaParametro  */
    private $pilhaParametro;

    /** @var Stack $pilhaParametro  */
    private $pilhaProcedures;

    private $numeroParametro;



    public function exec($branchCode,$currentToken,$previousToken)
    {
        switch ($branchCode){

            case  100 :
                $this->semanticAction100();
                break;
            case 101:
                $this->semanticAction101();
                break;
            case 102:
                $this->semanticAction102();
                break;
            case 104:
                $this->semanticAction104($previousToken);
                break;
            case 105:
                $this->semanticAction105($previousToken);
                break;
            case 106:
                $this->semanticAction106($previousToken);
                break;
            case 107:
                $this->semanticAction107();
                break;
            case 108:
                $this->semanticAction108($previousToken);
                break;
            case 109:
                $this->semanticAction109($previousToken);
                break;
            case 111:
                $this->semanticAction111();
                break;
            default:  dump($branchCode);dump($this->areaInstrucoes);die;
                


        }
    }

    private function semanticAction100(){
        $this->pilha = new Stack();
        $this->pilhaParametro = new Stack();
        $this->pilhaProcedures = new Stack();
        $this->tabelaSimbolo = new TabelaSimbolos();
        $this->areaLiterais = new AreaLiterais();
        $this->areaInstrucoes = new AreaInstrucoes(self::$maxInst);
        $this->nivelAtual = 0;
        $this->ptLivre = 1;
        $this->escopo[0] = 1;
        $this->numeroVariaveis = 0;
        $this->deslocamento = 3;
        $this->lc = 1;
        $this->lit = 1;
        self::inicializaAI($this->areaInstrucoes);
        self::inicializaAL($this->areaLiterais);
    }

    public function semanticAction101(){
        $this->incluirAI($this->areaInstrucoes,AreaInstrucoes::PARA,0,0);
        dump($this->areaInstrucoes);
    }

    public function semanticAction102(){
        $this->deslocamento = 3;
        $operacao2 = $this->deslocamento + $this->numeroVariaveis;

        $this->incluirAI($this->areaInstrucoes,AreaInstrucoes::AMEM,0, $operacao2);
    }

    public function semanticAction104($previousToken){
        $tokenName = $previousToken->getName();
        $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);

            if($this->tipoIdentificador == 'VAR') {
                $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, 'VAR', $this->nivelAtual, $this->deslocamento, 0);
                $this->numeroVariaveis++;
                $this->deslocamento++;
            }elseif($this->tipoIdentificador == 'PAR'){
                $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, 'PAR', $this->nivelAtual, 0, 0);
                $this->numeroParametro++;
                $this->pilhaParametro->add($this->tabelaSimbolo->list[$this->lastHash]);
            }else{
                die('erro 104');
            }

    }

    public function semanticAction105($previousToken){
        $tokenName = $previousToken->getName();

        $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);
        if($exist){
            die('erro 105');
        }else{
           $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, 'CONST', $this->nivelAtual, 0, 0);
        }
    }

    public function semanticAction106($previousToken){
        $tokenName = $previousToken->getName();
        $constante = $this->tabelaSimbolo->list[$this->lastHash];
        $constante->setGeralA($tokenName);
    }

    public function semanticAction107(){
        $this->tipoIdentificador = 'VAR';
        $this->numeroVariaveis = 0;
    }

    public function semanticAction108($previousToken){
        $tokenName = $previousToken->getName();

        $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);
        if($exist){
            die('erro 108');
        }else{
            $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, 'PROC', $this->nivelAtual, 0, 0);
            $this->nivelAtual++;
            $this->possuiParametro = false;
            $this->numeroParametro = 0;
            $this->deslocamento = 3;
        }

    }

    public function semanticAction109($previousToken){
        if($this->possuiParametro){
            $procedure = $this->tabelaSimbolo->list[$this->lastHash];
            $procedure->setGeralB($this->numeroParametro);

            for ($i = 1; $i <= $this->numeroParametro; $i++) {

                /** @var Simbolo $parametro */
                $parametro = $this->pilhaParametro->getTop();
                $parametro->setGeralA( -($this->numeroParametro - $i));
            }

            $this->incluirAI($this->areaInstrucoes,AreaInstrucoes::DSVS,0,0);
            $this->pilhaProcedures->add($this->areaInstrucoes->LC);
            $this->pilhaProcedures->add($this->numeroParametro);
        }

    }

    public function semanticAction111(){
            $this->tipoIdentificador = 'PAR';
            $this->possuiParametro = true;
    }

    /**
     * Inicializa a área de instruções.
    */
    public static function inicializaAI(AreaInstrucoes $AI){
        for ($i=0;$i<self::$maxInst;$i++){
            //começava de 1
            $AI->AI[$i]->codigo= -1;
            $AI->AI[$i]->op1= -1;
            $AI->AI[$i]->op2= -1;
        }
        $AI->LC=0;
    }

    /**
     * Inicializa a área de literais
     */
    public static function inicializaAL(AreaLiterais $AL){
        for ($i=0;$i<self::$maxList;$i++){
            $AL->AL[$i]="";
            $AL->LIT=0;
        }
    }

    /**
     * Inclui uma instrução na área de instruções utilizada pela máquina
     * hipotética.
     */
	  public function incluirAI(AreaInstrucoes $AI, $c, $o1, $o2) {
	  	if($AI->LC>=self::$maxInst)
        {
            $aux=false;
        }
        else
        {
            $aux=true;
            $AI->AI[$AI->LC]->codigo=$c;

            if($o1 != -1){
                $AI->AI[$AI->LC]->op1=$o1;
            }

            if($c==24){
                $AI->AI[$AI->LC]->op2=$o2;
            }

            if($o2!=-1){
                $AI->AI[$AI->LC]->op2=$o2;
            }

            $AI->LC=$AI->LC+1;
        }
	  	return $aux;
	  }

    /**
    * Altera uma instrução da área de instruções utilizada pela máquina
    * hipotética.
    */
    public static function alterarAI(AreaInstrucoes $AI, $s, $o1, $o2){

        if ($o1!=-1){
            $AI->AI[$s]->op1=$o1;
        }

        if($o2!=-1){
            $AI->AI[$s]->op2=$o2;
        }
    }

    /**
     * Inclui um literal na área de literais utilizada pela máquina
     * hipotética.
     */
      public static function incluirAL(AreaLiterais $AL, $literal){
            if ($AL->LIT>=self::$maxList){
                $aux=false;
            }else{
                $aux=true;
                $AL->AL[$AL->LIT]=$literal;
                $AL->LIT=$AL->LIT+1;
            }
            return $aux;
      }
}