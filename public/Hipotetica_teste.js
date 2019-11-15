$(() => {
    $("#btn-compilar").on("click", function () {
        let instrucoes = JSON.parse($(this).attr("data-instrucoes"));
        let literais = JSON.parse($(this).attr("data-literais"));
        console.log("COMPILANDO...", literais);
        MaquinaHipotetica.interpretar(instrucoes, literais);
    });
});



var MaquinaHipotetica = (function () {
    function MaquinaHipotetica() {
        MaquinaHipotetica.nv = MaquinaHipotetica.np = MaquinaHipotetica.num_impr = 0;
    }
    MaquinaHipotetica.S_$LI$ = function () {
        if (MaquinaHipotetica.S == null)
            MaquinaHipotetica.S = (function (s) {
                var a = []; while (s-- > 0)
                    a.push(0); return a;
            })(1000); return MaquinaHipotetica.S;
    };
    ;

    MaquinaHipotetica.baseLiteral = function () {
        var b1 = MaquinaHipotetica.b;
        while ((MaquinaHipotetica.l > 0)) {
            {
                b1 = MaquinaHipotetica.S_$LI$()[b1];
                MaquinaHipotetica.l -= 1;
            }
        }
        ;
        return b1;
    };
    MaquinaHipotetica.interpretar = function (AI, AL) {
        MaquinaHipotetica.topo = 0;
        MaquinaHipotetica.b = 0;
        MaquinaHipotetica.p = 0;
        MaquinaHipotetica.S_$LI$()[1] = 0;
        MaquinaHipotetica.S_$LI$()[2] = 0;
        MaquinaHipotetica.S_$LI$()[3] = 0;
        MaquinaHipotetica.operador = 0;

        while ((MaquinaHipotetica.operador !== 26)) {
            {
                MaquinaHipotetica.operador = AI.AI[MaquinaHipotetica.p].codigo;
                // console.warn("OPERACAO", MaquinaHipotetica.operador);
                // console.warn("TESTE", MaquinaHipotetica.S_$LI$());
                MaquinaHipotetica.l = AI.AI[MaquinaHipotetica.p].op1;
                MaquinaHipotetica.a = AI.AI[MaquinaHipotetica.p].op2;
                MaquinaHipotetica.p += 1;
                switch ((MaquinaHipotetica.operador)) {
                    case 1:
                        MaquinaHipotetica.p = MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.b + 2)];
                        MaquinaHipotetica.topo = MaquinaHipotetica.b - MaquinaHipotetica.a;
                        MaquinaHipotetica.b = MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.b + 1)];
                        break;
                    case 2:
                        MaquinaHipotetica.topo += 1;
                        MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] = MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.baseLiteral() + MaquinaHipotetica.a)];
                        break;
                    case 3:
                        MaquinaHipotetica.topo += 1;
                        MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] = parseInt(MaquinaHipotetica.a);
                        break;
                    case 4:
                        MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.baseLiteral() + MaquinaHipotetica.a)] = MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo];
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 5:
                        MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] += MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo];
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 6:
                        MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] -= MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo];
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 7:
                        MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] *= MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo];
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 8:
                        if (MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] === 0) {
                            console.error("Divisão por zero. - Erro durante a execução");
                            alert("Divisão por zero. - Erro durante a execução");
                        }
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = (function (n) { return n < 0 ? Math.ceil(n) : Math.floor(n); })(MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] / MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo]);
                            MaquinaHipotetica.topo -= 1;
                        }
                        break;
                    case 9:
                        MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] = (-MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo]);
                        break;
                    case 10:
                        MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] = (1 - MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo]);
                        break;
                    case 11:
                        if ((MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] === 1) && (MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] === 1)) {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 1;
                        }
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 0;
                            MaquinaHipotetica.topo -= 1;
                        }
                        break;
                    case 12:
                        if ((MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] === 1) || (MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] === 1)) {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 1;
                        }
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 0;
                            MaquinaHipotetica.topo -= 1;
                        }
                        break;
                    case 13:
                        if (MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] < MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo])
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 1;
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 0;
                        }
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 14:
                        if (MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] > MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo])
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 1;
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 0;
                        }
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 15:
                        if (MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] === MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo])
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 1;
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 0;
                        }
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 16:
                        if (MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] !== MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo])
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 1;
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 0;
                        }
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 17:
                        if (MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] <= MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo])
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 1;
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 0;
                        }
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 18:
                        if (MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] >= MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo])
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 1;
                        else {
                            MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)] = 0;
                        }
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 19:
                        MaquinaHipotetica.p = MaquinaHipotetica.a;
                        break;
                    case 20:
                        if (MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] === 0) {
                            MaquinaHipotetica.p = MaquinaHipotetica.a;
                        }
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 21:
                        MaquinaHipotetica.topo += 1;
                        let leitura = window.prompt("Informe o valor:");
                        MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] = parseInt(leitura);
                        break;
                    case 22:
                        console.info("[SYS_Informação]: " + MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo]);
                        alert("[SYS_Informação]: " + MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo]);
                        MaquinaHipotetica.topo -= 1;
                        break;
                    case 23:
                        if (MaquinaHipotetica.a >= AL.LIT)
                            console.error("Literal não encontrado na área dos literais. - Erro durante a execução");
                        else {
                            console.info("[SYS_Informação]: " + AL.AL[MaquinaHipotetica.a]);
                            alert("[SYS_Informação]: " + AL.AL[MaquinaHipotetica.a]);
                        }
                        break;
                    case 24:
                        MaquinaHipotetica.topo += MaquinaHipotetica.a;
                        break;
                    case 25:
                        MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo + 1)] = MaquinaHipotetica.baseLiteral();
                        MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo + 2)] = MaquinaHipotetica.b;
                        MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo + 3)] = MaquinaHipotetica.p;
                        MaquinaHipotetica.b = MaquinaHipotetica.topo + 1;
                        MaquinaHipotetica.p = MaquinaHipotetica.a;
                        break;
                    case 26:
                        break;
                    case 27:
                        break;
                    case 28:
                        MaquinaHipotetica.topo += 1;
                        MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] = MaquinaHipotetica.S_$LI$()[(MaquinaHipotetica.topo - 1)];
                        break;
                    case 29:
                        if (MaquinaHipotetica.S_$LI$()[MaquinaHipotetica.topo] === 1) {
                            MaquinaHipotetica.p = MaquinaHipotetica.a;
                        }
                        MaquinaHipotetica.topo -= 1;
                }
            }
        }
        ;
    };
    return MaquinaHipotetica;
}());
MaquinaHipotetica.MaxInst = 1000;
MaquinaHipotetica.MaxList = 30;
MaquinaHipotetica.b = 0;
MaquinaHipotetica.topo = 0;
MaquinaHipotetica.p = 0;
MaquinaHipotetica.l = 0;
MaquinaHipotetica.a = 0;
MaquinaHipotetica.nv = 0;
MaquinaHipotetica.np = 0;
MaquinaHipotetica.operador = 0;
MaquinaHipotetica.k = 0;
MaquinaHipotetica.i = 0;
MaquinaHipotetica.num_impr = 0;
MaquinaHipotetica["__class"] = "MaquinaHipotetica";
MaquinaHipotetica.S_$LI$();
