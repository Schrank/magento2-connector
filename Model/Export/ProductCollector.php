<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\Export;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Store\Api\Data\StoreInterface;

class ProductCollector
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var int
     */
    private $allProductsCount;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getCollection(StoreInterface $store, int $pageSize = 100, int $currentPage = 1) : Collection
    {
        $collection = $this->collectionFactory->create();


        $collection->setStore($store);

        $collection->setPageSize($pageSize);
        $collection->setCurPage($currentPage);

        $collection->addAttributeToSelect('*');

        $collection->addAttributeToFilter(ProductInterface::VISIBILITY, ['neq' => Visibility::VISIBILITY_NOT_VISIBLE]);
        $collection->addAttributeToFilter(ProductInterface::STATUS, ['eq' => Status::STATUS_ENABLED]);

        $collection->load();

        $collection->addTaxPercents();
        $collection->addCategoryIds();

        return $collection;
    }

    public function shouldCancel(Collection $collection, int $pageSize, int $currentPage): bool
    {
        return ($pageSize * $currentPage) >= $this->getAllProductsCount($collection);
    }

    private function getAllProductsCount(Collection $collection): int
    {
        if (null === $this->allProductsCount) {
            $this->allProductsCount = $collection->getSize();
        }

        return $this->allProductsCount;
    }
}
