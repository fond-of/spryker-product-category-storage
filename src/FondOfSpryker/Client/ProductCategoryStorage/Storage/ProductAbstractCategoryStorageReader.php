<?php

namespace FondOfSpryker\Client\ProductCategoryStorage\Storage;

use Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\Kernel\Locator;
use Spryker\Client\ProductCategoryStorage\Dependency\Client\ProductCategoryStorageToStorageClientInterface;
use Spryker\Client\ProductCategoryStorage\Dependency\Service\ProductCategoryStorageToSynchronizationServiceInterface;
use Spryker\Client\ProductCategoryStorage\ProductCategoryStorageConfig;
use Spryker\Client\ProductCategoryStorage\Storage\ProductAbstractCategoryStorageReader as SprykerProductAbstractCategoryStorageReader;
use Spryker\Shared\ProductCategoryStorage\ProductCategoryStorageConfig as SharedProductCategoryStorageConfig;

class ProductAbstractCategoryStorageReader extends SprykerProductAbstractCategoryStorageReader
{
    /**
     * @var \Spryker\Client\ProductCategoryStorage\Dependency\Client\ProductCategoryStorageToStorageClientInterface
     */
    protected $storageClient;

    /**
     * @var \Spryker\Client\ProductCategoryStorage\Dependency\Service\ProductCategoryStorageToSynchronizationServiceInterface
     */
    protected $synchronizationService;

    /**
     * @param \Spryker\Client\ProductCategoryStorage\Dependency\Client\ProductCategoryStorageToStorageClientInterface $storageClient
     * @param \Spryker\Client\ProductCategoryStorage\Dependency\Service\ProductCategoryStorageToSynchronizationServiceInterface $synchronizationService
     */
    public function __construct(ProductCategoryStorageToStorageClientInterface $storageClient, ProductCategoryStorageToSynchronizationServiceInterface $synchronizationService)
    {
        $this->storageClient = $storageClient;
        $this->synchronizationService = $synchronizationService;
    }

    /**
     * @param int $idProductAbstract
     * @param string $locale
     *
     * @return \Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer|null
     */
    public function findProductAbstractCategory($idProductAbstract, $locale)
    {
        $productAbstractCategoryStorageData = $this->getStorageData($idProductAbstract, $locale);

        if (!$productAbstractCategoryStorageData) {
            return null;
        }

        $spyProductCategoryAbstractTransfer = new ProductAbstractCategoryStorageTransfer();

        return $spyProductCategoryAbstractTransfer->fromArray($productAbstractCategoryStorageData, true);
    }

    /**
     * @param array $productAbstractIds
     * @param string $localeName
     *
     * @return array
     */
    public function findBulkProductAbstractCategory(array $productAbstractIds, string $localeName): array
    {
        //SprykerUpgradeToDo Check it
        return parent::findBulkProductAbstractCategory($productAbstractIds, $localeName);
    }

    /**
     * @param int $idProductAbstract
     * @param string $locale
     *
     * @return array|null
     */
    protected function getStorageData(int $idProductAbstract, string $locale): ?array
    {
        if (ProductCategoryStorageConfig::isCollectorCompatibilityMode()) {
            $clientLocatorClassName = Locator::class;
            /** @var \Spryker\Client\Product\ProductClientInterface $productClient */
            $productClient = $clientLocatorClassName::getInstance()->product()->client();
            $collectorData = $productClient->getProductAbstractFromStorageById($idProductAbstract, $locale);
            $categories = [];

            foreach ($collectorData['categories'] as $category) {
                $categories[] = [
                    'category_node_id' => $category['nodeId'],
                    'name' => $category['name'],
                    'url' => $category['url'],
                ];
            }

            return [
                'id_product_abstract' => $idProductAbstract,
                'categories' => $categories,
            ];
        }

        $key = $this->generateKey($idProductAbstract, $locale);

        $productAbstractCategoryStorageData = $this->storageClient->get($key);

        return $productAbstractCategoryStorageData;
    }

    /**
     * @param int|string $idProductAbstract
     * @param string $localeName
     *
     * @return string
     */
    protected function generateKey($idProductAbstract, string $localeName): string
    {
        $synchronizationDataTransfer = new SynchronizationDataTransfer();
        $synchronizationDataTransfer
            ->setLocale($localeName)
            ->setReference($idProductAbstract);

        return $this->synchronizationService
            ->getStorageKeyBuilder(SharedProductCategoryStorageConfig::PRODUCT_ABSTRACT_CATEGORY_RESOURCE_NAME)
            ->generateKey($synchronizationDataTransfer);
    }
}
