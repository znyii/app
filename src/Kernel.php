<?php

namespace ZnYii\App;

use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\ConstructKernelEvent;
use ZnCore\Base\Libs\App\Subscribers\ConfigureContainerSubscriber;
use ZnCore\Base\Libs\App\Subscribers\ConfigureEntityManagerSubscriber;
use ZnYii\App\Subscribers\FilterYiiModulesByCompanySubscriber;
use ZnYii\App\Subscribers\PrepareYiiSubscriber;

class Kernel extends \ZnCore\Base\Libs\App\Kernel
{

    public function __construct(string $appName)
    {
        parent::__construct($appName);

        $event = new ConstructKernelEvent($appName, $_ENV);
        $this->getEventDispatcher()->dispatch($event, KernelEventEnum::AFTER_CONSTRUCT_KERNEL);
    }

    public function subscribes(): array
    {
        return [
            PrepareYiiSubscriber::class,
            //FilterYiiModulesByCompanySubscriber::class,
            ConfigureContainerSubscriber::class,
//            ConfigureEntityManagerSubscriber::class,
        ];
    }
}
