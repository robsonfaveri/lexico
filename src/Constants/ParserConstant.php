<?php


namespace App\Constants;


class ParserConstant
{
    const START_SIMBOL = 46;

    const FIRST_NON_TERMINAL = 46;

    const FIRST_SEMANTIC_ACTION = 77;

    const PARSER_TABLE =
        [
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, -1, -1, 1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 1, -1, -1, -1, -1, -1, -1, 1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 2, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, 4, -1, -1, 3, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 8, -1, -1, 5, -1, -1, -1, -1, -1, -1, -1, -1, -1, 8, -1, -1, -1, -1, -1, -1, 8, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 7, -1, -1, -1, 6, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 6, -1, -1, -1, -1, -1, -1, 6, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 12, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 12, -1, -1, -1, -1, -1, -1, 9, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 11, -1, -1, -1, 10, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 10, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 13, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 15, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 14, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, 16, -1, -1, -1, 17, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 18, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, 20, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 19, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, 23, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 21, -1, -1, -1, 22, 24, 43, -1, -1, -1, 23, 49, 29, -1, -1, -1, -1, -1, -1, 34, 33, -1, -1, 23, -1, 32, 38],
            [-1, -1, 25, -1, -1, -1, 26, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 25, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 25, -1, -1, -1],
            [-1, 28, -1, -1, -1, -1, -1, 27, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, 31, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 30, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 30, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 35, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, 37, -1, -1, -1, -1, -1, 36, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, 40, -1, -1, -1, 40, 40, -1, -1, -1, -1, -1, -1, 40, 40, 39, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 40, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, 42, -1, -1, -1, -1, -1, 41, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 44, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, 45, -1, -1, 46, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, 48, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 47, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, 50, -1, -1, -1, 50, 50, -1, -1, -1, -1, -1, -1, 50, 50, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 50, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, 51, 51, -1, -1, -1, -1, 51, -1, -1, -1, -1, 53, 54, 56, 55, 57, 52, -1, -1, -1, -1, -1, -1, -1, -1, 51, -1, 51, -1, -1, -1, -1, 51, -1, -1, -1, -1, -1, 51, 51, 51, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, 60, -1, -1, -1, 59, 58, -1, -1, -1, -1, -1, -1, 60, 60, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 60, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, 64, 64, -1, -1, -1, -1, 64, -1, -1, 62, 61, 64, 64, 64, 64, 64, 64, -1, -1, -1, -1, -1, -1, -1, -1, 64, -1, 64, -1, -1, -1, -1, 64, 63, -1, -1, -1, -1, 64, 64, 64, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, 65, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 65, 65, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 65, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1],
            [-1, 66, 66, -1, -1, -1, -1, 66, 67, 68, 66, 66, 66, 66, 66, 66, 66, 66, -1, -1, -1, 69, -1, -1, -1, -1, 66, -1, 66, -1, -1, -1, -1, 66, 66, -1, -1, -1, -1, 66, 66, 66, -1, -1, -1],
            [-1, -1, -1, -1, -1, -1, 71, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 73, 70, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 72, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1]
        ];

    const PRODUCTIONS =
        [
            [37, 19, 3, 47, 4],
            [50, 52, 55, 57],
            [19, 49],
            [0],
            [2, 19, 49],
            [26, 19, 18, 20, 3, 51],
            [0],
            [19, 18, 20, 3, 51],
            [0],
            [43, 48, 5, 54, 3, 53],
            [0],
            [48, 5, 54, 3, 53],
            [0],
            [32],
            [36, 19, 56, 3, 47, 3, 55],
            [0],
            [0],
            [7, 48, 5, 32, 8],
            [23, 59, 58, 29],
            [0],
            [3, 59, 58],
            [19, 6, 70],
            [57],
            [0],
            [24, 19, 60],
            [0],
            [7, 70, 61, 8],
            [0],
            [2, 70, 61],
            [31, 70, 40, 59, 62],
            [0],
            [28, 59],
            [44, 70, 27, 59],
            [39, 59, 42, 70],
            [38, 7, 63, 64, 8],
            [19],
            [0],
            [2, 63, 64],
            [45, 7, 65, 66, 8],
            [21],
            [70],
            [0],
            [2, 65, 66],
            [25, 70, 34, 67, 29],
            [20, 68, 5, 59, 69],
            [2, 20, 68],
            [0],
            [0],
            [3, 67],
            [30, 19, 6, 70, 41, 70, 27, 59],
            [72, 71],
            [0],
            [18, 72],
            [13, 72],
            [14, 72],
            [16, 72],
            [15, 72],
            [17, 72],
            [12, 74, 73],
            [11, 74, 73],
            [74, 73],
            [12, 74, 73],
            [11, 74, 73],
            [35, 74, 73],
            [0],
            [76, 75],
            [0],
            [9, 76, 75],
            [10, 76, 75],
            [22, 76, 75],
            [20],
            [7, 70, 8],
            [33, 76],
            [63]
        ];

    const PARSER_ERROR =
        [
        "",
        "Era esperado fim de programa",
        "Era esperado \",\"",
        "Era esperado \";\"",
        "Era esperado \".\"",
        "Era esperado \":\"",
        "Era esperado \":=\"",
        "Era esperado \"(\"",
        "Era esperado \")\"",
        "Era esperado \"*\"",
        "Era esperado \"/\"",
        "Era esperado \"-\"",
        "Era esperado \"+\"",
        "Era esperado \"<\"",
        "Era esperado \">\"",
        "Era esperado \"<=\"",
        "Era esperado \">=\"",
        "Era esperado \"<>\"",
        "Era esperado \"=\"",
        "Era esperado id",
        "Era esperado inteiro",
        "Era esperado literal",
        "Era esperado and",
        "Era esperado begin",
        "Era esperado call",
        "Era esperado case",
        "Era esperado const",
        "Era esperado do",
        "Era esperado else",
        "Era esperado end",
        "Era esperado for",
        "Era esperado if",
        "Era esperado integer",
        "Era esperado not",
        "Era esperado of",
        "Era esperado or",
        "Era esperado procedure",
        "Era esperado program",
        "Era esperado readln",
        "Era esperado repeat",
        "Era esperado then",
        "Era esperado to",
        "Era esperado until",
        "Era esperado var",
        "Era esperado while",
        "Era esperado writeln",
        "<PROGRAMA> inválido",
        "<BLOCO> inválido",
        "<LID> inválido",
        "<REPID> inválido",
        "<DCLCONST> inválido",
        "<LDCONST> inválido",
        "<DCLVAR> inválido",
        "<LDVAR> inválido",
        "<TIPO> inválido",
        "<DCLPROC> inválido",
        "<DEFPAR> inválido",
        "<CORPO> inválido",
        "<REPCOMANDO> inválido",
        "<COMANDO> inválido",
        "<PARAMETROS> inválido",
        "<REPPAR> inválido",
        "<ELSEPARTE> inválido",
        "<VARIAVEL> inválido",
        "<REPVARIAVEL> inválido",
        "<ITEMSAIDA> inválido",
        "<REPITEM> inválido",
        "<CONDCASE> inválido",
        "<RPINTEIRO> inválido",
        "<CONTCASE> inválido",
        "<EXPRESSAO> inválido",
        "<REPEXPSIMP> inválido",
        "<EXPSIMP> inválido",
        "<REPEXP> inválido",
        "<TERMO> inválido",
        "<REPTERMO> inválido",
        "<FATOR> inválido"
    ];

}