<?php


namespace Loger;


use DateTime;
use InvalidArgumentException;


class Log
{
    const INFO = 1;
    const ERROR = 2;
    const WARNING = 3;

    /** @var int */
    public $type;
    /** @var String */
    public $title;
    /** @var String */
    public $massage;
    /** @var String */
    public $filename;
    /** @var DateTime */
    public $dateTime;


    public function __construct(int $type, String $title, String $massage, String $filename)
    {
        if (!($type == self::INFO || $type == self::ERROR || $type == self::WARNING))
            throw new InvalidArgumentException('error', 785);

        $this->type = $type;
        $this->title = $title;
        $this->massage = $massage;
        $this->filename = $filename;
        $this->dateTime = new DateTime();
    }
}