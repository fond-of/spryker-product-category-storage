<?php

namespace FondOfSpryker\Client\ProductCategoryStorage;

use FondOfSpryker\Client\ProductCategoryStorage\Storage\ProductAbstractCategoryStorageReader;
use Spryker\Client\ProductCategoryStorage\ProductCategoryStorageFactory as SprykerProductCategoryStorageFactory;

class ProductCategoryStorageFactory extends SprykerProductCategoryStorageFactory
{
    /**
     * @return \Spryker\Client\ProductCategoryStorage\Storage\ProductAbstractCategoryStorageReaderInterface
     */
    public function createProductCategoryStorageReader()
    {
        return new ProductAbstractCategoryStorageReader($this->getStorage(), $this->getSynchronizationService());
    }
}
