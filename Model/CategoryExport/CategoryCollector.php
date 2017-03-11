<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\CategoryExport;

use LizardsAndPumpkins\Magento2Connector\Model\ProductExport\AbstractCatalogEntityCollector;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryCollector extends AbstractCatalogEntityCollector
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    protected function prepareCollection(
        AbstractCollection $collection,
        StoreInterface $store,
        int $pageSize,
        int $currentPage,
        array $attributesToSelect = ['*']
    ): AbstractCollection {
        return $collection->addAttributeToFilter(Category::KEY_IS_ACTIVE, ['eq' => 1]);
    }

    /**
     * @return AbstractCollection|CategoryCollection
     */
    protected function getCollectionModel(): AbstractCollection
    {
        return $this->collectionFactory->create();
    }
}
