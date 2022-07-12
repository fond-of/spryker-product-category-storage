<?php

namespace FondOfSpryker\Zed\ProductCategoryStorage\Business;

use FondOfSpryker\Zed\ProductCategoryStorage\Business\Storage\ProductCategoryStorageWriter;
use FondOfSpryker\Zed\ProductCategoryStorage\ProductCategoryStorageDependencyProvider;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\ProductCategoryStorage\Business\ProductCategoryStorageBusinessFactory as SprykerProductCategoryStorageBusinessFactory;
use Spryker\Zed\ProductCategoryStorage\Business\Storage\ProductCategoryStorageWriterInterface;

/**
 * @method \Spryker\Zed\ProductCategoryStorage\ProductCategoryStorageConfig getConfig()
 * @method \Spryker\Zed\ProductCategoryStorage\Persistence\ProductCategoryStorageQueryContainerInterface getQueryContainer()
 */
class ProductCategoryStorageBusinessFactory extends SprykerProductCategoryStorageBusinessFactory
{
    /**
     * @return \Spryker\Zed\ProductCategoryStorage\Business\Storage\ProductCategoryStorageWriterInterface
     */
    public function createProductCategoryStorageWriter(): ProductCategoryStorageWriterInterface
    {
        return new ProductCategoryStorageWriter(
            $this->getCategoryFacade(),
            $this->getQueryContainer(),
            $this->getConfig()->isSendingToQueue(),
            $this->getStore(),
        );
    }

    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStore(): StoreTransfer
    {
        return $this->getProvidedDependency(ProductCategoryStorageDependencyProvider::FACADE_STORE);
    }
}
