<?php


namespace App\Service;


class SemanticService
{

    private $pilha;

    private $tabelaSimbolo;

    private $areaInstrucoes;

    private $areaLiterais;

    private $nivelAtual;

    private $ptLivre;

    private $escopo = [];

    private $numeroVariaveis;

    private $deslocamento;

    private $lc;

    private $lit;

    public static $maxInst=1000;

    public static $maxList=30;



    public function exec($branchCode)
    {
        switch ($branchCode){
            case  100 :
                $this->semanticAction100();
                break;
            case 101:
                $this->semanticAction101();
                break;
                


        }
    }

    private function semanticAction100(){
        $this->pilha = new Stack();
        $this->tabelaSimbolo = new TabelaSimbolos();
        $this->areaLiterais = new AreaLiterais();
        $this->areaInstrucoes = new AreaInstrucoes();
        $this->nivelAtual = 0;
        $this->ptLivre = 1;
        $this->escopo[0] = 1;
        $this->numeroVariaveis = 0;
        $this->deslocamento = 3;
        $this->lc = 1;
        $this->lit = 1;
        self::inicializaAI($this->areaLiterais);
        self::inicializaAL($this->areaInstrucoes);
    }

    public function semanticAction101(){
        $this->incluirAI($this->areaInstrucoes,AreaInstrucoes::PARA,0,0);
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