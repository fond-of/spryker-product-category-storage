<?php

namespace FondOfSpryker\Zed\ProductCategoryStorage\Business;

use FondOfSpryker\Zed\ProductCategoryStorage\Business\Storage\ProductCategoryStorageWriter;
use Spryker\Zed\ProductCategoryStorage\Business\ProductCategoryStorageBusinessFactory as SprykerProductCategoryStorageBusinessFactory;
use Spryker\Zed\ProductCategoryStorage\Business\Writer\ProductCategoryStorageWriterInterface;

/**
 * @method \Spryker\Zed\ProductCategoryStorage\ProductCategoryStorageConfig getConfig()
 * @method \Spryker\Zed\ProductCategoryStorage\Persistence\ProductCategoryStorageQueryContainerInterface getQueryContainer()
 */
class ProductCategoryStorageBusinessFactory extends SprykerProductCategoryStorageBusinessFactory
{
    /**
     * @return \Spryker\Zed\ProductCategoryStorage\Business\Writer\ProductCategoryStorageWriterInterface
     */
    public function createProductCategoryStorageWriter(): ProductCategoryStorageWriterInterface
    {
        return new ProductCategoryStorageWriter(
            $this->getRepository(),
            $this->getEntityManager(),
            $this->getStoreFacade(),
            $this->createProductAbstractReader(),
            $this->createProductCategoryStorageReader(),
            $this->getConfig(),
        );
    }
}
