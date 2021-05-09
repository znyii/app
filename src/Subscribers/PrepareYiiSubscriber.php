<?php

namespace ZnYii\App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\ConstructKernelEvent;
use ZnCore\Domain\Traits\EntityManagerTrait;
use ZnYii\App\Constant;

class PrepareYiiSubscriber implements EventSubscriberInterface
{

    use EntityManagerTrait;

    public static function getSubscribedEvents()
    {
        return [
            KernelEventEnum::AFTER_CONSTRUCT_KERNEL => 'onAfterConstructKernel',
        ];
    }

    public function onAfterConstructKernel(ConstructKernelEvent $event)
    {
        $this->bootstrap($event->getEnv());
    }

    public function bootstrap(array $env)
    {
        Constant::defineEnv($env);
        include __DIR__ . '/../../../../znyii/app/src/Fork/yiisoft/yii/di/Container.php';
        include __DIR__ . '/../../../../znyii/app/src/Fork/yiisoft/yii/Yii.php';
        Constant::defineBase(realpath(__DIR__ . '/../../../../..'));
    }
}
