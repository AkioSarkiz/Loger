<?php


namespace Loger;


class Loger
{
    /**
     * История для записи в конце программы
     * @var array
     */
    private static $logList = [];
    public const DEFAULT_FILE_LOG = 'general.log';

    /**
     * @param String $title
     * @param String $massage
     * @param String $filename
     * @return Void
     */
    public static function addInfo(String $title, String $massage = null, String $filename = self::DEFAULT_FILE_LOG): Void
    {
        array_push(self::$logList, new Log(Log::INFO, $title, $massage ?? '', $filename));
    }

    /**
     * @param String $title
     * @param String $massage
     * @param String $filename
     * @return Void
     */
    public static function addError(String $title, String $massage = '', String $filename = self::DEFAULT_FILE_LOG): Void
    {
        array_push(self::$logList, new Log(Log::ERROR, $title, $massage, $filename));
    }

    /**
     * @param String $title
     * @param String $massage
     * @param String $filename
     * @return Void
     */
    public static function addWarning(String $title, String $massage = '', String $filename = self::DEFAULT_FILE_LOG): Void
    {
        array_push(self::$logList, new Log(Log::WARNING, $title, $massage, $filename));
    }

    public static function writeToFile(): Void
    {
        foreach (self::$logList as $log)
        {
            $handle = fopen(HOME_PATH . '.log/' . $log->filename, 'a+');
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
                $log->dateTime->format('Y-m-d H:i:s'),
                $log->title,
                $log->massage
            ));

            fclose($handle);
        }
        self::$logList = [];
    }
}