<?php

declare(strict_types = 1);


use Loger\Log;
use PHPUnit\Framework\TestCase;

class LogTest extends TestCase
{
    public function test1()
    {
        // init
        Log::setPathLog(__DIR__);

        // Work!
        Log::addInfo('App start success!', null, 'test1');

        // Process...
        Log::addWarning('Please, wait...', 'content...', 'test1');

        // Error!
        Log::addError('OMG! error!', null, 'test1');

        // The end program
        Log::writeToFile();

        $this->assertTrue(true);
    }

    public function test2()
    {
        // init
        Log::setPathLog(__DIR__);
        Log::setAutoWrite(true);

        // Work!
        Log::addInfo('App start success!', null, 'test2');

        // Process...
        Log::addWarning('Please, wait...', 'content...', 'test2');

        // Error!
        Log::addError('OMG! error!', null, 'test2');

        $this->assertTrue(true);
    }


    public function test3()
    {
        // init
        Log::setPathLog(__DIR__);
        Log::setAutoWrite(true);

        // Work!
        Log::addInfoFast(new Exception());

        // Process...
        Log::addWarningFast(new Exception());

        // Error!
        Log::addErrorFast(new Exception());

        $this->assertTrue(true);
    }
}
