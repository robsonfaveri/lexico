<?php


namespace App\Service;



class SemanticService
{

    /** @var Stack $pilha  */
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

    public static $maxInst = 100;

    public static $maxList = 30;

    private $lastHash;

    private $lastProcedure;

    private $tipoIdentificador;

    private $possuiParametro;

    /** @var Stack $pilhaParametro  */
    private $pilhaParametro;

    /** @var Stack $pilhaParametro  */
    private $pilhaProcedures;

    /** @var Stack $pilhaFor  */
    private $pilhaFor;

    private $numeroParametro;

    private $numeroParametroEfetivo;

    /** @var Simbolo $identificadorAtual */
    private $identificadorAtual;

    /** @var Simbolo $identificadorAtual */
    private $identificadorForAtual;

    /** @var Stack $pilhaIFs  */
    private $pilhaIFs;

    private $contexto;



    public function exec($branchCode, $currentToken, $previousToken)
    {
       // dump($branchCode);
        switch ($branchCode) {

            case 100:
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
                $this->semanticAction109();
                break;
            case 110:
                $this->semanticAction110($previousToken, $currentToken);
                break;
            case 111:
                $this->semanticAction111();
                break;
            case 114:
                $this->semanticAction114($previousToken, $currentToken);
                break;
            case 115:
                $this->semanticAction115();
                break;
            case 116:
                $this->semanticAction116($previousToken);
                break;
            case 117:
                $this->semanticAction117($previousToken);
                break;
            case 118:
                $this->semanticAction118();
                break;
            case 120:
                $this->semanticAction120();
                break;
            case 121:
                $this->semanticAction121();
                break;
            case 122:
                $this->semanticAction122();
                break;
            case 128:
                $this->semanticAction128();
                break;
            case 129:
                $this->semanticAction129($previousToken, $currentToken);
                break;
            case 130:
                $this->semanticAction130($previousToken);
                break;
            case 131:
                $this->semanticAction131();
                break;
            case 137:
                $this->semanticAction137($previousToken);
                break;
            case 138:
                $this->semanticAction138();
                break;
            case 139:
                $this->semanticAction139($previousToken);
                break;
            case 140:
                $this->semanticAction140();
                break;
            case 141:
                $this->semanticAction141();
                break;
            case 142:
                $this->semanticAction142();
                break;
            case 143:
                $this->semanticAction143();
                break;
            case 144:
                $this->semanticAction144();
                break;
            case 145:
                $this->semanticAction145();
                break;
            case 146:
                $this->semanticAction146();
                break;
            case 147:
                $this->semanticAction147();
                break;
            case 148:
                $this->semanticAction148();
                break;
            case 149:
                $this->semanticAction149();
                break;
            case 150:
                $this->semanticAction150();
                break;
            case 151:
                $this->semanticAction151();
                break;
            case 152:
                $this->semanticAction152();
                break;
            case 153:
                $this->semanticAction153();
                break;
            case 154:
                $this->semanticAction154($previousToken);
                break;
            case 155:
                $this->semanticAction155();
                break;
            case 156:
                $this->semanticAction156();
                break;
            default:
                dump("DEFAULT");
                dump($branchCode);
               dump($this->areaInstrucoes);
                die;
        }
    }

    private function semanticAction100()
    {
        $this->pilha = new Stack();
        $this->pilhaParametro = new Stack();
        $this->pilhaProcedures = new Stack();
        $this->pilhaFor = new Stack();
        $this->pilhaIFs = new Stack();
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

    public function semanticAction101()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::PARA, 0, 0);
//        dd($this->areaInstrucoes);
    }

    public function semanticAction102()
    {
        $this->deslocamento = 3;
        $operacao2 = $this->deslocamento + $this->numeroVariaveis;


        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::AMEM, 0, $operacao2);
    }

    public function semanticAction104($previousToken)
    {
        $tokenName = $previousToken->getName();
        $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);

        if ($this->tipoIdentificador == Simbolo::VARIAVEL) {
            $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::VARIAVEL, $this->nivelAtual, $this->deslocamento, 0);
            $this->numeroVariaveis++;
            $this->deslocamento++;
        } elseif ($this->tipoIdentificador == Simbolo::PARAMETRO) {
            $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::PARAMETRO, $this->nivelAtual, 0, 0);
            $this->numeroParametro++;
            $this->pilhaParametro->add($this->tabelaSimbolo->list[$this->lastHash]);
        } else {
            die('erro 104');
        }
    }

    public function semanticAction105($previousToken)
    {
        $tokenName = $previousToken->getName();

        $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);
        if ($exist) {
            die('erro 105');
        } else {
            $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::CONSTANTE, $this->nivelAtual, 0, 0);
        }
    }

    public function semanticAction106($previousToken)
    {
        $tokenName = $previousToken->getName();
        $constante = $this->tabelaSimbolo->list[$this->lastHash];
        $constante->setGeralA($tokenName);
    }

    public function semanticAction107()
    {
        $this->tipoIdentificador = Simbolo::VARIAVEL;
        $this->numeroVariaveis = 0;
    }

    public function semanticAction108($previousToken)
    {
        $tokenName = $previousToken->getName();

        $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);
        if ($exist) {
            die('erro 108');
        } else {
            $this->lastProcedure = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::PROCEDURE, $this->nivelAtual, $this->areaInstrucoes->LC+1, 0);
            $this->nivelAtual++;
            $this->possuiParametro = false;
            $this->numeroParametro = 0;
            $this->deslocamento = 3;
            $this->numeroVariaveis = 0;
        }
    }

    public function semanticAction109()
    {
        if ($this->possuiParametro) {
            $procedure = $this->tabelaSimbolo->list[$this->lastProcedure];
            $procedure->setGeralB($this->numeroParametro);

            for ($i = 1; $i <= $this->numeroParametro; $i++) {

                /** @var Simbolo $parametro */
                $parametro = $this->pilhaParametro->getTop();

                $parametro->setGeralA($i*-1);
                $this->pilhaParametro->removeTop();
            }

            $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVS, 0, 0);
            $this->pilhaProcedures->add($this->areaInstrucoes->LC-1);
            $this->pilhaProcedures->add($this->numeroParametro);
        }
    }

    public function semanticAction110($previousToken,$currentToken)
    {
        $numeroParametro = $this->pilhaProcedures->getTop();
        $this->pilhaProcedures->removeTop();

        $valorLC = $this->pilhaProcedures->getTop();
        $this->pilhaProcedures->removeTop();

        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::RETU, 0, $numeroParametro);
        self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC);
        $this->tabelaSimbolo->removeByNivel($this->nivelAtual);
        $this->nivelAtual--;
    }

    public function semanticAction111()
    {
        $this->tipoIdentificador = Simbolo::PARAMETRO;
        $this->possuiParametro = true;
    }

    public function semanticAction114($previousToken, $currentToken)
    {
        $simbolo = $this->tabelaSimbolo->search($previousToken->getName());

        if ($simbolo != null) {
            if ($simbolo->getCategoria() == Simbolo::VARIAVEL) {
                $this->identificadorAtual = $simbolo;
            } else {
                dd('erro 114 não é variavel');
            }
        } else {
            dd('erro 114 não declarado');
        }
    }

    public function semanticAction115()
    {
        $operacao1 = $this->nivelAtual - $this->identificadorAtual->getNivel();
        $operacao2 = $this->identificadorAtual->getGeralA();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $operacao1, $operacao2);
    }

    public function semanticAction116($previousToken)
    {
        $simbolo = $this->tabelaSimbolo->search($previousToken->getName());

        if ($simbolo != null) {
            if ($simbolo->getCategoria() == Simbolo::PROCEDURE) {
                $this->identificadorAtual = $simbolo;
            } else {
                dd('erro 116 não é procedure');
            }
        } else {
            dd('erro 116 não declarado');
        }
    }

    public function semanticAction117($previousToken)
    {

        $simbolo = $this->tabelaSimbolo->search($this->identificadorAtual->getNome());

        if($simbolo->getGeralB() != $this->numeroParametroEfetivo){
           //dd($this->areaInstrucoes);
           die('erro 117');
       }else{

           $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CALL, 0, $this->identificadorAtual->getGeralA());
           $this->numeroParametroEfetivo = 0;
       }
    }

    public function semanticAction118()
    {
        $this->numeroParametroEfetivo++;
    }

    public function semanticAction120()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVF, 0, 0);
        $this->pilhaIFs->add($this->areaInstrucoes->LC-1);
    }

    public function semanticAction121()
    {
        $valorLC = $this->pilhaIFs->getTop();
        $this->pilhaIFs->removeTop();

        self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC);
    }

    public function semanticAction122()
    {
        $valorLC = $this->pilhaIFs->getTop();
        $this->pilhaIFs->removeTop();

        self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC+1);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVS, 0, 0);
        $this->pilhaIFs->add($this->areaInstrucoes->LC-1);
    }

    public function semanticAction128()
    {
        $this->contexto = 'readln';
    }

    public function semanticAction129($previousToken, $currentToken)
    {
        $simbolo = $this->tabelaSimbolo->search($previousToken->getName());
        if ($this->contexto == "readln") {
            if ($simbolo != null) {
                if ($simbolo->getCategoria() == Simbolo::VARIAVEL) {
                    $operacao1 = $this->nivelAtual - $simbolo->getNivel();
                    $operacao2 = $simbolo->getGeralA();
                    $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::LEIT, 0, 0);
                    $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $operacao1, $operacao2);
                } else {
                    dd('erro 129 nao e variavel');
                }
            } else {
                dd('erro 129 nao existe variavel');
            }
        } elseif ($this->contexto == "expressao") {
            if ($simbolo != null) {
                if ($simbolo->getCategoria() == Simbolo::PROCEDURE) {
                    dd('erro 129 simbolo e procedure');
                } else {
                    if ($simbolo->getCategoria() == Simbolo::CONSTANTE) {
                        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, $simbolo->getGeralA());
                    } else {
                        $d_nivel = $this->nivelAtual-$simbolo->getNivel();
                        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRVL, $d_nivel, $simbolo->getGeralA());
                    }
                }
            } else {
                dd('erro 129 nao existe variavel');
            }
        }
    }

    public function semanticAction130($previousToken)
    {
        self::incluirAL($this->areaLiterais, $previousToken->getName());
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::IMPRL, 0, $this->areaLiterais->LIT-1);

    }

    public function semanticAction131()
    {
       $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::IMPR, 0, 0);

    }


    public function semanticAction137($previousToken)
    {
        $simbolo = $this->tabelaSimbolo->search($previousToken->getName());

        if ($simbolo != null) {
            if ($simbolo->getCategoria() == Simbolo::VARIAVEL) {
                $this->identificadorForAtual = $simbolo;
            } else {
                dd('erro 137 não é variavel');
            }
        } else {
            dd('erro 137 não declarado');
        }
    }

    public function semanticAction138()
    {
        $operacao1 = $this->nivelAtual - $this->identificadorForAtual->getNivel();
        $operacao2 = $this->identificadorForAtual->getGeralA();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $operacao1, $operacao2);
    }

    public function semanticAction139($previousToken)
    {
        $this->pilhaFor->add($this->areaInstrucoes->LC);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::COPI, 0, 0);

        $operacao1 = $this->nivelAtual - $this->identificadorForAtual->getNivel();
        $operacao2 = $this->identificadorForAtual->getGeralA();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRVL, $operacao1, $operacao2);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMAI, 0, 0);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVF, 0, 0);
        $this->pilhaFor->add($this->areaInstrucoes->LC-1);
    }

    public function semanticAction140()
    {
        $operacao1 = $this->identificadorForAtual->getNivel();
        $operacao2 = $this->identificadorForAtual->getGeralA();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRVL, $operacao1, $operacao2);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, 1);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::SOMA, 0, 0);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $operacao1, $operacao2);
        self::alterarAI($this->areaInstrucoes, $this->pilhaFor->getTop(), 0, $this->areaInstrucoes->LC+1);
        $this->pilhaFor->removeTop();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVS, 0, $this->pilhaFor->getTop());
        $this->pilhaFor->removeTop();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::AMEM, 0, -1);

    }

    public function semanticAction141()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMIG, 0, 0);
    }

    public function semanticAction142()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMME, 0, 0);
    }


    public function semanticAction143()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMMA, 0, 0);
    }

    public function semanticAction144()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMAI, 0, 0);
    }

    public function semanticAction145()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMEI, 0, 0);
    }

    public function semanticAction146()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMDF, 0, 0);
    }


    public function semanticAction147()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::INVR, 0, 0);
    }

    public function semanticAction148()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::SOMA, 0, 0);
    }

    public function semanticAction149()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::SUBT, 0, 0);
    }

    public function semanticAction150()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DISJ, 0, 0);
    }

    public function semanticAction151()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::MULT, 0, 0);
    }

    public function semanticAction152()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DIV, 0, 0);
    }

    public function semanticAction153()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CONJ, 0, 0);
    }

    public function semanticAction154($previousToken)
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, $previousToken->getName());

    }

    public function semanticAction155()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::NEGA, 0, 0);
    }

    public function semanticAction156()
    {
        $this->contexto = 'expressao';
    }

    /**
     * Inicializa a área de instruções.
     */
    public static function inicializaAI(AreaInstrucoes $AI)
    {
        for ($i = 0; $i < self::$maxInst; $i++) {
            //começava de 1
            $AI->AI[$i]->codigo = -1;
            $AI->AI[$i]->op1 = -1;
            $AI->AI[$i]->op2 = -1;
        }
        $AI->LC = 0;
    }

    /**
     * Inicializa a área de literais
     */
    public static function inicializaAL(AreaLiterais $AL)
    {
        for ($i = 0; $i < self::$maxList; $i++) {
            $AL->AL[$i] = "";
            $AL->LIT = 0;
        }
    }

    /**
     * Inclui uma instrução na área de instruções utilizada pela máquina
     * hipotética.
     */
    public function incluirAI(AreaInstrucoes $AI, $c, $o1, $o2)
    {
        if ($AI->LC >= self::$maxInst) {
            $aux = false;
        } else {
            $aux = true;
            $AI->AI[$AI->LC]->codigo = $c;

            if ($o1 != -1) {
                $AI->AI[$AI->LC]->op1 = $o1;
            }

            if ($c == 24) {
                $AI->AI[$AI->LC]->op2 = $o2;
            }

            if ($o2 != -1) {
                $AI->AI[$AI->LC]->op2 = $o2;
            }

            $AI->LC = $AI->LC + 1;
        }
        return $aux;
    }

    /**
     * Altera uma instrução da área de instruções utilizada pela máquina
     * hipotética.
     */
    public static function alterarAI(AreaInstrucoes $AI, $s, $o1, $o2)
    {

        if ($o1 != -1) {
            $AI->AI[$s]->op1 = $o1;
        }

        if ($o2 != -1) {
            $AI->AI[$s]->op2 = $o2;
        }
    }

    /**
     * Inclui um literal na área de literais utilizada pela máquina
     * hipotética.
     */
    public static function incluirAL(AreaLiterais $AL, $literal)
    {
        if ($AL->LIT >= self::$maxList) {
            $aux = false;
        } else {
            $aux = true;
            $AL->AL[$AL->LIT] = $literal;
            $AL->LIT = $AL->LIT + 1;
        }
        return $aux;
    }

    /**
     * @return AreaInstrucoes
     */
    public function getAreaInstrucoes()
    {
        return $this->areaInstrucoes;
    }


    /**
     * @return AreaLiterais
     */
    public function getAreaLiterais()
    {
        return $this->areaLiterais;
    }



}
