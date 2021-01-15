<?php

namespace ZnYii\App;

use ZnCore\Base\Libs\DotEnv\DotEnv;

class Kernel extends \ZnCore\Base\Libs\App\Kernel
{

    public function bootstrapEnv()
    {
        DotEnv::init(__DIR__ . '/../../../..');
    }

    public function booststrap(array $env)
    {
        Constant::defineEnv($env);
        include __DIR__ . '/../../../znyii/app/src/Fork/yiisoft/yii/di/Container.php';
        include __DIR__ . '/../../../znyii/app/src/Fork/yiisoft/yii/Yii.php';
        Constant::defineBase(realpath(__DIR__ . '/../../../..'));
    }
}
