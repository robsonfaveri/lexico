/**
 * Classe que implementa a m��quina hipot��tica.
 * Esta classe, bem como as classes "Tipos", "AreaInstrucoes"
 * e "AreaLiterais" foi criada por Maicon, Reinaldo e Fabio e adaptada
 * para este aplicativo.
 * @class
 */

$(() => {
   $("#btn-compilar").on("click",function(){
      let instrucoes = JSON.parse($(this).attr("data-instrucoes"));
      let literais = JSON.parse($(this).attr("data-literais"));
      console.log("COMPILANDO...",literais);
      Hipotetica.Interpreta(instrucoes,literais);
   });
});

var Hipotetica = (function () {
    console.log("CARREGOU");
    function Hipotetica() {
        Hipotetica.num_impr = 0;
    }
    Hipotetica.S_$LI$ = function () { if (Hipotetica.S == null)
        Hipotetica.S = (function (s) { var a = []; while (s-- > 0)
            a.push(0); return a; })(1000); return Hipotetica.S; };
    ;

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
                        leitura = window.prompt("Informe o valor:",leitura);
                        console.log("Leitura",parseInt(leitura));
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
