<?php

declare(strict_types=1);


namespace Loger;


use DateTime;


/**
 * Class Log
 * @package Loger
 * @license MIT
 */
class Log
{
    const INFO = 1;
    const ERROR = 2;
    const WARNING = 3;

    private static $autoWrite = false;

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
    /** @var String */
    private static $formatFile = '.log';


    /**
     * Log constructor.
     * @param int $type
     * @param String $title
     * @param String $massage
     * @param String $filename
     */
    public function __construct(int $type, String $title, String $massage, String $filename)
    {
        $this->type = $type;
        $this->title = $title;
        $this->massage = $massage;
        $this->filename = $filename . self::$formatFile;
        try {
            $this->dateTime = (new DateTime())->format('Y-m-d H:i:s');
        }catch (\Exception $e) {
            $this->dateTime = 'error';
        }
    }

    /**
     * История для записи в конце программы
     * @var array
     */
    private static $logList = [];
    private static $path = __DIR__;
    public const DEFAULT_FILE_LOG = 'general.log';

    /**
     * @param String $title
     * @param String $massage
     * @param String $filename
     * @return Void
     */
    public static function addInfo(String $title, String $massage = null, String $filename = self::DEFAULT_FILE_LOG): Void
    {
        array_push(self::$logList, new self(self::INFO, $title, $massage ?? '', $filename));
        if (self::$autoWrite) self::writeToFile();
    }

    /**
     * @param String $title
     * @param String $massage
     * @param String $filename
     * @return Void
     */
    public static function addError(String $title, String $massage = null, String $filename = self::DEFAULT_FILE_LOG): Void
    {
        array_push(self::$logList, new self(self::ERROR, $title, $massage ?? '', $filename));
        if (self::$autoWrite) self::writeToFile();
    }

    /**
     * @param String $title
     * @param String $massage
     * @param String $filename
     * @return Void
     */
    public static function addWarning(String $title, String $massage = null, String $filename = self::DEFAULT_FILE_LOG): Void
    {
        array_push(self::$logList, new self(self::WARNING, $title, $massage ?? '', $filename));
        if (self::$autoWrite) self::writeToFile();
    }

    /**
     * @return Void
     */
    public static function writeToFile(): Void
    {
        if (!file_exists(self::$path. '/log') || !is_dir(!self::$path . '/log'))
            mkdir((self::$path . '/log'));

        foreach (self::$logList as $log)
        {
            $handle = fopen(self::$path. '/log/' . $log->filename, 'a+');
            $tag = null;
            switch ($log->type){
                case Log::INFO:
                    $tag = 'i';
                    break;
                case Log::ERROR:
                    $tag = 'e';
                    break;
                case Log::WARNING:
                    $tag = 'w';
                    break;
            }

            fwrite($handle, sprintf("%s [%s]\t%s\t%s" . PHP_EOL,
                $tag,
                $log->dateTime,
                $log->title,
                $log->massage
            ));

            fclose($handle);
        }
        self::$logList = [];
    }

    /**
     * @param String $path
     * @return Void
     */
    public static function setPathLog(String $path): Void
    {
        self::$path = $path;
    }

    /**
     * @param bool $index
     * @return Void
     */
    public static function setAutoWrite(bool $index): Void
    {
        self::$autoWrite = $index;
    }
}