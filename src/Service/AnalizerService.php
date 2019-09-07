<?php


namespace App\Service;


use App\Entity\Token;
use App\Exception\LexicalError;
use Doctrine\Common\Collections\ArrayCollection;

class AnalizerService
{
    private $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    private $numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    private $index;
    private $content;
    private $current;
    private $currentLine;
    private $currentChar;
    private $state;
    public static $reservedWords;
    private $openComment, $openLiteral;

    public function __construct($content) {

        $this->content = str_replace("\r\n", "\r", strtolower($content));
        $this->index = 0;
        $this->currentLine = 1;
        $this->currentChar = 0;
        self::$reservedWords = new ArrayCollection();
        $this->addReservedWords();

    }

    private function addWord($name, $cod): void {
        self::$reservedWords->add(new Token($name, $cod, "Palavra Reservada"));
    }

    private function addReservedWords(): void {
        $this->addWord("program", 37);
        $this->addWord("const", 26);
        $this->addWord("var", 43);
        $this->addWord("procedure", 36);
        $this->addWord("begin", 23);
        $this->addWord("end", 29);
        $this->addWord("integer", 32);
        $this->addWord("of", 34);
        $this->addWord("call", 24);
        $this->addWord("if", 31);
        $this->addWord("then", 40);
        $this->addWord("else", 28);
        $this->addWord("while", 44);
        $this->addWord("do", 27);
        $this->addWord("repeat", 39);
        $this->addWord("until", 42);
        $this->addWord("readln", 38);
        $this->addWord("writeln", 45);
        $this->addWord("or", 35);
        $this->addWord("and", 22);
        $this->addWord("not", 33);
        $this->addWord("for", 30);
        $this->addWord("to", 41);
        $this->addWord("case", 25);

    }

    public function bound($a, $entradas) {
        foreach ($entradas as $caracter)
            if ($a == $caracter) return true;
        return false;
    }

    public function nextToken() {
        $charProcessadas = '';

        for ($i = $this->index; $i < strlen($this->content); $i++) {
            $this->index = $i;
            $this->current = $this->content[$i];
            switch ($this->state) {
                case 0:
                    if ($this->bound($this->current, $this->letters)) {

                        $charProcessadas .= $this->current;
                        $this->state = 1;
                    } else if ($this->bound($this->current, $this->numbers)) {
                        $charProcessadas .= $this->current;
                        $this->state = 3;
                    } else if ($this->current == '"') {
                        $this->openLiteral = true;
                        $this->state = 12;
                    } else if ($this->current == '+') {
                        $this->index = $i + 1;
                        return new Token($this->current, 12, "Operacao Adicao",$this->currentLine);
                    } else if ($this->current == '-') {
                        $this->index = $i + 1;
                        return new Token('-', 11, "Operacao Subtracao",$this->currentLine);
                    } else if ($this->current == '*') {
                        $this->index = $i + 1;
                        return new Token($this->current, 9, "Operador Multiplicacao",$this->currentLine);
                    } else if ($this->current == '/') {
                        $this->index = $i + 1;
                        return new Token($this->current, 10, "Operador Divisao",$this->currentLine);
                    } else if ($this->current == '<') {
                        $charProcessadas .= $this->current;
                        $this->state = 10;
                    } else if ($this->current == '>') {
                        $charProcessadas .= $this->current;
                        $this->state = 5;
                    } else if ($this->current == '=') {
                        $this->index = $i + 1;
                        return new Token($this->current, 18, "Igual",$this->currentLine);
                    } else if ($this->current == ':') {
                        $charProcessadas .= $this->current;
                        $this->state = 7;
                    } else if ($this->current == '.') {
                        $this->index = $i + 1;
                        return new Token($this->current, 4, "Ponto",$this->currentLine);
                    } else if ($this->current == '(') {
                        $charProcessadas .= $this->current;
                        $this->state = 14;
                    } else if ($this->current == ')') {
                        $this->index = $i + 1;
                        return new Token($this->current, 8, "Fecha Parenteses",$this->currentLine);
                    } else if ($this->current == ',') {
                        $this->index = $i + 1;
                        return new Token($this->current, 2, "Virgula",$this->currentLine);
                    } else if ($this->current == ';') {
                        $this->index = $i + 1;
                        return new Token($this->current, 3, "Ponto e Virgula",$this->currentLine);
                    } else if ($this->current == " " || $this->current == "\t" || $this->current == "\b" || $this->current == "\f") {
                        $this->index = $i + 1;
                        $this->currentChar++;
                    } else if ($this->current == "\n" || $this->current == "\r") {
                            $this->currentChar = 0;
                            $this->currentLine++;
                    } else if ($this->current == '$' && $i == strlen($this->content) - 1) {
                        return null;
                    } else {
                        $this->currentChar--;
                        throw new LexicalError("Caractere Invalido", $i, 1, null, null, $this->currentLine, $this->currentChar);
                    }

                    break;
                case 1:
                    if ($this->bound($this->current, $this->letters) || $this->bound($this->current, $this->numbers)) {
                        $charProcessadas .= $this->current;
                    } else {
                        $this->state = 0;
                        $this->index = $i;
                        $token = new Token($charProcessadas, 19, "Identificador",$this->currentLine);

                        /**
                         * @var $reservedWord Token
                         */
                        foreach (self::$reservedWords as $reservedWord) {
                            if ($reservedWord->getName() == $token->getName()) {
                                $token = clone $reservedWord;
                                $token->setLineToken($this->currentLine);
                                break;
                            }
                        }
                        return $token;
                    }
                    break;

                case 3:
                    if ($this->bound($this->current, $this->numbers)) {
                        $charProcessadas .= $this->current;
                    } else {
                        $this->state = 0;
                        $this->index = $i;
                        $num = 0;

                        if ($charProcessadas > 32767 || $charProcessadas < -32767) {
                            throw new LexicalError("Numero fora da escala", $i - strlen($charProcessadas), strlen($charProcessadas), null, $this->currentLine);
                        }

                        return new Token($charProcessadas, 20, "Inteiro",$this->currentLine);
                    }
                    break;

                case 12:
                    if ($this->current != '"') {
                        $charProcessadas .= $this->current;
                    } else {
                        $this->state = 0;
                        $this->index = $i + 1;
                        $this->openLiteral = false;
                        if (strlen($charProcessadas) > 255) throw new LexicalError("Literal Muito Grande", $i - strlen($charProcessadas), strlen($charProcessadas), null, $this->currentLine);
                            return new Token($charProcessadas, 21, "Literal",$this->currentLine);
                    }
                    break;

                case 5:
                    $this->state = 0;
                    if ($this->current == '=') {
                        $charProcessadas .= $this->current;
                        $this->index = $i + 1;
                        return new Token($charProcessadas, 16, "Maior ou Igual",$this->currentLine);
                    } else {
                        $this->index = $i;
                        return new Token($charProcessadas, 14, "Maior",$this->currentLine);
                    }
                    break;



                case 7:
                    $this->state = 0;
                    if ($this->current == '=') {
                        $charProcessadas .= $this->current;;
                        $this->index = $i + 1;
                        return new Token($charProcessadas, 6, "Atribuicao",$this->currentLine);
                    } else {
                        $this->index = $i;
                        return new Token($charProcessadas, 5, "Dois Pontos",$this->currentLine);
                    }
                    break;

                case 10:
                    $this->state = 0;
                    if ($this->current == '=') {
                        $charProcessadas .= $this->current;
                        $this->index = $i + 1;
                        return new Token($charProcessadas, 15, "Menor ou Igual",$this->currentLine);
                    } elseif($this->current == '>') {
                        $charProcessadas .= $this->current;
                        $this->index = $i + 1;
                        return new Token($charProcessadas, 17, "Diferente",$this->currentLine);
                    }else{
                        $this->index = $i;
                        return new Token($charProcessadas, 13, "Menor",$this->currentLine);
                    }
                    break;

                case 14:
                    if ($this->current == '*') {
                        $this->copenComment = true;
                        $charProcessadas = '';
                        $this->state = 15;
                    } else {
                        $this->state = 0;
                        $this->index = $i;
                        return new Token("(", 7, "Abre Parenteses",$this->currentLine);
                    }
                    break;

                case 15:
                    if ($this->current == '*' && $this->content[$i + 1] == ')') {
                        $this->openComment = false;
                        $this->state = 0;
                        $i += 1;
                    }
                    break;
            }
            $this->currentChar += strlen($this->current);
        }

        if ($this->openComment)
            throw new LexicalError("Comentario Aberto", true, false, $this->index, null, $this->currentLine);

        if ($this->openLiteral)
            throw new LexicalError("Literal Aberto", false, true, $this->index, null, $this->currentLine);

        return null;
    }
}