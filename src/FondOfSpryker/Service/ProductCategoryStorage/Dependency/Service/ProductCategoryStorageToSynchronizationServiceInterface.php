<?php

namespace FondOfSpryker\Service\ProductCategoryStorage\Dependency\Service;

use Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface;

interface ProductCategoryStorageToSynchronizationServiceInterface
{
    /**
     * @param string $resourceName
     *
     * @return \Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface
     */
    public function getStorageKeyBuilder(string $resourceName): SynchronizationKeyGeneratorPluginInterface;
}
