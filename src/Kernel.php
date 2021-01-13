<?php

namespace ZnYii\App;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnYii\App\Loader\AdvancedLoader;
use ZnYii\App\Loader\BaseLoader;

class Kernel extends \ZnCore\Base\Libs\App\Kernel
{

    public function bootstrapEnv()
    {
        DotEnv::init(__DIR__ . '/../../../..');
    }
    
    public function booststrap(array $env)
    {
        /*if ($env === null) {
            $env = $this->env;
        }*/
        Constant::defineEnv($env);
        include __DIR__ . '/../../../yiisoft/yii2/Yii.php';
        Constant::defineBase(realpath(__DIR__ . '/../../../..'));
        //Constant::defineApp($this->appName);
    }
}
