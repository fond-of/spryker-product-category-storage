<?php

namespace FondOfSpryker\Service\ProductCategoryStorage\Plugin\Synchronization;

use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Service\Kernel\AbstractPlugin;
use Spryker\Service\Synchronization\Dependency\Plugin\SynchronizationKeyGeneratorPluginInterface;
use Spryker\Service\Synchronization\Plugin\BaseKeyGenerator;

/**
 * @method \FondOfSpryker\Service\ProductCategoryStorage\ProductCategoryStorageServiceFactory getFactory()
 */
class ProductCategoryStorageSynchronizationKeyGeneratorPlugin extends AbstractPlugin implements SynchronizationKeyGeneratorPluginInterface
{
    /**
     * @var string
     */
    protected $resourceName;

    /**
     * @param string $resourceName
     */
    public function __construct(string $resourceName)
    {
        $this->resourceName = $resourceName;
    }

    /**
     * Specification:
     * - Generates storage or search key based on SynchronizationDataTransfer
     * for entities which use synchronization
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SynchronizationDataTransfer $dataTransfer
     *
     * @return string
     */
    public function generateKey(SynchronizationDataTransfer $dataTransfer): string
    {
        if ($dataTransfer->getStore() === null) {
            $storeName = $this->getFactory()->getStore()->getStoreName();

            $dataTransfer->setStore($storeName);
        }

        $synchronizationKeyGeneratorPlugin = $this->getFactory()->getSynchronizationService()
            ->getStorageKeyBuilder('');

        if ($synchronizationKeyGeneratorPlugin instanceof BaseKeyGenerator) {
            $synchronizationKeyGeneratorPlugin->setResource($this->resourceName);
        }

        return $synchronizationKeyGeneratorPlugin->generateKey($dataTransfer);
    }
}
