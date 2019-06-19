<?php


namespace App\Service;


use App\Entity\Token;
use App\Exception\LexicalError;
use Doctrine\Common\Collections\ArrayCollection;

class AnalizerService
{
    private $letters = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    private $numbers = ['0','1','2','3','4','5','6','7','8','9'];
    private $index;
    private $content;
    private $current;
    private $state;
    public static $reservedWords;
    private  $openComment, $openLiteral;

    public function  __construct($content) {

        $this->content = str_replace("\r\n","",strtolower($content));;
        $this->index = 0;

        self::$reservedWords = new ArrayCollection();
        $this->addReservedWords();

    }

    private function addWord($name, $cod):void{
        self::$reservedWords->add(new Token($name,$cod, "Palavra Reservada"));
    }

    private function addReservedWords():void{
        $this->addWord("program", 22);
        $this->addWord("const", 23);
        $this->addWord("var", 24);
        $this->addWord("procedure", 25);
        $this->addWord("begin", 26);
        $this->addWord("end", 27);
        $this->addWord("integer", 28);
        $this->addWord("of", 29);
        $this->addWord("call", 30);
        $this->addWord("if", 31);
        $this->addWord("then", 32);
        $this->addWord("else", 33);
        $this->addWord("while", 34);
        $this->addWord("do", 35);
        $this->addWord("repeat", 36);
        $this->addWord("until", 37);
        $this->addWord("readln", 38);
        $this->addWord("writeln", 39);
        $this->addWord("or", 40);
        $this->addWord("and", 41);
        $this->addWord("not", 42);
        $this->addWord("for", 43);
        $this->addWord("to", 44);
        $this->addWord("case", 45);

    }

    public function bound($a,$entradas){
        foreach($entradas as $caracter)
            if($a == $caracter) return true;
            return false;
    }

    public function nextToken() {
        $charProcessadas = '';

            for($i = $this->index; $i< strlen($this->content); $i++) {
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
                            return new Token($this->current, 2, "Operacao Adicao");
                        } else if ($this->current == '-') {
                            $this->index = $i + 1;
                            return new Token('-', 3, "Operacao Subtracao");
                        } else if ($this->current == '*') {
                            $this->index = $i + 1;
                            return new Token($this->current, 4, "Operador Multiplicacao");
                        } else if ($this->current == '/') {
                            $this->index = $i + 1;
                            return new Token($this->current, 5, "Operador Divisao");
                        } else if ($this->current == '<') {
                            $charProcessadas .= $this->current;
                            $this->state = 10;
                        } else if ($this->current == '>') {
                            $charProcessadas .= $this->current;
                            $this->state = 5;
                        } else if ($this->current == '=') {
                            $this->index = $i + 1;
                            return new Token($this->current, 6, "Igual");
                        } else if ($this->current == ':') {
                            $charProcessadas .= $this->current;
                            $this->state = 7;
                        } else if ($this->current == '.') {
                            $this->index = $i + 1;
                            return new Token($this->current, 16, "Ponto");
                        } else if ($this->current == '(') {
                            $charProcessadas .= $this->current;
                            $this->state = 14;
                        } else if ($this->current == ')') {
                            $this->index = $i + 1;
                            return new Token($this->current, 18, "Fecha Parenteses");
                        } else if ($this->current == ',') {
                            $this->index = $i + 1;
                            return new Token($this->current, 15, "Virgula");
                        } else if ($this->current == ';') {
                            $this->index = $i + 1;
                            return new Token($this->current, 14, "Ponto e Virgula");
                        } else if ($this->current == ' ' || $this->current == '\n' || $this->current == '\t' || $this->current == '\b' || $this->current == '\f' || $this->current == '\r') {
                            $this->index = $i + 1;
                        } else if ($this->current == '$' && $i == strlen($this->content) - 1) {
                            return null;
                        } else {
                            throw new LexicalError("Caractere Invalido", $i, 1);
                        }
                    
                        break;
                    case 1:
                        if ($this->bound($this->current, $this->letters) || $this->bound($this->current, $this->numbers)) {
                            $charProcessadas .= $this->current;
                        } else {
                            $this->state = 0;
                            $this->index = $i;
                            $token = new Token($charProcessadas, 19, "Identificador");

                            foreach (self::$reservedWords as $reservedWord) {
                                if ($reservedWord->getName() == $token->getName()) {
                                    $token = $reservedWord;
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
                                throw new LexicalError("Numero fora da escala", $i - strlen($charProcessadas), strlen($charProcessadas));
                            }

                            return new Token($charProcessadas, 20, "Inteiro");
                        }
                        break;

                    case 12:
                        if ($this->current != '"') {
                            $charProcessadas .= $this->current;
                        } else {
                            $this->state = 0;
                            $this->index = $i + 1;
                            $this->openLiteral = false;
                            if (strlen($charProcessadas) > 255) throw new LexicalError("Literal Muito Grande", $i - strlen($charProcessadas), strlen($charProcessadas));
                            return new Token(strlen($charProcessadas), 21, "Literal");
                        }
                        break;

                    case 5:
                        $this->state = 0;
                        if($this->current == '='){
                            $charProcessadas .= $this->current;
                            $this->index = $i+1;
                            return new Token($charProcessadas,8, "Maior ou Igual");
                        }else{
                            $this->index = $i;
                            return new Token($charProcessadas,7, "Maior");
                        }

                    case 7:
                        $this->state = 0;
                        if($this->current == '='){
                            $charProcessadas .= $this->current;;
                            $this->index = $i+1;
                            return new Token($charProcessadas,12, "Atribuicao");
                        }else{
                            $this->index = $i;
                            return new Token($charProcessadas,13, "Dois Pontos");
                        }

                    case 14:
                        if($this->current == '*'){
                            $this->copenComment = true;
                            $charProcessadas = '';
                            $this->state = 15;
                        }
                        else{
                            $this->state = 0;
                            $this->index = $i;
                            return new Token("(",17,"Abre Parenteses");
                        }
                        break;

                    case 15:
                        if($this->current == '*' && $this->content[$i+1] == ')'){
                            $this->openComment = false;
                            $this->state = 0;
                            $i+=1;
                        }
                        break;
                }
            }

            if($this->openComment)
                throw new LexicalError("Comentario Aberto",true,false,$this->index);

            if($this->openLiteral)
                throw new LexicalError("Literal Aberto",false,true, $this->index);

            return null;

        

    }
}