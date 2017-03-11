<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport;

use Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection;
use Magento\Store\Api\Data\StoreInterface;

abstract class AbstractCatalogEntityCollector
{
    /**
     * @var int
     */
    private $allEntitiesCount;

    public function getCollection(StoreInterface $store, int $pageSize = 100, int $currentPage = 1): AbstractCollection
    {
        $collection = $this->initCollection($store, $pageSize, $currentPage);
        return $this->prepareCollection($collection, $store, $pageSize, $currentPage);
    }

    public function shouldCancel(AbstractCollection $collection, int $pageSize, int $currentPage): bool
    {
        return ($pageSize * $currentPage) >= $this->getAllEntitiesCount($collection);
    }

    abstract protected function prepareCollection(
        AbstractCollection $collection,
        StoreInterface $store,
        int $pageSize,
        int $currentPage,
        array $attributesToSelect = ['*']
    ): AbstractCollection;

    private function initCollection(
        StoreInterface $store,
        int $pageSize,
        int $currentPage,
        array $attributesToSelect = ['*']
    ): AbstractCollection {
        $collection = $this->getCollectionModel();

        $collection->setStore($store);

        $collection->setPageSize($pageSize);
        $collection->setCurPage($currentPage);

        $collection->addAttributeToSelect($attributesToSelect);

        return $collection;
    }

    private function getAllEntitiesCount(AbstractCollection $collection): int
    {
        if (null === $this->allEntitiesCount) {
            $this->allEntitiesCount = $collection->getSize();
        }

        return $this->allEntitiesCount;
    }

    abstract protected function getCollectionModel(): AbstractCollection;
}
