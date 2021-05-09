<?php

namespace ZnYii\App;

use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Base\Libs\App\Subscribers\ConfigureContainerSubscriber;
use ZnCore\Base\Libs\App\Subscribers\ConfigureEntityManagerSubscriber;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnYii\App\Subscribers\PrepareConfigSubscriber;

class Kernel extends \ZnCore\Base\Libs\App\Kernel
{

    public function __construct(string $appName)
    {
        parent::__construct($appName);
        $this->booststrap($_ENV);
    }

    public function subscribes(): array
    {
        return [
            PrepareConfigSubscriber::class,
            ConfigureContainerSubscriber::class,
            ConfigureEntityManagerSubscriber::class,
        ];
    }

    public function bootstrapEnv()
    {
        DeprecateHelper::softThrow();
        DotEnv::init(__DIR__ . '/../../../..');
    }

    public function loadAppConfig(): array
    {
        $config = $this->loadMainConfig($this->appName);

        $requestEvent = new LoadConfigEvent($this, $config);
        $this->getEventDispatcher()->dispatch($requestEvent, KernelEventEnum::AFTER_LOAD_CONFIG);
        $config = $requestEvent->getConfig();

        return $config;
    }

    public function booststrap(array $env)
    {
        Constant::defineEnv($env);
        include __DIR__ . '/../../../znyii/app/src/Fork/yiisoft/yii/di/Container.php';
        include __DIR__ . '/../../../znyii/app/src/Fork/yiisoft/yii/Yii.php';
        Constant::defineBase(realpath(__DIR__ . '/../../../..'));
    }
}
