<?php

namespace FondOfSpryker\Service\ProductCategoryStorage;

use FondOfSpryker\Service\ProductCategoryStorage\Dependency\Service\ProductCategoryStorageToSynchronizationServiceBridge;
use Spryker\Service\Kernel\AbstractBundleDependencyProvider;
use Spryker\Service\Kernel\Container;
use Spryker\Shared\Kernel\Store;

class ProductCategoryStorageDependencyProvider extends AbstractBundleDependencyProvider
{
    public const SERVICE_SYNCHRONIZATION = 'SERVICE_SYNCHRONIZATION';
    public const STORE = 'STORE';

    /**
     * @param \Spryker\Service\Kernel\Container $container
     *
     * @return \Spryker\Service\Kernel\Container
     */
    public function provideServiceDependencies(Container $container): Container
    {
        $container = $this->addStore($container);
        $container = $this->addSynchronizationService($container);

        return $container;
    }

    /**
     * @param \Spryker\Service\Kernel\Container $container
     *
     * @return \Spryker\Service\Kernel\Container
     */
    protected function addStore(Container $container): Container
    {
        $container[static::STORE] = function () {
            return Store::getInstance();
        };

        return $container;
    }

    /**
     * @param \Spryker\Service\Kernel\Container $container
     *
     * @return \Spryker\Service\Kernel\Container
     */
    protected function addSynchronizationService(Container $container): Container
    {
        $container[static::SERVICE_SYNCHRONIZATION] = function (Container $container) {
            return new ProductCategoryStorageToSynchronizationServiceBridge($container->getLocator()->synchronization()->service());
        };

        return $container;
    }
}
