<?php


namespace App\Exception;


class TableError extends \Exception
{
    private $msg;


    public function __construct($msg)
    {
        parent::__construct();
        $this->msg = $msg;
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
     * @return TableError
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
        return $this;
    }
}
