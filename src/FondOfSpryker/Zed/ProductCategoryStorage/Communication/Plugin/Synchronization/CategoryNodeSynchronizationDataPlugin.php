<?php

namespace FondOfSpryker\Zed\CategoryStorage\Communication\Plugin\Synchronization;

use Spryker\Zed\CategoryStorage\Communication\Plugin\Synchronization\CategoryNodeSynchronizationDataPlugin as SprykerCategoryNodeSynchronizationDataPlugin;

class CategoryNodeSynchronizationDataPlugin extends SprykerCategoryNodeSynchronizationDataPlugin
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return bool
     */
    public function hasStore(): bool
    {
        return true;
    }
}
