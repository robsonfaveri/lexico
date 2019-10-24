/* Generated from Java with JSweet 2.2.0-SNAPSHOT - http://www.jsweet.org */
/**
 * Classe utilizada pela classe "Hipotetica" para armazenar as informac��es
 * de uma instrucao.
 * Esta classe, bem como as classes "AreaInstrucoes", "AreaLiterais"
 * e "Hipotetica" foi criada por Maicon, Reinaldo e Fabio e adaptada
 * para este aplicativo.
 * @class
 */
var Tipos = (function () {
    function Tipos() {
        if (this.codigo === undefined)
            this.codigo = 0;
        if (this.op1 === undefined)
            this.op1 = 0;
        if (this.op2 === undefined)
            this.op2 = 0;
        this.codigo = 0;
        this.op1 = 0;
        this.op2 = 0;
    }
    return Tipos;
}());
Tipos["__class"] = "Tipos";
/**
 * Classe utilizada pela classe "Hipotetica" para armazenar a ��rea de
 * instruc��es.
 * Esta classe, bem como as classes "Tipos", "AreaLiterais"
 * e "Hipotetica" foi criada por Maicon, Reinaldo e Fabio e adaptada
 * para este aplicativo.
 * @class
 */
var AreaInstrucoes = (function () {
    function AreaInstrucoes() {
        this.AI = (function (s) { var a = []; while (s-- > 0)
            a.push(null); return a; })(1000);
        if (this.LC === undefined)
            this.LC = 0;
        for (var i = 0; i < 1000; i++) {
            {
                this.AI[i] = new Tipos();
            }
            ;
        }
    }
    return AreaInstrucoes;
}());
AreaInstrucoes["__class"] = "AreaInstrucoes";
/**
 * Classe utilizada pela classe "Hipotetica" para armazenar a ��rea de
 * literais.
 * Esta classe, bem como as classes "Tipos", "AreaInstrucoes"
 * e "Hipotetica" foi criada por Maicon, Reinaldo e Fabio e adaptada
 * para este aplicativo.
 * @class
 */
var AreaLiterais = (function () {
    function AreaLiterais() {
        this.AL = (function (s) { var a = []; while (s-- > 0)
            a.push(null); return a; })(30);
        if (this.LIT === undefined)
            this.LIT = 0;
    }
    return AreaLiterais;
}());
AreaLiterais["__class"] = "AreaLiterais";
/**
 * Classe que implementa a m��quina hipot��tica.
 * Esta classe, bem como as classes "Tipos", "AreaInstrucoes"
 * e "AreaLiterais" foi criada por Maicon, Reinaldo e Fabio e adaptada
 * para este aplicativo.
 * @class
 */
var Hipotetica = (function () {
    function Hipotetica() {
        Hipotetica.num_impr = 0;
    }
    Hipotetica.S_$LI$ = function () { if (Hipotetica.S == null)
        Hipotetica.S = (function (s) { var a = []; while (s-- > 0)
            a.push(0); return a; })(1000); return Hipotetica.S; };
    ;
    /**
     * Inicializa a ��rea de instruc��es.
     * @param {AreaInstrucoes} AI
     */
    Hipotetica.InicializaAI = function (AI) {
        for (var i = 0; i < Hipotetica.MaxInst; i++) {
            {
                AI.AI[i].codigo = -1;
                AI.AI[i].op1 = -1;
                AI.AI[i].op2 = -1;
            }
            ;
        }
        AI.LC = 0;
    };
    /**
     * Inicializa a ��rea de literais
     * @param {AreaLiterais} AL
     */
    Hipotetica.InicializaAL = function (AL) {
        for (var i = 0; i < Hipotetica.MaxList; i++) {
            {
                AL.AL[i] = "";
                AL.LIT = 0;
            }
            ;
        }
    };
    /**
     * Inclui uma instrucao na ��rea de instruc��es utilizada pela m��quina
     * hipot��tica.
     * @param {AreaInstrucoes} AI
     * @param {number} c
     * @param {number} o1
     * @param {number} o2
     * @return {boolean}
     */
    Hipotetica.prototype.IncluirAI = function (AI, c, o1, o2) {
        var aux;
        if (AI.LC >= Hipotetica.MaxInst) {
            aux = false;
        }
        else {
            aux = true;
            AI.AI[AI.LC].codigo = c;
            if (o1 !== -1) {
                AI.AI[AI.LC].op1 = o1;
            }
            if (c === 24) {
                AI.AI[AI.LC].op2 = o2;
            }
            if (o2 !== -1) {
                AI.AI[AI.LC].op2 = o2;
            }
            AI.LC = AI.LC + 1;
        }
        return aux;
    };
    /**
     * Altera uma instrucao da ��rea de instruc��es utilizada pela m��quina
     * hipot��tica.
     * @param {AreaInstrucoes} AI
     * @param {number} s
     * @param {number} o1
     * @param {number} o2
     */
    Hipotetica.AlterarAI = function (AI, s, o1, o2) {
        if (o1 !== -1) {
            AI.AI[s].op1 = o1;
        }
        if (o2 !== -1) {
            AI.AI[s].op2 = o2;
        }
    };
    /**
     * Inclui um literal na ��rea de literais utilizada pela m��quina
     * hipot��tica.
     * @param {AreaLiterais} AL
     * @param {string} literal
     * @return {boolean}
     */
    Hipotetica.IncluirAL = function (AL, literal) {
        var aux;
        if (AL.LIT >= Hipotetica.MaxList) {
            aux = false;
        }
        else {
            aux = true;
            AL.AL[AL.LIT] = literal;
            AL.LIT = AL.LIT + 1;
        }
        return aux;
    };
    /**
     * Utilizada para determinar a base.
     * @return {number}
     */
    Hipotetica.Base = function () {
        var b1;
        b1 = Hipotetica.b;
        while ((Hipotetica.l > 0)) {
            {
                b1 = Hipotetica.S_$LI$()[b1];
                Hipotetica.l = Hipotetica.l - 1;
            }
        }
        ;
        return b1;
    };
    /**
     * Respons��vel por interpretar as instruc��es.
     * @param {AreaInstrucoes} AI
     * @param {AreaLiterais} AL
     */
    Hipotetica.Interpreta = function (AI, AL) {
        Hipotetica.topo = 0;
        Hipotetica.b = 0;
        Hipotetica.p = 0;
        Hipotetica.S_$LI$()[1] = 0;
        Hipotetica.S_$LI$()[2] = 0;
        Hipotetica.S_$LI$()[3] = 0;
        Hipotetica.operador = 0;
        var leitura;
        while ((Hipotetica.operador !== 26)) {
            {
                Hipotetica.operador = AI.AI[Hipotetica.p].codigo;
                Hipotetica.l = AI.AI[Hipotetica.p].op1;
                Hipotetica.a = AI.AI[Hipotetica.p].op2;
                Hipotetica.p = Hipotetica.p + 1;
                switch ((Hipotetica.operador)) {
                    case 1:
                        Hipotetica.p = Hipotetica.S_$LI$()[Hipotetica.b + 2];
                        Hipotetica.topo = Hipotetica.b - Hipotetica.a - 1;
                        Hipotetica.b = Hipotetica.S_$LI$()[Hipotetica.b + 1];
                        break;
                    case 2:
                        Hipotetica.topo = Hipotetica.topo + 1;
                        Hipotetica.S_$LI$()[Hipotetica.topo] = Hipotetica.S_$LI$()[Hipotetica.Base() + Hipotetica.a];
                        break;
                    case 3:
                        Hipotetica.topo = Hipotetica.topo + 1;
                        Hipotetica.S_$LI$()[Hipotetica.topo] = Hipotetica.a;
                        break;
                    case 4:
                        Hipotetica.S_$LI$()[Hipotetica.Base() + Hipotetica.a] = Hipotetica.S_$LI$()[Hipotetica.topo];
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 5:
                        Hipotetica.S_$LI$()[Hipotetica.topo - 1] = Hipotetica.S_$LI$()[Hipotetica.topo - 1] + Hipotetica.S_$LI$()[Hipotetica.topo];
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 6:
                        Hipotetica.S_$LI$()[Hipotetica.topo - 1] = Hipotetica.S_$LI$()[Hipotetica.topo - 1] - Hipotetica.S_$LI$()[Hipotetica.topo];
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 7:
                        Hipotetica.S_$LI$()[Hipotetica.topo - 1] = Hipotetica.S_$LI$()[Hipotetica.topo - 1] * Hipotetica.S_$LI$()[Hipotetica.topo];
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 8:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo] === 0) {
                            console.info("Divisao por zero.Erro durante a execucao");
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = (Hipotetica.S_$LI$()[Hipotetica.topo - 1] / Hipotetica.S_$LI$()[Hipotetica.topo] | 0);
                            Hipotetica.topo = Hipotetica.topo - 1;
                        }
                        break;
                    case 9:
                        Hipotetica.S_$LI$()[Hipotetica.topo] = -Hipotetica.S_$LI$()[Hipotetica.topo];
                        break;
                    case 10:
                        Hipotetica.S_$LI$()[Hipotetica.topo] = 1 - Hipotetica.S_$LI$()[Hipotetica.topo];
                        break;
                    case 11:
                        if ((Hipotetica.S_$LI$()[Hipotetica.topo - 1] === 1) && (Hipotetica.S_$LI$()[Hipotetica.topo] === 1)) {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 1;
                        }
                        else {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 0;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 12:
                        if ((Hipotetica.S_$LI$()[Hipotetica.topo - 1] === 1 || Hipotetica.S_$LI$()[Hipotetica.topo] === 1)) {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 1;
                        }
                        else {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 0;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 13:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo - 1] < Hipotetica.S_$LI$()[Hipotetica.topo]) {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 1;
                        }
                        else {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 0;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 14:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo - 1] > Hipotetica.S_$LI$()[Hipotetica.topo]) {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 1;
                        }
                        else {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 0;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 15:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo - 1] === Hipotetica.S_$LI$()[Hipotetica.topo]) {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 1;
                        }
                        else {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 0;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 16:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo - 1] !== Hipotetica.S_$LI$()[Hipotetica.topo]) {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 1;
                        }
                        else {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 0;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 17:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo - 1] <= Hipotetica.S_$LI$()[Hipotetica.topo]) {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 1;
                        }
                        else {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 0;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 18:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo - 1] >= Hipotetica.S_$LI$()[Hipotetica.topo]) {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 1;
                        }
                        else {
                            Hipotetica.S_$LI$()[Hipotetica.topo - 1] = 0;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 19:
                        Hipotetica.p = Hipotetica.a;
                        break;
                    case 20:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo] === 0) {
                            Hipotetica.p = Hipotetica.a;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 21:
                        Hipotetica.topo = Hipotetica.topo + 1;
                        console.log("Leitura");
                        window.prompt("Informe o valor:",leitura)
                        (Hipotetica.S_$LI$()[Hipotetica.topo]) = parseInt(leitura);
                        break;
                    case 22:
                        console.info("" + Hipotetica.S_$LI$()[Hipotetica.topo] + "Informacao");
                        Hipotetica.topo = Hipotetica.topo - 1;
                        break;
                    case 23:
                        if (Hipotetica.a >= AL.LIT) {
                            console.info("Literal nao encontrado na \ufffd\ufffdrea dos literais.Erro durante a execucao");
                        }
                        else {
                            console.info("" + AL.AL[Hipotetica.a] + "Informacao");
                        }
                        break;
                    case 24:
                        Hipotetica.topo = Hipotetica.topo + Hipotetica.a;
                        break;
                    case 25:
                        var base = Hipotetica.Base();
                        Hipotetica.S_$LI$()[Hipotetica.topo + 1] = base;
                        Hipotetica.S_$LI$()[Hipotetica.topo + 2] = Hipotetica.b;
                        Hipotetica.S_$LI$()[Hipotetica.topo + 3] = Hipotetica.p;
                        Hipotetica.b = Hipotetica.topo + 1;
                        Hipotetica.p = Hipotetica.a;
                        break;
                    case 26:
                        break;
                    case 27:
                        break;
                    case 28:
                        Hipotetica.topo = Hipotetica.topo + 1;
                        Hipotetica.S_$LI$()[Hipotetica.topo] = Hipotetica.S_$LI$()[Hipotetica.topo - 1];
                        break;
                    case 29:
                        if (Hipotetica.S_$LI$()[Hipotetica.topo] === 1) {
                            Hipotetica.p = Hipotetica.a;
                        }
                        Hipotetica.topo = Hipotetica.topo - 1;
                }
            }
        }
        ;
    };
    /*private*/ Hipotetica.mostraAreaDados = function () {
        for (var i = Hipotetica.topo; i >= 0; i--) {
            {
                console.info(i + "[" + Hipotetica.S_$LI$()[i] + "]");
            }
            ;
        }
    };
    return Hipotetica;
}());
Hipotetica.MaxInst = 1000;
Hipotetica.MaxList = 30;
Hipotetica.b = 0;
Hipotetica.topo = 0;
Hipotetica.p = 0;
Hipotetica.l = 0;
Hipotetica.a = 0;
Hipotetica.operador = 0;
Hipotetica.k = 0;
Hipotetica.num_impr = 0;
Hipotetica["__class"] = "Hipotetica";
Hipotetica.S_$LI$();
