<?php


namespace App\Exception;


class LexicalError extends \Exception {
    private $msg;
    private $lenght;
    private $literal;
    private $index;
    private $comment;
    private $lineCodeError;
    private $currentChar;

    public function __construct($msg, $index, $lenght = null, $comment = null, $literal = null, $lineCodeError = null, $currentChar = null) {
        parent::__construct();
        $this->msg = $msg;
        $this->index = $index;
        $this->lenght = $lenght;
        $this->literal = $literal;
        $this->comment = $comment;
        $this->lineCodeError = $lineCodeError;
        $this->currentChar = $currentChar;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     * @return LexicalError
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
        return $this;
    }

    /**
     * @return null
     */
    public function getLenght()
    {
        return $this->lenght;
    }

    /**
     * @param null $lenght
     * @return LexicalError
     */
    public function setLenght($lenght)
    {
        $this->lenght = $lenght;
        return $this;
    }

    /**
     * @return null
     */
    public function getLiteral()
    {
        return $this->literal;
    }

    /**
     * @param null $literal
     * @return LexicalError
     */
    public function setLiteral($literal)
    {
        $this->literal = $literal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param mixed $index
     * @return LexicalError
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @return null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param null $comment
     * @return LexicalError
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return null
     */
    public function getLineCodeError() {
        return $this->lineCodeError;
    }

    /**
     * @param null $lineCodeError
     * @return LexicalError
     */
    public function setLineCodeError($lineCodeError) {
        $this->lineCodeError = $lineCodeError;
        return $this;
    }

    /**
     * @return null
     */
    public function getCurrentChar() {
        return $this->currentChar;
    }

    /**
     * @param null $currentChar
     * @return LexicalError
     */
    public function setCurrentChar($currentChar) {
        $this->currentChar = $currentChar;
        return $this;
    }


}