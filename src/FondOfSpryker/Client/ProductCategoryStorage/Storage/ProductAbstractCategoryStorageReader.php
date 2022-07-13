<?php

namespace FondOfSpryker\Client\ProductCategoryStorage\Storage;

use Spryker\Client\ProductCategoryStorage\Storage\ProductAbstractCategoryStorageReader as SprykerProductAbstractCategoryStorageReader;

class ProductAbstractCategoryStorageReader extends SprykerProductAbstractCategoryStorageReader
{
    /**
     * @param array<int> $productAbstractIds
     * @param string $localeName
     * @param string $storeName
     *
     * @return array
     */
    protected function findBulkStorageData(array $productAbstractIds, string $localeName, string $storeName): array
    {
        $storageKeys = [];
        foreach ($productAbstractIds as $idProductAbstract) {
            $storageKeys[] = $this->generateKey((string)$idProductAbstract, $localeName, $storeName);
        }
        $productAbstractCategoryStorageData = $this->storageClient->getMulti($storageKeys);

        $decodedProductAbstractCategoryStorageData = [];
        foreach ($productAbstractCategoryStorageData as $item) {
            if ($item !== null) {
                $decodedProductAbstractCategoryStorageData[] = json_decode($item, true);
            }
        }

        return $decodedProductAbstractCategoryStorageData;
    }
}
