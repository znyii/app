<?php

namespace ZnYii\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Domain\Traits\EntityManagerTrait;

class FilterYiiModulesByCompanySubscriber implements EventSubscriberInterface
{

    public $companyId;

    use EntityManagerTrait;

    public function __construct(int $companyId = null)
    {
        $this->companyId = $companyId ?? $_ENV['COMPANY_ID'];
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEventEnum::AFTER_LOAD_CONFIG => 'onAfterLoadConfig',
        ];
    }

    public function onAfterLoadConfig(LoadConfigEvent $event)
    {
        $config = $event->getConfig();
        $modulesConfig = $config['params']['modulesByCompanyId'];
        $modulesByCompanyId = ArrayHelper::merge($modulesConfig['common'], $modulesConfig[$this->companyId]);
        $config['modules'] = ArrayHelper::extractByKeys($config['modules'], $modulesByCompanyId);
        $event->setConfig($config);
    }
}
