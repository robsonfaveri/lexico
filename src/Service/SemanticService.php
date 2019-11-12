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

    public static $maxInst = 100;

    public static $maxList = 30;

    private $lastHash;

    private $tipoIdentificador;

    private $possuiParametro;

    /** @var Stack $pilhaParametro  */
    private $pilhaParametro;

    /** @var Stack $pilhaParametro  */
    private $pilhaProcedures;

    private $numeroParametro;

    /** @var Simbolo $identificadorAtual */
    private $identificadorAtual;

    private $contexto;



    public function exec($branchCode, $currentToken, $previousToken)
    {
        switch ($branchCode) {

            case  100:
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
            case 129:
                $this->semanticAction129($previousToken, $currentToken);
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
            $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::PROCEDURE, $this->nivelAtual, 0, 0);
            $this->nivelAtual++;
            $this->possuiParametro = false;
            $this->numeroParametro = 0;
            $this->deslocamento = 3;
        }
    }

    public function semanticAction109()
    {
        if ($this->possuiParametro) {
            $procedure = $this->tabelaSimbolo->list[$this->lastHash];
            $procedure->setGeralB($this->numeroParametro);

            for ($i = 1; $i <= $this->numeroParametro; $i++) {

                /** @var Simbolo $parametro */
                $parametro = $this->pilhaParametro->getTop();
                $parametro->setGeralA(-($this->numeroParametro - $i));
            }

            $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVS, 0, 0);
            $this->pilhaProcedures->add($this->areaInstrucoes->LC);
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
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $this->identificadorAtual->getNivel(), $this->identificadorAtual->getGeralA());
    }


    public function semanticAction129($previousToken, $currentToken)
    {
        $simbolo = $this->tabelaSimbolo->search($previousToken->getName());
        if ($this->contexto == "readln") {
            if ($simbolo != null) {
                if ($simbolo->getCategoria() == Simbolo::VARIAVEL) {
                    $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::LEIT, 0, 0);
                    $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $simbolo->getNivel(), $simbolo->getGeralA());
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
                        dump(129);
                        dd($previousToken);
                        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, $previousToken);
                    } else {
                        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRVL, 0, $this->deslocamento);
                    }
                }
            } else {
                dd('erro 129 nao existe variavel');
            }
        }
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
        dump(154);dd($previousToken);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, $previousToken);

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
}
