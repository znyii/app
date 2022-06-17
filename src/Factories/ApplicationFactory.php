<?php

namespace ZnYii\App\Factories;

use ZnCore\Base\Libs\App\Kernel;

class ApplicationFactory extends \ZnCore\Base\Libs\App\Factories\ApplicationFactory
{

    /*public static function createConsoleYii(Kernel $kernel): \yii\console\Application
    {
        $config = $kernel->loadAppConfig();
        unset($config['consoleCommands']);
        $application = new \yii\console\Application($config);
        return $application;
    }

    public static function createTestYii(Kernel $kernel): \yii\console\Application
    {
        $config = $kernel->loadAppConfig();
        unset($config['consoleCommands']);
        $application = new \yii\console\Application($config);
        restore_error_handler();
        return $application;
    }*/
}
