<?php

namespace ZnYii\App\Factories\YiiAdvanced;

use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\App\Kernel;
use ZnCore\Base\Libs\App\Loaders\BundleLoader;
use ZnCore\Contract\Kernel\Interfaces\KernelInterface;
use ZnYii\App\Loader\AdvancedLoader;

class KernelFactory extends \ZnCore\Base\Libs\App\Factories\KernelFactory
{

    public static function createConsoleKernel(array $bundles = [], $import = ['i18next', 'container', 'console', 'migration']): KernelInterface
    {
        return self::createKernel('console', $import);
    }

    public static function createFrontendKernel(array $bundles = []): KernelInterface
    {
        return self::createKernel('frontend', ['i18next', 'container', 'yiiWeb']);
    }

    public static function createBackendKernel(): KernelInterface
    {
        return self::createKernel('backend', ['i18next', 'container', 'yiiAdmin']);
    }

    protected static function createKernel(string $appName, array $import): KernelInterface
    {
        self::init();
        $bundleLoader = new BundleLoader([], $import);
        static::loadBundles($bundleLoader, $appName);
        $kernel = new \ZnYii\App\Kernel($appName);
        $kernel->setLoader(new AdvancedLoader(__DIR__ . '/../../../../../../' . $appName));
        $kernel->setLoader($bundleLoader);
        return $kernel;
    }

    protected static function loadBundles(LoaderInterface $bundleLoader, string $appName)
    {
        $bundleLoader->addBundles(include __DIR__ . '/../../../../../../' . $appName . '/config/extra/bundle.php');
        $bundleLoader->addBundles(include __DIR__ . '/../../../../../../common/config/extra/bundle.php');
    }
}
