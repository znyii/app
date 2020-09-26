<?php

namespace ZnYii\App;

use ZnYii\App\Enums\AppTypeEnum;
use ZnYii\App\Kernel;
use ZnYii\App\Loader\AdvancedLoader;
use yii\base\Application;

class BootstrapYii
{

    public static function init(string $appName, string $appType = AppTypeEnum::WEB): Application {

        $_ENV['PROJECT_DIR'] = realpath(__DIR__ . '/../../../..');
        $_ENV['APP_DIR'] = $_ENV['PROJECT_DIR'] . '/' . $appName;
        $_ENV['APP_NAME'] = $appName;

        $loader = new AdvancedLoader($_ENV);
        $kernel = new Kernel($_ENV, $loader);
        $mainConfig = $kernel->run();

        if($appType == AppTypeEnum::WEB) {
            $application = new \yii\web\Application($mainConfig);
        } elseif ($appType == AppTypeEnum::CONSOLE) {
            $application = new \yii\console\Application($mainConfig);
        }

        return $application;
    }
}
