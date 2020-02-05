<?php

namespace FondOfSpryker\Service\ProductCategoryStorage;

use FondOfSpryker\Service\ProductCategoryStorage\Dependency\Service\ProductCategoryStorageToSynchronizationServiceInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;
use Spryker\Shared\Kernel\Store;

class ProductCategoryStorageServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return $this->getProvidedDependency(ProductCategoryStorageDependencyProvider::STORE);
    }

    /**
     * @return \FondOfSpryker\Service\ProductCategoryStorage\Dependency\Service\ProductCategoryStorageToSynchronizationServiceInterface
     */
    public function getSynchronizationService(): ProductCategoryStorageToSynchronizationServiceInterface
    {
        return $this->getProvidedDependency(ProductCategoryStorageDependencyProvider::SERVICE_SYNCHRONIZATION);
    }
}
