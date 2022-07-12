<?php

namespace FondOfSpryker\Zed\ProductCategoryStorage\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface ProductCategoryStorageToStoreFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer;
}
