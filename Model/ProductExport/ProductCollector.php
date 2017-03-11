<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model\ProductExport;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Store\Api\Data\StoreInterface;

class ProductCollector extends AbstractCatalogEntityCollector
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * prepareCollection
     *
     * @param AbstractCollection|ProductCollection $collection
     * @param StoreInterface                       $store
     * @param int                                  $pageSize
     * @param int                                  $currentPage
     * @param array                                $attributesToSelect
     *
     * @return AbstractCollection
     */
    protected function prepareCollection(
        AbstractCollection $collection,
        StoreInterface $store,
        int $pageSize,
        int $currentPage,
        array $attributesToSelect = ['*']
    ): AbstractCollection {
        $collection->addAttributeToFilter(ProductInterface::VISIBILITY, ['neq' => Visibility::VISIBILITY_NOT_VISIBLE]);
        $collection->addAttributeToFilter(ProductInterface::STATUS, ['eq' => Status::STATUS_ENABLED]);

        $collection->load();

        $collection->addTaxPercents();
        $collection->addCategoryIds();

        return $collection;
    }

    /**
     * getCollectionModel
     *
     * @return AbstractCollection|ProductCollection
     */
    protected function getCollectionModel(): AbstractCollection
    {
        return $this->collectionFactory->create();
    }
}
