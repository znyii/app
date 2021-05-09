<?php

namespace ZnYii\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Domain\Traits\EntityManagerTrait;

class FilterModulesByCompanySubscriber implements EventSubscriberInterface
{

    use EntityManagerTrait;

    public static function getSubscribedEvents()
    {
        return [
            KernelEventEnum::AFTER_LOAD_CONFIG => 'onAfterLoadConfig',
        ];
    }

    public function onAfterLoadConfig(LoadConfigEvent $event)
    {
        $config = $event->getConfig();
        $config = $this->filterModuleConfig($config);
        $event->setConfig($config);
    }

    protected function filterModuleConfig(array $config): array
    {
        $companyId = $_ENV['COMPANY_ID'] ?? 1;
        $modulesByCompanyId = $config['params']['modulesByCompanyId']['common'];
        $modulesByCompanyId = ArrayHelper::merge($modulesByCompanyId, $config['params']['modulesByCompanyId'][$companyId]);
        $config['modules'] = ArrayHelper::extractByKeys($config['modules'], $modulesByCompanyId);
        return $config;
    }
}
