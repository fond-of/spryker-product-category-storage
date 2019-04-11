<?php

namespace FondOfSpryker\Service\ProductCategoryStorage\Dependency\Service;

use Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface;
use Spryker\Service\Synchronization\SynchronizationServiceInterface;

class ProductCategoryStorageToSynchronizationServiceBridge implements ProductCategoryStorageToSynchronizationServiceInterface
{
    /**
     * @var \Spryker\Service\Synchronization\SynchronizationServiceInterface
     */
    protected $synchronizationService;

    /**
     * @param \Spryker\Service\Synchronization\SynchronizationServiceInterface $synchronizationService
     */
    public function __construct(SynchronizationServiceInterface $synchronizationService)
    {
        $this->synchronizationService = $synchronizationService;
    }

    /**
     * @param string $resourceName
     *
     * @return \Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface
     */
    public function getStorageKeyBuilder(string $resourceName): SynchronizationKeyGeneratorPluginInterface
    {
        return $this->synchronizationService->getStorageKeyBuilder($resourceName);
    }
}
