<?php

namespace ZnYii\App;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnYii\App\Loader\BaseLoader;

class Kernel extends \ZnCore\Base\Libs\App\Kernel
{

    public function run(array $env = null)
    {
        if($env === null) {
            $env = $this->env;
        }

//        $this->init($env);
        Constant::defineEnv($env);
        $this->loader->loadYii();

        $appName = $env['APP_NAME'];
        Constant::defineBase(realpath(__DIR__ . '/../../../..'));
        Constant::defineApp($appName);
        $config = $this->loadMainConfig($appName);
        return $config;
    }

    private function init(array $env)
    {

    }

    /*private function loadMainConfig(string $appName): array
    {
        $this->loader->bootstrapApp($appName);
        $config = $this->loader->loadMainConfig($appName);
        return $config;
    }*/

    /*private function initCache(array $env)
    {
        $cacheDirectory = FileHelper::path($env['CACHE_DIRECTORY']);
        $this->cache = new FilesystemAdapter('kernel', TimeEnum::SECOND_PER_MINUTE * 20, $cacheDirectory);
    }*/
}
