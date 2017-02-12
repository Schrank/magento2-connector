<?php
declare(strict_types = 1);
namespace LizardsAndPumpkins\Magento2Connector\Model;

use LizardsAndPumpkins\Magento2Connector\Model\Export\Context;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductCollector;
use LizardsAndPumpkins\Magento2Connector\Model\Export\ProductXmlGenerator;
use LizardsAndPumpkins\MagentoConnector\XmlBuilder\CatalogMerge;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Store\Api\Data\StoreInterface;

class ProductListXmlGenerator
{
    /**
     * @var CatalogMerge
     */
    private $catalogMerge;
    /**
     * @var ProductCollector
     */
    private $productCollector;
    /**
     * @var ProductXmlGenerator
     */
    private $productXmlGenerator;

    public function __construct(
        CatalogMerge $catalogMerge,
        ProductCollector $productCollector,
        ProductXmlGenerator $productXmlGenerator
    ) {
        $this->catalogMerge = $catalogMerge;
        $this->productCollector = $productCollector;
        $this->productXmlGenerator = $productXmlGenerator;
    }

    public function generateXml(
        StoreInterface $store,
        string $locale = 'de_DE',
        int $pageSize = 100,
        int $currentPage = 1
    ): CatalogMerge {
        $productCollection = $this->productCollector->getCollection($store, $pageSize, $currentPage);

        if ((int)$productCollection->count() === 0) {
            return null;
        }

        /** @var ProductInterface $product */
        foreach ($productCollection->getItems() as $product) {
            $context = new Context($locale);
            $productXmlString = $this->productXmlGenerator->productToXmlString($product, $context);
            $this->catalogMerge->addProduct($productXmlString);
        }

        return $this->catalogMerge;
    }
}
