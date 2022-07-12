<?php

namespace FondOfSpryker\Zed\ProductCategoryStorage\Communication\Plugin\Synchronization;

use Spryker\Zed\CategoryStorage\Communication\Plugin\Synchronization\CategoryTreeSynchronizationDataPlugin as SprykerCategoryTreeSynchronizationDataPlugin;

/**
 * @method \Spryker\Zed\ProductCategoryStorage\ProductCategoryStorageConfig getConfig()
 * @method \Spryker\Zed\ProductCategoryStorage\Persistence\ProductCategoryStorageQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ProductCategoryStorage\Business\ProductCategoryStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\ProductCategoryStorage\Communication\ProductCategoryStorageCommunicationFactory getFactory()
 */
class CategoryTreeSynchronizationDataPlugin extends SprykerCategoryTreeSynchronizationDataPlugin
{
    /**
     * @return bool
     */
    public function hasStore(): bool
    {
        return true;
    }
}
