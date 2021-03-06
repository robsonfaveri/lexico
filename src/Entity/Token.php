<?php


namespace App\Entity;

 class Token {
    private $description, $name;
    private $code;
    private $reservedWord;

    public function __construct($name, $code, $description) {
        $this->name = $name;
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Token
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Token
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return Token
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReservedWord()
    {
        return $this->reservedWord;
    }

    /**
     * @param mixed $reservedWord
     * @return Token
     */
    public function setReservedWord($reservedWord)
    {
        $this->reservedWord = $reservedWord;
        return $this;
    }


	public  function __toString(){
		return  $this->getName() . " | " . $this->getCode() . " | " . $this->getDescription();
	}

	public function __clone(){
		return new Token($this->getName() ,$this->getCode(),$this->getDescription());
	}

}
