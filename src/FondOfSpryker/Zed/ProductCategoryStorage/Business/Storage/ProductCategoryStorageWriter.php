<?php
namespace FondOfSpryker\Zed\ProductCategoryStorage\Business\Storage;

use Exception;
use FondOfSpryker\Zed\ProductCategoryStorage\Dependency\Facade\ProductCategoryStorageToStoreFacadeInterface;
use Generated\Shared\Transfer\ProductCategoryStorageTransfer;
use Orm\Zed\Product\Persistence\Base\SpyProductAbstractLocalizedAttributes;
use Orm\Zed\ProductCategoryStorage\Persistence\SpyProductAbstractCategoryStorage;
use Spryker\Zed\ProductCategoryStorage\Business\Storage\ProductCategoryStorageWriter as SprykerProductCategoryStorageWriter;
use Spryker\Zed\ProductCategoryStorage\Dependency\Facade\ProductCategoryStorageToCategoryInterface;
use Spryker\Zed\ProductCategoryStorage\Persistence\ProductCategoryStorageQueryContainerInterface;

class ProductCategoryStorageWriter extends SprykerProductCategoryStorageWriter
{
    /**
     * @var \FondOfSpryker\Zed\ProductCategoryStorage\Dependency\Facade\ProductCategoryStorageToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @param \Spryker\Zed\ProductCategoryStorage\Dependency\Facade\ProductCategoryStorageToCategoryInterface $categoryFacade
     * @param \Spryker\Zed\ProductCategoryStorage\Persistence\ProductCategoryStorageQueryContainerInterface $queryContainer
     * @param bool $isSendingToQueue
     * @param \FondOfSpryker\Zed\ProductCategoryStorage\Dependency\Facade\ProductCategoryStorageToStoreFacadeInterface $storeFacade
     */
    public function __construct(
        ProductCategoryStorageToCategoryInterface $categoryFacade,
        ProductCategoryStorageQueryContainerInterface $queryContainer,
        $isSendingToQueue,
        ProductCategoryStorageToStoreFacadeInterface $storeFacade
    ) {
        parent::__construct($categoryFacade, $queryContainer, $isSendingToQueue);
        $this->categoryFacade = $categoryFacade;
        $this->queryContainer = $queryContainer;
        $this->isSendingToQueue = $isSendingToQueue;
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param array $pathTokens
     *
     * @return array
     */
    protected function generateCategoryDataTransfers(array $pathTokens)
    {
        $productCategoryCollection = [];
        foreach ($pathTokens as $pathItem) {
            $idNode = (int)$pathItem[self::ID_CATEGORY_NODE];
            $idCategory = (int)$pathItem[self::FK_CATEGORY];

            $productCategoryCollection[] = (new ProductCategoryStorageTransfer())
                ->setCategoryNodeId($idNode)
                ->setCategoryId($idCategory)
                ->setUrl($pathItem[self::URL])
                ->setName($pathItem[self::NAME])
                ->setStore($this->storeFacade->getCurrentStore());
        }

        return $productCategoryCollection;
    }

    /**
     * @param \Orm\Zed\Product\Persistence\Base\SpyProductAbstractLocalizedAttributes $spyProductAbstractLocalizedEntity
     * @param array $categories
     * @param \Orm\Zed\ProductCategoryStorage\Persistence\SpyProductAbstractCategoryStorage|null $spyProductAbstractCategoryStorageEntity
     *
     * @return void
     */
    protected function storeDataSet(
        SpyProductAbstractLocalizedAttributes $spyProductAbstractLocalizedEntity,
        array $categories,
        ?SpyProductAbstractCategoryStorage $spyProductAbstractCategoryStorageEntity = null
    ) {
        if ($spyProductAbstractCategoryStorageEntity === null) {
            $spyProductAbstractCategoryStorageEntity = new SpyProductAbstractCategoryStorage();
        }

        try {
            $categories = $categories[$spyProductAbstractLocalizedEntity->getFkProductAbstract()][$spyProductAbstractLocalizedEntity->getFkLocale()];
        } catch (Exception $exception) {
        }
        if (!$categories) {
            if (!$spyProductAbstractCategoryStorageEntity->isNew()) {
                $spyProductAbstractCategoryStorageEntity->delete();
            }

            return;
        }

        $productAbstractCategoryStorageTransfer = $this->getProductAbstractCategoryTransfer($spyProductAbstractLocalizedEntity, $categories);

        $spyProductAbstractCategoryStorageEntity->setFkProductAbstract($spyProductAbstractLocalizedEntity->getFkProductAbstract());
        $spyProductAbstractCategoryStorageEntity->setData($productAbstractCategoryStorageTransfer->toArray());
        $spyProductAbstractCategoryStorageEntity->setLocale($spyProductAbstractLocalizedEntity->getLocale()->getLocaleName());
        $spyProductAbstractCategoryStorageEntity->setIsSendingToQueue($this->isSendingToQueue);
        $spyProductAbstractCategoryStorageEntity->setStore($this->storeFacade->getCurrentStore()->getName());
        $spyProductAbstractCategoryStorageEntity->save();
    }
}
