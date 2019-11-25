<?php


namespace App\Exception;


class SemanticError extends \Exception
{
    private $msg;
    private $index;
    private $lineCodeError;
    private $currentChar;

    public function __construct($msg, $index, $lineCodeError = null, $currentChar = null)
    {
        parent::__construct();
        $this->msg = $msg;
        $this->index = $index;
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
     * @return SemanticError
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
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
     * @return SemanticError
     */
    public function setIndex($index)
    {
        $this->index = $index;
        return $this;
    }



    /**
     * @return null
     */
    public function getLineCodeError()
    {
        return $this->lineCodeError;
    }

    /**
     * @param null $lineCodeError
     * @return SemanticError
     */
    public function setLineCodeError($lineCodeError)
    {
        $this->lineCodeError = $lineCodeError;
        return $this;
    }

    /**
     * @return null
     */
    public function getCurrentChar()
    {
        return $this->currentChar;
    }

    /**
     * @param null $currentChar
     * @return SemanticError
     */
    public function setCurrentChar($currentChar)
    {
        $this->currentChar = $currentChar;
        return $this;
    }
}
