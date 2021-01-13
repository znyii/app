<?php

namespace ZnYii\App\Loader;

use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Helpers\LoadHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;

abstract class BaseLoader implements LoaderInterface
{

    protected $env;
    protected $appDirectory;

    abstract public function bootstrapApp(string $appName);

    abstract public function mainConfigFiles(string $appName): array;

    abstract public function paramConfigFiles(string $appName): array;

    public function __construct(string $appDirectory)
    {
        $this->appDirectory = $appDirectory;
//        $this->env = $env ?: $_ENV;
//        dd($this->env);
    }

    public function loadMainConfig(string $appName): array
    {
        $configFiles = $this->mainConfigFiles($appName);
        $config = LoadHelper::loadConfigList($configFiles);
        if (empty($config['params'])) {
            $config['params'] = $this->loadParams($appName);
        }
        $config = $this->prepareConfig($appName, $config);
        return $config;
    }

    /*public function loadYii()
    {
        include __DIR__ . '/../../../../yiisoft/yii2/Yii.php';
    }*/

    protected function isTestEnv(): bool
    {
        return EnvHelper::isTest();
    }

    private function prepareConfig(string $appName, array $config): array
    {
        $config['vendorPath'] = $config['vendorPath'] ?? FileHelper::path('vendor');
        $config['id'] = $config['id'] ?? $this->generateAppId($appName);
        $config['basePath'] = $config['basePath'] ?? $this->appDirectory;
        //$config['controllerNamespace'] = $config['controllerNamespace'] ?? $_ENV['PROJECT_DIR'] . '\controllers';
        return $config;
    }

    private function generateAppId(string $appName): string
    {
        $appId = 'app-' . $appName /*. '-' . $this->env['APP_ENV']*/;
        return $appId;
    }

    private function loadParams(string $appName): array
    {
        $configFiles = $this->paramConfigFiles($appName);
        $config = [];
        if ($configFiles) {
            $config = LoadHelper::loadConfigList($configFiles);
        }
        return $config;
    }
}
