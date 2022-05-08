<?php

namespace ZnYii\App\Fork\yiisoft\yii\di;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Domain\Helpers\EntityHelper;

class Container extends \yii\di\Container implements ContainerInterface
{

    /*public function get($class, $params = [], $config = [])
    {
        $object = ContainerHelper::getContainer()->make($class, $params);
        EntityHelper::setAttributes($object, $config);
        return $object;
    }

    protected function build($class, $params, $config)
    {
        $object = ContainerHelper::getContainer()->make($class, $params);
        EntityHelper::setAttributes($object, $config);
        return $object;
    }

    public function has($class)
    {
        return ContainerHelper::getContainer()->has($class);
    }*/
}
