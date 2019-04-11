<?php

namespace FondOfSpryker\Zed\ProductCategoryStorage\Business;

use FondOfSpryker\Zed\ProductCategoryStorage\Business\Storage\ProductCategoryStorageWriter;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Store\Persistence\Base\SpyStoreQuery;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\ProductCategoryStorage\Business\ProductCategoryStorageBusinessFactory as SprykerProductCategoryStorageBusinessFactory;
use Spryker\Zed\ProductCategoryStorage\Business\Storage\ProductCategoryStorageWriterInterface;

/**
 * @method \FondOfSpryker\Zed\ProductCategoryStorage\ProductCategoryStorageConfig getConfig()
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
            $this->getStore()
        );
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function createStore(): Store
    {
        return Store::getInstance();
    }

    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStore(): StoreTransfer
    {
        $store = $this->createStore();

        $spyStoreQuery = SpyStoreQuery::create();
        $spyStore = $spyStoreQuery->filterByName($store->getStoreName())->findOne();

        $storeTransfer = new StoreTransfer();
        $storeTransfer->fromArray($spyStore->toArray(), true);

        return $storeTransfer;
    }
}
