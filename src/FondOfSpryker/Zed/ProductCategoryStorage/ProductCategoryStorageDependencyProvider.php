<?php

namespace FondOfSpryker\Zed\ProductCategoryStorage;

use FondOfSpryker\Zed\ProductCategoryStorage\Dependency\Facade\ProductCategoryStorageToStoreFacadeBridge;
use Spryker\Zed\ProductCategoryStorage\ProductCategoryStorageDependencyProvider as SprykerProductCategoryStorageDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProductCategoryStorageDependencyProvider extends SprykerProductCategoryStorageDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addStore($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStore(Container $container): Container
    {
        $container[static::FACADE_STORE] = static function (Container $container) {
            return new ProductCategoryStorageToStoreFacadeBridge($container->getLocator()->store()->facade());
        };

        return $container;
    }
}
