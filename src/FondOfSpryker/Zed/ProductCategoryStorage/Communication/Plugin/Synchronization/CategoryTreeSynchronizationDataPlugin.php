<?php

namespace FondOfSpryker\Zed\CategoryStorage\Communication\Plugin\Synchronization;

use Spryker\Zed\CategoryStorage\Communication\Plugin\Synchronization\CategoryTreeSynchronizationDataPlugin as SprykerCategoryTreeSynchronizationDataPlugin;

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
