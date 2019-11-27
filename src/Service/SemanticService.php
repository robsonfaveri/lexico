<?php


namespace App\Service;

use App\Exception\SemanticError;

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

    private $numeroVariaveis;

    private $deslocamento;

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

    /** @var Stack $pilhaWhile  */
    private $pilhaWhile;

    /** @var Stack $pilhaRepeat  */
    private $pilhaRepeat;

    /** @var Stack $pilhaCase  */
    private $pilhaCase;

    /** @var Stack $pilhaCaseFinal  */
    private $pilhaCaseFinal;

    /** @var Stack $pilhaCaseAux  */
    private $pilhaCaseFinalAux;

    private $contexto;

    private $currentToken;

    public function exec($branchCode, $currentToken, $previousToken, $oldToken)
    {
        $this->currentToken = $currentToken;
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
                $this->semanticAction110();
                break;
            case 111:
                $this->semanticAction111();
                break;
            case 114:
                $this->semanticAction114($previousToken);
                break;
            case 115:
                $this->semanticAction115();
                break;
            case 116:
                $this->semanticAction116($previousToken);
                break;
            case 117:
                $this->semanticAction117();
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
            case 123:
                $this->semanticAction123();
                break;
            case 124:
                $this->semanticAction124();
                break;
            case 125:
                $this->semanticAction125();
                break;
            case 126:
                $this->semanticAction126();
                break;
            case 127:
                $this->semanticAction127();
                break;
            case 128:
                $this->semanticAction128();
                break;
            case 129:
                $this->semanticAction129($previousToken);
                break;
            case 130:
                $this->semanticAction130($previousToken);
                break;
            case 131:
                $this->semanticAction131();
                break;
            case 132:
                $this->semanticAction132();
                break;
            case 133:
                $this->semanticAction133();
                break;
            case 134:
                $this->semanticAction134($oldToken);
                break;
            case 135:
                $this->semanticAction135();
                break;
            case 136:
                $this->semanticAction136($oldToken);
                break;
            case 137:
                $this->semanticAction137($previousToken);
                break;
            case 138:
                $this->semanticAction138();
                break;
            case 139:
                $this->semanticAction139();
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

    //UTILIZADO PARA INICIALIZAR VARIAVEIS, ARRAYS E PILHAS QUE SERÂO UTILIZADAS
    private function semanticAction100()
    {
        $this->pilha = new Stack();
        $this->pilhaParametro = new Stack();
        $this->pilhaProcedures = new Stack();
        $this->pilhaFor = new Stack();
        $this->pilhaIFs = new Stack();
        $this->pilhaWhile = new Stack();
        $this->pilhaRepeat = new Stack();
        $this->pilhaCase = new Stack();
        $this->pilhaCaseFinal = new Stack();
        $this->pilhaCaseFinalAux = new Stack();
        $this->tabelaSimbolo = new TabelaSimbolos();
        $this->areaLiterais = new AreaLiterais();
        $this->areaInstrucoes = new AreaInstrucoes(self::$maxInst);
        $this->nivelAtual = 0;
        $this->numeroVariaveis = 0;
        $this->deslocamento = 3;
        self::inicializaAI($this->areaInstrucoes);
        self::inicializaAL($this->areaLiterais);
    }


    //INCLUINDO INSTRUCAO "PARA" NA AREA DE INSTRUCAO
    public function semanticAction101()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::PARA, 0, 0);
    }

    //INCLUIDO A INSTRUCAO "AMEM" NA AREA DE INSTRUCOES DEIXANDO 3 POSICOES RESERVADAS
    //  SOMANDO O NUMERO DE VARIAVEIS QUE CONTEM NO ESCOPO
    public function semanticAction102()
    {
        $this->deslocamento = 3;
        $operacao2 = $this->deslocamento + $this->numeroVariaveis;
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::AMEM, 0, $operacao2);
    }


    //INSERIDO NA TABELA DE SIMBOLO OS PARAMETROS E VARIAVEIS CONFORME O NIVEL ATUAL QUE O PROGRAMA OU PROCEDIMENTO SE ENCONTRA
    public function semanticAction104($previousToken)
    {
        $tokenName = $previousToken->getName();
        if ($this->tipoIdentificador == Simbolo::VARIAVEL) {
            $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);
            if($exist){
                throw new SemanticError("Erro semântico, Variavel já declarada, ação 104", 104, $this->currentToken->getLineToken());
            }else {
                $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::VARIAVEL, $this->nivelAtual, $this->deslocamento, 0);
                $this->numeroVariaveis++;
                $this->deslocamento++;
            }
        } elseif ($this->tipoIdentificador == Simbolo::PARAMETRO) {
            $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);
            if($exist){
                throw new SemanticError("Erro semântico, parametro já declarado, ação 104", 104, $this->currentToken->getLineToken());
            }else {
                $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::PARAMETRO, $this->nivelAtual, 0, 0);
                $this->numeroParametro++;
                $this->pilhaParametro->add($this->tabelaSimbolo->list[$this->lastHash]);
            }
        } else {
            throw new SemanticError("Erro semântico, identificador não reconhecido, ação 104", 104, $this->currentToken->getLineToken());
        }
    }

    //ADICIONA CONSTANTE CONFORME O ESCOPO QUE ELA PERTENCE
    public function semanticAction105($previousToken)
    {
        $tokenName = $previousToken->getName();
        $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);
        if ($exist) {
            throw new SemanticError("Erro semântico, constante já declarada, ação 105", 105, $this->currentToken->getLineToken());
        } else {
            $this->lastHash = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::CONSTANTE, $this->nivelAtual, 0, 0);
        }
    }

    //ALTERA VALOR REFENTE DA CONST SALVO NA 105
    public function semanticAction106($previousToken)
    {
        $tokenName = $previousToken->getName();
        $constante = $this->tabelaSimbolo->list[$this->lastHash];
        $constante->setGeralA($tokenName);
    }

    //SETA QUE OS IDENTIFICADORES A SEREM DECLARADOS SÂO VARIAVEIS
    // E ZERA A VARIAVEL QUE GUARDA O NUMERO DE VARIAVEIS PARA GARANTIR QUE NÂO TENHA MAIS VARIAVEIS QUE O ESPERADO
    public function semanticAction107()
    {
        $this->tipoIdentificador = Simbolo::VARIAVEL;
        $this->numeroVariaveis = 0;
    }


    //ADICIONA PROCEDURE A TABELA DE SIMBOLOS CASO ELA NÂO EXISTA E SALVA SEU HASH PARA PROXIMAS ACOES
    //ATUALIZA NIVEL E ZERA VARIAVEIS PARA SEREM USADAS NO ESCOPO DA PROCEDURE
    public function semanticAction108($previousToken)
    {
        $tokenName = $previousToken->getName();
        $exist = $this->tabelaSimbolo->searchNameAndNivel($tokenName, $this->nivelAtual);
        if ($exist) {
            throw new SemanticError("Erro semântico, Procedure já declarada, ação 108", 108, $this->currentToken->getLineToken());
        } else {
            $this->lastProcedure = $this->tabelaSimbolo->adiciona($tokenName, Simbolo::PROCEDURE, $this->nivelAtual, $this->areaInstrucoes->LC + 1, 0);
            $this->nivelAtual++;
            $this->possuiParametro = false;
            $this->numeroParametro = 0;
            $this->deslocamento = 3;
            $this->numeroVariaveis = 0;
        }
    }

    //CASO A PROCEDURE TENHA PARAMETRO ATUALIZA o NUMERO DE PARAMETRO QUE ELA POSSUI NA TABELA DE SIMBOLOS E ATUALIZANDO A PILHA DE PARAMETROS
    //ADICIONA A INSTRUÇÂO DSVS E GUARDA NA PILHA DE PROCEDURES O LC E NUMERO DE PARAMETROS PARA USO NA ACAO 110
    public function semanticAction109()
    {
        if ($this->possuiParametro) {
            $procedure = $this->tabelaSimbolo->list[$this->lastProcedure];
            $procedure->setGeralB($this->numeroParametro);

            for ($i = 1; $i <= $this->numeroParametro; $i++) {

                /** @var Simbolo $parametro */
                $parametro = $this->pilhaParametro->getTop();

                $parametro->setGeralA($i * -1);
                $this->pilhaParametro->removeTop();
            }

            $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVS, 0, 0);
            $this->pilhaProcedures->add($this->areaInstrucoes->LC - 1);
            $this->pilhaProcedures->add($this->numeroParametro);
        }
    }

    //FINALIZA A PROCEDURE, INSERE A INTRUCAO RETU COM O NUMERO DE PARAMETRO GUARDADO NA 110,
    //ALTERA O DSVS DA 110 PARA O LC ATUAL, REMOVE TODOS O INDICADORES DO ESCOPO DA PROCEDURE ATUAL E  ATUALIZA O NIVEL
    public function semanticAction110()
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

    //CLASSIFICA O IDENTIFICADOR ENCONTRADO COMO UM PARAMETRO E INFORMA QUE A PROSSEDURE POSSUI PARAMETRO
    public function semanticAction111()
    {
        $this->tipoIdentificador = Simbolo::PARAMETRO;
        $this->possuiParametro = true;
    }

    //COM BASE NO TOKEN VERIFICA SE ELE EXISTE NA TABELA DE SIMBOLOS E SE È UMA VARIAVEL,
    // ADICIONANDO UM UMA VARIAVEL DE CONTROLE CASO VERDADEIRO
    public function semanticAction114($previousToken)
    {
        $simbolo = $this->tabelaSimbolo->search($previousToken->getName());

        if ($simbolo != null) {
            if ($simbolo->getCategoria() == Simbolo::VARIAVEL) {
                $this->identificadorAtual = $simbolo;
            } else {
                throw new SemanticError("Erro semântico, não é variavel, ação 114", 114, $this->currentToken->getLineToken());
            }
        } else {
            throw new SemanticError("Erro semântico, variavel não foi declarada, ação 114", 114, $this->currentToken->getLineToken());
        }
    }

    //ADICIONA A INSTRUÇAO ARMZ A AREA DE INSTRUÇOES USANDO A DIFERENCA ENTRE NIVEL ATUAL E O NIVEL DO IDENTIFICADOR ATUAL
    public function semanticAction115()
    {
        $operacao1 = $this->nivelAtual - $this->identificadorAtual->getNivel();
        $operacao2 = $this->identificadorAtual->getGeralA();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $operacao1, $operacao2);
    }

    //VERIFICA COM BASE NO TOKEN ATUAL SE ELE EXISTE NA TABELA DE SIMBOLO E VERIFICA SE É UMA PROCEDURE
    // ADICIONANDO A MESMA A UMA VARIAVEL DE CONTROLE CASO VERDADEIRO
    public function semanticAction116($previousToken)
    {
        $simbolo = $this->tabelaSimbolo->search($previousToken->getName());
        if ($simbolo != null) {
            if ($simbolo->getCategoria() == Simbolo::PROCEDURE) {
                $this->identificadorAtual = $simbolo;
            } else {
                throw new SemanticError("Erro semântico, não é procedure, ação 116", 116, $this->currentToken->getLineToken());
            }
        } else {
            throw new SemanticError("Erro semântico, não foi declarado, ação 116", 116, $this->currentToken->getLineToken());
        }
    }

    //IMPLEMENTAÇÂO DA INSTRUCAO CALL, CASO O NUMERO DE PARAMETROS DA PROCEDURE ENCONTRADA NA 116
    // FOR DIFERENTE DOS PARAMETROS PASSADOS NO CALL GERA ERRO
    // SENAO GERA CALL APONTANDO PARA O INDICADOR SALVO EM GERALA DA PROCEDURE EM 108 e ZERA O NUMERO DE PARAMETROS EFETIVOS
    public function semanticAction117()
    {
        $simbolo = $this->tabelaSimbolo->search($this->identificadorAtual->getNome());
        if ($simbolo->getGeralB() != $this->numeroParametroEfetivo) {
            //dd($this->areaInstrucoes);
            throw new SemanticError("Erro semântico, ação 117", 117, $this->currentToken->getLineToken());
        } else {

            $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CALL, 0, $this->identificadorAtual->getGeralA());
            $this->numeroParametroEfetivo = 0;
        }
    }

    //INCREMENTA O NUMERO DE PARAMETRO EFETIVO, QUE È O USADO NA CHAMADA DO PARAMETRO
    public function semanticAction118()
    {
        $this->numeroParametroEfetivo++;
    }

    //ADICIONA A INSTRUCAO DSVF PARA O IF E SALVA A POSISAO NA AREA DE INSTRUCAO DE DSVF
    public function semanticAction120()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVF, 0, 0);
        $this->pilhaIFs->add($this->areaInstrucoes->LC - 1);
    }

    //COMPLETA A INSTRUÇÂO DSVS SALVO NA 122
    public function semanticAction121()
    {
        $valorLC = $this->pilhaIFs->getTop();
        $this->pilhaIFs->removeTop();

        self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC);
    }

    //RESOLVE O DSVF DO 120 E INCLUI O DSVS NA AREA DE INSTRUÇOES
    public function semanticAction122()
    {
        $valorLC = $this->pilhaIFs->getTop();
        $this->pilhaIFs->removeTop();

        self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC + 1);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVS, 0, 0);
        $this->pilhaIFs->add($this->areaInstrucoes->LC - 1);
    }

    //SALVA O VALOR DE LC NA PILHA PARA PODER RETORNAR PARA O PONTO ATUAL NO WHILE
    public function semanticAction123()
    {
        $this->pilhaWhile->add($this->areaInstrucoes->LC);
    }

    //ADICIONA A AREA DE INSTRUÇOES O DSVF E ADICIONA SUA POSICAO NA PILHA
    public function semanticAction124()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVF, 0, 0);
        $this->pilhaWhile->add($this->areaInstrucoes->LC - 1);
    }

    //RESOLVE o DSVF da 124 E INCLI DSVS COM VALOR SALVO EM 123 PARA RETORNO
    public function semanticAction125()
    {
        $valorLC = $this->pilhaWhile->getTop();
        $this->pilhaWhile->removeTop();

        self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC + 1);

        $valorLC = $this->pilhaWhile->getTop();
        $this->pilhaWhile->removeTop();

        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVS, 0, $valorLC);
    }

    //SALVA VALOR DA POSICAO ATUAL DA AI PARA USO POSTERIOR PARA RETORNO
    public function semanticAction126()
    {
        $this->pilhaRepeat->add($this->areaInstrucoes->LC);
    }

    //GERA DSVF USANDO O INDICE SALVO em 126
    public function semanticAction127()
    {
        $valorLC = $this->pilhaRepeat->getTop();
        $this->pilhaRepeat->removeTop();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVF, 0, $valorLC);
    }

    public function semanticAction128()
    {
        $this->contexto = 'readln';
    }

    //VERIFICA SE CONTEXTO FOR DE READLN ADD A AREA DE INTRUÇÂO LEIT E ARMZ CONFORME O NIVEL DO TOKEN ATUAL COM O A DIFERENCA ENTRE O NIVEL ATUAL
    //CASO EXPRESSAO CARREVA VALOR DE CONSTANTE OU VARIAVEL SALVO NA TALEBA DE SIMBOLO
    public function semanticAction129($previousToken)
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
                    throw new SemanticError("Erro semântico, não é variavel, ação 129", 129, $this->currentToken->getLineToken());
                }
            } else {
                throw new SemanticError("Erro semântico, não existe variavel, ação 129", 129, $this->currentToken->getLineToken());
            }
        } elseif ($this->contexto == "expressao") {
            if ($simbolo != null) {
                if ($simbolo->getCategoria() == Simbolo::PROCEDURE) {
                    throw new SemanticError("Erro semântico, identificador inválido, ação 129", 129, $this->currentToken->getLineToken());
                } else {
                    if ($simbolo->getCategoria() == Simbolo::CONSTANTE) {
                        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, $simbolo->getGeralA());
                    } else {
                        $d_nivel = $this->nivelAtual - $simbolo->getNivel();
                        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRVL, $d_nivel, $simbolo->getGeralA());
                    }
                }
            } else {
                throw new SemanticError("Erro semântico, não existe variavel, ação 129", 129, $this->currentToken->getLineToken());
            }
        }
    }

    //GERA IMPRL NA AREA DE INSTRUÇÔES E USA A POSIÇÂO EM QUE O LITERAL FOI SALVO NA AREA DE LITERAIS
    public function semanticAction130($previousToken)
    {
        self::incluirAL($this->areaLiterais, $previousToken->getName());
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::IMPRL, 0, $this->areaLiterais->LIT - 1);
    }

    //GERA IMPR NA AREA DE INTRUÇOES
    public function semanticAction131()
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::IMPR, 0, 0);
    }

    public function semanticAction132()
    {
        //não utilizado

    }

    //FINALIZAÇÂO DO CASE EM QUESTAO, ALTERADO Os DSVS SALVO EM 135 E INCLUI AMEM A AREA DE INSTRUCAO
    public function semanticAction133()
    {
        while (!$this->pilhaCaseFinal->isEmpty()) {
            $valorLC = $this->pilhaCaseFinal->getTop();
            $this->pilhaCaseFinal->removeTop();

            self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC);
        }
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::AMEM, 0, -1);
    }


    //GERA INSTRUCOES DO PARA O CASE E ALTERA OS DSVTs SALVOS NA PILHA, INCLUI O DSVF NA PILHA
    public function semanticAction134($oldToken)
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::COPI, 0, 0);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, $oldToken->getName());
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMIG, 0, 0);

        while (!$this->pilhaCase->isEmpty()) {
            $valorLC = $this->pilhaCase->getTop();
            $this->pilhaCase->removeTop();

            self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC + 1);
        }

        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVF, 0, 0);
        $this->pilhaCaseFinalAux->add($this->areaInstrucoes->LC - 1);
    }

    //RESOLVE DSVF DO 134 E insere intrução DSVS
    public function semanticAction135()
    {
        $valorLC = $this->pilhaCaseFinalAux->getTop();
        $this->pilhaCaseFinalAux->removeTop();

        self::alterarAI($this->areaInstrucoes, $valorLC, 0, $this->areaInstrucoes->LC + 1);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVS, 0, 0);
        $this->pilhaCaseFinal->add($this->areaInstrucoes->LC - 1);
    }

    //GERA INSTRUÇÔES neCESSARIA PARA A ACAO ATUAL RELATIVO AO case GERA O DSVT QUE SERA TRATADO NO 134
    public function semanticAction136($oldToken)
    {
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::COPI, 0, 0);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, $oldToken->getName());
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMIG, 0, 0);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVT, 0, 0);
        $this->pilhaCase->add($this->areaInstrucoes->LC - 1);
    }

    //VERIFICA SE TOKEN ATUAL ESTÀ NA TABELA DE SIMBOLO, SE SIM, ADICIONA IDENTIFICADOR ATUAL DE CONTROLE DE FOR
    public function semanticAction137($previousToken)
    {
        $simbolo = $this->tabelaSimbolo->search($previousToken->getName());

        if ($simbolo != null) {
            if ($simbolo->getCategoria() == Simbolo::VARIAVEL) {
                $this->identificadorForAtual = $simbolo;
            } else {
                throw new SemanticError("Erro semântico, não é variavel, ação 137", 137, $this->currentToken->getLineToken());
            }
        } else {
            throw new SemanticError("Erro semântico, não foi declarado, ação 137", 137, $this->currentToken->getLineToken());
        }
    }

    //ADICIONA INSTRUCAO ARMZ COM DADOS DO INDENTIFICADOR SALVO NO 137
    public function semanticAction138()
    {
        $operacao1 = $this->nivelAtual - $this->identificadorForAtual->getNivel();
        $operacao2 = $this->identificadorForAtual->getGeralA();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $operacao1, $operacao2);
    }

    //ADICIONA INDICE ATUAL DA AREA DE INSTRUCAO a PILHA DE FOR ,
    // E ADICIONA INTRUÇOES NECESSARIAS  PARA O FOR , INCLUSIVE O DSVF E INCLUI SUA POSIÇÂO A PILHA DE FOR
    public function semanticAction139()
    {
        $this->pilhaFor->add($this->areaInstrucoes->LC);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::COPI, 0, 0);

        $operacao1 = $this->nivelAtual - $this->identificadorForAtual->getNivel();
        $operacao2 = $this->identificadorForAtual->getGeralA();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRVL, $operacao1, $operacao2);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CMAI, 0, 0);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::DSVF, 0, 0);
        $this->pilhaFor->add($this->areaInstrucoes->LC - 1);
    }

    //AO FINAL DO FOR INSERE AS INTRUCOES NECESSARIAS PARA O CONTROLE DO FOR,
    // COMPLETANDO DSVF , ADICIONANDO o DSVS, COM VALORE DA PILHA DE FOR E ADICIONA O AMEM
    public function semanticAction140()
    {
        $operacao1 = $this->identificadorForAtual->getNivel();
        $operacao2 = $this->identificadorForAtual->getGeralA();
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRVL, $operacao1, $operacao2);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::CRCT, 0, 1);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::SOMA, 0, 0);
        $this->incluirAI($this->areaInstrucoes, AreaInstrucoes::ARMZ, $operacao1, $operacao2);
        self::alterarAI($this->areaInstrucoes, $this->pilhaFor->getTop(), 0, $this->areaInstrucoes->LC + 1);
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
